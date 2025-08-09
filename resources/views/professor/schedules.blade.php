@extends('layouts.schedule')

@section('title', 'Mes cours')

@section('schedule-content')
<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-alt me-1"></i>
                Emploi du Temps - Semaine du {{ $weekStart->locale('fr')->format('d/m/Y') }} au {{ $weekEnd->locale('fr')->format('d/m/Y') }}
            </div>
            <div>
                <a href="{{ route('professor.schedule.download') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-download me-1"></i> Télécharger PDF
                </a>
            </div>
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
                                <td class="bg-light text-center font-weight-bold">{{ $timeSlot['display_start'] }} - {{ $timeSlot['display_end'] }}</td>
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
                                                            <i class="fas fa-users me-1"></i> {{ $schedule->class->name ?? 'Non assignée' }}<br>
                                                            <i class="fas fa-clock me-1"></i> {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}<br>
                                                            <i class="fas fa-map-marker-alt me-1"></i> {{ $schedule->salle->nom ?? 'Non assignée' }}
                                                        </small>
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
@endsection
