@extends('admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Withdrawal Detail - {{ $withdrawal->reference }}</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.withdrawal.index') }}"
                                class="text-muted text-hover-primary">Withdrawal</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $withdrawal->reference }}</li>
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

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible d-flex align-items-center p-5 mb-10">
                    <i class="ki-outline ki-cross-circle fs-2hx text-danger me-4"></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">Validation Error</h4>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>
                                    @if ($withdrawal->status === 'completed' && $withdrawal->payment_proof)
                                        Payment Proof (Transfer to User)
                                    @else
                                        Withdrawal Information
                                    @endif
                                </h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            @if ($withdrawal->status === 'completed' && $withdrawal->payment_proof)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $withdrawal->payment_proof) }}" alt="Payment Proof"
                                        class="img-fluid rounded" style="max-height: 600px; cursor: pointer;"
                                        data-bs-toggle="modal" data-bs-target="#paymentProofModal">
                                    <p class="text-muted mt-3">Click image to enlarge</p>
                                </div>

                                <!-- Modal for full image -->
                                <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Payment Proof - {{ $withdrawal->reference }}</h5>
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                    data-bs-dismiss="modal">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </div>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $withdrawal->payment_proof) }}"
                                                    alt="Payment Proof" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-primary d-flex align-items-center p-5">
                                    <i class="ki-outline ki-information-5 fs-2hx text-primary me-4"></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-primary">Withdrawal Request</h4>
                                        <span>User has requested a withdrawal. Please transfer the amount to their wallet
                                            and
                                            upload the payment proof to complete this transaction.</span>
                                    </div>
                                </div>

                                @if ($withdrawal->wallet)
                                    <div class="card bg-light-info mt-5">
                                        <div class="card-body">
                                            <h5 class="text-info mb-4"><i class="ki-outline ki-wallet fs-2 me-2"></i>User's
                                                Wallet Details</h5>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small mb-1">Account Number</label>
                                                    <div class="fw-bold text-gray-800">
                                                        {{ $withdrawal->wallet->account_number }}</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="text-muted small mb-1">Account Holder Name</label>
                                                    <div class="fw-bold text-gray-800">
                                                        {{ $withdrawal->wallet->account_name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                                            {{ $withdrawal->user->name }}
                                        </a>
                                        <a href="#" class="fw-semibold text-gray-600 text-hover-primary">
                                            {{ $withdrawal->user->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--end::Section-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Separator-->

                            <!--begin::Section - Transaction Details-->
                            <div class="mb-7">
                                <h5 class="mb-4">Transaction Details</h5>
                                <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2 m-0">
                                    <tr>
                                        <td class="text-gray-500">Reference:</td>
                                        <td class="text-gray-800">
                                            <span class="badge badge-light-primary">{{ $withdrawal->reference }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">Amount:</td>
                                        <td class="text-gray-800 fw-bold text-danger">
                                            {{ number_format($withdrawal->amount, 2) }} USDT</td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">Fee:</td>
                                        <td class="text-gray-800 fw-bold text-warning">
                                            {{ number_format($withdrawal->withdrawal_fee, 2) }} USDT</td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">Total:</td>
                                        <td class="text-gray-800 fw-bold">
                                            {{ number_format($withdrawal->total_amount, 2) }} USDT</td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">Status:</td>
                                        <td>
                                            <span class="badge badge-light-{{ $withdrawal->status_color }}">
                                                {{ ucfirst($withdrawal->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-500">Date:</td>
                                        <td class="text-gray-800">{{ $withdrawal->created_at->format('d M Y, h:i a') }}
                                        </td>
                                    </tr>
                                    @if ($withdrawal->approver)
                                        <tr>
                                            <td class="text-gray-500">Processed By:</td>
                                            <td class="text-gray-800">{{ $withdrawal->approver->name }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <!--end::Section-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Separator-->

                            <!--begin::Actions-->
                            @if ($withdrawal->status === 'pending')
                                <div class="mb-0">
                                    <h5 class="mb-4">Actions</h5>

                                    <!-- Approve Button - Trigger Modal -->
                                    <button type="button" class="btn btn-success w-100 mb-3" data-bs-toggle="modal"
                                        data-bs-target="#approveModal">
                                        <i class="ki-outline ki-check fs-2"></i>
                                        Approve & Complete
                                    </button>

                                    <!-- Reject Button -->
                                    <form action="{{ route('admin.withdrawal.reject', $withdrawal->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100"
                                            onclick="return confirm('Are you sure you want to reject this withdrawal?')">
                                            <i class="ki-outline ki-cross fs-2"></i>
                                            Reject Withdrawal
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="mb-0">
                                    <div class="alert alert-info d-flex align-items-center p-5">
                                        <i class="ki-outline ki-information fs-2hx text-info me-4"></i>
                                        <div class="d-flex flex-column">
                                            <span>This withdrawal has been {{ $withdrawal->status }}</span>
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

    <!-- Approve Modal with Upload -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Approve Withdrawal</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <div class="modal-body px-5 my-7">
                    <form action="{{ route('admin.withdrawal.approve', $withdrawal->id) }}" method="POST"
                        enctype="multipart/form-data" id="approve-form">
                        @csrf

                        <div class="alert alert-warning d-flex align-items-center p-5 mb-5">
                            <i class="ki-outline ki-information-5 fs-2hx text-warning me-4"></i>
                            <div class="d-flex flex-column">
                                <span>Please make sure you have transferred <strong
                                        class="text-danger">{{ number_format($withdrawal->amount, 2) }} USDT</strong> to
                                    the user's wallet before approving.</span>
                            </div>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Upload Payment Proof</label>
                            <input type="file" name="payment_proof"
                                class="form-control form-control-solid @error('payment_proof') is-invalid @enderror"
                                accept="image/*" required onchange="previewImage(event)" />
                            <small class="text-muted d-block mt-1">Upload proof of transfer (JPG, PNG - Max 5MB)</small>
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <!-- Preview -->
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <img id="preview-img" src="" alt="Preview" class="img-fluid rounded border"
                                    style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="text-center pt-10">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">
                                <i class="ki-outline ki-check fs-2"></i>
                                Confirm & Approve
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Auto hide alert after 5 seconds
                setTimeout(function() {
                    $('.alert-dismissible').fadeOut('slow');
                }, 5000);
            });

            function previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview-img').src = e.target.result;
                        document.getElementById('image-preview').style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
@endsection
