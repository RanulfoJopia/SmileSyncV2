<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmileSync – Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        body { background-color: #f8f9fc; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #0069d9; }
        .navbar-brand, .navbar-nav .nav-link { color: #fff !important; }
        .sidebar { background: #fff; min-height: 100vh; border-right: 1px solid #dee2e6; padding: 20px; }
        .sidebar .nav-link { color: #000; padding: 10px; border-radius: 8px; display: flex; align-items: center; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #0069d9; color: #fff !important; font-weight: bold;
        }
        .card { border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .card:hover { transform: translateY(-5px); transition: .2s; }
        .chart-container { height: 280px; }
        .table thead { background-color: #0069d9; color: #fff; }
    </style>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand fw-bold text-white">🦷 SmileSync</a>

    <div class="ms-auto text-white fw-semibold">
        {{ Auth::user()->name }}
        <img src="https://i.pravatar.cc/40?img=6" class="rounded-circle ms-2">
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <h5 class="fw-bold text-primary">Navigation</h5>
            <ul class="nav flex-column mt-3">
                <li class="nav-item mb-2"><a class="nav-link active" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="#"><i class="bi bi-calendar-check me-2"></i>Appointments</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="#"><i class="bi bi-people me-2"></i>Records</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="#"><i class="bi bi-bar-chart-line me-2"></i>Reports</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="#"><i class="bi bi-bell me-2"></i>Notifications</a></li>
            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-10 p-4">

            <h1 class="fw-bold text-primary text-center mb-2">Dashboard</h1>
            <p class="text-center text-muted">Overview of your appointments and stats</p>

            <!-- Summary Cards -->
            <div class="row g-4 mb-4 text-center">
                <div class="col-md-3"><div class="card p-3"><i class="bi bi-people-fill text-primary fs-1"></i><h6>Total Patients</h6><h3>{{ $totalPatients }}</h3></div></div>
                <div class="col-md-3"><div class="card p-3"><i class="bi bi-person-badge text-success fs-1"></i><h6>Upcoming</h6><h3>{{ $counts['upcoming'] }}</h3></div></div>
                <div class="col-md-3"><div class="card p-3"><i class="bi bi-calendar-check text-warning fs-1"></i><h6>Complete</h6><h3>{{ $counts['complete'] }}</h3></div></div>
                <div class="col-md-3"><div class="card p-3"><i class="bi bi-exclamation-triangle text-danger fs-1"></i><h6>Overdue</h6><h3>{{ $counts['overdue'] }}</h3></div></div>
            </div>

            <!-- CHARTS -->
            <div class="row g-4 mb-4">
                <div class="col-md-6"><div class="card p-3"><h5><i class="bi bi-pie-chart me-2"></i>Appointment Status</h5><canvas id="statusChart"></canvas></div></div>
                <div class="col-md-6"><div class="card p-3"><h5><i class="bi bi-bar-chart me-2"></i>Monthly Appointments</h5><canvas id="monthChart"></canvas></div></div>
            </div>

            <!-- Appointments Table -->
            <div class="card p-3">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-list-ul me-2"></i>Recent Appointments</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments as $appt)
                                <tr>
                                    <td>{{ $appt->patient_name ?? '-' }}</td>
                                    <td>{{ $appt->doctor_name ?? '-' }}</td>
                                    <td>{{ $appt->date }}</td>
                                    <td>{{ $appt->time }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($appt->status=='upcoming') bg-warning text-dark 
                                            @elseif($appt->status=='complete') bg-success 
                                            @else bg-danger @endif">{{ ucfirst($appt->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No appointments found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: ['Upcoming', 'Complete', 'Overdue'],
        datasets: [{ data: [{{ $counts['upcoming'] }}, {{ $counts['complete'] }}, {{ $counts['overdue'] }}] }]
    }
});

new Chart(document.getElementById('monthChart'), {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [{ label: 'Appointments', data:[10,20,15,25,30,20] }]
    }
});
</script>
</body>
</html>
