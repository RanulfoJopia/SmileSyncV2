<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // Fetch all appointments ordered by date and time for the table and other KPIs
    $allAppointments = \DB::table('appointments')
        ->orderBy('date', 'asc')
        ->orderBy('time', 'asc')
        ->get();

    // 1. Total Patients (KPI FIX)
    // Use a robust DB query to count unique non-empty entries in the 'patient' column.
    $totalPatients = \DB::table('appointments')
        ->select('patient') // Select the patient column
        ->whereNotNull('patient') // Ensure the patient name is not null
        ->where('patient', '!=', '') // Ensure the patient name is not an empty string
        ->distinct() // Count only unique patient names
        ->count();

    // 2. Upcoming Appointments (for the table)
    $appointments = $allAppointments
        ->filter(function ($appt) {
            // Using strtolower for robust case-insensitive status check
            return strtolower($appt->status) === 'upcoming'; 
        })
        ->take(10); // Show top 10 upcoming appointments

    // 3. KPI Counts (using all data)
    $counts = [
        'upcoming' => $allAppointments->where('status','upcoming')->count(),
        'complete' => $allAppointments->where('status','complete')->count(),
        'overdue'  => $allAppointments->where('status','overdue')->count(),
    ];

    return view('dashboard', compact('appointments', 'totalPatients', 'counts'));
}
}