@extends('layouts.schedule')

@section('content')
<div class="container">
    <h1>Emploi du temps</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jour</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th>Professeur</th>
                <th>Classe</th>
                <th>Salle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->day }}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                    <td>{{ $schedule->professor->name }}</td>
                    <td>{{ $schedule->class->name }}</td>
                    <td>{{ $schedule->room }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
