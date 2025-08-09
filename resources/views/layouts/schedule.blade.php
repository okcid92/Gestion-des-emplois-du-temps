<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Emploi du temps') - IBAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/schedule.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
    <div class="schedule-container">
        <div class="left-panel">
            <h2 class="week-title">Semaine du {{ $weekStart->locale('fr')->format('d/m/Y') }}</h2>
            <div class="action-buttons">
                <button class="btn btn-outline-primary" onclick="previousWeek()">
                    <i class="fas fa-chevron-left me-2"></i>Semaine précédente
                </button>
                <button class="btn btn-outline-primary" onclick="nextWeek()">
                    Semaine suivante<i class="fas fa-chevron-right ms-2"></i>
                </button>
                <button class="btn btn-outline-secondary" onclick="currentWeek()">
                    <i class="fas fa-calendar-day me-2"></i>Semaine actuelle
                </button>
                <hr class="border-light my-3">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                    </button>
                </form>
            </div>
            
            <div class="quote-box mt-4">
                <i class="fas fa-quote-left"></i>
                <p class="quote-text" id="dailyQuote">Chargement de la citation...</p>
                <i class="fas fa-quote-right"></i>
            </div>
        </div>

        <div class="schedule-grid">
            @yield('schedule-content')
        </div>
    </div>

    <style>
    .schedule-container {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 2rem;
        min-height: calc(100vh - 80px);
        max-width: 1800px;
        margin: 0 auto;
    }

    .left-panel {
        background-color: #ffffff;
        padding: 1.5rem;
        border-radius: 10px;
        height: fit-content;
        box-shadow: 0 2px 8px rgba(0,0,0,.03);
        border: 1px solid #e9ecef;
    }

    .week-title {
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        color: #2c3e50;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .action-buttons .btn {
        width: 100%;
        text-align: left;
        padding: 0.75rem 1rem;
        border-color: #e9ecef;
    }

    .action-buttons .btn:hover {
        background-color: #f8f9fa;
    }

    .quote-box {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 2rem;
        text-align: center;
        color: #6c757d;
        border: 1px solid #e9ecef;
    }

    .quote-box i {
        color: #0d6efd;
        font-size: 1.25rem;
        margin: 0.5rem 0;
    }

    .quote-text {
        font-style: italic;
        margin: 1rem 0;
        line-height: 1.5;
    }

    .schedule-grid {
        background-color: #ffffff;
        padding: 1.5rem;
        border-radius: 10px;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,.03);
        border: 1px solid #e9ecef;
    }

    @media (max-width: 992px) {
        .schedule-container {
            grid-template-columns: 1fr;
        }
        
        .left-panel {
            margin-bottom: 1rem;
        }
    }
    </style>

    @push('scripts')
    <script>
    const quotes = [
        "L'éducation est l'arme la plus puissante pour changer le monde. - Nelson Mandela",
        "Le succès, c'est tomber sept fois et se relever huit fois. - Proverbe japonais",
        "Le meilleur moment pour planter un arbre était il y a 20 ans. Le deuxième meilleur moment est maintenant. - Proverbe chinois",
        "L'apprentissage est un trésor qui suivra son propriétaire partout. - Proverbe chinois",
        "La connaissance parle, mais la sagesse écoute. - Jimi Hendrix"
    ];

    document.addEventListener('DOMContentLoaded', function() {
        const quoteElement = document.getElementById('dailyQuote');
        const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
        quoteElement.textContent = randomQuote;
    });

    function previousWeek() {
        // To be implemented
        console.log('Previous week');
    }

    function nextWeek() {
        // To be implemented
        console.log('Next week');
    }

    function currentWeek() {
        // To be implemented
        console.log('Current week');
    }
    </script>
    @endpush
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
