<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmileSync</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { background-color: #f8f9fc; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #0069d9; }
        .navbar-brand, .navbar-nav .nav-link { color: #fff !important; }

        .sidebar {
            background: #fff;
            min-height: 100vh;
            border-right: 1px solid #dee2e6;
            padding: 20px;
        }

        .sidebar .nav-link {
            color: #000;
            padding: 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: .2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #0069d9;
            color: #fff !important;
            font-weight: bold;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .card:hover { transform: translateY(-5px); transition: .2s; }

        .table thead { background-color: #0069d9; color: #fff; }
    </style>
</head>

<body>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand fw-bold text-white">🦷 SmileSync</a>

    <div class="ms-auto text-white fw-semibold d-flex align-items-center">
        {{ Auth::user()->name ?? 'Guest' }}
        <img src="https://i.pravatar.cc/40?img=6" class="rounded-circle ms-2">
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <h5 class="fw-bold text-primary">Navigation</h5>
            <ul class="nav flex-column mt-3">
                <li class="nav-item mb-2"><a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="#"><i class="bi bi-calendar-check me-2"></i>Appointments</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="#"><i class="bi bi-people me-2"></i>Records</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="#"><i class="bi bi-bar-chart-line me-2"></i>Reports</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="#"><i class="bi bi-bell me-2"></i>Notifications</a></li>

                <li class="nav-item mt-4">
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="btn btn-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Page Content -->
        <div class="col-md-10 p-4">
            @yield('content')
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

</body>
</html>
