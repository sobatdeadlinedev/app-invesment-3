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
                    <form action="{{ route('admin.signals.update', $signal->id) }}" method="POST" id="signalForm">
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
                                <!-- Hidden input for actual value -->
                                <input type="hidden" name="entry_price" id="entry_price_hidden" value="{{ old('entry_price', $signal->entry_price) }}">
                                <!-- Display input with formatting -->
                                <input type="text" id="entry_price_display" 
                                    class="form-control @error('entry_price') is-invalid @enderror"
                                    placeholder="92,920.80" 
                                    value="{{ old('entry_price') ? number_format(old('entry_price'), 2) : number_format($signal->entry_price, 2) }}"
                                    required>
                                @error('entry_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Starting price for this signal</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Settlement Price (USDT)</label>
                                <!-- Hidden input for actual value -->
                                <input type="hidden" name="target_price" id="target_price_hidden" value="{{ old('target_price', $signal->target_price) }}">
                                <!-- Display input with formatting -->
                                <input type="text" id="target_price_display"
                                    class="form-control @error('target_price') is-invalid @enderror"
                                    placeholder="95,840.50"
                                    value="{{ old('target_price') ? number_format(old('target_price'), 2) : number_format($signal->target_price, 2) }}"
                                    required>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to format number with commas
            function formatNumber(value) {
                // Remove all non-digit and non-decimal characters
                let num = value.replace(/[^\d.]/g, '');
                
                // Split by decimal point
                let parts = num.split('.');
                
                // Format integer part with commas
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                
                // Limit decimal places to 2
                if (parts[1]) {
                    parts[1] = parts[1].substring(0, 2);
                }
                
                return parts.join('.');
            }

            // Function to parse formatted number to float
            function parseFormattedNumber(value) {
                return value.replace(/,/g, '');
            }

            // Entry Price formatting
            const entryPriceDisplay = document.getElementById('entry_price_display');
            const entryPriceHidden = document.getElementById('entry_price_hidden');

            entryPriceDisplay.addEventListener('input', function(e) {
                let cursorPosition = e.target.selectionStart;
                let oldValue = e.target.value;
                let formatted = formatNumber(e.target.value);
                
                e.target.value = formatted;
                entryPriceHidden.value = parseFormattedNumber(formatted);

                // Adjust cursor position after formatting
                let diff = formatted.length - oldValue.length;
                e.target.selectionStart = e.target.selectionEnd = cursorPosition + diff;
            });

            entryPriceDisplay.addEventListener('blur', function(e) {
                let value = parseFormattedNumber(e.target.value);
                if (value && !isNaN(value)) {
                    let num = parseFloat(value);
                    e.target.value = num.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    entryPriceHidden.value = num;
                }
            });

            // Target Price formatting
            const targetPriceDisplay = document.getElementById('target_price_display');
            const targetPriceHidden = document.getElementById('target_price_hidden');

            targetPriceDisplay.addEventListener('input', function(e) {
                let cursorPosition = e.target.selectionStart;
                let oldValue = e.target.value;
                let formatted = formatNumber(e.target.value);
                
                e.target.value = formatted;
                targetPriceHidden.value = parseFormattedNumber(formatted);

                // Adjust cursor position after formatting
                let diff = formatted.length - oldValue.length;
                e.target.selectionStart = e.target.selectionEnd = cursorPosition + diff;
            });

            targetPriceDisplay.addEventListener('blur', function(e) {
                let value = parseFormattedNumber(e.target.value);
                if (value && !isNaN(value)) {
                    let num = parseFloat(value);
                    e.target.value = num.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    targetPriceHidden.value = num;
                }
            });

            // Form validation before submit
            document.getElementById('signalForm').addEventListener('submit', function(e) {
                const entryPrice = parseFloat(entryPriceHidden.value);
                const targetPrice = parseFloat(targetPriceHidden.value);

                if (isNaN(entryPrice) || entryPrice <= 0) {
                    e.preventDefault();
                    alert('Please enter a valid Opening Price');
                    entryPriceDisplay.focus();
                    return false;
                }

                if (isNaN(targetPrice) || targetPrice <= 0) {
                    e.preventDefault();
                    alert('Please enter a valid Settlement Price');
                    targetPriceDisplay.focus();
                    return false;
                }
            });
        });
    </script>
@endsection