@extends('admin.layouts.app')
@section('content')
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Edit Trading Signal</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.signals.index') }}" class="text-muted text-hover-primary">Signals</a>
                        </li>
                        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                        <li class="breadcrumb-item text-muted">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

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

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.signals.update', $signal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-10">
                            <label class="form-label required">Select Coin</label>
                            <select name="coin" class="form-select @error('coin') is-invalid @enderror" required>
                                <option value="">Choose a coin...</option>
                                @foreach ($coins as $symbol => $info)
                                    <option value="{{ $symbol }}"
                                        {{ old('coin', $signal->coin) == $symbol ? 'selected' : '' }}>
                                        {{ $info['symbol'] }} - {{ $info['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('coin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label required">Signal Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                placeholder="e.g., BTC/USDT Long Signal" value="{{ old('title', $signal->title) }}"
                                required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                                placeholder="Optional description about this signal">{{ old('description', $signal->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-10">
                            <div class="col-md-6">
                                <label class="form-label required">Opening Price (USDT)</label>
                                <input type="number" name="entry_price"
                                    class="form-control @error('entry_price') is-invalid @enderror" step="0.01"
                                    placeholder="0.00" value="{{ old('entry_price', $signal->entry_price) }}" required>
                                @error('entry_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Starting price for this signal</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Settlement Price (USDT)</label>
                                <input type="number" name="target_price"
                                    class="form-control @error('target_price') is-invalid @enderror" step="0.01"
                                    placeholder="0.00" value="{{ old('target_price', $signal->target_price) }}" required>
                                @error('target_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Expected settlement price</div>
                            </div>
                        </div>

                        <div class="alert alert-warning d-flex align-items-center p-5 mb-10">
                            <i class="ki-outline ki-information fs-2hx text-warning me-4"></i>
                            <div class="d-flex flex-column">
                                <h5 class="mb-1">Note</h5>
                                <span>You can only edit this signal while it's still OPEN. Once closed or settled, changes
                                    are not allowed.</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.signals.show', $signal->id) }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ki-outline ki-check fs-2"></i>Update Signal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
