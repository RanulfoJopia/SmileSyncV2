<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // A mapping for month numbers to names (using '01' to '12')
    private $monthNames = [
        '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', 
        '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', 
        '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
    ];

    public function index(Request $request)
    {
        // Get the requested report type, defaulting to 'overview'
        $reportType = $request->get('report', 'overview');
        
        // --- Global KPI Data ---
        $kpiData = $this->getKpiData();

        // --- Chart Data ---
        $chartData = [];

        if ($reportType === 'patient_visits') {
            $chartData['patientCharts'] = $this->getPatientVisitData();
        } elseif ($reportType === 'doctor_overview') {
            $chartData['doctorCharts'] = $this->getDoctorOverviewData();
        }
        
        // Combine all data to pass to the view
        $data = array_merge($kpiData, $chartData, ['reportType' => $reportType]);

        // Note: Ensure your reports view expects these data variables
        return view('reports', $data);
    }

    /**
     * Fetches the top-level KPI numbers.
     */
    private function getKpiData()
    {
        // Total Completed Visits (Q1 KPI)
        // Note: Temporarily removed date filter to test if records exist at all.
        $totalCompletedVisits = DB::table('appointments')
            // Using DB::raw for case-insensitive comparison to robustly find 'complete'
            ->where(DB::raw('LOWER(status)'), 'complete') 
            // ->whereBetween('date', [now()->startOfYear(), now()->startOfYear()->addMonths(3)]) // Re-enable later
            ->count(); 
        
        // Total Appointments (all time)
        $totalAppointments = DB::table('appointments')->count(); 

        // Active Doctors (count all entries in the doctors table)
        $activeDoctors = DB::table('doctors')->count(); 

        return [
            'totalVisits' => $totalCompletedVisits,
            'totalAppointments' => $totalAppointments,
            'activeDoctors' => $activeDoctors,
        ];
    }

    /**
     * Calculates data for Patient Visit Summary Charts (using the 'appointments' table).
     */
    private function getPatientVisitData()
    {
        // 1. Monthly Visits (from appointments table, counting 'complete' status)
        $monthlyVisits = DB::table('appointments')
            ->select(
                DB::raw("DATE_FORMAT(date, '%m') as month_num"), 
                DB::raw('COUNT(*) as count')
            )
            // Only count appointments that are complete/finished visits
            ->where(DB::raw('LOWER(status)'), 'complete') 
            ->groupBy('month_num')
            ->orderBy('month_num', 'asc')
            ->get();

        $months = [];
        $visitCounts = [];
        foreach ($monthlyVisits as $visit) {
            $months[] = $this->monthNames[$visit->month_num] ?? $visit->month_num;
            $visitCounts[] = $visit->count;
        }

        // 2. Visit Type Distribution (from appointments table, counting 'complete' status)
        $typeDistribution = DB::table('appointments')
            ->select('type', DB::raw('COUNT(*) as count'))
            // Only count appointments that are complete/finished visits
            ->where(DB::raw('LOWER(status)'), 'complete') 
            ->groupBy('type')
            ->orderBy('count', 'desc')
            ->get();
        
        $typeLabels = $typeDistribution->pluck('type')->map(fn($type) => ucfirst($type))->toArray();
        $typeCounts = $typeDistribution->pluck('count')->toArray();

        return [
            'months' => $months,
            'visitCounts' => $visitCounts,
            'typeLabels' => $typeLabels,
            'typeCounts' => $typeCounts,
        ];
    }
    
    /**
     * Calculates data for Doctor Overview Charts (using the 'appointments' table).
     */
    private function getDoctorOverviewData()
    {
        // 1. Appointments by Doctor & Month
        $appointmentsByDoctor = DB::table('appointments')
            ->select(
                DB::raw("DATE_FORMAT(date, '%m') as month_num"), 
                'doctor', // <-- FIX: Using 'doctor' column
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month_num', 'doctor') // <-- FIX: Using 'doctor' column
            ->orderBy('month_num', 'asc')
            ->get();

        $allMonths = $appointmentsByDoctor->pluck('month_num')->unique()->map(fn($m) => $this->monthNames[$m] ?? $m)->toArray();
        $allDoctors = $appointmentsByDoctor->pluck('doctor')->unique()->toArray(); // <-- FIX: Using 'doctor' column

        // 2. Doctor Ranking (Total Appointments Q1)
        $doctorRanking = DB::table('appointments')
            ->select('doctor', DB::raw('COUNT(*) as count')) // <-- FIX: Using 'doctor' column
            // Note: Temporarily REMOVING Q1 filter to ensure ranking works with existing data
            // ->whereBetween('date', [now()->startOfYear(), now()->startOfYear()->addMonths(3)]) // Re-enable later
            ->groupBy('doctor') // <-- FIX: Using 'doctor' column
            ->orderBy('count', 'desc')
            ->get();

        $appointmentCounts = $doctorRanking->pluck('count', 'doctor')->toArray(); // <-- FIX: Using 'doctor' column
        
        // Format for Chart.js consumption (Renaming 'doctor' back to 'doctor_name' for Blade JS compatibility)
        $appointments = $appointmentsByDoctor->map(function ($item) {
            $item->month = $this->monthNames[$item->month_num] ?? $item->month_num;
            $item->doctor_name = $item->doctor; // Map 'doctor' to 'doctor_name' for front-end script
            unset($item->month_num);
            unset($item->doctor); // Remove the original 'doctor' column
            return $item;
        })->toArray();

        return [
            'months' => array_values($allMonths),
            'doctors' => array_values($allDoctors),
            'appointments' => $appointments,
            'appointmentCounts' => $appointmentCounts,
        ];
    }
}