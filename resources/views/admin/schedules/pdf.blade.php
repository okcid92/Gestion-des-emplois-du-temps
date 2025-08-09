<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Emploi du temps</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .schedule-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .schedule-info {
            font-size: 0.9em;
            color: #666;
        }
        .week-info {
            margin-bottom: 20px;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Emploi du temps</h1>
    
    <div class="week-info">
        Semaine du {{ $weekStart->format('d/m/Y') }} au {{ $weekEnd->format('d/m/Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Jour</th>
                <th>Cours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($days as $dayEn => $dayFr)
                <tr>
                    <td style="width: 15%;">{{ $dayFr }}</td>
                    <td>
                        @php
                            $daySchedules = $schedules->where('day', $dayEn)->sortBy('start_time');
                        @endphp
                        
                        @foreach($daySchedules as $schedule)
                            <div class="schedule-item">
                                <div class="schedule-title">
                                    {{ $schedule->title }}
                                </div>
                                <div class="schedule-info">
                                    {{ $schedule->start_time }} - {{ $schedule->end_time }} |
                                    Prof: {{ $schedule->professor->name }} |
                                    Classe: {{ $schedule->class->name }} |
                                    Salle: {{ $schedule->salle->nom }}
                                </div>
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
