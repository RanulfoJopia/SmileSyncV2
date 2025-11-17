<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // app/Http/Controllers/DoctorController.php

public function index()
{
    // Fetch all doctors to display in the table
    $doctors = Doctor::orderBy('name')->get();
    
    // Pass the doctors list to the view, now pointing to doctor.blade.php
    return view('doctor', compact('doctors')); 
}

    /**
     * Show the form for creating a new resource.
     * Note: Since we are using a single page, this method is often skipped. 
     * The form will be included in the index view.
     */
    public function create()
    {
        return redirect()->route('doctors.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:doctors,email',
        ]);

        // 2. Create the Doctor record
        Doctor::create($request->all());

        // 3. Redirect back to the index view with a success message
        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        // Redirect back with a success message
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }

    // Edit and Update methods are omitted for simplicity but follow the same pattern
}