<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ url('/') }}/" />
    <title>STARS INVESMENT</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ $appConfig['app_logo']['value'] }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-5 p-lg-10 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid my-auto">
                    <div class="w-100 w-lg-500px p-10">
                        <form class="form w-100" method="POST" action="{{ route('forget-password.send-otp') }}">
                            @csrf

                            <div class="text-center mb-11">
                                <h1 class="text-gray-900 fw-bolder mb-3">Lupa Password?</h1>
                                <div class="text-gray-500 fw-semibold fs-6">
                                    Masukkan email Anda untuk menerima kode OTP
                                </div>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="fv-row mb-8">
                                <input type="email" placeholder="Email" name="email" autocomplete="off"
                                    value="{{ old('email') }}"
                                    class="form-control bg-transparent @error('email') is-invalid @enderror" required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-10">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Kirim Kode OTP</span>
                                </button>
                            </div>

                            <div class="text-gray-500 text-center fw-semibold fs-6">
                                <a href="{{ route('login') }}" class="link-primary fw-bold">
                                    Kembali ke Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                style="background-image: url(assets/media/misc/auth-bg.png)">
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="#" class="mb-12 mb-lg-12">
                        <img alt="Logo"
                            src="{{ $appConfig['app_logo']['value'] ?? 'assets/media/logos/default-dark.svg' }}"
                            class="h-150px h-lg-180px" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
</body>

</html>
