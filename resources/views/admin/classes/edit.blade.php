@extends('layouts.admin')

@section('title', 'Modifier une Classe')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Modifier la Classe</h1>
        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Formulaire de Modification
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.classes.update', $class->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de la Classe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $class->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Enregistrer les Modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informations
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-6">Étudiants :</dt>
                        <dd class="col-sm-6">{{ $class->students()->count() }}</dd>

                        <dt class="col-sm-6">Cours programmés :</dt>
                        <dd class="col-sm-6">{{ $class->schedules()->count() }}</dd>

                        <dt class="col-sm-6">Créée le :</dt>
                        <dd class="col-sm-6">{{ $class->created_at->format('d/m/Y') }}</dd>

                        <dt class="col-sm-6">Dernière modification :</dt>
                        <dd class="col-sm-6">{{ $class->updated_at->format('d/m/Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
