<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../" />
    <title>Register - MLM App</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>

<body id="kt_body" class="app-blank">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>

    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">
                        <form class="form w-100" method="POST" action="{{ route('register.post') }}">
                            @csrf

                            <div class="text-center mb-11">
                                <h1 class="text-gray-900 fw-bolder mb-3">Sign Up</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Daftar Akun Baru</div>
                            </div>

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
                                <input type="text" placeholder="Nama Lengkap" name="name" autocomplete="off"
                                    value="{{ old('name') }}"
                                    class="form-control bg-transparent @error('name') is-invalid @enderror" required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Username" name="username" autocomplete="off"
                                    value="{{ old('username') }}"
                                    class="form-control bg-transparent @error('username') is-invalid @enderror"
                                    required />
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Nomor Telepon (08xxx)" name="phone"
                                    autocomplete="off" value="{{ old('phone') }}"
                                    class="form-control bg-transparent @error('phone') is-invalid @enderror" required />
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nomor akan otomatis diformat ke 62xxx</div>
                            </div>

                            <div class="fv-row mb-8">
                                <div class="position-relative">
                                    <input type="password" placeholder="Password" name="password" autocomplete="off"
                                        id="password"
                                        class="form-control bg-transparent @error('password') is-invalid @enderror"
                                        required />
                                    <span
                                        class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                        data-kt-password-meter-control="visibility"
                                        onclick="togglePassword('password', 'password-icon')">
                                        <i class="ki-outline ki-eye-slash fs-2" id="password-icon"></i>
                                        <i class="ki-outline ki-eye fs-2 d-none" id="password-icon-show"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Minimal 8 karakter</div>
                            </div>

                            <div class="fv-row mb-8">
                                <div class="position-relative">
                                    <input type="password" placeholder="Konfirmasi Password"
                                        name="password_confirmation" autocomplete="off" id="password_confirmation"
                                        class="form-control bg-transparent" required />
                                    <span
                                        class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                        data-kt-password-meter-control="visibility"
                                        onclick="togglePassword('password_confirmation', 'password-confirmation-icon')">
                                        <i class="ki-outline ki-eye-slash fs-2" id="password-confirmation-icon"></i>
                                        <i class="ki-outline ki-eye fs-2 d-none"
                                            id="password-confirmation-icon-show"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="d-grid mb-10">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Sign Up</span>
                                </button>
                            </div>

                            <div class="text-gray-500 text-center fw-semibold fs-6">
                                Already have an Account?
                                <a href="{{ route('login') }}" class="link-primary fw-semibold">Sign in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                style="background-image: url(assets/media/misc/auth-bg.png)">
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="{{ route('login') }}" class="mb-12 mb-lg-12">
                        <img alt="Logo" src="assets/media/logos/logo-ji.png" class="h-150px h-lg-180px" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        var hostUrl = "assets/";
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const iconHide = document.getElementById(iconId);
            const iconShow = document.getElementById(iconId + '-show');

            if (input.type === 'password') {
                input.type = 'text';
                iconHide.classList.add('d-none');
                iconShow.classList.remove('d-none');
            } else {
                input.type = 'password';
                iconHide.classList.remove('d-none');
                iconShow.classList.add('d-none');
            }
        }
    </script>
</body>

</html>
