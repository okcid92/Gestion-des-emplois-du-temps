@extends('layouts.admin')

@section('title', 'Tableau de bord administrateur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Tableau de bord administrateur MIAGE</h1>
</div>
    
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 filter-card" data-filter="all" style="cursor: pointer; border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title">Total Utilisateurs</h5>
                    <h2 class="mb-0">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4 filter-card" data-filter="student" style="cursor: pointer; border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title">Étudiants</h5>
                    <h2 class="mb-0">{{ $totalStudents }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4 filter-card" data-filter="professor" style="cursor: pointer; border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title">Professeurs</h5>
                    <h2 class="mb-0">{{ $totalProfessors }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4" style="cursor: pointer; border-radius: 10px;" onclick="window.location.href='{{ route('admin.classes.index') }}'">
                <div class="card-body">
                    <h5 class="card-title">Classes</h5>
                    <h2 class="mb-0">{{ $totalClasses }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-users me-1"></i>
                        Gestion des Utilisateurs
                    </div>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nouvel Utilisateur
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr data-role="{{ $user->role }}">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-end mt-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">Voir tous les utilisateurs</a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-door-open me-1"></i>
                        Gestion des Salles
                    </div>
                    <a href="{{ route('admin.salles.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nouvelle Salle
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
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
                            @foreach(App\Models\Salle::latest()->take(5)->get() as $salle)
                            <tr>
                                <td>{{ $salle->nom }}</td>
                                <td>{{ $salle->type ?? '-' }}</td>
                                <td>{{ $salle->capacite ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $salle->disponible ? 'success' : 'danger' }}">
                                        {{ $salle->disponible ? 'Disponible' : 'Indisponible' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.salles.edit', $salle->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.salles.destroy', $salle->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-end mt-3">
                        <a href="{{ route('admin.salles.index') }}" class="btn btn-primary btn-sm">Voir toutes les salles</a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-calendar-alt me-1"></i>
                        Emploi du Temps - Semaine du {{ $weekStart->locale('fr')->format('d/m/Y') }} au {{ $weekEnd->locale('fr')->format('d/m/Y') }}
                    </div>
                    <div>
                        <a href="{{ route('admin.schedules.classic') }}" class="btn btn-secondary btn-sm me-2">
                            <i class="fas fa-calendar-week me-1"></i> Vue Complète
                        </a>
                        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Nouveau Cours
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered schedule-table">
                            <thead>
                                <tr class="bg-light">
                                    <th style="width: 100px;">Horaire</th>
                                    @foreach($days as $dayEn => $dayFr)
                                        <th style="width: 14%;">
                                            {{ $dayFr }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timeSlots as $timeSlot)
                                    <tr>
                                        <td class="bg-light text-center font-weight-bold">{{ $timeSlot['display_start'] ?? $timeSlot['start'] }} - {{ $timeSlot['display_end'] ?? $timeSlot['end'] }}</td>
                                        @foreach($days as $dayEn => $dayFr)
                                            <td class="schedule-cell">
                                                @php
                                                    $hasSchedule = false;
                                                @endphp
                                                @foreach($schedulesByDay[$dayEn] as $schedule)
                                                    @php
                                                        // Vérifier si l'horaire du cours est dans le créneau actuel
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
                                                            <div class="schedule-title">{{ $schedule->title }}</div>
                                                            <div class="schedule-details">
                                                                <small>
                                                                    <i class="fas fa-user-tie me-1"></i> {{ $schedule->professor->name ?? 'Non assigné' }}<br>
                                                                    <i class="fas fa-users me-1"></i> {{ $schedule->class->name ?? 'Non assignée' }}<br>
                                                                    <i class="fas fa-clock me-1"></i> {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}<br>
                                                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $schedule->salle->nom ?? 'Non assignée' }}
                                                                </small>
                                                            </div>
                                                            <div class="schedule-actions mt-2">
                                                                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                
                                                @if(!$hasSchedule)
                                                    <div class="no-class-item">
                                                        <div class="no-class-text">Pas de cours</div>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner toutes les cartes de filtrage
    const filterCards = document.querySelectorAll('.filter-card');
    const userRows = document.querySelectorAll('tr[data-role]');

    // Ajouter un écouteur d'événements à chaque carte
    filterCards.forEach(card => {
        card.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Retirer la classe active de toutes les cartes
            filterCards.forEach(c => c.classList.remove('border-5'));
            // Ajouter la classe active à la carte cliquée
            this.classList.add('border-5');

            // Filtrer les lignes du tableau
            userRows.forEach(row => {
                if (filter === 'all' || row.dataset.role === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Activer le filtre "tous" par défaut
    document.querySelector('[data-filter="all"]').classList.add('border-5');
});
</script>
@endpush
