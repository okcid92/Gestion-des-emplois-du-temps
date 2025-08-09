@extends('layouts.admin')

@section('title', 'Ajouter un cours')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ajouter un cours</h1>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Retour
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-plus me-2"></i>
        Nouveau cours
    </div>
    <div class="card-body">
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($professors->isEmpty())
        <div class="alert alert-warning">
            <strong>Attention :</strong> Aucun professeur n'est disponible. Veuillez d'abord ajouter des professeurs.
        </div>
    @endif

    @if($classes->isEmpty())
        <div class="alert alert-warning">
            <strong>Attention :</strong> Aucune classe n'est disponible. Veuillez d'abord ajouter des classes.
        </div>
    @endif

    @if($salles->isEmpty())
        <div class="alert alert-warning">
            <strong>Attention :</strong> Aucune salle n'est disponible. Veuillez d'abord ajouter des salles.
        </div>
    @endif
    
    <form action="{{ route('admin.schedules.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">
                Titre du cours <span style="color: red;">*</span>
            </label>
            <input type="text" 
                   class="form-control @error('title') is-invalid @enderror" 
                   id="title" 
                   name="title" 
                   value="{{ old('title') }}" 
                   placeholder="Exemple: Mathématiques, Français, etc."
                   required
                   >
            @error('title')
                <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="professor_id" class="form-label fw-bold">
                Professeur <span style="color: red;">*</span>
            </label>
            <select class="form-select @error('professor_id') is-invalid @enderror" 
                    id="professor_id" 
                    name="professor_id" 
                    required
                    >
                <option value="">Sélectionnez un professeur</option>
                @forelse($professors as $professor)
                    <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                        {{ $professor->name }}
                    </option>
                @empty
                    <option value="" disabled>Aucun professeur disponible</option>
                @endforelse
            </select>
            @error('professor_id')
                <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="class_id" class="form-label fw-bold">
                Classe <span style="color: red;">*</span>
            </label>
            <select class="form-select @error('class_id') is-invalid @enderror" 
                    id="class_id" 
                    name="class_id" 
                    required
                    >
                <option value="">Sélectionnez une classe</option>
                @forelse($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @empty
                    <option value="" disabled>Aucune classe disponible</option>
                @endforelse
            </select>
            @error('class_id')
                <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>



        <div class="mb-3">
            <label for="day" class="form-label fw-bold">
                Jour <span style="color: red;">*</span>
            </label>
            <select class="form-select @error('day') is-invalid @enderror" 
                    id="day" 
                    name="day" 
                    required
                    >
                <option value="">Sélectionnez un jour</option>
                <option value="Monday" {{ old('day') == 'Monday' ? 'selected' : '' }}>Lundi</option>
                <option value="Tuesday" {{ old('day') == 'Tuesday' ? 'selected' : '' }}>Mardi</option>
                <option value="Wednesday" {{ old('day') == 'Wednesday' ? 'selected' : '' }}>Mercredi</option>
                <option value="Thursday" {{ old('day') == 'Thursday' ? 'selected' : '' }}>Jeudi</option>
                <option value="Friday" {{ old('day') == 'Friday' ? 'selected' : '' }}>Vendredi</option>
                <option value="Saturday" {{ old('day') == 'Saturday' ? 'selected' : '' }}>Samedi</option>
            </select>
            @error('day')
                <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label fw-bold">
                Heure de début <span style="color: red;">*</span>
            </label>
            <input type="time" 
                   class="form-control @error('start_time') is-invalid @enderror" 
                   id="start_time" 
                   name="start_time" 
                   value="{{ old('start_time') }}" 
                   required
                   >
            @error('start_time')
                <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label fw-bold">
                Heure de fin <span style="color: red;">*</span>
            </label>
            <input type="time" 
                   class="form-control @error('end_time') is-invalid @enderror" 
                   id="end_time" 
                   name="end_time" 
                   value="{{ old('end_time') }}" 
                   required
                   >
            @error('end_time')
                <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="salle_id" class="form-label fw-bold">
                Salle <span style="color: red;">*</span>
            </label>
            <select class="form-select @error('salle_id') is-invalid @enderror" 
                    id="salle_id" 
                    name="salle_id" 
                    required
                    >
                <option value="">Sélectionnez une salle</option>
                
                @if($salles->where('disponible', false)->count() > 0)
                    <optgroup label="Salles indisponibles">
                        @foreach($salles->where('disponible', false) as $salle)
                            <option value="{{ $salle->id }}" {{ old('salle_id') == $salle->id ? 'selected' : '' }} style="color: #dc3545; font-style: italic;">
                                {{ $salle->nom }} @if($salle->type)({{ $salle->type }})@endif - INDISPONIBLE
                            </option>
                        @endforeach
                    </optgroup>
                @endif
                
                @if($salles->where('disponible', true)->count() > 0)
                    <optgroup label="Salles disponibles">
                        @foreach($salles->where('disponible', true) as $salle)
                            <option value="{{ $salle->id }}" {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                                {{ $salle->nom }} @if($salle->type)({{ $salle->type }})@endif
                            </option>
                        @endforeach
                    </optgroup>
                @endif
                
                @if($salles->isEmpty())
                    <option value="" disabled>Aucune salle disponible</option>
                @endif
            </select>
            @error('salle_id')
                <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>
                Créer le cours
            </button>
        </div>
    </form>
</div>
@endsection
