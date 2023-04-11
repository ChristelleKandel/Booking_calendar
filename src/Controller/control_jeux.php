<?php
/* +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - controller jeu
Date : Avril 2023
*************************************/

require ('../Models/Jeux.php');

// Affiche la liste de tous les Jeux
function accueilJeu() {
  $Jeux= Jeux::getAllJeu();
  require '../index.php?id=1';
}

//Ajouter un Jeu
if(isset($_POST['addJeu']))
{
    addJeu($_POST['nom'], $_POST['proprio']);
}

//Modifier un Jeu
if(isset($_POST['saveJeu']))
{
    saveJeu();
}

//Supprimer un Jeu
if(isset($_POST['supprJeu']))
{
    supprJeu();
}

