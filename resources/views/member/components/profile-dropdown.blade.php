<!-- Profile Dropdown Menu -->
<div class="profile-dropdown">
    <button class="btn-header-icon profile-trigger" id="profileDropdownBtn">
        <i class="bi bi-person-circle"></i>
    </button>
    
    <div class="profile-dropdown-menu" id="profileDropdownMenu">
        <!-- User Info Section -->
        <div class="profile-header">
            <div class="profile-avatar">
                <div class="avatar-circle">
                    <i class="bi bi-person-fill"></i>
                </div>
                @if(auth()->user()->vip_level)
                    <span class="vip-badge">VIP{{ auth()->user()->vip_level }}</span>
                @endif
            </div>
            <div class="profile-info">
                <div class="profile-email">{{ auth()->user()->email }}</div>
                <div class="profile-phone">
                    <i class="bi bi-telephone-fill"></i>
                    <span>{{ auth()->user()->phone ?? '+62 812-3456-7890' }}</span>
                    <button class="btn-copy" onclick="copyToClipboard('{{ auth()->user()->phone ?? '+62 812-3456-7890' }}')">
                        <i class="bi bi-clipboard"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Verification Section -->
        <div class="verification-section">
            <!-- Single Verification -->
            @if(auth()->user()->is_verified ?? false)
                <!-- Already Verified -->
                <a href="{{ route('member.verification.index') }}" class="verification-item verified">
                    <div class="verification-content">
                        <div class="verification-title">{{ app()->getLocale() == 'id' ? 'Verifikasi' : 'Verification' }}</div>
                        <div class="verification-status">{{ app()->getLocale() == 'id' ? 'Sudah Terverifikasi' : 'Verified' }}</div>
                    </div>
                    <div class="verification-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                </a>
            @else
                <!-- Need Verification -->
                <a href="{{ route('member.verification.index') }}" class="verification-item not-verified">
                    <div class="verification-content">
                        <div class="verification-title">{{ app()->getLocale() == 'id' ? 'Verifikasi' : 'Verification' }}</div>
                        <div class="verification-status">{{ app()->getLocale() == 'id' ? 'Harus Verifikasi' : 'Must Verify' }}</div>
                    </div>
                    <div class="verification-icon">
                        <i class="bi bi-shield-exclamation"></i>
                    </div>
                </a>
            @endif
        </div>

        <!-- Logout Button -->
        <div class="logout-section">
            <a href="{{ route('logout') }}" class="logout-btn" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>{{ app()->getLocale() == 'id' ? 'Keluar' : 'Logout' }}</span>
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

<style>
/* Profile Dropdown Styles */
.profile-dropdown {
    position: relative;
    display: inline-block;
}

.profile-trigger {
    cursor: pointer;
    background: #000000;
    border: none;
    font-size: 20px;
    color: #ffffff !important;
    padding: 10px;
    border-radius: 12px;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
}

.profile-trigger:hover {
    background: #1a1a1a;
    transform: scale(1.05);
}

.profile-trigger i {
    color: #ffffff !important;
}

.profile-dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    margin-top: 10px;
    width: 320px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    z-index: 9999;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}

.profile-dropdown-menu.show {
    display: block;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Profile Header */
.profile-header {
    padding: 24px 20px;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
}

.profile-avatar {
    position: relative;
    display: inline-block;
    margin-bottom: 16px;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #f3f4f6;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.avatar-circle i {
    font-size: 40px;
    color: #6b7280;
}

.vip-badge {
    position: absolute;
    bottom: 5px;
    right: -5px;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #ffffff;
    font-size: 10px;
    font-weight: bold;
    padding: 4px 10px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(251, 191, 36, 0.4);
    border: 2px solid #ffffff;
}

.profile-info {
    margin-top: 8px;
}

.profile-email {
    color: #111827;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 8px;
    word-break: break-all;
}

.profile-phone {
    color: #6b7280;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.profile-phone i {
    font-size: 12px;
}

.btn-copy {
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 2px 4px;
    transition: color 0.2s;
    font-size: 13px;
    margin-left: 2px;
}

.btn-copy:hover {
    color: #111827;
}

/* Verification Section */
.verification-section {
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: #ffffff;
}

.verification-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s;
    border: 1px solid transparent;
    position: relative;
    z-index: 1;
    pointer-events: auto;
    cursor: pointer;
}

.verification-item:hover {
    transform: translateX(4px);
    border-color: #d1d5db;
}

.verification-item * {
    pointer-events: none;
}

.basic-verification {
    background: linear-gradient(135deg, rgba(56, 189, 248, 0.15), rgba(14, 165, 233, 0.15));
}

.basic-verification:hover {
    background: linear-gradient(135deg, rgba(56, 189, 248, 0.25), rgba(14, 165, 233, 0.25));
}

.advanced-verification {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(22, 163, 74, 0.15));
}

.advanced-verification:hover {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.25), rgba(22, 163, 74, 0.25));
}

/* Verified Status - Green */
.verified {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(22, 163, 74, 0.15));
}

.verified:hover {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.25), rgba(22, 163, 74, 0.25));
}

.verified .verification-icon {
    color: rgba(34, 197, 94, 0.9);
}

/* Not Verified Status - Orange/Red */
.not-verified {
    background: linear-gradient(135deg, rgba(234, 88, 12, 0.15), rgba(249, 115, 22, 0.15));
}

.not-verified:hover {
    background: linear-gradient(135deg, rgba(234, 88, 12, 0.25), rgba(249, 115, 22, 0.25));
}

.not-verified .verification-icon {
    color: rgba(234, 88, 12, 0.9);
}

.verification-content {
    flex: 1;
}

.verification-title {
    color: #111827;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 4px;
}

.verification-status {
    color: #6b7280;
    font-size: 13px;
}

.verification-icon {
    font-size: 28px;
    color: rgba(255,255,255,0.5);
}

.basic-verification .verification-icon {
    color: rgba(56, 189, 248, 0.8);
}

.advanced-verification .verification-icon {
    color: rgba(34, 197, 94, 0.8);
}

/* Logout Section */
.logout-section {
    padding: 12px 16px;
    background: #ffffff;
    border-top: 1px solid #e5e7eb;
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: #dc2626;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s;
    font-size: 15px;
    font-weight: 500;
}

.logout-btn:hover {
    background: rgba(220, 38, 38, 0.1);
    transform: translateX(4px);
}

.logout-btn i {
    font-size: 20px;
}

/* Responsive */
@media (max-width: 480px) {
    .profile-dropdown-menu {
        width: 280px;
    }
}
</style>

<script>
// Toggle Dropdown
document.addEventListener('DOMContentLoaded', function() {
    const dropdownBtn = document.getElementById('profileDropdownBtn');
    const dropdownMenu = document.getElementById('profileDropdownMenu');
    
    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdownMenu.contains(e.target) && e.target !== dropdownBtn) {
                dropdownMenu.classList.remove('show');
            }
        });
    }
});

// Copy to Clipboard
function copyToClipboard(text) {
    const locale = '{{ app()->getLocale() }}';
    const message = locale === 'id' ? 'Nomor telepon tersalin!' : 'Phone number copied!';
    
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            showToast(message);
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    } else {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            showToast(message);
        } catch (err) {
            console.error('Could not copy text: ', err);
        }
        document.body.removeChild(textarea);
    }
}

// Simple Toast Notification (optional)
function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 10000;
        animation: slideInUp 0.3s ease;
    `;
    
    document.body.appendChild(toast);
    
    // Remove after 2 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOutDown 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 2000);
}

// Add animations for toast
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutDown {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>