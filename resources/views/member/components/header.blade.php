<!-- Fixed Header -->
<div class="fixed-header">
    <div class="header-grid">
        <!-- Left: App Logo -->
        <div class="header-left">
            <img src="assets/media/logos/logo-ji.png" alt="App Logo" class="app-logo">
        </div>

        <!-- Right: Logout -->
        <div class="header-right">
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>
