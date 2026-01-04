@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Page Title -->
            <div class="mb-4">
                <h5 class="text-white fw-bold mb-1">Verifikasi Akun</h5>
                <p class="text-muted small mb-0">Lengkapi data untuk verifikasi identitas Anda</p>
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

                    <!-- Card: Data Diri -->
                    <div class="card-dark shadow-sm p-3 mb-3">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="verification-icon-small">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h6 class="text-white mb-0 fw-bold">Data Diri</h6>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label class="text-muted small mb-2">Nama Lengkap</label>
                            <input type="text" name="full_name"
                                class="form-control-dark @error('full_name') is-invalid @enderror"
                                placeholder="Masukkan nama lengkap sesuai KTP" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Nomor Identitas -->
                        <div class="mb-3">
                            <label class="text-muted small mb-2">Nomor Identitas</label>
                            <input type="text" name="identity_number"
                                class="form-control-dark @error('identity_number') is-invalid @enderror"
                                placeholder="Masukkan nomor identitas" value="{{ old('identity_number') }}" required>
                            @error('identity_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Jenis Identitas -->
                        <div class="mb-0">
                            <label class="text-muted small mb-2">Jenis Identitas</label>
                            <select name="identity_type"
                                class="form-control-dark @error('identity_type') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Identitas</option>
                                <option value="KTP" {{ old('identity_type') == 'KTP' ? 'selected' : '' }}>KTP</option>
                                <option value="SIM" {{ old('identity_type') == 'SIM' ? 'selected' : '' }}>SIM</option>
                                <option value="Paspor" {{ old('identity_type') == 'Paspor' ? 'selected' : '' }}>Paspor
                                </option>
                            </select>
                            @error('identity_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Card: Upload Foto Identitas -->
                    <div class="card-dark shadow-sm p-3 mb-3">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="verification-icon-small">
                                <i class="bi bi-card-image"></i>
                            </div>
                            <h6 class="text-white mb-0 fw-bold">Foto Identitas</h6>
                        </div>

                        <div class="upload-area" onclick="document.getElementById('identity_photo').click()">
                            <input type="file" id="identity_photo" name="identity_photo" accept="image/*" class="d-none"
                                onchange="previewImage(this, 'identityPreview')" required>
                            <div id="identityPreview" class="preview-container">
                                <i class="bi bi-cloud-upload upload-icon"></i>
                                <p class="text-white fw-bold mb-1">Upload Foto Identitas</p>
                                <small class="text-muted">Format: JPG, JPEG, PNG (Max 2MB)</small>
                            </div>
                        </div>
                        @error('identity_photo')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Card: Upload Foto Selfie -->
                    <div class="card-dark shadow-sm p-3 mb-3">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="verification-icon-small">
                                <i class="bi bi-camera-fill"></i>
                            </div>
                            <h6 class="text-white mb-0 fw-bold">Foto Selfie dengan Identitas</h6>
                        </div>

                        <div class="upload-area" onclick="document.getElementById('selfie_photo').click()">
                            <input type="file" id="selfie_photo" name="selfie_photo" accept="image/*" class="d-none"
                                onchange="previewImage(this, 'selfiePreview')" required>
                            <div id="selfiePreview" class="preview-container">
                                <i class="bi bi-cloud-upload upload-icon"></i>
                                <p class="text-white fw-bold mb-1">Upload Foto Selfie</p>
                                <small class="text-muted">Foto selfie sambil memegang identitas (Max 2MB)</small>
                            </div>
                        </div>
                        @error('selfie_photo')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="alert-info-box mb-3">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <small>Pastikan foto identitas dan selfie terlihat jelas untuk mempercepat proses verifikasi</small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-gold w-100 py-3">
                        <i class="bi bi-check-circle-fill me-2"></i>Ajukan Verifikasi
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
                    <h5 class="text-white fw-bold mb-2">Verifikasi Sedang Diproses</h5>
                    <p class="text-muted mb-3">Dokumen Anda sedang dalam proses verifikasi oleh admin. Mohon tunggu hingga
                        proses selesai.</p>
                    <small class="text-muted">Diajukan pada:
                        {{ $verification->submitted_at->format('d M Y, H:i') }}</small>
                </div>

                <!-- Data yang Disubmit -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white fw-bold mb-3">Data yang Diajukan</h6>

                    <div class="verification-data-item">
                        <small class="text-muted">Nama Lengkap</small>
                        <p class="text-white mb-0">{{ $verification->full_name }}</p>
                    </div>
                    <div class="verification-data-item">
                        <small class="text-muted">Nomor Identitas</small>
                        <p class="text-white mb-0">{{ $verification->identity_number }}</p>
                    </div>
                    <div class="verification-data-item">
                        <small class="text-muted">Jenis Identitas</small>
                        <p class="text-white mb-0">{{ $verification->identity_type }}</p>
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
                    <h5 class="text-white fw-bold mb-2">Akun Terverifikasi</h5>
                    <p class="text-muted mb-3">Selamat! Akun Anda telah berhasil diverifikasi.</p>
                    @if ($verification->verified_at)
                        <small class="text-muted">Diverifikasi pada:
                            {{ $verification->verified_at->format('d M Y, H:i') }}</small>
                    @endif
                </div>

                <!-- Data Terverifikasi -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white fw-bold mb-3">Data Terverifikasi</h6>

                    <div class="verification-data-item">
                        <small class="text-muted">Nama Lengkap</small>
                        <p class="text-white mb-0">{{ $verification->full_name }}</p>
                    </div>
                    <div class="verification-data-item">
                        <small class="text-muted">Nomor Identitas</small>
                        <p class="text-white mb-0">{{ $verification->identity_number }}</p>
                    </div>
                    <div class="verification-data-item">
                        <small class="text-muted">Jenis Identitas</small>
                        <p class="text-white mb-0">{{ $verification->identity_type }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="preview-image">`;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Enhanced dropdown behavior
        document.getElementById('identity-type')?.addEventListener('change', function() {
            // Visual feedback when identity type is selected
            if (this.value) {
                this.style.borderColor = 'var(--gold-color)';
                this.style.backgroundColor = 'rgba(245, 166, 35, 0.1)';
            } else {
                this.style.borderColor = 'var(--border-color)';
                this.style.backgroundColor = 'rgba(245, 166, 35, 0.05)';
            }
        });

        // Form validation before submit
        document.getElementById('verificationForm')?.addEventListener('submit', function(e) {
            const identityPhoto = document.getElementById('identity_photo').files[0];
            const selfiePhoto = document.getElementById('selfie_photo').files[0];

            if (!identityPhoto || !selfiePhoto) {
                e.preventDefault();
                alert('Mohon upload semua foto yang diperlukan');
                return false;
            }

            // Check file size
            if (identityPhoto.size > 2048000 || selfiePhoto.size > 2048000) {
                e.preventDefault();
                alert('Ukuran file maksimal 2MB');
                return false;
            }
        });
    </script>
@endsection
