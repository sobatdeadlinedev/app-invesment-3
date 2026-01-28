<!-- Fixed Bottom Navbar -->
<div class="bottom-nav">
    <a href="{{ route('member.dashboard.index') }}"
        class="nav-item {{ request()->routeIs('member.dashboard.*') ? 'active' : '' }}">
        <i class="bi bi-house-door-fill d-block fs-5"></i>
        <span>{{ __('app.home') }}</span>
    </a>
    <a href="{{ route('member.invest.coin', ['coin' => 'btcusdt']) }}"
        class="nav-item {{ request()->routeIs('member.invest.*') ? 'active' : '' }}">
        <i class="bi bi-graph-up d-block fs-5"></i>
        <span>{{ __('app.trade') }}</span>
    </a>
    <a href="{{ route('member.team.index') }}" class="nav-item {{ request()->routeIs('member.team.*') ? 'active' : '' }}">
        <i class="bi bi-people-fill d-block fs-5"></i>
        <span>{{ __('app.team') }}</span>
    </a>
    <a href="{{ route('member.profile.index') }}"
        class="nav-item {{ request()->routeIs('member.profile.*') ? 'active' : '' }}">
        <i class="bi bi-wallet-fill d-block fs-5"></i>
        <span>{{ __('app.my_assets') }}</span>
    </a>
</div>
