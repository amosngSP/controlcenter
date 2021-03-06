<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/radar.svg') }}">
        </div>

    <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    @auth
        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>

        @can('view', \App\Models\Vatbook::class)
            <li class="nav-item {{ Route::is('vatbook') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('vatbook') }}">
                <i class="fas fa-fw fa-calendar"></i>
                <span>Vatbook</span></a>
            </li>
        @endcan

        @if(Setting::get('linkMoodle') != "")
            <li class="nav-item">
            <a class="nav-link" href="{{ Setting::get('linkMoodle') }}" target="_blank">
                <i class="fas fa-graduation-cap"></i>
                <span>Moodle</span></a>
            </li>
        @endif

        <li class="nav-item {{ Route::is('member.endorsements') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('member.endorsements') }}">
            <i class="fas fa-fw fa-check-square"></i>
            <span>Endorsements List</span></a>
        </li>

        @if (\Auth::user()->isMentorOrAbove())

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
        Training
        </div>

        <li class="nav-item {{ Route::is('mentor') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('mentor') }}">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>My students</span></a>
        </li>

        <li class="nav-item {{ Route::is('sweatbook') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sweatbook') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Sweatbox Calendar</span></a>
        </li>

        @endif
        @if (\Auth::user()->isModeratorOrAbove())

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ Route::is('requests') || Route::is('requests.history') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReq" aria-expanded="true" aria-controls="collapseReq">
            <i class="fas fa-fw fa-flag"></i>
            <span>Requests</span>
        </a>
        <div id="collapseReq" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('requests') }}">Open Requests</a>
            <a class="collapse-item" href="{{ route('requests.history') }}">Closed Requests</a>
            </div>
        </div>
        </li>

        @endif

        @if (\Auth::user()->isMentorOrAbove())
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
        Members
        </div>

        @if (\Auth::user()->isModeratorOrAbove())
        <li class="nav-item {{ Route::is('users') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Overview</span></a>
        </li>
        @endif

        <li class="nav-item {{ Route::is('users.soloendorsements') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.soloendorsements') }}">
            <i class="fas fa-fw fa-check-square"></i>
            <span>Solo Endorsements</span></a>
        </li>

        @endif

        @if (\Auth::user()->isModeratorOrAbove())
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ Route::is('reports.trainings') || Route::is('reports.mentors') || Route::is('reports.atc') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Reports</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            
            @if (\Auth::user()->isAdmin())
                <a class="collapse-item" href="{{ route('reports.trainings') }}">Trainings</a>
            @endif

            <a class="collapse-item" href="{{ route('reports.mentors') }}">Mentors</a>
            
            </div>
        </div>
        </li>
        @endif

        @if (\Auth::user()->isModeratorOrAbove())

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item {{ Route::is('admin.settings') || Route::is('vote.overview') || Route::is('admin.templates') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Administration</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            @if (\Auth::user()->isAdmin())
                <a class="collapse-item" href="{{ route('admin.settings') }}">Settings</a>
                <a class="collapse-item" href="{{ route('vote.overview') }}">Votes</a>
            @endif

            @if (\Auth::user()->isModeratorOrAbove())
                <a class="collapse-item" href="{{ route('admin.templates') }}">Notification templates</a>
            @endif
            </div>
        </div>
        </li>

        @endif

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        @if(Config::get('app.env') != "production")
            <div class="alert alert-warning" style="font-size: 80%;" role="alert">
                Development Env
            </div>
        @endif

        <!-- Logo -->
        <a href="{{ Setting::get('linkHome') }}"><img class="logo" src="{{ asset('images/logos/vat'.mb_strtolower(Config::get('app.owner_short')).'.svg') }}"></a>
        <span class="version-sidebar">Control Center v{{ config('app.version') }}</span>
    @else
        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <li class="nav-item active">
        <a class="nav-link" href="{{ route('login') }}">
            <i class="fas fa-sign-in-alt"></i>
            <span>Login</span></a>
        </li>
    @endauth

</ul>
<!-- End of Sidebar -->