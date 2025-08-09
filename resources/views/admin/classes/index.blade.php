@extends('layouts.admin')

@section('title', 'Gestion des Classes')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4 text-primary fw-bold">Gestion des Classes</h1>
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Classe
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary">
                <i class="fas fa-table me-2"></i>Liste des Classes
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Nombre d'Étudiants</th>
                        <th>Cours Programmés</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                    <tr>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->students_count }}</td>
                        <td>{{ $class->schedules_count }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucune classe n'a été créée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
