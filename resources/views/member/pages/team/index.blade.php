@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- QR Code Section -->
            <div class="qr-section">
                <div class="qr-code-wrapper">
                    <div id="qrcode"></div>
                </div>
            </div>

            <!-- Invitation Code Section -->
            <div class="invitation-section">
                <div class="invitation-item">
                    <label class="invitation-label">My invitation code:</label>
                    <div class="invitation-value-wrapper">
                        <span class="invitation-value" id="invitationCode">{{ $user->refferal_code }}</span>
                        <button class="btn-copy-icon" onclick="copyInvitationCode()" title="Copy Code">
                            <i class="bi bi-clipboard" id="copyCodeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="invitation-item">
                    <label class="invitation-label">My invitation code link:</label>
                    <div class="invitation-value-wrapper">
                        <span class="invitation-value link" id="invitationLink">{{ $referralLink }}</span>
                        <button class="btn-copy-icon" onclick="copyInvitationLink()" title="Copy Link">
                            <i class="bi bi-link-45deg" id="copyLinkIcon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Click Save Button -->
            <div class="save-button-section">
                <button class="btn-save" onclick="saveQRCode()">
                    <i class="bi bi-download me-2"></i>Save QR
                </button>
            </div>

            <!-- Statistics Section -->
            <div class="statistics-section">
                <div class="stat-item">
                    <span class="stat-label">Recommended number of people:</span>
                    <span class="stat-value">{{ $directTeam }} / {{ $totalTeam }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Current level:</span>
                    <span class="stat-value">LV{{ $user->level ?? 0 }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total Revenue:</span>
                    <span class="stat-value">{{ number_format($totalRevenue ?? 0, 2) }}</span>
                </div>
            </div>

            <!-- Rules Section -->
            <div class="rules-section">
                <div class="rules-header">
                    <i class="bi bi-info-circle"></i>
                    <span>Rules</span>
                </div>
                <div class="rules-content">
                    <ul>
                        <li>Share your referral code or link with friends</li>
                        <li>Earn commission when they join and trade</li>
                        <li>Build your network and increase your level</li>
                        <li>Higher levels get better commission rates</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* QR Code Section */
        .qr-section {
            padding: 40px 20px;
            text-align: center;
        }

        .qr-code-wrapper {
            display: inline-block;
            padding: 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        #qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #qrcode img,
        #qrcode canvas {
            border-radius: 8px;
        }

        /* Invitation Section */
        .invitation-section {
            padding: 0 20px;
            margin-bottom: 24px;
        }

        .invitation-item {
            margin-bottom: 20px;
        }

        .invitation-label {
            color: var(--text-muted);
            font-size: 13px;
            display: block;
            margin-bottom: 8px;
        }

        .invitation-value-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 16px;
            gap: 12px;
        }

        .invitation-value {
            color: var(--text-white);
            font-size: 14px;
            font-weight: 500;
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .invitation-value.link {
            font-family: monospace;
            font-size: 12px;
        }

        .btn-copy-icon {
            background: transparent;
            border: none;
            color: var(--gold-color);
            font-size: 18px;
            cursor: pointer;
            padding: 4px;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .btn-copy-icon:hover {
            color: #d4930f;
            transform: scale(1.1);
        }

        .btn-copy-icon:active {
            transform: scale(0.95);
        }

        /* Save Button Section */
        .save-button-section {
            padding: 0 20px;
            margin-bottom: 32px;
        }

        .btn-save {
            width: 100%;
            background: linear-gradient(135deg, #f5a623 0%, #d4930f 100%);
            border: none;
            border-radius: 10px;
            padding: 14px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(245, 166, 35, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 166, 35, 0.4);
        }

        .btn-save:active {
            transform: translateY(0);
        }

        /* Statistics Section */
        .statistics-section {
            padding: 0 20px;
            margin-bottom: 24px;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 13px;
        }

        .stat-value {
            color: #4ade80;
            font-size: 14px;
            font-weight: 600;
        }

        /* Rules Section */
        .rules-section {
            padding: 0 20px;
            margin-bottom: 24px;
        }

        .rules-header {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-white);
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .rules-header i {
            color: var(--gold-color);
            font-size: 18px;
        }

        .rules-content {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
        }

        .rules-content ul {
            margin: 0;
            padding-left: 20px;
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .rules-content ul li {
            margin-bottom: 8px;
        }

        .rules-content ul li:last-child {
            margin-bottom: 0;
        }

        /* Toast Notification */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #22c55e;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 9999;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 375px) {
            .qr-section {
                padding: 30px 20px;
            }

            .qr-code-wrapper {
                padding: 16px;
            }
        }
    </style>

    @push('scripts')
        <!-- QR Code Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

        <script>
            // Wait for DOM to be ready
            document.addEventListener('DOMContentLoaded', function() {
                // Clear any existing QR code
                const qrcodeDiv = document.getElementById("qrcode");
                qrcodeDiv.innerHTML = '';

                // Get the referral link
                const referralLink = "{{ $referralLink }}";
                console.log('Generating QR Code for:', referralLink); // Debug log

                // Generate QR Code
                const qrcode = new QRCode(qrcodeDiv, {
                    text: referralLink,
                    width: 200,
                    height: 200,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            });

            // Show Toast Notification
            function showToast(message, type = 'success') {
                const bgColor = type === 'success' ? '#22c55e' : '#ef4444';
                const toast = document.createElement('div');
                toast.className = 'toast-notification';
                toast.style.background = bgColor;
                toast.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }, 2000);
            }

            // Copy Invitation Code
            function copyInvitationCode() {
                const code = document.getElementById('invitationCode').textContent;
                const icon = document.getElementById('copyCodeIcon');

                navigator.clipboard.writeText(code).then(() => {
                    icon.classList.remove('bi-clipboard');
                    icon.classList.add('bi-check-lg');
                    showToast('Invitation code copied!');

                    setTimeout(() => {
                        icon.classList.remove('bi-check-lg');
                        icon.classList.add('bi-clipboard');
                    }, 2000);
                }).catch(err => {
                    showToast('Failed to copy code', 'error');
                    console.error('Error:', err);
                });
            }

            // Copy Invitation Link
            function copyInvitationLink() {
                const link = document.getElementById('invitationLink').textContent;
                const icon = document.getElementById('copyLinkIcon');

                navigator.clipboard.writeText(link).then(() => {
                    icon.classList.remove('bi-link-45deg');
                    icon.classList.add('bi-check-lg');
                    showToast('Invitation link copied!');

                    setTimeout(() => {
                        icon.classList.remove('bi-check-lg');
                        icon.classList.add('bi-link-45deg');
                    }, 2000);
                }).catch(err => {
                    showToast('Failed to copy link', 'error');
                    console.error('Error:', err);
                });
            }

            // Save QR Code
            function saveQRCode() {
                const canvas = document.querySelector('#qrcode canvas');
                if (canvas) {
                    const link = document.createElement('a');
                    link.download = 'referral-qrcode.png';
                    link.href = canvas.toDataURL();
                    link.click();
                    showToast('QR Code saved successfully!');
                } else {
                    showToast('Failed to save QR Code', 'error');
                }
            }

            // Auto hide alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                });
            }, 3000);
        </script>
    @endpush
@endsection
