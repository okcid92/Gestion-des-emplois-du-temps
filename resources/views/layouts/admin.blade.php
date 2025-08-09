<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - IBAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #ffffff;
            padding: 20px 0;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid #e9ecef;
            box-shadow: 2px 0 5px rgba(0,0,0,.02);
        }
        
        .brand {
            color: #2c3e50;
            font-size: 1.5rem;
            padding: 0 20px;
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .nav-item {
            margin: 5px 15px;
        }
        
        .nav-link {
            color: #6c757d !important;
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-weight: 500;
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            color: #95a5a6;
        }
        
        .nav-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd !important;
        }
        
        .nav-link:hover i {
            color: #0d6efd;
        }
        
        .nav-link.active {
            background-color: #e7f1ff;
            color: #0d6efd !important;
        }
        
        .nav-link.active i {
            color: #0d6efd;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.03);
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
            font-weight: 500;
        }
        
        /* Table Styles */
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            border-top: none;
            background-color: #f8f9fa;
            font-weight: 500;
        }
        
        /* Button Styles */
        .btn-primary {
            padding: 8px 16px;
        }
        
        .btn-sm {
            padding: 5px 10px;
        }
        
        /* Alert Styles */
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">IBAM Admin</div>
        <nav class="nav flex-column">
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> Utilisateurs
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}" href="{{ route('admin.classes.index') }}">
                    <i class="fas fa-graduation-cap"></i> Classes
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.salles.*') ? 'active' : '' }}" href="{{ route('admin.salles.index') }}">
                    <i class="fas fa-door-open"></i> Salles
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}" href="{{ route('admin.schedules.index') }}">
                    <i class="fas fa-calendar-alt"></i> Emplois du temps
                </a>
            </div>
            <div class="nav-item mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
