@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Ajouter une Salle</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.salles.index') }}">Salles</a></li>
        <li class="breadcrumb-item active">Ajouter</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-door-open me-1"></i>
            Nouvelle Salle
        </div>
        <div class="card-body">
            <form action="{{ route('admin.salles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de la salle *</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                           id="nom" name="nom" value="{{ old('nom') }}" required
                           placeholder="Exemple: Salle 101, Laboratoire, etc.">
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type de salle</label>
                    <select class="form-select @error('type') is-invalid @enderror" 
                            id="type" name="type">
                        <option value="">Sélectionner un type</option>
                        <option value="Salle de cours" {{ old('type') == 'Salle de cours' ? 'selected' : '' }}>Salle de cours</option>
                        <option value="Laboratoire" {{ old('type') == 'Laboratoire' ? 'selected' : '' }}>Laboratoire</option>
                        <option value="Amphithéâtre" {{ old('type') == 'Amphithéâtre' ? 'selected' : '' }}>Amphithéâtre</option>
                        <option value="Salle informatique" {{ old('type') == 'Salle informatique' ? 'selected' : '' }}>Salle informatique</option>
                        <option value="Autre" {{ old('type') == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="capacite" class="form-label">Capacité</label>
                    <input type="number" class="form-control @error('capacite') is-invalid @enderror" 
                           id="capacite" name="capacite" value="{{ old('capacite') }}" min="1"
                           placeholder="Nombre de places">
                    @error('capacite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3"
                              placeholder="Description optionnelle de la salle">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('disponible') is-invalid @enderror" 
                               id="disponible" name="disponible" value="1" 
                               {{ old('disponible', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="disponible">Salle disponible</label>
                        @error('disponible')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Créer la salle</button>
                    <a href="{{ route('admin.salles.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
