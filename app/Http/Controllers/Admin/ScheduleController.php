<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::orderBy('day')->orderBy('start_time')->get();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        
        return view('admin.schedules.index', compact('schedules', 'weekStart', 'weekEnd'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();
            $professors = User::where('role', 'professor')->get();
            $classes = ClassModel::all();
            
            // Récupérer toutes les salles et les trier avec les indisponibles en premier
            $sallesIndisponibles = Salle::where('disponible', false)->orderBy('nom')->get();
            $sallesDisponibles = Salle::where('disponible', true)->orderBy('nom')->get();
            $salles = $sallesIndisponibles->concat($sallesDisponibles);
            
            // Débogage pour vérifier les données
            if ($professors->isEmpty()) {
                \Log::warning('Aucun professeur trouvé pour le formulaire d\'emploi du temps');
            }
            
            if ($classes->isEmpty()) {
                \Log::warning('Aucune classe trouvée pour le formulaire d\'emploi du temps');
            }
            
            return view('admin.schedules.create', compact('weekStart', 'weekEnd', 'professors', 'classes', 'salles'));
        } catch (\Exception $e) {
            // Log l'erreur
            \Log::error('Erreur dans ScheduleController@create: ' . $e->getMessage());
            // Afficher l'erreur
            dd($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'professor_id' => 'required|exists:users,id',
                'class_id' => 'required|exists:classes,id',
                'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'salle_id' => 'required|exists:salles,id',
            ]);
            
            // Vérifier les chevauchements
            $conflict = $this->checkScheduleConflicts($validated);
            if ($conflict) {
                return redirect()->route('admin.schedules.create')
                    ->with('error', $conflict)
                    ->withInput();
            }
            
            Schedule::create($validated);
            return redirect()->route('admin.schedules.index')
                            ->with('success', 'Emploi du temps créé avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur dans ScheduleController@store: ' . $e->getMessage());
            return redirect()->route('admin.schedules.create')
                            ->with('error', 'Une erreur est survenue lors de la création du cours.')
                            ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        try {
            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();
            $professors = User::where('role', 'professor')->get();
            $classes = ClassModel::all();
            
            // Récupérer toutes les salles et les trier avec les indisponibles en premier
            $sallesIndisponibles = Salle::where('disponible', false)->orderBy('nom')->get();
            $sallesDisponibles = Salle::where('disponible', true)->orderBy('nom')->get();
            $salles = $sallesIndisponibles->concat($sallesDisponibles);
            
            return view('admin.schedules.edit', compact('schedule', 'weekStart', 'weekEnd', 'professors', 'classes', 'salles'));
        } catch (\Exception $e) {
            \Log::error('Erreur dans ScheduleController@edit: ' . $e->getMessage());
            return redirect()->route('admin.schedules.index')
                            ->with('error', 'Une erreur est survenue lors de la modification du cours.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'professor_id' => 'required|exists:users,id',
                'class_id' => 'required|exists:classes,id',
                'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'salle_id' => 'required|exists:salles,id',
            ]);
            
            // Vérifier les chevauchements
            $conflict = $this->checkScheduleConflicts($validated, $schedule->id);
            if ($conflict) {
                return redirect()->route('admin.schedules.edit', $schedule)
                    ->with('error', $conflict)
                    ->withInput();
            }
            
            $schedule->update($validated);
            return redirect()->route('admin.schedules.index')
                            ->with('success', 'Emploi du temps mis à jour avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur dans ScheduleController@update: ' . $e->getMessage());
            return redirect()->route('admin.schedules.edit', $schedule)
                            ->with('error', 'Une erreur est survenue lors de la mise à jour du cours.')
                            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->delete();
            
            return redirect()->route('admin.schedules.index')
                            ->with('success', 'Emploi du temps supprimé avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur dans ScheduleController@destroy: ' . $e->getMessage());
            return redirect()->route('admin.schedules.index')
                            ->with('error', 'Une erreur est survenue lors de la suppression du cours.');
        }
    }

    /**
     * Vue classique de l'emploi du temps
     */
    public function classicView()
    {
        try {
            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();
            
            // Récupérer tous les emplois du temps avec leurs relations
            $schedules = Schedule::with(['professor', 'class', 'salle'])
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

            // Définir les jours en anglais (pour le modèle) avec leurs traductions en français
            $days = [
                'Monday' => 'Lundi',
                'Tuesday' => 'Mardi',
                'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi',
                'Friday' => 'Vendredi',
                'Saturday' => 'Samedi'
            ];

            // Définir les créneaux horaires standards avec le format complet pour la comparaison
            $timeSlots = [
                ['start' => '07:30:00', 'end' => '12:30:00', 'display_start' => '07:30', 'display_end' => '12:30'],
                ['start' => '14:00:00', 'end' => '18:00:00', 'display_start' => '14:00', 'display_end' => '18:00']
            ];
            
            // Organiser les emplois du temps par jour
            $schedulesByDay = [];
            foreach (array_keys($days) as $day) {
                $schedulesByDay[$day] = $schedules->filter(function($schedule) use ($day) {
                    return $schedule->day === $day;
                });
            }
            
            return view('admin.schedules.classic', compact(
                'schedulesByDay',
                'days',
                'timeSlots',
                'weekStart',
                'weekEnd'
            ));
        } catch (\Exception $e) {
            \Log::error('Erreur dans ScheduleController@classicView: ' . $e->getMessage());
            return redirect()->route('admin.schedules.index')
                            ->with('error', 'Une erreur est survenue lors de l\'affichage de l\'emploi du temps.');
        }
    }

    /**
     * Vérifie les chevauchements d'emploi du temps
     */
    private function checkScheduleConflicts(array $validated, ?int $excludeId = null): ?string
    {
        $query = Schedule::query();
        
        // Si on modifie un emploi du temps existant, on l'exclut de la vérification
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        // Vérifier les chevauchements pour la salle
        $conflictingSalle = (clone $query)
            ->where('salle_id', $validated['salle_id'])
            ->where('day', $validated['day'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>', $validated['start_time']);
                })->orWhere(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                })->orWhere(function($q) use ($validated) {
                    $q->where('start_time', '>=', $validated['start_time'])
                      ->where('end_time', '<=', $validated['end_time']);
                });
            })
            ->first();

        if ($conflictingSalle) {
            return 'La salle est déjà occupée sur ce créneau horaire.';
        }

        // Vérifier les chevauchements pour le professeur
        $conflictingProfessor = (clone $query)
            ->where('professor_id', $validated['professor_id'])
            ->where('day', $validated['day'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>', $validated['start_time']);
                })->orWhere(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                })->orWhere(function($q) use ($validated) {
                    $q->where('start_time', '>=', $validated['start_time'])
                      ->where('end_time', '<=', $validated['end_time']);
                });
            })
            ->first();

        if ($conflictingProfessor) {
            return 'Le professeur a déjà un cours sur ce créneau horaire.';
        }

        // Vérifier les chevauchements pour la classe
        $conflictingClass = (clone $query)
            ->where('class_id', $validated['class_id'])
            ->where('day', $validated['day'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>', $validated['start_time']);
                })->orWhere(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                })->orWhere(function($q) use ($validated) {
                    $q->where('start_time', '>=', $validated['start_time'])
                      ->where('end_time', '<=', $validated['end_time']);
                });
            })
            ->first();

        if ($conflictingClass) {
            return 'La classe a déjà un cours sur ce créneau horaire.';
        }

        return null;
    }

    /**
     * Télécharger l'emploi du temps en PDF
     */
    public function download()
    {
        try {
            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();
            
            // Récupérer tous les emplois du temps avec leurs relations
            $schedules = Schedule::with(['professor', 'class', 'salle'])
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

            // Définir les jours en anglais (pour le modèle) avec leurs traductions en français
            $days = [
                'Monday' => 'Lundi',
                'Tuesday' => 'Mardi',
                'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi',
                'Friday' => 'Vendredi',
                'Saturday' => 'Samedi'
            ];

            // Définir les créneaux horaires standards avec le format complet pour la comparaison
            $timeSlots = [
                ['start' => '07:30:00', 'end' => '12:30:00', 'display_start' => '07:30', 'display_end' => '12:30'],
                ['start' => '14:00:00', 'end' => '18:00:00', 'display_start' => '14:00', 'display_end' => '18:00']
            ];
            
            // Organiser les emplois du temps par jour
            $schedulesByDay = [];
            foreach (array_keys($days) as $day) {
                $schedulesByDay[$day] = $schedules->filter(function($schedule) use ($day) {
                    return $schedule->day === $day;
                });
            }
            
            $data = compact('schedulesByDay', 'days', 'timeSlots', 'weekStart', 'weekEnd');
            $pdf = PDF::loadView('pdf.schedule', $data);
            
            $filename = 'emploi-du-temps-general-' . $weekStart->format('d-m-Y') . '.pdf';
            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Log::error('Erreur dans ScheduleController@downloadSchedule: ' . $e->getMessage());
            return redirect()->route('admin.schedules.classic')
                            ->with('error', 'Une erreur est survenue lors du téléchargement de l\'emploi du temps.');
        }
    }
}