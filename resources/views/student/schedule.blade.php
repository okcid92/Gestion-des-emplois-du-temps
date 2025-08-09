@extends('layouts.schedule')

@section('title', 'Mon emploi du temps')

@section('schedule-content')
<div class="container-fluid px-4">
    <div class="card mb-4" style="max-width: 1400px; margin: 0 auto;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-calendar-alt me-1"></i>
                Emploi du Temps - Semaine du {{ $weekStart->locale('fr')->format('d/m/Y') }} au {{ $weekEnd->locale('fr')->format('d/m/Y') }}
            </div>
            <div>
                <a href="{{ route('student.schedule.download') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-download me-1"></i> Télécharger PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered schedule-table">
                    <thead>
                        <tr class="bg-light">
                            <th style="width: 120px;">Horaire</th>
                            @foreach($days as $dayEn => $dayFr)
                                @if($dayEn != 'sunday')
                                    <th style="width: 16.66%;">{{ $dayFr }}</th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $timeSlot)
                            <tr>
                                <td class="bg-light text-center">
                                    <div class="time-slot-period">{{ $timeSlot['period'] }}</div>
                                    <div class="time-slot-hours">{{ $timeSlot['display_start'] }} - {{ $timeSlot['display_end'] }}</div>
                                </td>
                                @foreach($days as $dayEn => $dayFr)
                                    @if($dayEn != 'sunday')
                                        <td class="schedule-cell">
                                            @php
                                                $hasSchedule = false;
                                            @endphp
                                            @foreach($schedulesByDay[$dayEn] as $schedule)
                                                @php
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
                                                        <div class="schedule-title d-flex justify-content-between align-items-center">
                                                            <span>{{ $schedule->title }}</span>
                                                            @if(auth()->user()->role === 'administrator')
                                                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}" 
                                                                   class="btn btn-link btn-sm text-primary p-0">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div class="schedule-details">
                                                            <div class="schedule-detail-row">
                                                                <i class="fas fa-user-tie"></i>
                                                                <span>{{ $schedule->professor->name ?? 'Non assigné' }}</span>
                                                            </div>
                                                            <div class="schedule-detail-row">
                                                                <i class="fas fa-users"></i>
                                                                <span>{{ $schedule->class->name ?? 'Non assignée' }}</span>
                                                            </div>
                                                            <div class="schedule-detail-row">
                                                                <i class="fas fa-clock"></i>
                                                                <span>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</span>
                                                            </div>
                                                            <div class="schedule-detail-row">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                <span>{{ $schedule->salle->nom ?? 'Non assignée' }}</span>
                                                            </div>
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
                                    @endif
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
