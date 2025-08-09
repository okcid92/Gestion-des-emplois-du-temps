@extends('layouts.admin')

@section('title', 'Modifier le cours')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier le cours</h1>
    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Retour
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-edit me-2"></i>
        Modification du cours
    </div>
    <div class="card-body">
    
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

    <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du cours <span class="text-danger">*</span></label>
                    <input type="text" 
                        class="form-control @error('title') is-invalid @enderror" 
                        id="title" 
                        name="title" 
                        value="{{ old('title', $schedule->title) }}" 
                        required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="professor_id" class="form-label">Professeur <span class="text-danger">*</span></label>
                    <select class="form-select @error('professor_id') is-invalid @enderror" 
                            id="professor_id" 
                            name="professor_id" 
                            required>
                        <option value="">Sélectionnez un professeur</option>
                        @foreach($professors as $professor)
                            <option value="{{ $professor->id }}" {{ old('professor_id', $schedule->professor_id) == $professor->id ? 'selected' : '' }}>
                                {{ $professor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('professor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="class_id" class="form-label">Classe <span class="text-danger">*</span></label>
                    <select class="form-select @error('class_id') is-invalid @enderror" 
                            id="class_id" 
                            name="class_id" 
                            required>
                        <option value="">Sélectionnez une classe</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $schedule->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="salle_id" class="form-label">Salle <span class="text-danger">*</span></label>
                    <select class="form-select @error('salle_id') is-invalid @enderror" 
                            id="salle_id" 
                            name="salle_id" 
                            required>
                        <option value="">Sélectionnez une salle</option>
                        
                        @if($salles->where('disponible', false)->count() > 0)
                            <optgroup label="Salles indisponibles">
                                @foreach($salles->where('disponible', false) as $salle)
                                    <option value="{{ $salle->id }}" {{ old('salle_id', $schedule->salle_id) == $salle->id ? 'selected' : '' }} class="text-danger fst-italic">
                                        {{ $salle->nom }} @if($salle->type)({{ $salle->type }})@endif - INDISPONIBLE
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        
                        @if($salles->where('disponible', true)->count() > 0)
                            <optgroup label="Salles disponibles">
                                @foreach($salles->where('disponible', true) as $salle)
                                    <option value="{{ $salle->id }}" {{ old('salle_id', $schedule->salle_id) == $salle->id ? 'selected' : '' }}>
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
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="day" class="form-label">Jour <span class="text-danger">*</span></label>
                    <select class="form-select @error('day') is-invalid @enderror" 
                            id="day" 
                            name="day" 
                            required>
                        <option value="">Sélectionnez un jour</option>
                        <option value="Monday" {{ old('day', $schedule->day) == 'Monday' ? 'selected' : '' }}>Lundi</option>
                        <option value="Tuesday" {{ old('day', $schedule->day) == 'Tuesday' ? 'selected' : '' }}>Mardi</option>
                        <option value="Wednesday" {{ old('day', $schedule->day) == 'Wednesday' ? 'selected' : '' }}>Mercredi</option>
                        <option value="Thursday" {{ old('day', $schedule->day) == 'Thursday' ? 'selected' : '' }}>Jeudi</option>
                        <option value="Friday" {{ old('day', $schedule->day) == 'Friday' ? 'selected' : '' }}>Vendredi</option>
                        <option value="Saturday" {{ old('day', $schedule->day) == 'Saturday' ? 'selected' : '' }}>Samedi</option>
                    </select>
                    @error('day')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Heure de début <span class="text-danger">*</span></label>
                            <input type="time" 
                                class="form-control @error('start_time') is-invalid @enderror" 
                                id="start_time" 
                                name="start_time" 
                                value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}" 
                                required>
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end_time" class="form-label">Heure de fin <span class="text-danger">*</span></label>
                            <input type="time" 
                                class="form-control @error('end_time') is-invalid @enderror" 
                                id="end_time" 
                                name="end_time" 
                                value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}" 
                                required>
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection
