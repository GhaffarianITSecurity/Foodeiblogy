<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">داشبورد</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">صفحه اصلی</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
                </a>
            </li>
            
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->user_avatar }}" class="user-image rounded-circle shadow"
                        alt="User Image">
                    <span class="d-none d-md-inline">مدیر ارشد</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ auth()->user()->user_avatar }}" class="rounded-circle shadow" alt="User Image">
                        <p>
                            {{ auth()->user()->full_name }}
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat float-start">پروفایل</a>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-default btn-flat float-end">خروج</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
