<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - IBAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            overflow: hidden;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,.03);
        }
        .form-control,
        .input-group-text {
            border-color: #e9ecef;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: none;
        }
        .form-control:focus + .input-group-text,
        .input-group-text + .form-control:focus {
            border-color: #0d6efd;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        .form-label {
            color: #2c3e50;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .input-group-text {
            color: #6c757d;
            background-color: #f8f9fa;
        }
        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
            color: #0d6efd;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container min-vh-100 py-5">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo IBAM" class="img-fluid mb-4" style="max-height: 80px;">
                </div>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <h1 class="text-center fw-bold mb-4 display-6 text-primary">Créer un compte</h1>
                        
                        <p class="text-center text-muted mb-4">
                            Rejoignez la communauté IBAM et accédez à tous nos services.
                        </p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="form-label">Nom complet</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" class="form-control ps-2 border-start-0" id="name" 
                                        name="name" value="{{ old('name') }}" placeholder="Entrez votre nom complet"
                                        required autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">Adresse email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control ps-2 border-start-0" id="email" 
                                        name="email" value="{{ old('email') }}" placeholder="Entrez votre email"
                                        required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control ps-2 border-start-0" id="password" 
                                        name="password" placeholder="Créez votre mot de passe" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input type="password" class="form-control ps-2 border-start-0" id="password_confirmation" 
                                        name="password_confirmation" placeholder="Confirmez votre mot de passe" required>
                                </div>
                            </div>

                            <div class="d-grid gap-3 mt-5">
                                <button type="submit" class="btn btn-primary py-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-plus me-2"></i>Créer mon compte
                                </button>
                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="text-decoration-none text-primary">
                                        <i class="bi bi-arrow-left me-1"></i>Déjà inscrit ? Connectez-vous
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
