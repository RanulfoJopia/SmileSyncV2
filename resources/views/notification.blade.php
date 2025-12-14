<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications - SmileSync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* --- GENERAL & SIDEBAR STYLES (FROM ORIGINAL RECORDS PAGE) --- */
        html, body, .container-fluid, .row { height: 100%; }
        body { background: #f0f2f5; font-family: 'Poppins', sans-serif; } /* Updated body background to match dashboard */

        .sidebar {
            background: white;
            min-height: calc(100vh - 60px); /* Adjusted height to account for the sticky navbar */
            border-right: 1px solid #e0e4eb;
            padding: 20px 0; /* Updated padding to match dashboard sidebar */
            box-shadow: 2px 0 5px rgba(0,0,0,0.02);
            position: sticky;
            top: 60px; /* Offset by the navbar height */
        }
        .sidebar h5 { color: #004c9e; padding: 0 20px; }
        .sidebar .nav-item { padding: 0 10px; }
        .sidebar .nav-link { 
            color: #333; 
            padding: 12px 15px; /* Updated padding to match dashboard sidebar */
            border-radius: 8px; /* Updated border-radius to match dashboard sidebar */
            margin-bottom: 5px; 
            display: flex; 
            align-items: center; 
            transition: all .2s; 
        }
        .sidebar .nav-link i { font-size: 1.1rem; width: 25px; }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #0069d9;
            color: #fff !important;
            font-weight: 600; /* Updated font-weight to match dashboard sidebar */
        }
        /* Style for the clickable patient link */
        .patient-link:hover {
            text-decoration: underline !important;
        }

        /* --- NAVBAR STYLES (FROM DASHBOARD CODE) --- */
        .navbar { 
            background: #004c9e; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        } 
        .navbar-brand { font-weight: 700; }
        .user-avatar { border: 2px solid white; width: 40px; height: 40px; object-fit: cover; } 
    </style>
</head>
<body>

{{-- 1. BLADE LOGIC TO DETERMINE ACTIVE TAB BASED ON URL PARAMETER --}}
@php
    // Read the 'tab' query parameter from the URL, default to 'unread'
    $currentTab = request('tab', 'unread'); 
    
    // Set active/show classes dynamically
    $unreadActive = $currentTab === 'unread' ? 'active' : '';
    $readActive = $currentTab === 'read' ? 'active' : '';
    $unreadShow = $currentTab === 'unread' ? 'show active' : '';
    $readShow = $currentTab === 'read' ? 'show active' : '';
@endphp

{{-- Applied previous navbar suggestion: d-flex and justify-content-between --}}
<nav class="navbar px-4 sticky-top d-flex justify-content-between">
    <a class="navbar-brand fw-bold text-white" href="/dashboard"><i class="bi bi-people-fill me-2"></i> SmileSync Notification</a>

    {{-- UPDATED Dropdown Menu for User and Logout (ms-auto removed as redundant with d-flex) --}}
    <div class="dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{-- Avatar --}}
            <img src="{{ asset('assets/avatar.png') }}" class="rounded-circle user-avatar">
        </a>
        
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
            <li class="dropdown-header">Logged in as:</li>
            <li class="dropdown-header fw-bold text-primary">Admin User</li>
            <li><hr class="dropdown-divider"></li>
            
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid p-0">
    <div class="row g-0">

        <div class="col-auto col-md-2 sidebar">
            <h5 class="fw-bold mt-2 mb-4">Main Menu</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('doctors.index') }}"><i class="bi bi-person-badge me-2"></i>Manage Doctors</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('appointments.index') }}"><i class="bi bi-calendar-check me-2"></i> Appointments</a></li>
                <li class="nav-item"><a class="nav-link" href="/records"><i class="bi bi-people me-2"></i> Records</a></li>
                <li class="nav-item"><a class="nav-link" href="reports"><i class="bi bi-bar-chart-line me-2"></i> Reports</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('notifications.index') }}"><i class="bi bi-bell me-2"></i> Notifications</a></li>
            </ul>
        </div>

        <div class="col-md-10 p-5"> {{-- Added p-5 for spacing --}}
            <h3 class="fw-bold text-primary mb-4"><i class="bi bi-bell me-2"></i>Notifications</h3>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card p-4">
                <ul class="nav nav-tabs mb-4" id="notificationTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        {{-- Tab Button using dynamic active class --}}
                        <button class="nav-link {{ $unreadActive }}" id="unread-tab" data-bs-toggle="tab" data-bs-target="#unread-tab-pane" type="button" role="tab">
                            Unread ({{ $unreadNotifications->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        {{-- Tab Button using dynamic active class --}}
                        <button class="nav-link {{ $readActive }}" id="read-tab" data-bs-toggle="tab" data-bs-target="#read-tab-pane" type="button" role="tab">
                            Read ({{ $readNotifications->count() }})
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="notificationTabsContent">
                    
                    {{-- UNREAD NOTIFICATIONS Pane using dynamic show active classes --}}
                    <div class="tab-pane fade {{ $unreadShow }}" id="unread-tab-pane" role="tabpanel" tabindex="0">
                        @forelse ($unreadNotifications as $notification)
                            <div class="d-flex justify-content-between align-items-center notification-item unread p-3 border-bottom">
                                <div>
                                    <p class="mb-1 fw-bold text-primary">{{ $notification->data['title'] ?? 'New Appointment Scheduled' }}</p>
                                    <p class="mb-0 text-dark">{{ $notification->data['message'] ?? 'Check your appointments for details.' }}</p>
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i> Received {{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                {{-- 2. ADDED HIDDEN INPUT to form --}}
                                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="active_tab" value="unread">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="alert alert-info text-center">You have no new notifications.</div>
                        @endforelse
                    </div>

                    {{-- READ NOTIFICATIONS Pane using dynamic show active classes --}}
                    <div class="tab-pane fade {{ $readShow }}" id="read-tab-pane" role="tabpanel" tabindex="0">
                        @forelse ($readNotifications as $notification)
                            <div class="d-flex justify-content-between align-items-center notification-item read p-3 border-bottom">
                                <div>
                                    <p class="mb-1 text-secondary fw-semibold">{{ $notification->data['title'] ?? 'New Appointment Scheduled' }}</p>
                                    <p class="mb-0 text-muted">{{ $notification->data['message'] ?? 'Check your appointments for details.' }}</p>
                                    <small class="text-muted"><i class="bi bi-check-circle me-1"></i> Read {{ $notification->read_at->diffForHumans() }}</small>
                                </div>
                                {{-- 2. ADDED HIDDEN INPUT to form --}}
                                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="active_tab" value="read">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="alert alert-info text-center">You have no read notifications.</div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>