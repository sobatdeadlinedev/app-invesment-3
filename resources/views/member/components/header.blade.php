<!-- Fixed Header -->
<div class="fixed-header">
    <div class="header-grid">
        <!-- Left: Globe Icon Button with Dropdown -->
        <div class="header-left">
            <div class="dropdown">
                <button class="btn-header-icon dropdown-toggle" type="button" id="languageDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false" title="{{ __('app.language') }}">
                    <i class="bi bi-globe"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-language" aria-labelledby="languageDropdown">
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}"
                            href="{{ route('language.switch', 'id') }}">
                            <i class="bi bi-flag-fill me-2"></i> Indonesia
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                            href="{{ route('language.switch', 'en') }}">
                            <i class="bi bi-flag-fill me-2"></i> English
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right: Profile/Notification Icon -->
        <div class="header-right">
            <a href="{{ route('member.verification.index') }}" class="btn-header-icon" title="{{ __('app.profile') }}">
                <i class="bi bi-person-circle"></i>
            </a>
        </div>
    </div>
</div>
