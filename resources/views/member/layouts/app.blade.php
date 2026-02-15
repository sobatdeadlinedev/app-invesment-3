<!DOCTYPE html>
<html lang="id">

<head>
    <base href="/" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ $appConfig['app_logo']['value'] }}" />
    <title>LVUUX Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Mobile-First Design with Light Theme - Soft White, Charcoal Black, Gold */
        :root {
            /* Base Colors dari Palette */
            --soft-white: #F5F5F5;
            --charcoal-black: #212121;
            --gold: #A97E00;

            /* Primary & Background - LIGHT THEME */
            --primary-light: #F5F5F5;
            /* Soft White untuk background utama */
            --secondary-light: #EBEBEB;
            /* Soft white lebih gelap */
            --card-light: #FFFFFF;
            /* Pure white untuk card */

            /* Gold Colors */
            --gold-color: #A97E00;
            --gold-hover: #8a6600;

            /* Text Colors - untuk light theme */
            --text-primary: #212121;
            /* Charcoal untuk text utama */
            --text-secondary: #424242;
            /* Charcoal lebih terang */
            --text-muted: #666666;
            /* Abu-abu untuk text secondary */
            --border-color: #D1D1D1;
            /* Border abu-abu terang */
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--primary-light);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            color: var(--text-primary);
        }

        /* Mobile Container */
        .mobile-container {
            width: 425px;
            height: 100vh;
            background-color: var(--primary-light);
            position: relative;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Language Dropdown */
        .dropdown-menu-language {
            background: var(--card-light) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            min-width: 160px;
            padding: 8px 0;
        }

        .dropdown-menu-language .dropdown-item {
            color: var(--text-primary) !important;
            padding: 10px 16px !important;
            transition: all 0.2s ease !important;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .dropdown-menu-language .dropdown-item:hover {
            background: rgba(169, 126, 0, 0.1) !important;
            color: var(--gold-color) !important;
        }

        .dropdown-menu-language .dropdown-item.active {
            background: rgba(169, 126, 0, 0.15) !important;
            color: var(--gold-color) !important;
            font-weight: 600 !important;
        }

        .dropdown-menu-language .dropdown-item i {
            font-size: 14px;
            width: 20px;
        }

        /* Remove default Bootstrap dropdown arrow */
        .btn-header-icon.dropdown-toggle::after {
            display: none !important;
        }

        /* Dropdown positioning */
        .dropdown-menu-language {
            margin-top: 8px !important;
        }

        /* Fixed Header */
        .fixed-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: linear-gradient(135deg, #FFFFFF 0%, #F5F5F5 100%);
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
            border: 2px solid var(--border-color);
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
            background-color: var(--card-light);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .card-dark:hover {
            box-shadow: 0 4px 12px rgba(169, 126, 0, 0.15);
            border-color: rgba(169, 126, 0, 0.3);
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
            color: #fff;
            font-weight: 600;
            transition: all 0.2s ease;
            border-radius: 8px;
        }

        .btn-gold:hover {
            background-color: var(--gold-hover);
            border-color: var(--gold-hover);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(169, 126, 0, 0.3);
        }

        /* Text Colors */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .text-white {
            color: var(--text-primary) !important;
        }

        /* Fixed Bottom Navigation */
        .bottom-nav {
            position: sticky;
            bottom: 0;
            width: 100%;
            background: linear-gradient(135deg, #FFFFFF, #F5F5F5);
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
            color: var(--gold-color);
            background: rgba(169, 126, 0, 0.05);
        }

        .nav-item.active {
            color: var(--gold-color);
            font-weight: 600;
        }

        .nav-item.active i {
            color: var(--gold-color);
        }

        .nav-item span {
            display: block;
            margin-top: 2px;
        }

        /* Responsive for larger screens */
        @media (min-width: 768px) {
            body {
                background: linear-gradient(135deg, #F5F5F5 0%, #FFFFFF 100%);
            }

            .mobile-container {
                border-radius: 0;
                overflow: hidden;
            }
        }

        /* Team Icon Wrapper */
        .team-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(169, 126, 0, 0.1) 0%, rgba(169, 126, 0, 0.05) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(169, 126, 0, 0.3);
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
            background-color: rgba(169, 126, 0, 0.05);
        }

        .team-member-item:last-child {
            border-bottom: none;
        }

        /* Team Avatar */
        .team-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--secondary-light) 0%, var(--card-light) 100%);
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

        /* Profile Avatar Large */
        .profile-avatar-large {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--secondary-light) 0%, var(--card-light) 100%);
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
            background: linear-gradient(135deg, rgba(169, 126, 0, 0.1) 0%, rgba(169, 126, 0, 0.05) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(169, 126, 0, 0.3);
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
            color: #fff;
        }

        /* Badge Count */
        .badge-count {
            background: rgba(169, 126, 0, 0.15);
            border: 1px solid rgba(169, 126, 0, 0.3);
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
            background-color: rgba(169, 126, 0, 0.05);
        }

        .bank-list-item:last-of-type {
            border-bottom: 1px solid var(--border-color);
        }

        /* Bank Icon Circle */
        .bank-icon-circle {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, rgba(169, 126, 0, 0.1) 0%, rgba(169, 126, 0, 0.05) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(169, 126, 0, 0.3);
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
            background: rgba(169, 126, 0, 0.1);
            border-color: rgba(169, 126, 0, 0.3);
        }

        .btn-bank-edit:hover {
            background: rgba(169, 126, 0, 0.2);
            border-color: rgba(169, 126, 0, 0.5);
        }

        .btn-bank-edit i {
            color: var(--gold-color);
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

        /* Referral Icon Small */
        .referral-icon-small {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, rgba(169, 126, 0, 0.1) 0%, rgba(169, 126, 0, 0.05) 100%);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(169, 126, 0, 0.3);
            flex-shrink: 0;
        }

        .referral-icon-small i {
            font-size: 14px;
            color: var(--gold-color);
        }

        /* Referral Code Display */
        .referral-code-display {
            font-size: 18px;
            font-weight: 700;
            color: var(--gold-color);
            letter-spacing: 1.5px;
            font-family: 'Courier New', monospace;
        }

        /* Copy Button Small */
        .btn-copy-small {
            background: rgba(169, 126, 0, 0.15);
            border: 1px solid rgba(169, 126, 0, 0.3);
            border-radius: 6px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            cursor: pointer;
            padding: 0;
            flex-shrink: 0;
        }

        .btn-copy-small:hover {
            background: rgba(169, 126, 0, 0.25);
            border-color: rgba(169, 126, 0, 0.5);
        }

        .btn-copy-small i {
            color: var(--gold-color);
            font-size: 14px;
        }

        /* Market Status Badge */
        .market-status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .market-status-badge.active {
            background: rgba(40, 167, 69, 0.15);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
        }

        .market-status-badge.active i {
            font-size: 8px;
        }

        /* Market Coin Item */
        .market-coin-item {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }

        .market-coin-item:hover {
            background-color: rgba(169, 126, 0, 0.05);
        }

        .market-coin-item:last-child {
            border-bottom: none;
        }

        /* Coin Icon */
        .coin-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid;
        }

        .coin-icon i {
            font-size: 20px;
        }

        /* Coin specific colors */
        .coin-icon.btc {
            background: rgba(247, 147, 26, 0.15);
            border-color: rgba(247, 147, 26, 0.3);
        }

        .coin-icon.btc i {
            color: #f7931a;
        }

        .coin-icon.eth {
            background: rgba(98, 126, 234, 0.15);
            border-color: rgba(98, 126, 234, 0.3);
        }

        .coin-icon.eth i {
            color: #627eea;
        }

        .coin-icon.doge {
            background: rgba(186, 155, 70, 0.15);
            border-color: rgba(186, 155, 70, 0.3);
        }

        .coin-icon.doge i {
            color: #ba9b46;
        }

        .coin-icon.bnb {
            background: rgba(243, 186, 47, 0.15);
            border-color: rgba(243, 186, 47, 0.3);
        }

        .coin-icon.bnb i {
            color: #f3ba2f;
        }

        .coin-icon.sol {
            background: rgba(20, 241, 149, 0.15);
            border-color: rgba(20, 241, 149, 0.3);
        }

        .coin-icon.sol i {
            color: #14f195;
        }

        .coin-icon.xrp {
            background: rgba(35, 137, 218, 0.15);
            border-color: rgba(35, 137, 218, 0.3);
        }

        .coin-icon.xrp i {
            color: #2389da;
        }

        /* Price Change */
        .price-change {
            font-size: 12px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
        }

        .price-change.positive {
            color: #28a745;
            background: rgba(40, 167, 69, 0.1);
        }

        .price-change.negative {
            color: #dc3545;
            background: rgba(220, 53, 69, 0.1);
        }

        /* Coin List Item */
        .coin-list-item {
            display: block;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .coin-list-item:hover {
            background-color: rgba(169, 126, 0, 0.05);
        }

        .coin-list-item:last-child {
            border-bottom: none;
        }

        /* Back Button */
        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: rgba(169, 126, 0, 0.1);
            border: 1px solid rgba(169, 126, 0, 0.3);
            border-radius: 8px;
            color: var(--gold-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: rgba(169, 126, 0, 0.2);
            border-color: rgba(169, 126, 0, 0.5);
            color: var(--gold-color);
        }

        /* Coin Icon Large */
        .coin-icon-large {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 2px solid;
        }

        .coin-icon-large i {
            font-size: 32px;
        }

        .coin-icon-large.btc {
            background: rgba(247, 147, 26, 0.15);
            border-color: rgba(247, 147, 26, 0.5);
        }

        .coin-icon-large.btc i {
            color: #f7931a;
        }

        /* Price Change Large */
        .price-change-large {
            font-size: 18px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
            display: inline-block;
        }

        .price-change-large.positive {
            color: #28a745;
            background: rgba(40, 167, 69, 0.15);
        }

        .price-change-large.negative {
            color: #dc3545;
            background: rgba(220, 53, 69, 0.15);
        }

        /* Chart Timeframe Pills */
        .chart-timeframe-pills {
            display: flex;
            gap: 6px;
        }

        .timeframe-pill {
            padding: 4px 12px;
            background: rgba(169, 126, 0, 0.1);
            border: 1px solid rgba(169, 126, 0, 0.3);
            border-radius: 6px;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .timeframe-pill:hover {
            background: rgba(169, 126, 0, 0.15);
        }

        .timeframe-pill.active {
            background: var(--gold-color);
            border-color: var(--gold-color);
            color: #fff;
        }

        /* Chart Container */
        .chart-container {
            height: 250px;
            position: relative;
        }

        /* Form Control Dark */
        .form-control-dark {
            background: rgba(169, 126, 0, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 16px;
            color: var(--text-primary);
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.2s ease;
        }

        .form-control-dark:focus {
            outline: none;
            border-color: var(--gold-color);
            background: rgba(169, 126, 0, 0.1);
        }

        .form-control-dark::placeholder {
            color: var(--text-muted);
        }

        /* Amount Quick Select */
        .amount-quick-select {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .quick-amount-btn {
            padding: 10px;
            background: rgba(169, 126, 0, 0.1);
            border: 1px solid rgba(169, 126, 0, 0.3);
            border-radius: 6px;
            color: var(--gold-color);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-amount-btn:hover {
            background: rgba(169, 126, 0, 0.2);
            border-color: var(--gold-color);
        }

        /* Duration Options */
        .duration-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .duration-btn {
            padding: 12px;
            background: rgba(169, 126, 0, 0.05);
            border: 2px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }

        .duration-btn:hover {
            background: rgba(169, 126, 0, 0.1);
            border-color: rgba(169, 126, 0, 0.5);
        }

        .duration-btn.active {
            background: rgba(169, 126, 0, 0.15);
            border-color: var(--gold-color);
        }

        .duration-time {
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .duration-payout {
            color: var(--gold-color);
            font-size: 12px;
            font-weight: 600;
        }

        /* Trading Buttons */
        .btn-call {
            background: linear-gradient(135deg, var(--gold-color) 0%, var(--gold-hover) 100%);
            border: none;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            padding: 14px 20px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-call:hover {
            background: linear-gradient(135deg, var(--gold-hover) 0%, var(--gold-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(169, 126, 0, 0.4);
        }

        .btn-put {
            background: linear-gradient(135deg, var(--gold-color) 0%, var(--gold-hover) 100%);
            border: none;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            padding: 14px 20px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-put:hover {
            background: linear-gradient(135deg, var(--gold-hover) 0%, var(--gold-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(169, 126, 0, 0.4);
        }

        /* Step Indicator */
        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(169, 126, 0, 0.1);
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .step-item.active .step-circle {
            background: var(--gold-color);
            border-color: var(--gold-color);
            color: #fff;
        }

        .step-item.completed .step-circle {
            background: rgba(40, 167, 69, 0.2);
            border-color: #28a745;
            color: #28a745;
        }

        .step-label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .step-item.active .step-label {
            color: var(--gold-color);
        }

        .step-line {
            width: 80px;
            height: 2px;
            background: var(--border-color);
            margin: 0 -10px;
            margin-bottom: 28px;
        }

        /* Step Content */
        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Input with Icon */
        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold-color);
            font-size: 18px;
            font-weight: 700;
            pointer-events: none;
        }

        .form-control-dark.with-icon {
            padding-left: 40px;
        }

        /* Payment Method Option */
        .payment-method-option {
            position: relative;
            margin-bottom: 12px;
            cursor: pointer;
        }

        .payment-radio {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .payment-label {
            display: block;
            padding: 16px;
            background: rgba(169, 126, 0, 0.05);
            border: 2px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .payment-radio:checked+.payment-label {
            background: rgba(169, 126, 0, 0.15);
            border-color: var(--gold-color);
        }

        .payment-label:hover {
            background: rgba(169, 126, 0, 0.1);
        }

        /* Payment Icon */
        .payment-icon {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid;
        }

        .payment-icon i {
            font-size: 22px;
        }

        .payment-icon.ewallet {
            background: rgba(138, 43, 226, 0.15);
            border-color: rgba(138, 43, 226, 0.3);
        }

        .payment-icon.ewallet i {
            color: #8a2be2;
        }

        .payment-icon.qrcode {
            background: rgba(169, 126, 0, 0.15);
            border-color: rgba(169, 126, 0, 0.3);
        }

        .payment-icon.qrcode i {
            color: var(--gold-color);
        }

        /* Payment Details */
        .payment-details {
            display: none;
        }

        .payment-details.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        /* Payment Info Item */
        .payment-info-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .payment-info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        /* Copy Button Mini */
        .btn-copy-mini {
            background: rgba(169, 126, 0, 0.15);
            border: 1px solid rgba(169, 126, 0, 0.3);
            border-radius: 4px;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            cursor: pointer;
            padding: 0;
        }

        .btn-copy-mini:hover {
            background: rgba(169, 126, 0, 0.25);
            border-color: rgba(169, 126, 0, 0.5);
        }

        .btn-copy-mini i {
            color: var(--gold-color);
            font-size: 12px;
        }

        /* Alert Info Box */
        .alert-info-box {
            background: rgba(169, 126, 0, 0.1);
            border: 1px solid rgba(169, 126, 0, 0.3);
            border-radius: 8px;
            padding: 10px 12px;
            color: var(--gold-color);
            font-size: 12px;
            display: flex;
            align-items: center;
        }

        .alert-info-box i {
            flex-shrink: 0;
        }

        /* QR Code Container */
        .qr-code-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .qr-code-image {
            width: 200px;
            height: 200px;
            border-radius: 12px;
            border: 2px solid var(--border-color);
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .upload-area:hover {
            border-color: var(--gold-color);
            background: rgba(169, 126, 0, 0.05);
        }

        .upload-icon {
            font-size: 48px;
            color: var(--gold-color);
            margin-bottom: 10px;
            display: block;
        }

        .preview-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            object-fit: contain;
        }

        /* Withdraw Bank Option */
        .withdraw-bank-option {
            position: relative;
            cursor: pointer;
            border-bottom: 1px solid var(--border-color);
        }

        .withdraw-bank-option:last-child {
            border-bottom: none;
        }

        .bank-radio {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .bank-option-label {
            display: block;
            padding: 16px 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: transparent;
            margin: 0;
        }

        .bank-option-label:hover {
            background: rgba(169, 126, 0, 0.05);
        }

        .bank-radio:checked+.bank-option-label {
            background: rgba(169, 126, 0, 0.1);
        }

        /* Radio Check Icon */
        .radio-check {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .radio-check i {
            font-size: 24px;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .bank-radio:checked+.bank-option-label .radio-check i {
            color: var(--gold-color);
        }

        .verification-icon-small {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, rgba(169, 126, 0, 0.1) 0%, rgba(169, 126, 0, 0.05) 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(169, 126, 0, 0.3);
            flex-shrink: 0;
        }

        .verification-icon-small i {
            font-size: 16px;
            color: var(--gold-color);
        }

        .form-control-dark.is-invalid {
            border-color: #dc3545;
        }

        /* Improved Dropdown Styling */
        .form-control-dark-select {
            background: rgba(169, 126, 0, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 16px;
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 600;
            width: 100%;
            transition: all 0.2s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23A97E00' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .form-control-dark-select:focus {
            outline: none;
            border-color: var(--gold-color);
            background-color: rgba(169, 126, 0, 0.1);
            box-shadow: 0 0 0 3px rgba(169, 126, 0, 0.1);
        }

        .form-control-dark-select.is-invalid {
            border-color: #dc3545;
        }

        .form-control-dark-select option {
            background-color: #FFFFFF !important;
            color: var(--text-primary) !important;
            padding: 12px;
            font-size: 14px;
        }

        .form-control-dark-select option:hover {
            background-color: rgba(169, 126, 0, 0.1) !important;
        }

        .form-control-dark-select option:checked {
            background: linear-gradient(135deg, var(--gold-color) 0%, var(--gold-hover) 100%) !important;
            color: #fff !important;
            font-weight: 700;
        }

        .form-control-dark-select option[value=""] {
            color: var(--text-muted) !important;
        }

        .form-control-dark-select option:disabled {
            color: var(--text-muted) !important;
            opacity: 0.5;
        }

        .preview-container {
            min-height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .preview-container img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            object-fit: contain;
        }

        .verification-data-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .verification-data-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .btn-verification-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(169, 126, 0, 0.1);
            border: 1px solid rgba(169, 126, 0, 0.3);
            border-radius: 6px;
            color: var(--gold-color);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-verification-link:hover {
            background: rgba(169, 126, 0, 0.2);
            border-color: var(--gold-color);
            color: var(--gold-color);
            text-decoration: none;
        }

        .btn-verification-link i {
            font-size: 14px;
        }

        /* Referral Link Display */
        .referral-link-display {
            background: rgba(169, 126, 0, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            color: var(--text-muted);
            font-size: 11px;
            font-family: monospace;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }

        /* Responsive Adjustments */
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

            .referral-icon-wrapper {
                width: 45px;
                height: 45px;
            }

            .referral-icon-wrapper i {
                font-size: 20px;
            }

            .referral-code-display {
                font-size: 14px;
            }

            .btn-copy-small {
                width: 28px;
                height: 28px;
            }

            .btn-copy-small i {
                font-size: 12px;
            }

            .coin-icon {
                width: 36px;
                height: 36px;
            }

            .coin-icon i {
                font-size: 18px;
            }

            .coin-icon-large {
                width: 50px;
                height: 50px;
            }

            .coin-icon-large i {
                font-size: 28px;
            }

            .chart-container {
                height: 200px;
            }

            .amount-quick-select {
                grid-template-columns: repeat(4, 1fr);
                gap: 6px;
            }

            .quick-amount-btn {
                padding: 8px;
                font-size: 12px;
            }

            .step-circle {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }

            .step-line {
                width: 60px;
            }

            .qr-code-image {
                width: 180px;
                height: 180px;
            }

            .payment-icon {
                width: 40px;
                height: 40px;
            }

            .payment-icon i {
                font-size: 20px;
            }

            .radio-check i {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            .form-control-dark-select {
                font-size: 16px;
            }
        }

        /* Header Icon Buttons */
        .btn-header-icon {
            width: 45px;
            height: 45px;
            background: var(--charcoal-black);
            border: none;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-header-icon:hover {
            background: var(--gold-color);
        }

        .btn-header-icon i {
            color: #FFFFFF;
            font-size: 20px;
        }

        .btn-header-icon:hover i {
            color: var(--charcoal-black);
        }

        /* Tab Navigation */
        .tab-navigation {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            background: var(--charcoal-black);
            padding: 6px;
            border-radius: 25px;
        }

        .tab-btn {
            flex: 1;
            padding: 10px 16px;
            background: transparent;
            border: none;
            border-radius: 20px;
            color: #999;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .tab-btn:hover {
            color: #FFF;
        }

        .tab-btn.active {
            background: var(--gold-color);
            color: var(--charcoal-black);
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="mobile-container">
        @include('member.components.header')

        @yield('content')

        @include('member.components.bottombar')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
