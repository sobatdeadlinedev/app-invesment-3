<!-- Fixed Bottom Navbar -->
<div class="bottom-nav">
    <a href="{{ route('member.dashboard.index') }}" class="nav-item active">
        <i class="bi bi-house-door-fill d-block fs-5"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('member.invest.index') }}" class="nav-item">
        <i class="bi bi-graph-up d-block fs-5"></i>
        <span>Trade</span>
    </a>
    <a href="{{ route('member.team.index') }}" class="nav-item">
        <i class="bi bi-people-fill d-block fs-5"></i>
        <span>Team</span>
    </a>
    <a href="{{ route('member.profile.index') }}" class="nav-item">
        <i class="bi bi-wallet-fill d-block fs-5"></i>
        <span>My assets</span>
    </a>
</div>
