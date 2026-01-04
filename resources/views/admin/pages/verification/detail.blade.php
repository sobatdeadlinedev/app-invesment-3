@extends('admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Verification Detail - {{ $verification->user->name }}</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.verification.index') }}"
                                class="text-muted text-hover-primary">Verification</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $verification->user->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center p-5 mb-10">
                    <i class="ki-outline ki-shield-tick fs-2hx text-success me-4"></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">Success</h4>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center p-5 mb-10">
                    <i class="ki-outline ki-cross-circle fs-2hx text-danger me-4"></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">Error</h4>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">

                    <!--begin::Card - Identity Photo-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Identity Photo</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            @if ($verification->identity_photo_path)
                                <div class="text-center">
                                    <img src="{{ $verification->identity_photo_url }}" alt="Identity Photo"
                                        class="img-fluid rounded" style="max-height: 600px; cursor: pointer;"
                                        data-bs-toggle="modal" data-bs-target="#identityPhotoModal">
                                    <p class="text-muted mt-3">Click image to enlarge</p>
                                </div>

                                <!-- Modal for full image -->
                                <div class="modal fade" id="identityPhotoModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Identity Photo - {{ $verification->user->name }}
                                                </h5>
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                    data-bs-dismiss="modal">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </div>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ $verification->identity_photo_url }}" alt="Identity Photo"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <i class="ki-outline ki-file-deleted fs-5x text-muted mb-5"></i>
                                    <p class="text-muted">No identity photo uploaded</p>
                                </div>
                            @endif
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->

                    <!--begin::Card - Selfie Photo-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Selfie with Identity</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            @if ($verification->selfie_with_identity_path)
                                <div class="text-center">
                                    <img src="{{ $verification->selfie_with_identity_url }}" alt="Selfie with Identity"
                                        class="img-fluid rounded" style="max-height: 600px; cursor: pointer;"
                                        data-bs-toggle="modal" data-bs-target="#selfiePhotoModal">
                                    <p class="text-muted mt-3">Click image to enlarge</p>
                                </div>

                                <!-- Modal for full image -->
                                <div class="modal fade" id="selfiePhotoModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Selfie with Identity -
                                                    {{ $verification->user->name }}</h5>
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                    data-bs-dismiss="modal">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </div>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ $verification->selfie_with_identity_url }}"
                                                    alt="Selfie with Identity" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <i class="ki-outline ki-file-deleted fs-5x text-muted mb-5"></i>
                                    <p class="text-muted">No selfie photo uploaded</p>
                                </div>
                            @endif
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->

                </div>
                <!--end::Content-->

                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
                    <!--begin::Card-->
                    <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary"
                        data-kt-sticky-offset="{default: false, lg: '200px'}"
                        data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto"
                        data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Summary</h2>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Section - User Info-->
                            <div class="mb-7">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-60px symbol-circle me-3">
                                        <img alt="Pic" src="{{ asset('assets/media/avatars/blank.png') }}" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-2">
                                            {{ $verification->user->name }}
                                        </a>
                                        <a href="#" class="fw-semibold text-gray-600 text-hover-primary">
                                            {{ $verification->user->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--end::Section-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Separator-->

                            <!--begin::Section - Verification Details-->
                            <div class="mb-7">
                                <h5 class="mb-4">Verification Details</h5>
                                <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2 m-0">
                                    <tr>
                                        <td class="text-gray-500">Full Name:</td>
                                        <td class="text-gray-800">{{ $verification->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">Identity Number:</td>
                                        <td class="text-gray-800">
                                            <span
                                                class="badge badge-light-primary">{{ $verification->identity_number }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">Identity Type:</td>
                                        <td class="text-gray-800">{{ $verification->identity_type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">Status:</td>
                                        <td>
                                            @if ($verification->isVerified())
                                                <span class="badge badge-light-success">
                                                    <i class="ki-outline ki-check-circle fs-5"></i> Verified
                                                </span>
                                            @else
                                                <span class="badge badge-light-warning">
                                                    <i class="ki-outline ki-time fs-5"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">Submitted:</td>
                                        <td class="text-gray-800">
                                            {{ $verification->submitted_at->format('d M Y, h:i a') }}</td>
                                    </tr>
                                    @if ($verification->isVerified())
                                        <tr>
                                            <td class="text-gray-500">Verified:</td>
                                            <td class="text-gray-800">
                                                {{ $verification->verified_at->format('d M Y, h:i a') }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <!--end::Section-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Separator-->

                            <!--begin::Actions-->
                            @if (!$verification->isVerified())
                                <div class="mb-0">
                                    <h5 class="mb-4">Actions</h5>

                                    <form action="{{ route('admin.verification.verify', $verification->id) }}"
                                        method="POST" class="mb-3">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100"
                                            onclick="return confirm('Are you sure you want to verify this account? This will grant the user verified status.')">
                                            <i class="ki-outline ki-check fs-2"></i>
                                            Verify Account
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.verification.reject', $verification->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100"
                                            onclick="return confirm('Are you sure you want to reject this verification? User will be able to resubmit their documents.')">
                                            <i class="ki-outline ki-cross fs-2"></i>
                                            Reject Verification
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="mb-0">
                                    <div class="alert alert-success d-flex align-items-center p-5">
                                        <i class="ki-outline ki-shield-tick fs-2hx text-success me-4"></i>
                                        <div class="d-flex flex-column">
                                            <span>This account has been verified</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!--end::Actions-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
            </div>
            <!--end::Layout-->
        </div>
    </div>
    <!--end::Content-->

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Auto hide alert after 5 seconds
                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 5000);
            });
        </script>
    @endpush
@endsection
