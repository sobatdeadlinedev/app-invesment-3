<!DOCTYPE html>
<html lang="id">

<head>
    <base href="/" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://via.placeholder.com/40">
    <title>My Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Mobile-First Design with Jhonson Investment Theme */
        :root {
            --primary-dark: #1a1d3f;
            --secondary-dark: #252850;
            --card-dark: #2d3158;
            --gold-color: #f5a623;
            --gold-hover: #e69500;
            --blue-color: #3bb5e8;
            --blue-dark: #2a8ab8;
            --text-muted: #a5a8c4;
            --border-color: #3d4170;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--primary-dark);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            color: #ffffff;
        }

        /* Mobile Container */
        .mobile-container {
            width: 425px;
            height: 100vh;
            background-color: var(--primary-dark);
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Fixed Header */
        .fixed-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: linear-gradient(135deg, #2d3158 0%, #252850 100%);
            border-bottom: 2px solid var(--border-color);
            padding: 15px 20px 12px 20px;
        }

        /* Header Layout - 2 kolom (left & right) */
        .header-grid {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-right {
            display: flex;
            justify-content: flex-end;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .app-logo {
            height: 32px;
            width: auto;
            object-fit: contain;
        }

        .user-email {
            color: var(--text-muted);
            font-size: 11px;
        }

        .btn-logout {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 8px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: rgba(220, 53, 69, 0.2);
        }

        .btn-logout i {
            color: #dc3545;
            font-size: 18px;
        }

        /* Scrollable Content */
        .scrollable-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Hide scrollbar but keep functionality */
        .scrollable-content::-webkit-scrollbar {
            width: 0px;
        }

        /* Content Sections */
        .content-section {
            padding: 20px;
        }

        /* Cards */
        .card-dark {
            background-color: var(--card-dark);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: box-shadow 0.2s ease;
        }

        .card-dark:hover {
            box-shadow: 0 4px 12px rgba(218, 165, 32, 0.15);
        }

        /* Gold Theme Colors */
        .text-gold {
            color: var(--gold-color) !important;
        }

        .bg-gold {
            background-color: var(--gold-color) !important;
        }

        .btn-gold {
            background-color: var(--gold-color);
            border-color: var(--gold-color);
            color: #000;
            font-weight: 600;
            transition: all 0.2s ease;
            border-radius: 8px;
        }

        .btn-gold:hover {
            background-color: var(--gold-hover);
            border-color: var(--gold-hover);
            color: #000;
        }

        /* Text Colors */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .text-white {
            color: #ffffff !important;
        }

        /* Fixed Bottom Navigation */
        .bottom-nav {
            position: sticky;
            bottom: 0;
            width: 100%;
            background: linear-gradient(135deg, #2d3158, #252850);
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-around;
            padding: 12px 0 12px 0;
            backdrop-filter: blur(10px);
            z-index: 100;
        }

        .nav-item {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 11px;
            text-align: center;
            flex: 1;
            transition: all 0.2s ease;
            padding: 6px 2px;
            border-radius: 4px;
        }

        .nav-item:hover {
            color: var(--blue-color);
            background-color: rgba(59, 181, 232, 0.1);
        }

        .nav-item.active {
            color: var(--blue-color);
            font-weight: 600;
        }

        .nav-item.active i {
            color: var(--blue-color);
        }

        .nav-item span {
            display: block;
            margin-top: 2px;
        }

        /* Responsive for larger screens */
        @media (min-width: 768px) {
            body {
                background: linear-gradient(135deg, #1a1d3f 0%, #252850 100%);
            }

            .mobile-container {
                border-radius: 0;
                overflow: hidden;
            }
        }
    </style>
</head>

<body>
    <div class="mobile-container">
        <!-- Fixed Header -->
        <div class="fixed-header">
            <div class="header-grid">
                <!-- Left: App Logo -->
                <div class="header-left">
                    <img src="assets/media/logos/logo-ji.png" alt="App Logo" class="app-logo">
                </div>

                <!-- Right: Logout -->
                <div class="header-right">
                    <a href="{{ route('login') }}" class="btn-logout" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Scrollable Content Area -->
        <div class="scrollable-content">
            <div class="content-section">
                <h5 class="text-white mb-3">Halo, Jhon Doe</h5>

                <!-- Example Card 1 -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white mb-2">Card Title</h6>
                    <p class="small text-muted mb-0">
                        Ini adalah contoh card dengan styling yang konsisten. Anda bisa menambahkan konten apapun di
                        sini.
                    </p>
                </div>

                <!-- Example Card 2 with Button -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white mb-2">Action Card</h6>
                    <p class="small text-muted mb-3">
                        Card ini memiliki tombol untuk aksi tertentu.
                    </p>
                    <button class="btn btn-gold w-100">
                        <i class="bi bi-check-circle me-2"></i>Lakukan Aksi
                    </button>
                </div>

                <!-- Example List -->
                <div class="card-dark shadow-sm p-0 mb-3">
                    <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                        <h6 class="text-white mb-0">Daftar Item</h6>
                    </div>
                    <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white fw-bold" style="font-size: 14px;">Item 1</div>
                                <small class="text-muted">Deskripsi item pertama</small>
                            </div>
                            <span class="text-gold fw-bold">Rp 100.000</span>
                        </div>
                    </div>
                    <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white fw-bold" style="font-size: 14px;">Item 2</div>
                                <small class="text-muted">Deskripsi item kedua</small>
                            </div>
                            <span class="text-gold fw-bold">Rp 200.000</span>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white fw-bold" style="font-size: 14px;">Item 3</div>
                                <small class="text-muted">Deskripsi item ketiga</small>
                            </div>
                            <span class="text-gold fw-bold">Rp 300.000</span>
                        </div>
                    </div>
                </div>

                <!-- Extra content for scrolling demo -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white mb-2">More Content</h6>
                    <p class="small text-muted mb-0">
                        Scroll ke bawah untuk melihat lebih banyak konten. Header dan bottom nav akan tetap di tempat.
                    </p>
                </div>
            </div>
        </div>

        <!-- Fixed Bottom Navbar -->
        <div class="bottom-nav">
            <a href="#" class="nav-item active">
                <i class="bi bi-house-door-fill d-block fs-5"></i>
                <span>Home</span>
            </a>
            <a href="#" class="nav-item">
                <i class="bi bi-graph-up d-block fs-5"></i>
                <span>Investasi</span>
            </a>
            <a href="#" class="nav-item">
                <i class="bi bi-people-fill d-block fs-5"></i>
                <span>Team</span>
            </a>
            <a href="#" class="nav-item">
                <i class="bi bi-wallet-fill d-block fs-5"></i>
                <span>Dompetku</span>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
