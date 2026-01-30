<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\UserVerification;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AdminNotificationMail;

class VerificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $verification = $user->verification;

        return view('member.pages.verification.index', compact('user', 'verification'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Cek apakah user sudah pernah submit
        if ($user->verification && $user->verification->submitted_at) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan verifikasi sebelumnya');
        }

        // Validasi
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'identity_number' => 'required|string|max:50',
            'identity_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'selfie_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi',
            'identity_number.required' => 'Nomor identitas wajib diisi',
            'identity_photo.required' => 'Foto identitas wajib diupload',
            'identity_photo.image' => 'File harus berupa gambar',
            'identity_photo.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'identity_photo.max' => 'Ukuran foto maksimal 2MB',
            'selfie_photo.required' => 'Foto selfie dengan identitas wajib diupload',
            'selfie_photo.image' => 'File harus berupa gambar',
            'selfie_photo.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'selfie_photo.max' => 'Ukuran foto maksimal 2MB',
        ]);

        try {
            // Upload identity photo dan dapatkan full URL
            $identityPath = $request->file('identity_photo')->store('verifications/identity', 'public');
            $identityFullUrl = url('storage/' . $identityPath);

            // Upload selfie photo dan dapatkan full URL
            $selfiePath = $request->file('selfie_photo')->store('verifications/selfie', 'public');
            $selfieFullUrl = url('storage/' . $selfiePath);

            // Create or update verification
            $verification = UserVerification::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $validated['full_name'],
                    'identity_number' => $validated['identity_number'],
                    'identity_photo_path' => $identityFullUrl,
                    'selfie_with_identity_path' => $selfieFullUrl,
                    'submitted_at' => now(),
                ]
            );

            // Kirim email notifikasi ke admin
            $this->sendAdminNotification($verification);

            return redirect()->route('member.verification.index')->with('success', 'Verifikasi berhasil diajukan! Mohon tunggu konfirmasi dari admin.');
        } catch (\Exception $e) {
            Log::error('Verification submission failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload dokumen. Silakan coba lagi.');
        }
    }

    /**
     * Send email notification to admin
     */
    private function sendAdminNotification($verification)
    {
        try {
            $adminEmail = Config::get('app_email')['value'] ?? null;

            if (!$adminEmail) {
                Log::warning('Admin email not configured');
                return;
            }

            $user = $verification->user;

            $data = [
                'full_name' => $verification->full_name,
                'identity_number' => $verification->identity_number,
                'submitted_at' => $verification->submitted_at->format('d M Y H:i'),
            ];

            Mail::to($adminEmail)->send(new AdminNotificationMail(
                'verification',
                $data,
                $user->name,
                $user->email
            ));
        } catch (\Exception $e) {
            Log::error('Failed to send admin notification email: ' . $e->getMessage());
            // Don't throw exception, just log it
        }
    }
}
