@extends('admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Create New Trading Signal</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.signals.index') }}" class="text-muted text-hover-primary">Signals</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Create</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center p-5 mb-10">
                    <i class="ki-outline ki-cross-circle fs-2hx text-danger me-4"></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">Error</h4>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body">
                    <form action="{{ route('admin.signals.store') }}" method="POST">
                        @csrf

                        <!--begin::Input group - Coin Selection-->
                        <div class="mb-10">
                            <label class="form-label required">Select Coin</label>
                            <select name="coin" class="form-select @error('coin') is-invalid @enderror" required>
                                <option value="">Choose a coin...</option>
                                @foreach ($coins as $symbol => $info)
                                    <option value="{{ $symbol }}" {{ old('coin') == $symbol ? 'selected' : '' }}>
                                        {{ $info['symbol'] }} - {{ $info['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('coin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Select the cryptocurrency for this trading signal</div>
                        </div>

                        <!--begin::Input group - Title-->
                        <div class="mb-10">
                            <label class="form-label required">Signal Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                placeholder="e.g., BTC Long Position - Breakout Signal" value="{{ old('title') }}"
                                required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!--begin::Input group - Description-->
                        <div class="mb-10">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                                placeholder="Optional description about this signal">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!--begin::Input group - Prices-->
                        <div class="row mb-10">
                            <div class="col-md-4">
                                <label class="form-label">Entry Price (USDT)</label>
                                <input type="number" name="entry_price"
                                    class="form-control @error('entry_price') is-invalid @enderror" step="0.01"
                                    placeholder="0.00" value="{{ old('entry_price') }}">
                                @error('entry_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Target Price (USDT)</label>
                                <input type="number" name="target_price"
                                    class="form-control @error('target_price') is-invalid @enderror" step="0.01"
                                    placeholder="0.00" value="{{ old('target_price') }}">
                                @error('target_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Stop Loss (USDT)</label>
                                <input type="number" name="stop_loss"
                                    class="form-control @error('stop_loss') is-invalid @enderror" step="0.01"
                                    placeholder="0.00" value="{{ old('stop_loss') }}">
                                @error('stop_loss')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.signals.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ki-outline ki-check fs-2"></i>Create Signal
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content-->
@endsection
