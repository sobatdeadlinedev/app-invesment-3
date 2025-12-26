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

                <!-- Member Item 2 -->
                <div class="team-member-item">
                    <div class="d-flex align-items-center gap-3">
                        <div class="team-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">JaneSmith456</div>
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-telephone-fill text-muted" style="font-size: 11px;"></i>
                                <small class="text-muted">+62 813-9876-5432</small>
                            </div>
                        </div>
                        <div class="team-status active">
                            <i class="bi bi-circle-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- Member Item 3 -->
                <div class="team-member-item">
                    <div class="d-flex align-items-center gap-3">
                        <div class="team-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">MikeJohnson</div>
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-telephone-fill text-muted" style="font-size: 11px;"></i>
                                <small class="text-muted">+62 814-5555-1234</small>
                            </div>
                        </div>
                        <div class="team-status active">
                            <i class="bi bi-circle-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- Member Item 4 -->
                <div class="team-member-item">
                    <div class="d-flex align-items-center gap-3">
                        <div class="team-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">SarahWilliams</div>
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-telephone-fill text-muted" style="font-size: 11px;"></i>
                                <small class="text-muted">+62 815-7777-8888</small>
                            </div>
                        </div>
                        <div class="team-status active">
                            <i class="bi bi-circle-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- Member Item 5 -->
                <div class="team-member-item" style="border-bottom: none;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="team-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">DavidBrown</div>
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-telephone-fill text-muted" style="font-size: 11px;"></i>
                                <small class="text-muted">+62 816-4444-9999</small>
                            </div>
                        </div>
                        <div class="team-status active">
                            <i class="bi bi-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            {{-- <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <h6 class="text-white mb-1" style="font-size: 13px;">Informasi Team</h6>
                        <p class="small text-muted mb-0" style="font-size: 12px;">
                            Daftar ini menampilkan semua member yang tergabung dalam team Anda. Status aktif ditandai dengan
                            indikator hijau.
                        </p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
