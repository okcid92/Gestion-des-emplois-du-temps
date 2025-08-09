<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\User;
use App\Models\ClassModel;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdministrator()) {
            return $this->adminDashboard();
        } elseif ($user->isProfessor()) {
            return redirect()->route('professor.schedules');
        } else {
            return redirect()->route('student.schedule');
        }
    }

    public function adminDashboard()
    {
        // Récupérer les statistiques
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalProfessors = User::where('role', 'professor')->count();
        $totalClasses = ClassModel::count();

        // Récupérer tous les utilisateurs pour le tableau
        $users = User::latest()->get();
        
        // Définir la semaine en cours pour l'emploi du temps
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        
        // Définir les jours de la semaine
        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi',
            'sunday' => 'Dimanche'
        ];
        
        // Définir les créneaux horaires
        $timeSlots = [
            ['start' => '07:30', 'end' => '12:30', 'display_start' => '7h30', 'display_end' => '12h30', 'period' => 'Matin'],
            ['start' => '14:00', 'end' => '18:00', 'display_start' => '14h', 'display_end' => '18h', 'period' => 'Après-midi'],
        ];
        
        // Récupérer les emplois du temps pour la semaine en cours
        $schedules = Schedule::with(['professor', 'class', 'salle'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
            
        // Organiser les emplois du temps par jour
        $schedulesByDay = [];
        foreach ($days as $dayEn => $dayFr) {
            $schedulesByDay[$dayEn] = $schedules->filter(function($schedule) use ($dayEn) {
                return strtolower(Carbon::parse($schedule->day)->format('l')) === $dayEn;
            });
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalProfessors',
            'totalClasses',
            'users',
            'weekStart',
            'weekEnd',
            'days',
            'timeSlots',
            'schedulesByDay'
        ));
    }

    public function printSchedule()
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $schedules = Schedule::whereBetween('day', [$weekStart, $weekEnd])->get();

        return view('schedules.printable', compact('schedules', 'weekStart', 'weekEnd'));
    }
}
