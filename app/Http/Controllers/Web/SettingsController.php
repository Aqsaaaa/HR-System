<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        $company = Setting::where('group', 'company')->pluck('value', 'key');
        $general = Setting::where('group', 'general')->pluck('value', 'key');

        return Inertia::render('Settings/Index', [
            'company' => $company,
            'general' => $general,
        ]);
    }

    public function updateCompany(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:255',
            'company_website' => 'nullable|string|max:255',
            'company_logo' => 'nullable|string',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'group' => 'company'],
                ['value' => $value ?? '']
            );
        }

        return redirect()->back()->with('success', 'Company settings updated.');
    }

    public function updateGeneral(Request $request)
    {
        $data = $request->validate([
            'timezone' => 'nullable|string|max:100',
            'date_format' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:10',
            'language' => 'nullable|string|max:10',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'group' => 'general'],
                ['value' => $value ?? '']
            );
        }

        return redirect()->back()->with('success', 'General settings updated.');
    }
}
