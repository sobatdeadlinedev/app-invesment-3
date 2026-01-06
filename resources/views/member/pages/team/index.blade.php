@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Team Stats Cards Row -->
            <div class="row g-2 mb-3">
                <!-- Total Network -->
                <div class="col-6">
                    <div class="card-dark shadow-sm p-3 h-100">
                        <div class="text-center">
                            <div class="team-icon-wrapper mb-2">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <p class="text-muted mb-1 small">Total Network</p>
                            <h3 class="text-gold mb-0 fw-bold">{{ $totalTeam }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Direct Team -->
                <div class="col-6">
                    <div class="card-dark shadow-sm p-3 h-100">
                        <div class="text-center">
                            <div class="team-icon-wrapper mb-2">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <p class="text-muted mb-1 small">Direct Team</p>
                            <h3 class="text-info mb-0 fw-bold">{{ $directTeam }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Level Statistics -->
            @if ($levelStats->count() > 0)
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white mb-3">Statistik Per Level</h6>
                    <div class="d-flex gap-2 overflow-auto pb-2">
                        @foreach ($levelStats as $level => $stats)
                            <div class="level-stat-card">
                                <div class="level-badge level-{{ $level }}">L{{ $level }}</div>
                                <div class="level-count">{{ $stats['count'] }}</div>
                                <div class="level-label">Member</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Referral Code & Link Card -->
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

            <!-- Level Filter Tabs -->
            @if ($totalTeam > 0)
                <div class="card-dark shadow-sm p-2 mb-3">
                    <div class="d-flex gap-2 overflow-auto">
                        <button class="filter-tab active" onclick="filterLevel('all')">
                            <i class="bi bi-grid-fill"></i> Semua ({{ $totalTeam }})
                        </button>
                        @foreach ($levelStats as $level => $stats)
                            <button class="filter-tab" onclick="filterLevel({{ $level }})">
                                L{{ $level }} ({{ $stats['count'] }})
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Team Members List -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Daftar Team Member</h6>
                </div>

                @forelse($teamMembers->sortBy('level') as $member)
                    <!-- Member Item -->
                    <div class="team-member-item" data-level="{{ $member->level }}">
                        <div class="d-flex align-items-start gap-3">
                            <!-- Level Badge -->
                            <div class="level-badge-vertical level-{{ $member->level }}">
                                <div class="level-text">L{{ $member->level }}</div>
                            </div>

                            <div class="team-avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="text-white fw-bold" style="font-size: 14px;">
                                        {{ $member->username }}
                                    </div>
                                </div>

                                <!-- Info Row -->
                                <div class="d-flex align-items-center gap-3 flex-wrap mb-1">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-telephone-fill text-muted" style="font-size: 11px;"></i>
                                        <small class="text-muted">{{ $member->phone }}</small>
                                    </div>
                                </div>

                                <!-- Referrer Info -->
                                @if ($member->level > 1)
                                    <div class="referrer-info mb-1">
                                        <i class="bi bi-arrow-return-right"></i>
                                        <small>Direferral oleh: <span
                                                class="text-warning">{{ $member->referrer_name }}</span></small>
                                    </div>
                                @endif

                                <!-- Join Date -->
                                <small class="text-muted" style="font-size: 11px;">
                                    <i class="bi bi-calendar3"></i>
                                    Bergabung {{ \Carbon\Carbon::parse($member->created_at)->diffForHumans() }}
                                </small>
                            </div>
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

        /* Level Statistics Cards */
        .level-stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            text-align: center;
            min-width: 80px;
            flex-shrink: 0;
        }

        .level-badge {
            font-size: 10px;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 6px;
        }

        .level-badge.level-1 {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .level-badge.level-2 {
            background: rgba(23, 162, 184, 0.2);
            color: #17a2b8;
        }

        .level-badge.level-3 {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .level-badge.level-4,
        .level-badge.level-5,
        .level-badge.level-6 {
            background: rgba(108, 117, 125, 0.2);
            color: #6c757d;
        }

        .level-count {
            font-size: 20px;
            font-weight: bold;
            color: var(--gold);
            margin-bottom: 2px;
        }

        .level-label {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* Filter Tabs */
        .filter-tab {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 16px;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            transition: all 0.3s;
        }

        .filter-tab.active {
            background: var(--gold);
            color: #000;
            border-color: var(--gold);
        }

        .filter-tab:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Level Badge Vertical */
        .level-badge-vertical {
            padding: 6px 10px;
            border-radius: 8px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            min-width: 36px;
        }

        .level-badge-vertical.level-1 {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .level-badge-vertical.level-2 {
            background: rgba(23, 162, 184, 0.2);
            color: #17a2b8;
        }

        .level-badge-vertical.level-3 {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .level-badge-vertical.level-4,
        .level-badge-vertical.level-5,
        .level-badge-vertical.level-6 {
            background: rgba(108, 117, 125, 0.2);
            color: #6c757d;
        }

        .level-text {
            font-size: 11px;
            font-weight: bold;
        }

        /* Referrer Info */
        .referrer-info {
            background: rgba(255, 193, 7, 0.1);
            border-left: 2px solid #ffc107;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .referrer-info i {
            color: #ffc107;
            margin-right: 4px;
        }

        /* Team Member Item Enhancement */
        .team-member-item {
            transition: all 0.3s;
        }

        .team-member-item.hidden {
            display: none;
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

        // Filter by Level
        function filterLevel(level) {
            const allMembers = document.querySelectorAll('.team-member-item');
            const allTabs = document.querySelectorAll('.filter-tab');

            // Update active tab
            allTabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');

            // Filter members
            if (level === 'all') {
                allMembers.forEach(member => {
                    member.classList.remove('hidden');
                });
            } else {
                allMembers.forEach(member => {
                    const memberLevel = parseInt(member.getAttribute('data-level'));
                    if (memberLevel === level) {
                        member.classList.remove('hidden');
                    } else {
                        member.classList.add('hidden');
                    }
                });
            }
        }
    </script>
@endsection
