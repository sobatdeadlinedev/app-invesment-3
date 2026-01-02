@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            {{-- <h5 class="text-white mb-3">Team</h5> --}}

            <!-- Team Count Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Team Member</p>
                        <h2 class="text-gold mb-0 fw-bold">24</h2>
                    </div>
                    <div class="team-icon-wrapper">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
            <!-- Card 2: Referral Code -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="referral-icon-small">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                        <p class="text-muted mb-0 small">Kode Referral</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="referral-code-display" id="referralCode">{{ $user->refferal_code }}</div>
                    <button class="btn-copy-small" onclick="copyReferralCode()" title="Copy">
                        <i class="bi bi-clipboard" id="copyIcon"></i>
                    </button>
                </div>
            </div>
            <!-- Team Members List -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Daftar Team Member</h6>
                </div>

                <!-- Member Item 1 -->
                <div class="team-member-item">
                    <div class="d-flex align-items-center gap-3">
                        <div class="team-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">JohnDoe123</div>
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-telephone-fill text-muted" style="font-size: 11px;"></i>
                                <small class="text-muted">+62 812-3456-7890</small>
                            </div>
                        </div>
                        <div class="team-status active">
                            <i class="bi bi-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function copyReferralCode() {
            const codeElement = document.getElementById('referralCode');
            const code = codeElement.textContent;
            const icon = document.getElementById('copyIcon');

            navigator.clipboard.writeText(code).then(() => {
                // Ubah icon jadi check
                icon.classList.remove('bi-clipboard');
                icon.classList.add('bi-check-lg');

                // Tampilkan notifikasi
                const toast = document.createElement('div');
                toast.style.cssText =
                    'position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 12px 20px; border-radius: 8px; z-index: 9999; font-size: 14px;';
                toast.textContent = 'Kode referral berhasil disalin!';
                document.body.appendChild(toast);

                // Hapus notifikasi setelah 2 detik
                setTimeout(() => {
                    toast.remove();
                    // Kembalikan icon ke clipboard
                    icon.classList.remove('bi-check-lg');
                    icon.classList.add('bi-clipboard');
                }, 2000);
            }).catch(err => {
                alert('Gagal menyalin kode referral');
                console.error('Error copying:', err);
            });
        }
    </script>
@endsection
