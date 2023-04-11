<?php

// On limite l'accès au site en utilisant les sessions (impossible de passer par url)
// Si la Session n'existe pas on retourne au formulaire d'identification, sinon on continue la navigation
session_start();

if(!isset($_SESSION['nom_administrateur'])) {
    header('location:/calendar/views/proprietaires/identification.php');
}
?>