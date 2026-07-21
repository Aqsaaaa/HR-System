<?php

namespace App\Services\Auth;

use App\Exceptions\BusinessRuleException;
use App\Models\User;
use App\Services\Audit\AuditService;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

class AuthenticationService
{
    public function __construct(
        private AuditService $auditService,
    ) {}

    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new BusinessRuleException('Invalid email or password.');
        }

        if (!$user->is_active) {
            throw new BusinessRuleException('Your account has been deactivated.');
        }

        if ($user->must_change_password) {
            throw new BusinessRuleException('You must change your password before logging in.');
        }

        $token = $user->createToken(
            $credentials['device_name'] ?? request()->userAgent() ?? 'api',
            $credentials['abilities'] ?? ['*'],
            now()->addDays(config('sanctum.expiration', 30))
        );

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        $this->auditService->log('user.login', 'auth', 'login', $user, null, [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration', 30) * 86400,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();

        $this->auditService->log('user.logout', 'auth', 'logout', $user);
    }

    public function logoutAll(User $user): void
    {
        $user->tokens()->delete();

        $this->auditService->log('user.logout.all', 'auth', 'logout', $user);
    }

    public function forgotPassword(string $email): string
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status !== Password::RESET_LINK_SENT) {
            throw new BusinessRuleException(__($status));
        }

        return __($status);
    }

    public function resetPassword(array $data): string
    {
        $status = Password::reset($data, function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
                'password_changed_at' => now(),
            ])->save();
        });

        if ($status !== Password::PASSWORD_RESET) {
            throw new BusinessRuleException(__($status));
        }

        return __($status);
    }

    public function changePassword(User $user, string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new BusinessRuleException('Current password is incorrect.');
        }

        if (Hash::check($newPassword, $user->password)) {
            throw new BusinessRuleException('New password must be different from current password.');
        }

        $user->update([
            'password' => Hash::make($newPassword),
            'must_change_password' => false,
            'password_changed_at' => now(),
        ]);

        $this->auditService->log('user.password.changed', 'auth', 'update', $user);
    }

    public function updateProfile(User $user, array $data): User
    {
        $oldValues = $user->only(array_keys($data));
        $user->update($data);

        $this->auditService->logUpdate($user, $oldValues, $data, 'auth', 'user.profile.updated');

        return $user->fresh();
    }

    public function enable2fa(User $user): string
    {
        $secret = app('pragmarx.google2fa')->generateSecretKey();

        $user->update([
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt(json_encode($this->generateRecoveryCodes())),
        ]);

        $this->auditService->log('user.2fa.enabled', 'auth', 'update', $user);

        return $secret;
    }

    public function confirm2fa(User $user, string $code): void
    {
        $secret = decrypt($user->two_factor_secret);

        if (!app('pragmarx.google2fa')->verifyKey($secret, $code)) {
            throw new BusinessRuleException('Invalid 2FA code.');
        }

        $user->update(['two_factor_confirmed_at' => now()]);
    }

    public function disable2fa(User $user): void
    {
        $user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        $this->auditService->log('user.2fa.disabled', 'auth', 'update', $user);
    }

    public function verify2fa(User $user, string $code): bool
    {
        $secret = decrypt($user->two_factor_secret);
        return app('pragmarx.google2fa')->verifyKey($secret, $code);
    }

    public function getActiveSessions(User $user): array
    {
        return $user->tokens()
            ->where('id', '!=', $user->currentAccessToken()->id)
            ->get(['id', 'name', 'last_used_at', 'created_at', 'expires_at'])
            ->toArray();
    }

    public function terminateSession(User $user, string $tokenId): void
    {
        $user->tokens()->where('id', $tokenId)->delete();
    }

    private function generateRecoveryCodes(): array
    {
        return collect(range(1, 8))->map(fn() => Str::random(10))->toArray();
    }
}
