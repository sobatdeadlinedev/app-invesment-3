@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Page Title -->
            <div class="mb-4">
                <h5 class="text-white fw-bold mb-1">{{ __('app.account_verification') }}</h5>
                <p class="text-muted small mb-0">{{ __('app.complete_verification_data') }}</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (!$verification || !$verification->submitted_at)
                <!-- Form Verifikasi -->
                <form action="{{ route('member.verification.store') }}" method="POST" enctype="multipart/form-data"
                    id="verificationForm">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <input type="text" name="full_name"
                            class="form-control-dark @error('full_name') is-invalid @enderror"
                            placeholder="{{ __('app.enter_full_name') }}" value="{{ old('full_name') }}" required
                            style="padding: 1rem; border-radius: 12px;">
                        @error('full_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Nomor Identitas -->
                    <div class="mb-3">
                        <input type="text" name="identity_number"
                            class="form-control-dark @error('identity_number') is-invalid @enderror"
                            placeholder="{{ __('app.enter_identity_number') }}" value="{{ old('identity_number') }}"
                            required style="padding: 1rem; border-radius: 12px;">
                        @error('identity_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Upload Foto Identitas -->
                    <div class="mb-3">
                        <div class="upload-area-simple" onclick="document.getElementById('identity_photo').click()">
                            <input type="file" id="identity_photo" name="identity_photo" accept="image/*" class="d-none"
                                onchange="previewImage(this, 'identityPreview')" required>
                            <div id="identityPreview" class="preview-container-simple">
                                <i class="bi bi-card-image" style="font-size: 24px; color: #6c757d;"></i>
                                <span class="text-muted ms-2">{{ __('app.upload_identity_photo') }}</span>
                            </div>
                        </div>
                        @error('identity_photo')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Upload Foto Selfie -->
                    <div class="mb-4">
                        <div class="upload-area-simple" onclick="document.getElementById('selfie_photo').click()">
                            <input type="file" id="selfie_photo" name="selfie_photo" accept="image/*" class="d-none"
                                onchange="previewImage(this, 'selfiePreview')" required>
                            <div id="selfiePreview" class="preview-container-simple">
                                <i class="bi bi-camera-fill" style="font-size: 24px; color: #6c757d;"></i>
                                <span class="text-muted ms-2">{{ __('app.upload_selfie_photo') }}</span>
                            </div>
                        </div>
                        @error('selfie_photo')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-gold w-100 py-3" style="border-radius: 12px;">
                        {{ __('app.submit_verification') }}
                    </button>
                </form>
            @elseif($verification->submitted_at && !$user->is_verified)
                <!-- Status: Pending -->
                <div class="card-dark shadow-sm p-4 text-center mb-3">
                    <div class="mb-3">
                        <div
                            style="width: 80px; height: 80px; margin: 0 auto; background: rgba(255, 193, 7, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255, 193, 7, 0.3);">
                            <i class="bi bi-clock-history" style="font-size: 40px; color: #ffc107;"></i>
                        </div>
                    </div>
                    <h5 class="text-white fw-bold mb-2">{{ __('app.verification_pending') }}</h5>
                    <p class="text-muted mb-3">{{ __('app.verification_pending_message') }}</p>
                    <small class="text-muted">{{ __('app.submitted_on') }}:
                        {{ $verification->submitted_at->format('d M Y, H:i') }}</small>
                </div>

                <!-- Data yang Disubmit -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white fw-bold mb-3">{{ __('app.submitted_data') }}</h6>

                    <div class="verification-data-item">
                        <small class="text-muted">{{ __('app.full_name') }}</small>
                        <p class="text-white mb-0">{{ $verification->full_name }}</p>
                    </div>
                    <div class="verification-data-item">
                        <small class="text-muted">{{ __('app.identity_number') }}</small>
                        <p class="text-white mb-0">{{ $verification->identity_number }}</p>
                    </div>
                </div>
            @elseif($user->is_verified)
                <!-- Status: Verified -->
                <div class="card-dark shadow-sm p-4 text-center mb-3">
                    <div class="mb-3">
                        <div
                            style="width: 80px; height: 80px; margin: 0 auto; background: rgba(40, 167, 69, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(40, 167, 69, 0.3);">
                            <i class="bi bi-check-circle-fill" style="font-size: 40px; color: #28a745;"></i>
                        </div>
                    </div>
                    <h5 class="text-white fw-bold mb-2">{{ __('app.account_verified') }}</h5>
                    <p class="text-muted mb-3">{{ __('app.account_verified_message') }}</p>
                    @if ($verification->verified_at)
                        <small class="text-muted">{{ __('app.verified_on') }}:
                            {{ $verification->verified_at->format('d M Y, H:i') }}</small>
                    @endif
                </div>

                <!-- Data Terverifikasi -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white fw-bold mb-3">{{ __('app.verified_data') }}</h6>

                    <div class="verification-data-item">
                        <small class="text-muted">{{ __('app.full_name') }}</small>
                        <p class="text-white mb-0">{{ $verification->full_name }}</p>
                    </div>
                    <div class="verification-data-item">
                        <small class="text-muted">{{ __('app.identity_number') }}</small>
                        <p class="text-white mb-0">{{ $verification->identity_number }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .upload-area-simple {
            background: rgba(245, 166, 35, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area-simple:hover {
            background: rgba(245, 166, 35, 0.1);
            border-color: var(--gold-color);
        }

        .preview-container-simple {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .preview-container-simple img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>

    <script>
        // Translation strings from Laravel
        const translations = {
            uploadAllPhotos: "{{ __('app.upload_all_photos') }}",
            maxFileSize: "{{ __('app.max_file_size') }}"
        };

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML =
                        `<img src="${e.target.result}" alt="Preview" style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px;">`;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Form validation before submit
        document.getElementById('verificationForm')?.addEventListener('submit', function(e) {
            const identityPhoto = document.getElementById('identity_photo').files[0];
            const selfiePhoto = document.getElementById('selfie_photo').files[0];

            if (!identityPhoto || !selfiePhoto) {
                e.preventDefault();
                alert(translations.uploadAllPhotos);
                return false;
            }

            // Check file size
            if (identityPhoto.size > 2048000 || selfiePhoto.size > 2048000) {
                e.preventDefault();
                alert(translations.maxFileSize);
                return false;
            }
        });
    </script>
@endsection
