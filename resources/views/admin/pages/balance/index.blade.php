@extends('admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        User Balance</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">User Balance</li>
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
                        <h3 class="fw-bold m-0">All User Balances</h3>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_balances">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-150px">Name</th>
                                <th class="min-w-150px">Email</th>
                                <th class="min-w-125px">Phone</th>
                                <th class="text-end min-w-125px">Balance</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold">{{ $user->name }}</span>
                                                <span class="text-muted small">{{ $user->username }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-gray-800">{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-800">{{ $user->phone }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span
                                            class="badge badge-light-{{ $user->balance >= 0 ? 'success' : 'danger' }} fs-7 fw-bold px-4 py-3">
                                            {{ number_format($user->balance, 2) }} USDT
                                        </span>
                                    </td>
                                </tr>
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

                    <!--begin::Pagination-->
                    <div class="d-flex justify-content-center mt-5">
                        {{ $users->links() }}
                    </div>
                    <!--end::Pagination-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content-->
@endsection
