@extends('layouts.admin')

@section('title', 'Gestion des Salles')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4 text-primary fw-bold">Gestion des Salles</h1>
        <a href="{{ route('admin.salles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Salle
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
                <i class="fas fa-door-open me-2"></i>Liste des Salles
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Capacité</th>
                        <th>Disponibilité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salles as $salle)
                    <tr>
                        <td>{{ $salle->nom }}</td>
                        <td>{{ $salle->type ?? '-' }}</td>
                        <td>{{ $salle->capacite ?? '-' }}</td>
                        <td>
                            <div class="position-relative">
                                <span class="badge fs-6 bg-{{ $salle->disponible ? 'success' : 'danger' }} bg-opacity-75">
                                    <i class="fas {{ $salle->disponible ? 'fa-check' : 'fa-times' }} me-1"></i>
                                    {{ $salle->disponible ? 'Disponible' : 'Indisponible' }}
                                </span>
                                
                                @if(!$salle->disponible && isset($salle->cours_actuel))
                                    <div class="mt-2">
                                        <small class="text-danger">
                                            <i class="fas fa-clock me-1"></i>
                                            <strong>Cours actuel:</strong> {{ $salle->cours_actuel }}
                                            <br>
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $salle->horaire_actuel }}
                                        </small>
                                    </div>
                                @endif

                                @if($salle->occupations && $salle->occupations->count() > 0)
                                    <div class="mt-2">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#horaires-{{ $salle->id }}" aria-expanded="false">
                                            <i class="fas fa-calendar me-1"></i>Voir les horaires
                                        </button>
                                        <div class="collapse mt-2" id="horaires-{{ $salle->id }}">
                                            <div class="card card-body bg-white border-0 shadow-sm">
                                                <h6 class="card-subtitle mb-2 text-muted">Horaires d'occupation</h6>
                                                <ul class="list-unstyled mb-0">
                                                    @foreach($salle->occupations as $occupation)
                                                        <li class="mb-1">
                                                            <small>
                                                                <i class="fas fa-calendar-day me-1"></i>
                                                                <strong>{{ $occupation['jour'] }}</strong> :
                                                                {{ $occupation['debut'] }} - {{ $occupation['fin'] }}
                                                                <br>
                                                                <i class="fas fa-book me-1"></i>
                                                                {{ $occupation['cours'] }}
                                                            </small>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.salles.edit', $salle) }}" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.salles.destroy', $salle) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    .collapse {
        width: 300px;
        position: absolute;
        z-index: 1000;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,.03);
        border-radius: 10px;
    }
    .badge {
        padding: 0.5rem 0.75rem;
        font-weight: 500;
    }
    .badge.bg-success {
        background-color: #d1e7dd !important;
        color: #0f5132;
    }
    .badge.bg-danger {
        background-color: #f8d7da !important;
        color: #842029;
    }
</style>
@endpush
@endsection
