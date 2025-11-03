<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class DashboardController extends Controller
{
   public function index()
{
    $userId = auth()->id();

    $appointments = \DB::table('appointments as a')
        ->leftJoin('users as u', 'a.doctor_id', '=', 'u.id')
        ->select('a.*', \DB::raw("CONCAT(u.first_name,' ',u.last_name) as doctor_name"))
        ->where('a.user_id', $userId)
        ->orWhere('a.doctor_id', $userId)
        ->orderBy('date')
        ->orderBy('time')
        ->get();

    $totalPatients = $appointments->count();

    $counts = [
        'upcoming' => $appointments->where('status','upcoming')->count(),
        'complete' => $appointments->where('status','complete')->count(),
        'overdue'  => $appointments->where('status','overdue')->count(),
    ];

    return view('dashboard', compact('appointments','totalPatients','counts'));
}

}
