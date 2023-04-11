<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - enregistrement new proprio
Date : Mars 2023
*************************************-->

<?php 

include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');


$error="";
//Enregistrement de la nouvelle réservation si elle existe
if (isset($_POST['submit'])) {
    // recuperation des informations du formulaire
    $nom = $_POST['nom'];
    //Verification de l'existence du nom User dans la BDD
    if ($nom!=null){
        $verifNom = $connection->query("SELECT * FROM proprietaires WHERE nom = '$nom'");
        $exist = $verifNom->rowCount();
        if($exist>0){
        $error = "Le nom d'utilisateur: $nom est déjà utilisé ";
        }
    }               
    $email = trim(strip_tags($_POST['email']));
        //Verification de l'existence de l'email dans la BDD
        if ($email!=null){
            $verifEmail = $connection->query("SELECT * FROM proprietaires WHERE email = '$email'");
            $exist = $verifEmail->rowCount();
            if($exist>0){
            $error .= "$email est déjà utilisé ";
            }
        }
    $mdp = trim(strip_tags($_POST['mdp']));
    $token=NULL;
    //Si l'email et le nom d'utilisateurs sont uniques (pas de message d'error):
    if ($error==""){
        if ($nom!=null && $mdp!=null) 
        // si le nom et le mdp ne sont pas vides on sécurise le mot de passe même dans la base de données, on le stock "haché"
        { 
            $mdpHach=password_hash($mdp, PASSWORD_DEFAULT);
            try {
                // requete préparée pour la sécurité  
                $connection = new PDO($dsn, $username, $dbpassword, $options);    
                $requete = "INSERT INTO proprietaires (nom, email, mdp, token) values (?, ?, ?, ?)";
                // preparation de la requete
                $save = $connection -> prepare($requete);
                // on va associer chaque ? (1er, 2eme, ...) à une variable et un type str, int...
                $save -> bindValue(1, $nom, PDO::PARAM_STR);
                $save -> bindValue(2, $email, PDO::PARAM_STR);
                $save -> bindValue(3, $mdpHach, PDO::PARAM_STR);
                $save -> bindValue(4, $token, PDO::PARAM_STR);
                // execution
                $save -> execute();
                // redirection 
                header('location: ../../views/proprietaires/liste_proprietaires.php');
            } catch(PDOException $error) {
                echo $requete . "<br>" . $error->getMessage();
            }
        }else{
            echo "Saisie non valide !!";
        }
    }else{
        echo $error;            
    }
}
    
