<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Records - SmileSync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        html, body, .container-fluid, .row { height: 100%; }
        body { background: #f8f9fc; }

        .sidebar {
            background: white;
            min-height: 100vh;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
        }
        .sidebar .nav-link {
            color: #333;
            font-weight: 500;
            border-radius: 5px;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #0069d9;
            color: #fff !important;
            font-weight: bold;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg px-4" style="background:#0069d9;">
    <a class="navbar-brand fw-bold text-white" href="#">🦷 SmileSync</a>
    <div class="ms-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-light btn-sm" type="submit">Logout</button>
        </form>
    </div>
</nav>

<div class="container-fluid">
    <div class="row flex-nowrap">

        <!-- SIDEBAR -->
        <div class="col-auto col-md-2 p-0 sidebar">
            <h5 class="fw-bold text-primary">Navigation</h5>
            <ul class="nav flex-column mt-3">
                <li class="nav-item mb-2"><a class="nav-link" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('doctors.index') }}"><i class="bi bi-person-badge me-2"></i>Manage Doctors</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="{{ route('appointments.index') }}"><i class="bi bi-calendar-check me-2"></i>Appointments</a></li>
                <li class="nav-item mb-2"><a class="nav-link active" href="#"><i class="bi bi-people me-2"></i>Records</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="reports"><i class="bi bi-bar-chart-line me-2"></i>Reports</a></li>
                <li class="nav-item mb-2"><a class="nav-link" href="#"><i class="bi bi-bell me-2"></i>Notifications</a></li>
            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-10 p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary"><i class="bi bi-folder-plus me-2"></i>Medical Records</h3>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-circle"></i> Add Record
                </button>
            </div>

            <form method="GET" action="{{ route('records.index') }}" class="mb-3">
 <div class="input-group" style="max-width: 350px;">
 <input type="text" class="form-control" name="search" placeholder="Search records..."
value="{{ request('search') }}">
 <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
                     </form>

            <div class="card p-3 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Type</th>
                                <th>Date/Time</th>
                                <th>Notes</th>
                                <th>Document</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($records as $r)
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td>{{ $r->patient }}</td>
                                <td>{{ $r->doctor }}</td>
                                <td>{{ ucfirst($r->type) }}</td>
                                <td>{{ $r->date }} at {{ $r->time }}</td>
                                <td>{{ Str::limit($r->notes, 30) }}</td>
                                <td>
                                    @if($r->document)
                                        <a href="{{ asset('storage/uploads/'.$r->document) }}" target="_blank" class="btn btn-sm btn-secondary">View</a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#edit{{ $r->id }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- EDIT MODALS -->
            @foreach($records as $r)
            <div class="modal fade" id="edit{{ $r->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <form method="POST" action="{{ route('records.update') }}" enctype="multipart/form-data" class="modal-content">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $r->id }}">
                        <input type="hidden" name="existing_document" value="{{ $r->document }}">

                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title">Edit Record</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="fw-semibold">Patient Name</label>
                                    <input type="text" name="patient_name" class="form-control" value="{{ $r->patient }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-semibold">Doctor Name</label>
                                    <input type="text" name="doctor_name" class="form-control" value="{{ $r->doctor }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="fw-semibold">Type</label>
                                    <input type="text" name="type" class="form-control" value="{{ $r->type }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="fw-semibold">Date</label>
                                    <input type="date" name="date" class="form-control" value="{{ $r->date }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="fw-semibold">Time</label>
                                    <input type="time" name="time" class="form-control" value="{{ $r->time }}" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="fw-semibold">Notes</label>
                                    <textarea name="notes" class="form-control">{{ $r->notes }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="fw-semibold">Upload Document</label>
                                    <input type="file" name="document" class="form-control">
                                    @if($r->document)
                                        <small class="text-muted">Current file: {{ $r->document }}</small>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-info text-white" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<!-- ADD RECORD MODAL -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('records.add') }}" enctype="multipart/form-data" class="modal-content">
            @csrf

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="fw-semibold">Patient Name</label>
                        <input type="text" name="patient_name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">Doctor Name</label>
                        <input type="text" name="doctor_name" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">Type</label>
                        <input type="text" name="type" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">Time</label>
                        <input type="time" name="time" class="form-control" required>
                    </div>

                    <div class="col-md-12">
                        <label class="fw-semibold">Notes</label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="fw-semibold">Upload Document</label>
                        <input type="file" name="document" class="form-control">
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Add Record</button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
