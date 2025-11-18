<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    // Show only appointments of the logged-in user
    public function index()
    {
        // Fetch appointments where the current user is the scheduler (user_id)
        $appointments = Appointment::where('user_id', Auth::id())->get();

        // Fetch all doctors for the modals
        $doctors = DB::table('doctors')->get();

        return view('appointment', compact('appointments', 'doctors'));
    }


    // Store a new appointment
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'patient' => 'nullable|string', // Added validation for patient field
            'doctor' => 'required|string',
            'date' => 'required|date|after_or_equal:today', // 🎯 FIX: Cannot be before today
            'time' => 'required',
            'status' => 'required|in:upcoming,complete,overdue', // Ensure status is valid
            'notes' => 'nullable|string', // Added validation for notes field
        ]);

        Appointment::create([
            'user_id' => Auth::id(),
            'patient' => $request->patient,
            'doctor' => $request->doctor,
            'date' => $request->date,
            'time' => $request->time,
            'status' => $request->status,
            'type' => $request->type,
            'notes' => $request->notes,
        ]);

        return redirect()->route('appointments.index')
                         ->with('success', 'Schedule added successfully!');
    }


    // Update appointment
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Prevent editing by other users
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'type' => 'required|string',
            'patient' => 'nullable|string', // Added validation for patient field
            'doctor' => 'required|string',
            'date' => 'required|date|after_or_equal:today', // 🎯 FIX: Cannot be before today
            'time' => 'required',
            'status' => 'required|in:upcoming,complete,overdue', // Ensure status is valid
            'notes' => 'nullable|string', // Added validation for notes field
        ]);

        $appointment->update([
            'type' => $request->type,
            'patient' => $request->patient, // Added patient update
            'doctor' => $request->doctor,
            'date' => $request->date,
            'time' => $request->time,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment updated successfully!');
    }


    // Delete appointment
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->delete();

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment deleted successfully!');
    }
}