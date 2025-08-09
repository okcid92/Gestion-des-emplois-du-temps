@extends('layouts.admin')

@section('title', 'Emploi du Temps Classique')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Emploi du Temps Classique</h1>
    <div>
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary me-2">
            <i class="fas fa-list me-2"></i>Vue Liste
        </a>
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary me-2">
            <i class="fas fa-plus me-2"></i>Nouveau Cours
        </a>
        <a href="{{ route('admin.schedules.download') }}" class="btn btn-light">
            <i class="fas fa-download me-2"></i>Télécharger PDF
        </a>
    </div>
</div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar-alt me-2"></i>
            Semaine du {{ $weekStart->locale('fr')->format('d/m/Y') }} au {{ $weekEnd->locale('fr')->format('d/m/Y') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered schedule-table">
                    <thead>
                        <tr class="bg-light">
                            <th style="width: 100px;">Horaire</th>
                            @foreach($days as $dayEn => $dayFr)
                                <th style="width: 14%;">
                                    {{ $dayFr }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $timeSlot)
                            <tr>
                                <td class="bg-light text-center font-weight-bold">{{ $timeSlot['display_start'] ?? $timeSlot['start'] }} - {{ $timeSlot['display_end'] ?? $timeSlot['end'] }}</td>
                                @foreach($days as $dayEn => $dayFr)
                                    <td class="schedule-cell">
                                        @php
                                            $hasSchedule = false;
                                        @endphp
                                        @foreach($schedulesByDay[$dayEn] as $schedule)
                                            @php
                                                // Vérifier si l'horaire du cours est dans le créneau actuel
                                                $scheduleStartTime = $schedule->start_time;
                                                $scheduleEndTime = $schedule->end_time;
                                                $inTimeSlot = ($scheduleStartTime >= $timeSlot['start'] && $scheduleStartTime < $timeSlot['end']) || 
                                                              ($scheduleEndTime > $timeSlot['start'] && $scheduleEndTime <= $timeSlot['end']) ||
                                                              ($scheduleStartTime <= $timeSlot['start'] && $scheduleEndTime >= $timeSlot['end']);
                                                if ($inTimeSlot) {
                                                    $hasSchedule = true;
                                                }
                                            @endphp
                                            @if($inTimeSlot)
                                                <div class="schedule-item">
                                                    <div class="schedule-title">{{ $schedule->title }}</div>
                                                    <div class="schedule-details">
                                                        <small>
                                                            <i class="fas fa-user-tie me-1"></i> {{ $schedule->professor->name ?? 'Non assigné' }}<br>
                                                            <i class="fas fa-users me-1"></i> {{ $schedule->class->name ?? 'Non assignée' }}<br>
                                                            <i class="fas fa-clock me-1"></i> {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}<br>
                                                            <i class="fas fa-map-marker-alt me-1"></i> {{ $schedule->salle->nom ?? 'Non assignée' }}
                                                        </small>
                                                    </div>
                                                    <div class="schedule-actions mt-2">
                                                        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                        @if(!$hasSchedule)
                                            <div class="no-class-item">
                                                <div class="no-class-text">Pas de cours</div>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .schedule-table {
        table-layout: fixed;
    }
    
    .schedule-cell {
        height: 100px;
        vertical-align: top;
        padding: 5px;
    }
    
    .schedule-item {
        background-color: #f8f9fa;
        border-left: 4px solid #0d6efd;
        padding: 8px;
        margin-bottom: 5px;
        border-radius: 4px;
        font-size: 0.85rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.1);
    }
    
    .schedule-title {
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .schedule-details {
        font-size: 0.8rem;
        color: #555;
    }
    
    .schedule-actions {
        display: flex;
        gap: 5px;
    }
    
    .no-class-item {
        background-color: #fff;
        border: 1px dashed #dee2e6;
        padding: 8px;
        margin-bottom: 5px;
        border-radius: 4px;
        font-size: 0.85rem;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80px;
    }
    
    .no-class-text {
        font-weight: bold;
        color: #757575;
        font-style: italic;
    }
</style>
@endsection
