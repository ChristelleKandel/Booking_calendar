<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - save proprio
Date : Mars 2023
*************************************-->

<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');


//Modifier le MdP
if (isset($_POST['email']) && !empty($_POST['email'])){
    $email = trim(strip_tags($_POST['email']));
    $mdp = trim(strip_tags($_POST['mdp']));
    if ($mdp!=null){ 
        $mdpHach=password_hash($mdp, PASSWORD_DEFAULT);
        // requete préparée pour la sécurité      
        $requete = "UPDATE proprietaires SET mdp=?, token=? WHERE email=?";
        $saveMdP = $connection -> prepare($requete);
        // on associe chaque ? à une variable et un type str, int...
        $saveMdP -> bindValue(1, $mdpHach, PDO::PARAM_STR);
        $saveMdP -> bindValue(2, $token, PDO::PARAM_STR);            
        $saveMdP -> bindValue(3, $email, PDO::PARAM_STR);
        $saveMdP -> execute();
        // redirection 
        header('location: ../../index.php');
    }
    else
    {
        echo "Saisie non valide !!";
    }
}