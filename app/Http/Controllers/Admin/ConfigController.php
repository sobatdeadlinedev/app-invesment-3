<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    public function index()
    {
        $configs = [
            'app_name' => Config::get('app_name', ['value' => '']),
            'app_logo' => Config::get('app_logo', ['value' => '']),
            'app_announcement' => Config::get('app_announcement', ['value' => '']),
            'app_wallet_address' => Config::get('app_wallet_address', ['name' => '', 'number' => '']),
            'app_qr_code' => Config::get('app_qr_code', ['value' => '']),
        ];

        return view('admin.pages.config.index', compact('configs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_announcement' => 'nullable|string',
            'wallet_name' => 'required|string|max:255',
            'wallet_number' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'app_qr_code' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        try {
            // Update App Name
            Config::set('app_name', ['value' => $request->app_name]);

            // Update App Announcement
            Config::set('app_announcement', ['value' => $request->app_announcement]);

            // Update Wallet Address
            Config::set('app_wallet_address', [
                'name' => $request->wallet_name,
                'number' => $request->wallet_number
            ]);

            // Update App Logo
            if ($request->hasFile('app_logo')) {
                $oldLogo = Config::get('app_logo', ['value' => '']);
                if (!empty($oldLogo['value'])) {
                    $this->deleteOldFile($oldLogo['value']);
                }

                $logoUrl = $this->uploadFile($request->file('app_logo'), 'logo');
                Config::set('app_logo', ['value' => $logoUrl]);
            }

            // Update QR Code
            if ($request->hasFile('app_qr_code')) {
                $oldQr = Config::get('app_qr_code', ['value' => '']);
                if (!empty($oldQr['value'])) {
                    $this->deleteOldFile($oldQr['value']);
                }

                $qrUrl = $this->uploadFile($request->file('app_qr_code'), 'qrcode');
                Config::set('app_qr_code', ['value' => $qrUrl]);
            }

            return redirect()->route('admin.config.index')
                ->with('success', 'Configuration updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update configuration: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Upload file and return full URL
     */
    private function uploadFile($file, $prefix)
    {
        $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Store to storage/app/public/configs
        $path = $file->storeAs('configs', $filename, 'public');

        // Generate full URL using Storage facade
        return Storage::url($path);
    }

    /**
     * Delete old file from storage
     */
    private function deleteOldFile($url)
    {
        try {
            // Extract path from URL
            // URL format: http://domain.com/storage/configs/logo_123.jpg
            // We need: configs/logo_123.jpg

            $path = str_replace('/storage/', '', parse_url($url, PHP_URL_PATH));

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        } catch (\Exception $e) {
            // Silent fail - file might not exist
        }
    }
}
