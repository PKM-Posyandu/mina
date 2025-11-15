<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posyandu Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root{ --c1:#00B8F0; --c2:#E64FC5; }
        body{ background:#f4f6fb; font-family:'Inter', 'Segoe UI', sans-serif; }

        .sidebar {
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #eef2f7;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.02);
            min-height: 100vh;
            position: sticky;
            top: 0;
            padding: 16px 14px;
        }
        .sidebar .brand{
            display:flex;align-items:center;gap:10px;margin-bottom:12px;padding:6px 8px;
        }
        .sidebar .brand-title{
            font-weight:700;font-size:18px;margin:0;background:linear-gradient(90deg,var(--c1),var(--c2));-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;
        }
        .sidebar .nav-link{color:#374151;border-radius:12px;padding:10px 12px;margin:4px 4px;transition:.2s ease;background:transparent;font-weight:500}
        .sidebar .nav-link:hover{color:#0ea5e9;background:linear-gradient(90deg, rgba(0,184,240,.10), rgba(230,79,197,.10));}
        .sidebar .nav-link.active{color:#111827;background:linear-gradient(90deg, rgba(0,184,240,.18), rgba(230,79,197,.18));border:1px solid rgba(0,184,240,.25)}
        .sidebar h3{font-size:14px;letter-spacing:.04em;text-transform:uppercase;margin:8px 8px 12px;color:#6b7280}

        .app-content-wrapper{background:#f9fbff; min-height:100vh; padding:24px; border-radius:24px 0 0 0; box-shadow: inset 0 1px 0 rgba(255,255,255,0.4);}
        .app-content{max-width:1200px;margin:0 auto;}
        .btn-primary{background:linear-gradient(90deg,var(--c1),var(--c2));border:none}
        .btn-primary:hover{filter:brightness(.95)}

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>
    @auth
    <div class="d-flex">
        <div class="sidebar d-none d-md-block">
            <div class="brand">
                <img src="{{ asset('assets/images/logo_posyandu_mina.png') }}" alt="Logo" width="36" height="36" style="border-radius:50%">
                <h1 class="brand-title mb-0">Admin Menu</h1>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('complaints.*') ? 'active' : '' }}" href="{{ route('complaints.index') }}">Manajemen Laporan Pengaduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">Manajemen Galeri Kegiatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}" href="{{ route('schedules.index') }}">Manajemen Jadwal Posyandu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.cakupan.*') ? 'active' : '' }}" href="{{ route('admin.cakupan.upload') }}">Manajemen Cakupan</a>
                </li>
                
                
            </ul>
            <hr>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
        <div class="content flex-grow-1">
            <div class="app-content-wrapper">
                <div class="app-content">
                    <button class="btn btn-primary d-md-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                        Menu
                    </button>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasSidebarLabel" style="background:linear-gradient(90deg,var(--c1),var(--c2));-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;">Admin Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('complaints.*') ? 'active' : '' }}" href="{{ route('complaints.index') }}">Manajemen Laporan Pengaduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">Manajemen Galeri Kegiatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}" href="{{ route('schedules.index') }}">Manajemen Jadwal Posyandu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.cakupan.*') ? 'active' : '' }}" href="{{ route('admin.cakupan.upload') }}">Manajemen Cakupan</a>
                </li>
                
                
            </ul>
            <hr>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
    @else
    <div class="content">
        <div class="app-content-wrapper">
            <div class="app-content">
                @yield('content')
            </div>
        </div>
    </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
