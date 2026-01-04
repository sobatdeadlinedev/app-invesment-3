@extends('admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Team List</h1>
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
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_teams">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-150px">User</th>
                                <th class="min-w-125px">Referral Code</th>
                                <th class="min-w-100px">Team Count</th>
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
                                        <span class="badge badge-light-success">{{ $user->referrals_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-light btn-active-light-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_team_detail_{{ $user->id }}"
                                            @if ($user->referrals_count == 0) disabled @endif>
                                            <i class="ki-outline ki-eye fs-5"></i> Detail
                                        </button>
                                    </td>
                                </tr>

                                <!--begin::Modal - Team Detail-->
                                <div class="modal fade" id="kt_modal_team_detail_{{ $user->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered mw-800px">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div>
                                                    <h2 class="fw-bold">Team Members - {{ $user->name }}</h2>
                                                    <span class="text-muted fs-7">Referral Code:
                                                        {{ $user->refferal_code }}</span>
                                                </div>
                                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                    data-bs-dismiss="modal">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </div>
                                            </div>
                                            <div class="modal-body px-5 my-7">
                                                @if ($user->referrals->count() > 0)
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                                            <thead>
                                                                <tr class="fw-bold text-muted">
                                                                    <th class="min-w-150px">Name</th>
                                                                    <th class="min-w-150px">Email</th>
                                                                    <th class="min-w-100px">Used At</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($user->referrals as $referral)
                                                                    <tr>
                                                                        <td>
                                                                            <span
                                                                                class="text-gray-800 fw-bold">{{ $referral->referred->name }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="text-gray-600">{{ $referral->referred->email }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="text-gray-600">{{ $referral->used_at->format('d M Y, h:i a') }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="text-center py-10">
                                                        <div class="text-gray-600">No team members yet</div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal - Team Detail-->
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-10">
                                        <div class="text-gray-600">No users found</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content-->

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
