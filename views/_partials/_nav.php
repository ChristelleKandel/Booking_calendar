<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand h1" href="https://eco-lab.fr"><img src="/calendar/assets/img/logo.png" class="rounded-circle logo" alt="Logo d'Ecolab"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- ml auto, remplacé par ms-auto avec bootstrap5, pour mettre le menu à gauche en gardant le logo à droite -->
            <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                <li class="nav-item <?= $nav_resa ?>">
                    <a class="nav-link btnspecial btn" aria-current="page" href="/calendar/views/reservations/liste_reservations.php">Réservations</a>
                </li>
                <li class="nav-item <?= $nav_jeux ?>">
                    <a class="nav-link btnspecial btn" href="/calendar/index.php?id=1">Tous les jeux</a>
                </li>  
                <li class="nav-item <?= $nav_proprio ?>">
                    <a class="nav-link btnspecial btn" href="/calendar/views/proprietaires/liste_proprietaires.php">Propriétaires</a>
                </li>   
                <li class="nav-item <?= $nav_add ?>">
                    <a class="nav-link btnspecial btn" href="/calendar/views/reservations/add_resa.php">Ajouter une réservation</a>
                </li>  
                <li class="nav-item <?= $nav_connect ?>">
                    <a class="nav-link btnspecial btn" href="/calendar/views/proprietaires/identification.php">Se connecter</a>
                </li>  
            </ul>
        </div>
    </div>
</nav>