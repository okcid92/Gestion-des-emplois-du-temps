<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IBAM - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            max-width: 1140px;
            margin: 0 auto;
        }
        .card {
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,.05);
            max-width: 900px;
            width: 100%;
            min-height: 600px;
        }
        .card-body {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1rem;
            padding: 2rem;
        }
        .text-muted {
            font-size: 0.9rem;
            max-width: 600px;
            margin: 0 auto;
        }
        .display-6 {
            font-size: calc(1.2rem + 1vw);
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            .card {
                border-radius: 0;
                box-shadow: none;
            }
            .card-body {
                padding: 1rem;
            }
        }
        .form-control {
            border-color: #e9ecef;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        .btn:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .text-muted {
            color: #6c757d !important;
        }
        .form-label {
            color: #2c3e50;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="row g-0 h-100">
                <!-- Image côté gauche - visible uniquement sur les écrans moyens et plus grands -->
                <div class="col-md-6 d-none d-md-block">
                    <img src="{{ asset('images/login-bg.jpg') }}" alt="Image de connexion" 
                        class="w-100 h-100" style="object-fit: cover;">
                </div>
                
                <!-- Formulaire côté droit -->
                <div class="col-12 col-md-6">
                    <div class="card-body d-flex flex-column justify-content-center p-4 p-sm-5">
                                <!-- Logo -->
                                <div class="text-center">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo IBAM" class="img-fluid" style="max-height: 60px; max-width: 100%;">
                                </div>
                                
                                <!-- Titre -->
                                <h1 class="text-center fw-bold display-6">Bienvenue à l'IBAM</h1>
                                
                                <!-- Message d'accueil -->
                                <p class="text-center text-muted">
                                    Nous sommes ravis de vous accueillir dans notre espace en ligne.
                                    Veuillez vous connecter pour accéder à votre compte, consulter vos cours et
                                    bien plus encore. Nous nous engageons à vous offrir les meilleures
                                    ressources et le soutien dont vous avez besoin pour réussir.
                                </p>
                                
                                <!-- Formulaire de connexion -->
                                <form method="POST" action="{{ route('login') }}" class="rounded-3 mx-auto" style="max-width: 360px;">
                                    @csrf
                                    
                                    <!-- Champ Identifiant -->
                                    <div class="mb-2">
                                        <label for="identifiant" class="form-label small">Identifiant</label>
                                        <input id="identifiant" type="text" 
                                            class="form-control @error('email') is-invalid @enderror" 
                                            name="email" value="{{ old('email') }}" 
                                            required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <!-- Champ Mot de passe -->
                                    <div class="mb-2">
                                        <label for="password" class="form-label small">Mot de passe</label>
                                        <div class="input-group">
                                            <input id="password" type="password" 
                                                class="form-control @error('password') is-invalid @enderror" 
                                                name="password" required autocomplete="current-password">
                                            <span class="input-group-text bg-white" id="togglePassword" style="cursor: pointer;">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Bouton de connexion -->
                                    <button type="submit" class="btn btn-primary w-100 py-2 mt-3">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                                    </button>
                                </form>
                                
                                <!-- Lien mot de passe oublié -->
                                <p class="text-center mt-2 small">
                                    <a href="#" class="text-decoration-none text-dark">
                                        Mot de passe oublié ?
                                    </a>
                                </p>
                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
