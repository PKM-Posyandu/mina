<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posyandu Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
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
            <h3>Admin Menu</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('complaints.index') }}">Manajemen Laporan Pengaduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('gallery.index') }}">Manajemen Galeri Kegiatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.cakupan.upload') }}">Manajemen Cakupan</a>
                </li>
                
                
            </ul>
            <hr>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
        <div class="content flex-grow-1">
            <button class="btn btn-primary d-md-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                Menu
            </button>
            @yield('content')
        </div>
    </div>

    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Admin Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('complaints.index') }}">Manajemen Laporan Pengaduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('gallery.index') }}">Manajemen Galeri Kegiatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.cakupan.upload') }}">Manajemen Cakupan</a>
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
        @yield('content')
    </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
