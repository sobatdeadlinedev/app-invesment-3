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

        /* Team Page Styles - Tambahkan ke CSS utama */

        /* Team Icon Wrapper */
        .team-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(245, 166, 35, 0.2) 0%, rgba(245, 166, 35, 0.1) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(245, 166, 35, 0.3);
        }

        .team-icon-wrapper i {
            font-size: 28px;
            color: var(--gold-color);
        }

        /* Team Member Item */
        .team-member-item {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }

        .team-member-item:hover {
            background-color: rgba(245, 166, 35, 0.05);
        }

        .team-member-item:last-child {
            border-bottom: none;
        }

        /* Team Avatar */
        .team-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--secondary-dark) 0%, var(--card-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--border-color);
            flex-shrink: 0;
        }

        .team-avatar i {
            font-size: 28px;
            color: var(--gold-color);
        }

        /* Team Status Indicator */
        .team-status {
            width: 12px;
            height: 12px;
            flex-shrink: 0;
        }

        .team-status i {
            font-size: 12px;
        }

        .team-status.active i {
            color: #28a745;
        }

        .team-status.inactive i {
            color: #6c757d;
        }

        /* Responsive adjustments for team page */
        @media (max-width: 375px) {
            .team-member-item {
                padding: 14px 16px;
            }

            .team-avatar {
                width: 40px;
                height: 40px;
            }

            .team-avatar i {
                font-size: 24px;
            }
        }

        /* Profile Page Styles - Tambahkan ke CSS utama */

        /* Profile Avatar Large */
        .profile-avatar-large {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--secondary-dark) 0%, var(--card-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--gold-color);
            flex-shrink: 0;
        }

        .profile-avatar-large i {
            font-size: 38px;
            color: var(--gold-color);
        }

        /* Balance Icon Wrapper */
        .balance-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(245, 166, 35, 0.2) 0%, rgba(245, 166, 35, 0.1) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(245, 166, 35, 0.3);
        }

        .balance-icon-wrapper i {
            font-size: 28px;
            color: var(--gold-color);
        }

        /* Outline Gold Button */
        .btn-outline-gold {
            background-color: transparent;
            border: 2px solid var(--gold-color);
            color: var(--gold-color);
            font-weight: 600;
            transition: all 0.2s ease;
            border-radius: 8px;
        }

        .btn-outline-gold:hover {
            background-color: var(--gold-color);
            border-color: var(--gold-color);
            color: #000;
        }

        /* Badge Count */
        .badge-count {
            background: rgba(245, 166, 35, 0.15);
            border: 1px solid rgba(245, 166, 35, 0.3);
            color: var(--gold-color);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Bank List Item */
        .bank-list-item {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }

        .bank-list-item:hover {
            background-color: rgba(245, 166, 35, 0.05);
        }

        .bank-list-item:last-of-type {
            border-bottom: 1px solid var(--border-color);
        }

        /* Bank Icon Circle */
        .bank-icon-circle {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, rgba(245, 166, 35, 0.2) 0%, rgba(245, 166, 35, 0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(245, 166, 35, 0.3);
            flex-shrink: 0;
        }

        .bank-icon-circle i {
            font-size: 20px;
            color: var(--gold-color);
        }

        /* Bank Action Buttons */
        .btn-bank-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            transition: all 0.2s ease;
            cursor: pointer;
            padding: 0;
            flex-shrink: 0;
        }

        .btn-bank-edit {
            background: rgba(59, 181, 232, 0.1);
            border-color: rgba(59, 181, 232, 0.3);
        }

        .btn-bank-edit:hover {
            background: rgba(59, 181, 232, 0.2);
            border-color: rgba(59, 181, 232, 0.5);
        }

        .btn-bank-edit i {
            color: var(--blue-color);
            font-size: 13px;
        }

        .btn-bank-delete {
            background: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.3);
        }

        .btn-bank-delete:hover {
            background: rgba(220, 53, 69, 0.2);
            border-color: rgba(220, 53, 69, 0.5);
        }

        .btn-bank-delete i {
            color: #dc3545;
            font-size: 13px;
        }

        /* Responsive adjustments for profile page */
        @media (max-width: 375px) {
            .profile-avatar-large {
                width: 50px;
                height: 50px;
            }

            .profile-avatar-large i {
                font-size: 32px;
            }

            .balance-icon-wrapper {
                width: 50px;
                height: 50px;
            }

            .balance-icon-wrapper i {
                font-size: 24px;
            }

            .bank-icon-circle {
                width: 40px;
                height: 40px;
            }

            .bank-icon-circle i {
                font-size: 18px;
            }

            .btn-bank-action {
                width: 28px;
                height: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="mobile-container">
        @include('member.components.header')

        @yield('content')

        @include('member.components.bottombar')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
