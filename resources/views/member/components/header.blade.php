<!-- Fixed Header -->
<div class="fixed-header">
    <div class="header-grid">
        <!-- Left: Globe Icon Button -->
        <div class="header-left">
            <a href="#" class="btn-header-icon" title="Language">
                <i class="bi bi-globe"></i>
            </a>
        </div>
        {{-- {{ route('language.select') }} --}}

        <!-- Right: Profile/Notification Icon -->
        <div class="header-right">
            <a href="{{ route('member.verification.index') }}" class="btn-header-icon" title="Profile">
                <i class="bi bi-person-circle"></i>
            </a>
        </div>
    </div>
</div>
