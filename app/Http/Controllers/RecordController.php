<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        // Automatically add appointments to records if they don't exist
        $appointments = DB::table('appointments')
            ->whereNotIn('type', ['personal', 'meeting'])
            ->get();

        foreach ($appointments as $a) {
            $exists = DB::table('records')
                ->where([
                    ['patient', $a->patient],
                    ['date', $a->date],
                    ['time', $a->time],
                ])
                ->exists();

            if (!$exists) {
                DB::table('records')->insert([
                    'patient' => $a->patient,
                    'doctor' => $a->doctor,
                    'type' => $a->type,
                    'date' => $a->date,
                    'time' => $a->time,
                    'notes' => $a->notes,
                    'document' => $a->document ?? null,
                ]);
            }
        }

        // SEARCH FUNCTIONALITY
        $search = $request->input('search');
        $records = DB::table('records');

        if ($search) {
            $records->where(function($query) use ($search) {
                $query->where('patient', 'like', "%{$search}%")
                      ->orWhere('doctor', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $records = $records->orderBy('date', 'desc')->get();

        return view('records', compact('records'));
    }

    public function add(Request $request)
    {
        $fileName = null;

        if ($request->hasFile('document')) {
            $fileName = time().'_'.$request->file('document')->getClientOriginalName();
            $request->file('document')->storeAs('uploads', $fileName, 'public');
        }

        DB::table('records')->insert([
            'patient' => $request->patient_name,
            'doctor' => $request->doctor_name,
            'type' => $request->type,
            'date' => $request->date,
            'time' => $request->time,
            'notes' => $request->notes,
            'document' => $fileName
        ]);

        return redirect('/records');
    }

    public function update(Request $request)
    {
        $fileName = $request->existing_document;

        if ($request->hasFile('document')) {
            $fileName = time().'_'.$request->file('document')->getClientOriginalName();
            $request->file('document')->storeAs('uploads', $fileName, 'public');
        }

        DB::table('records')
            ->where('id', $request->id)
            ->update([
                'patient' => $request->patient_name,
                'doctor' => $request->doctor_name,
                'type' => $request->type,
                'date' => $request->date,
                'time' => $request->time,
                'notes' => $request->notes,
                'document' => $fileName
            ]);

        return redirect('/records');
    }

    public function delete($id)
    {
        $record = DB::table('records')->where('id', $id)->first();

        if (!$record) {
            return redirect('/records')->with('error', 'Record not found.');
        }

        if ($record->document && Storage::disk('public')->exists("uploads/$record->document")) {
            Storage::disk('public')->delete("uploads/$record->document");
        }

        DB::table('records')->where('id', $id)->delete();

        return redirect('/records')->with('success', 'Record deleted successfully.');
    }
}
