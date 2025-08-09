@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">Ajouter un emploi du temps</a>
    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Jour</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
            <tr>
                <td>{{ $schedule->title }}</td>
                <td>{{ $schedule->day }}</td>
                <td>{{ $schedule->start_time }}</td>
                <td>{{ $schedule->end_time }}</td>
                <td>
                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
