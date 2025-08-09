@extends('layouts.admin')

@section('title', 'Emploi du Temps')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Emploi du Temps</h1>
    <div>
        <a href="{{ route('admin.schedules.classic') }}" class="btn btn-secondary me-2">
            <i class="fas fa-calendar-alt me-2"></i>Vue Classique
        </a>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouveau Cours
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-calendar-alt me-2"></i>
        Liste des Cours
    </div>
        <div class="card-body">
            @php
                $translations = [
                    'Monday' => 'Lundi',
                    'Tuesday' => 'Mardi',
                    'Wednesday' => 'Mercredi',
                    'Thursday' => 'Jeudi',
                    'Friday' => 'Vendredi',
                    'Saturday' => 'Samedi'
                ];
            @endphp
    
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Cours</th>
                            <th>Professeur</th>
                            <th>Classe</th>
                            <th>Salle</th>
                            <th>Jour</th>
                            <th>Heure de début</th>
                            <th>Heure de fin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
            <tbody>
                @forelse($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->title }}</td>
                        <td>{{ $schedule->professor->name ?? 'Non assigné' }}</td>
                        <td>{{ $schedule->class->name ?? 'Non assignée' }}</td>
                        <td>{{ $schedule->salle->nom ?? $schedule->old_room ?? 'Non assignée' }}</td>
                        <td>{{ $translations[$schedule->day] ?? $schedule->day }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                        <td style="white-space: nowrap;">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px;">
                            Aucun cours n'a été trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
            </div>
        </div>
    </div>
</div>

@endsection
