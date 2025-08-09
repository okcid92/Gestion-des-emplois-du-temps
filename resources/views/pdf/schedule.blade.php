<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Emploi du Temps - IBAM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }
        th {
            background-color: #f0f0f0;
        }
        .schedule-item {
            margin-bottom: 5px;
            padding: 5px;
            background-color: #f9f9f9;
        }
        .no-class {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>IBAM - Institut Burkinabé des Arts et Métiers</h2>
        <h3>Emploi du Temps</h3>
        <p>Semaine du {{ $weekStart->locale('fr')->format('d/m/Y') }} au {{ $weekEnd->locale('fr')->format('d/m/Y') }}</p>
        @if(isset($class))
            <p>Classe : {{ $class->name }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Horaire</th>
                @foreach($days as $dayEn => $dayFr)
                    <th>{{ $dayFr }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($timeSlots as $timeSlot)
                <tr>
                    <td>{{ $timeSlot['display_start'] }} - {{ $timeSlot['display_end'] }}</td>
                    @foreach($days as $dayEn => $dayFr)
                        <td>
                            @php $hasSchedule = false; @endphp
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
                                        <strong>{{ $schedule->title }}</strong><br>
                                        Prof: {{ $schedule->professor->name ?? 'Non assigné' }}<br>
                                        {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}<br>
                                        Salle: {{ $schedule->salle->nom ?? 'Non assignée' }}
                                    </div>
                                @endif
                            @endforeach
                            @if(!$hasSchedule)
                                <div class="no-class">Pas de cours</div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
