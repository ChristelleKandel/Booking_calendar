<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - header
Date : Mars 2023
*************************************-->
<?php 
//Ma function debug
function debug($val){
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}
?>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecolab</title>
    <!-- icone dans l'onglet -->
    <link rel="shortcut icon" href="/calendar/assets/img/logo.png" type="image/x-icon">
    <!-- version cdn de Bootstrap 5.3.0-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <!--ajout d'un fichier css perso APRES le fichier css de bootstrap-->
    <link rel="stylesheet" href="/calendar/assets/css/style.css">
    <!--Font awesome pour les icones:-->
    <script src="https://kit.fontawesome.com/05457f0eff.js" crossorigin="anonymous"></script>
    <!-- Lien vers Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto">
    <!-- CSS pour calendar -->
    <link rel="stylesheet" href="/calendar/assets/css/base_calendar.css">
</head>
<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/calendar/src/Models/DBconnect.php");
?>
