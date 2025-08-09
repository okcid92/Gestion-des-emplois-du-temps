<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IBAM - @yield('title', 'Tableau de bord')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
            color: #2c3e50;
        }
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,.03);
        }
        .navbar-brand {
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .navbar-brand:hover {
            color: #0d6efd;
        }
        .nav-link {
            color: #6c757d !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #0d6efd !important;
        }
        .dropdown-menu {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0,0,0,.05);
        }
        .dropdown-item {
            color: #6c757d;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }
        .main-content {
            padding: 2rem;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #e7f1ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0d6efd;
            font-weight: bold;
            margin-right: 0.5rem;
        }
        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.03);
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
            color: #2c3e50;
            font-weight: 500;
            padding: 1rem 1.25rem;
        }
        .table {
            color: #2c3e50;
        }
        .table th {
            background-color: #f8f9fa;
            border-color: #e9ecef;
            font-weight: 500;
        }
        .table td {
            border-color: #e9ecef;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">IBAM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->role === 'student')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('student.schedule') ? 'active' : '' }}" 
                               href="{{ route('student.schedule') }}">
                                Mon emploi du temps
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->role === 'professor')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('professor.schedules') ? 'active' : '' }}" 
                               href="{{ route('professor.schedules') }}">
                                Mes cours
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->role === 'administrator')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                               href="{{ route('admin.users.index') }}">
                                Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}" 
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Emplois du temps
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.schedules.index') }}">
                                        <i class="fas fa-list me-2"></i>Vue Liste
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.schedules.classic') }}">
                                        <i class="fas fa-calendar-alt me-2"></i>Vue Classique
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.schedules.create') }}">
                                        <i class="fas fa-plus me-2"></i>Ajouter un cours
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
