@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Team Count Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Team Member</p>
                        <h2 class="text-gold mb-0 fw-bold">{{ $totalTeam }}</h2>
                    </div>
                    <div class="team-icon-wrapper">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Referral Code & Link -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="referral-icon-small">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                        <p class="text-muted mb-0 small">Kode Referral</p>
                    </div>
                </div>

                <!-- Referral Code -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="referral-code-display" id="referralCode">{{ $user->refferal_code }}</div>
                    <button class="btn-copy-small" onclick="copyReferralCode()" title="Copy Kode">
                        <i class="bi bi-clipboard" id="copyCodeIcon"></i>
                    </button>
                </div>

                <!-- Referral Link -->
                <div>
                    <p class="text-muted mb-2 small">Link Referral</p>
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <div class="referral-link-display" id="referralLink">{{ $referralLink }}</div>
                        <button class="btn-copy-small" onclick="copyReferralLink()" title="Copy Link">
                            <i class="bi bi-link-45deg" id="copyLinkIcon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Team Members List -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Daftar Team Member</h6>
                </div>

                @forelse($teamMembers as $member)
                    <!-- Member Item -->
                    <div class="team-member-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="team-avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="text-white fw-bold mb-1" style="font-size: 14px;">{{ $member->username }}</div>
                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-telephone-fill text-muted" style="font-size: 11px;"></i>
                                        <small class="text-muted">{{ $member->phone }}</small>
                                    </div>
                                </div>
                                <small class="text-muted" style="font-size: 11px;">
                                    <i class="bi bi-calendar3"></i>
                                    Bergabung {{ $member->created_at->diffForHumans() }}
                                </small>
                            </div>
                            {{-- <div class="team-status active">
                                <i class="bi bi-circle-fill"></i>
                            </div> --}}
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-people text-muted" style="font-size: 48px;"></i>
                        </div>
                        <p class="text-muted mb-2">Belum ada team member</p>
                        <small class="text-muted" style="font-size: 12px;">
                            Bagikan kode atau link referral kamu untuk mendapatkan team member
                        </small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .referral-link-display {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            color: var(--text-muted);
            font-size: 11px;
            font-family: monospace;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }
    </style>

    <script>
        function showToast(message, type = 'success') {
            const bgColor = type === 'success' ? '#28a745' : '#dc3545';
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed; 
                top: 20px; 
                right: 20px; 
                background: ${bgColor}; 
                color: white; 
                padding: 12px 20px; 
                border-radius: 8px; 
                z-index: 9999; 
                font-size: 14px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            `;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 2000);
        }

        function copyReferralCode() {
            const codeElement = document.getElementById('referralCode');
            const code = codeElement.textContent;
            const icon = document.getElementById('copyCodeIcon');

            navigator.clipboard.writeText(code).then(() => {
                icon.classList.remove('bi-clipboard');
                icon.classList.add('bi-check-lg');

                showToast('Kode referral berhasil disalin!');

                setTimeout(() => {
                    icon.classList.remove('bi-check-lg');
                    icon.classList.add('bi-clipboard');
                }, 2000);
            }).catch(err => {
                showToast('Gagal menyalin kode referral', 'error');
                console.error('Error copying:', err);
            });
        }

        function copyReferralLink() {
            const linkElement = document.getElementById('referralLink');
            const link = linkElement.textContent;
            const icon = document.getElementById('copyLinkIcon');

            navigator.clipboard.writeText(link).then(() => {
                icon.classList.remove('bi-link-45deg');
                icon.classList.add('bi-check-lg');

                showToast('Link referral berhasil disalin!');

                setTimeout(() => {
                    icon.classList.remove('bi-check-lg');
                    icon.classList.add('bi-link-45deg');
                }, 2000);
            }).catch(err => {
                showToast('Gagal menyalin link referral', 'error');
                console.error('Error copying:', err);
            });
        }
    </script>
@endsection
