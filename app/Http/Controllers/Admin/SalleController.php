<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salle;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SalleController extends Controller
{
    public function index()
    {
        // Récupérer toutes les salles avec leurs emplois du temps
        $salles = Salle::with(['schedules' => function($query) {
            $query->orderBy('day')
                  ->orderBy('start_time');
        }])->get();
        
        // Get current day and time
        $currentDay = Carbon::now()->format('l'); // Returns day name (Monday, Tuesday, etc.)
        $currentTime = Carbon::now()->format('H:i');
        
        // Tableau de traduction des jours en français
        $joursFr = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];
        
        foreach ($salles as $salle) {
            // Vérifier si la salle est actuellement utilisée dans un emploi du temps
            $currentSchedule = $salle->schedules
                ->where('day', $currentDay)
                ->filter(function ($schedule) use ($currentTime) {
                    return $schedule->start_time <= $currentTime && $schedule->end_time > $currentTime;
                })
                ->first();
            
            if ($currentSchedule) {
                $salle->disponible = false;
                $salle->cours_actuel = $currentSchedule->title;
                $salle->horaire_actuel = "de {$currentSchedule->start_time} à {$currentSchedule->end_time}";
            }
            
            // Préparer les informations d'occupation pour chaque salle
            $salle->occupations = $salle->schedules->map(function ($schedule) use ($joursFr) {
                return [
                    'jour' => $joursFr[$schedule->day],
                    'debut' => $schedule->start_time,
                    'fin' => $schedule->end_time,
                    'cours' => $schedule->title
                ];
            });
        }
        
        // Trier les salles : indisponibles d'abord, puis disponibles, et ensuite par nom
        $salles = $salles->sortBy([
            ['disponible', 'asc'],
            ['nom', 'asc']
        ]);
        
        return view('admin.salles.index', compact('salles'));
    }

    public function create()
    {
        return view('admin.salles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'capacite' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'disponible' => ['boolean'],
        ]);

        Salle::create($validated);

        return redirect()->route('admin.salles.index')
            ->with('success', 'Salle créée avec succès.');
    }

    public function edit(Salle $salle)
    {
        return view('admin.salles.edit', compact('salle'));
    }

    public function update(Request $request, Salle $salle)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'capacite' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'disponible' => ['boolean'],
        ]);

        $salle->update($validated);

        return redirect()->route('admin.salles.index')
            ->with('success', 'Salle mise à jour avec succès.');
    }

    public function destroy(Salle $salle)
    {
        if ($salle->schedules()->exists()) {
            return redirect()->route('admin.salles.index')
                ->with('error', 'Cette salle ne peut pas être supprimée car elle est utilisée dans des emplois du temps.');
        }

        $salle->delete();
        return redirect()->route('admin.salles.index')
            ->with('success', 'Salle supprimée avec succès.');
    }
}
