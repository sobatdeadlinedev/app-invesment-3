@extends('admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Team List (Multi-Level)</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Team Management</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                            <input type="text" id="search-team" class="form-control form-control-solid w-250px ps-13"
                                placeholder="Search user" />
                        </div>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_teams">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-150px">User</th>
                                    <th class="min-w-125px">Referral Code</th>
                                    <th class="min-w-100px">Direct</th>
                                    <th class="min-w-100px">Total Network</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 mb-1">{{ $user->name }}</span>
                                                <span class="text-muted fs-7">{{ $user->email }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-primary">{{ $user->refferal_code }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ $user->referrals_count }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-light-success">{{ $user->total_multi_level_referrals }}</span>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-light btn-active-light-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_team_detail_{{ $user->id }}"
                                                @if ($user->total_multi_level_referrals == 0) disabled @endif>
                                                <i class="ki-outline ki-eye fs-5"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-10">
                                            <div class="text-gray-600">No users found</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content-->

    <!--begin::Modals-->
    @foreach ($users as $user)
        <!--begin::Modal - Team Detail-->
        <div class="modal fade" id="kt_modal_team_detail_{{ $user->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-950px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_team_detail_header">
                        <!--begin::Modal title-->
                        <div class="d-flex flex-column">
                            <h2 class="fw-bold mb-1">Multi-Level Team Network</h2>
                            <div class="d-flex align-items-center">
                                <span class="text-gray-600 fs-6 me-3">{{ $user->name }}</span>
                                <span class="badge badge-light-primary me-2">{{ $user->refferal_code }}</span>
                                <span class="badge badge-light-success">Total:
                                    {{ $user->total_multi_level_referrals }}</span>
                            </div>
                        </div>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        @if ($user->multi_level_referrals->count() > 0)
                            <!--begin::Level Stats-->
                            <div class="d-flex gap-3 mb-6">
                                @php
                                    $levelCounts = $user->multi_level_referrals->groupBy('level')->map->count();
                                @endphp
                                @foreach ($levelCounts as $level => $count)
                                    <div class="border border-gray-300 border-dashed rounded px-4 py-3">
                                        <div class="fw-bold text-gray-800 fs-4">{{ $count }}</div>
                                        <div class="text-muted fs-7">Level {{ $level }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <!--end::Level Stats-->

                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="ps-4 min-w-50px rounded-start">Level</th>
                                            <th class="min-w-175px">Name</th>
                                            <th class="min-w-175px">Email</th>
                                            <th class="min-w-125px">Direct Referrer</th>
                                            <th class="min-w-125px rounded-end">Joined Date</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @foreach ($user->multi_level_referrals->sortBy('level') as $referral)
                                            <tr>
                                                <td class="ps-4">
                                                    @if ($referral['level'] == 1)
                                                        <span class="badge badge-light-success">L1</span>
                                                    @elseif($referral['level'] == 2)
                                                        <span class="badge badge-light-info">L2</span>
                                                    @elseif($referral['level'] == 3)
                                                        <span class="badge badge-light-warning">L3</span>
                                                    @else
                                                        <span
                                                            class="badge badge-light-primary">L{{ $referral['level'] }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-circle symbol-35px me-3">
                                                            <div
                                                                class="symbol-label bg-light-primary text-primary fw-bold fs-6">
                                                                {{ substr($referral['referred']['name'], 0, 1) }}
                                                            </div>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Name-->
                                                        <div class="d-flex flex-column">
                                                            <span class="text-gray-800 fw-bold text-hover-primary mb-1">
                                                                {{ $referral['referred']['name'] }}
                                                            </span>
                                                        </div>
                                                        <!--end::Name-->
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-gray-600 fw-semibold d-block">
                                                        {{ $referral['referred']['email'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fs-7">
                                                        {{ $referral['referrer_name'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-gray-800 fw-bold mb-1">
                                                            {{ \Carbon\Carbon::parse($referral['used_at'])->format('d M Y') }}
                                                        </span>
                                                        <span class="text-muted fs-7">
                                                            {{ \Carbon\Carbon::parse($referral['used_at'])->format('h:i A') }}
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        @else
                            <!--begin::Empty state-->
                            <div class="text-center py-10">
                                <div class="mb-5">
                                    <i class="ki-outline ki-information-2 fs-3x text-gray-400"></i>
                                </div>
                                <div class="text-gray-600 fw-semibold fs-6">No team members yet</div>
                                <div class="text-muted fs-7 mt-2">Team members will appear here once they join</div>
                            </div>
                            <!--end::Empty state-->
                        @endif
                    </div>
                    <!--end::Modal body-->

                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                    <!--end::Modal footer-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Team Detail-->
    @endforeach
    <!--end::Modals-->

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Search functionality
                $('#search-team').on('keyup', function() {
                    const value = $(this).val().toLowerCase();
                    $('#kt_table_teams tbody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>
    @endpush
@endsection
