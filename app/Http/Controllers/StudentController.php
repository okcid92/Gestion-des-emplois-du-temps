<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    private function getScheduleData()
    {
        // Get the start and end of the current week
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek()->subDay(); // End on Saturday
        
        // Définir les jours de la semaine
        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi'
        ];
        
        // Définir les créneaux horaires
        $timeSlots = [
            [
                'start' => '07:30',
                'end' => '12:30',
                'display_start' => '7h30',
                'display_end' => '12h30',
                'period' => 'Matin'
            ],
            [
                'start' => '14:00',
                'end' => '18:00',
                'display_start' => '14h',
                'display_end' => '18h',
                'period' => 'Après-midi'
            ]
        ];
        
        // Get the authenticated student's class schedules
        $schedules = collect();
        $student = auth()->guard('web')->user();
        $class = null;
        
        if ($student && $student->class) {
            $class = $student->class;
            $schedules = Schedule::with(['professor', 'class', 'salle'])
                ->where('class_id', $class->id)
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();
        }
        
        // Organiser les emplois du temps par jour
        $schedulesByDay = [];
        foreach ($days as $dayEn => $dayFr) {
            $schedulesByDay[$dayEn] = $schedules->filter(function($schedule) use ($dayEn) {
                return $schedule->day === ucfirst($dayEn);
            });
        }

        return [
            'weekStart' => $weekStart,
            'weekEnd' => $weekEnd,
            'days' => $days,
            'timeSlots' => $timeSlots,
            'schedulesByDay' => $schedulesByDay,
            'class' => $class
        ];
    }

    public function schedule()
    {
        $data = $this->getScheduleData();
        return view('student.schedule', $data);
    }

    public function downloadSchedule()
    {
        $data = $this->getScheduleData();
        $pdf = PDF::loadView('pdf.schedule', $data);
        
        $filename = 'emploi-du-temps-' . $data['weekStart']->format('d-m-Y') . '.pdf';
        return $pdf->download($filename);
    }
}
