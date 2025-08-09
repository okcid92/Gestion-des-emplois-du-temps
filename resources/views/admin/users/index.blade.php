@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestion des Utilisateurs</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus me-2"></i>Nouvel Utilisateur
    </a>
</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-2"></i>
            Liste des Utilisateurs
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Classe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @switch($user->role)
                                    @case('administrator')
                                        <span class="badge bg-danger">Administrateur</span>
                                        @break
                                    @case('professor')
                                        <span class="badge bg-primary">Professeur</span>
                                        @break
                                    @case('student')
                                        <span class="badge bg-success">Étudiant</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($user->role === 'student' && $user->class)
                                    {{ $user->class->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $user->id }}">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Reset Password Modal -->
                                <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Réinitialiser le mot de passe</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.users.reset-password', $user) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Nouveau mot de passe</label>
                                                        <input type="password" class="form-control" 
                                                               id="password" name="password" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                                        <input type="password" class="form-control" 
                                                               id="password_confirmation" name="password_confirmation" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-warning">Réinitialiser</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmer la suppression</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer l'utilisateur <strong>{{ $user->name }}</strong> ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
