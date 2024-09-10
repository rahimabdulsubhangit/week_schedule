<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\team;
use App\Models\emp;
use App\Models\WeeklyHour;
use Carbon\Carbon;

class WeeklyHoursController extends Controller
{
     public function index()
    {
        $teams = team::with('employees.weeklyHours')->get();
        $weeks = $this->generateWeeks(); // Function to generate week options
        return view('weekly-hours.index', compact('teams', 'weeks'));
    }

    public function show(Request $request)
    {
        $weekStartDate = $request->query('week_start_date');
        $startDate = Carbon::parse($weekStartDate);
        $endDate = $startDate->copy()->addDays(6);

        $employees = emp::with(['weeklyHours' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }])->get();

        $totalHours = $this->calculateTotalHours($employees, $startDate, $endDate);

        return view('weekly-hours.show', compact('employees', 'totalHours', 'startDate', 'endDate'));
    }

    public function update(Request $request)
    {
        foreach ($request->hours as $employeeId => $hoursData) {
            foreach ($hoursData as $date => $hours) {
                WeeklyHour::updateOrCreate(
                    ['emp_id' => $employeeId, 'date' => $date],
                    ['hours' => $hours]
                );
            }
        }
        
        return redirect()->back()->with('success', 'Hours updated successfully!');
    }

    private function generateWeeks()
    {
        // Generate the start dates for recent weeks
        $weeks = [];
        $currentDate = Carbon::now();

        for ($i = 0; $i < 4; $i++) {
            $startOfWeek = $currentDate->startOfWeek()->subWeeks($i);
            $weeks[$startOfWeek->format('Y-m-d')] = $startOfWeek->format('F j, Y') . ' - ' . $startOfWeek->copy()->endOfWeek()->format('F j, Y');
        }

        return $weeks;
    }

    private function calculateTotalHours($employees, $startDate, $endDate)
    {
        $totalHours = [];
        foreach ($employees as $employee) {
            foreach ($employee->weeklyHours as $weeklyHour) {
                $date = $weeklyHour->date->format('Y-m-d');
                if (!isset($totalHours[$date])) {
                    $totalHours[$date] = 0;
                }
                $totalHours[$date] += $weeklyHour->hours->hour + ($weeklyHour->hours->minute / 60);
            }
        }
        return $totalHours;
    }
}
