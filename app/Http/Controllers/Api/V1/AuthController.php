<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthenticationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(
        private AuthenticationService $authService,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        return $this->success([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
            'token_type' => $result['token_type'],
            'expires_in' => $result['expires_in'],
        ], 'Login successful.');
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->success(null, 'Logged out successfully.');
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $this->authService->logoutAll($request->user());

        return $this->success(null, 'Logged out from all devices successfully.');
    }

    public function profile(Request $request): JsonResponse
    {
        $user = $request->user()->load('employee');

        return $this->success(new UserResource($user));
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $this->authService->updateProfile(
            $request->user(),
            $request->validated()
        );

        return $this->success(new UserResource($user), 'Profile updated successfully.');
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $this->authService->changePassword(
            $request->user(),
            $request->input('current_password'),
            $request->input('password')
        );

        return $this->success(null, 'Password changed successfully.');
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $message = $this->authService->forgotPassword($request->input('email'));

        return $this->success(null, $message);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $message = $this->authService->resetPassword($request->validated());

        return $this->success(null, $message);
    }

    public function enable2fa(Request $request): JsonResponse
    {
        $secret = $this->authService->enable2fa($request->user());

        $qrCodeUrl = app('pragmarx.google2fa')->getQRCodeUrl(
            config('app.name'),
            $request->user()->email,
            $secret
        );

        return $this->success([
            'secret' => $secret,
            'qr_code_url' => $qrCodeUrl,
        ], '2FA has been enabled. Verify with a code to confirm.');
    }

    public function confirm2fa(Request $request): JsonResponse
    {
        $request->validate(['code' => ['required', 'string', 'size:6']]);

        $this->authService->confirm2fa($request->user(), $request->input('code'));

        return $this->success(null, '2FA has been confirmed and enabled.');
    }

    public function disable2fa(Request $request): JsonResponse
    {
        $this->authService->disable2fa($request->user());

        return $this->success(null, '2FA has been disabled.');
    }

    public function verify2fa(Request $request): JsonResponse
    {
        $request->validate(['code' => ['required', 'string', 'size:6']]);

        $valid = $this->authService->verify2fa($request->user(), $request->input('code'));

        if (!$valid) {
            return $this->error('Invalid 2FA code.', 422, null, 'INVALID_2FA');
        }

        return $this->success(null, '2FA code verified successfully.');
    }

    public function sessions(Request $request): JsonResponse
    {
        $sessions = $this->authService->getActiveSessions($request->user());

        return $this->success($sessions);
    }

    public function terminateSession(Request $request, string $id): JsonResponse
    {
        $this->authService->terminateSession($request->user(), $id);

        return $this->success(null, 'Session terminated.');
    }
}
