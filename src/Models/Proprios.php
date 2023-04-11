<?php
// namespace App\Models;

// use PDO;
require_once 'DBconnect.php';

class Proprios{
    public $id;
    public $nom;
    public $email;
    public $mdp;
    public $token;

    public static function getAllAdmin() {
        GLOBAL $connection;        
        $requete = "SELECT * FROM proprietaires ORDER BY nom";
        $resultat = $connection->query($requete);
        $proprietaires = $resultat->fetchAll(PDO::FETCH_OBJ);
        return $proprietaires;
    }
}


//Supprimer un administrateur
function supprAdmin() {
    GLOBAL $connection; 
    //Action à mener (rédaction de la requête de suppression)
    $sql = "DELETE FROM proprietaires WHERE id=?";
    //préparation de la requête grâce à l'instance $connection
    $delete = $connection -> prepare ($sql);
    //Vérification de la requête
    $delete -> bindValue(1, $_POST['id'], PDO::PARAM_STR);
    //Exécution
    $delete ->execute();
    //redirection 
    header('location: ../views/IndexAdmin.php?action=vueAdmin');  
}

//Modifier un administrateur
function saveAdmin(){
    GLOBAL $connection;  
    // recuperation des informations du formulaire
    $nom = trim(strip_tags($_POST['nom']));
    $prenom = trim(strip_tags($_POST['prenom']));
    $tel = $_POST['tel'];
    $suppr = array("-", ".", " ");
    $tel = str_replace($suppr, "", $tel);//supprime les éléments de suppr
    $tel = substr(chunk_split($tel, 2, "-"), 0, -1); // ajoute un - tous les 2 caractères et retire le dernier
    $nom_user = trim(strip_tags($_POST['nom_user']));
    $email = trim(strip_tags($_POST['email']));  
    $id = $_POST['id'];
    // preparation de la requete        
    $requete = "UPDATE proprietaires SET nom=?, prenom=?, tel=?, email=?, nom_user=? WHERE id=?";
    $save = $connection -> prepare($requete);
    // on associe chaque ? à une variable et un type str, int...
    $save -> bindValue(1, $nom, PDO::PARAM_STR);
    $save -> bindValue(2, $prenom, PDO::PARAM_STR);
    $save -> bindValue(3, $tel, PDO::PARAM_STR); 
    $save -> bindValue(4, $email, PDO::PARAM_STR);
    $save -> bindValue(5, $nom_user, PDO::PARAM_STR);                   
    $save -> bindValue(6, $id, PDO::PARAM_INT);
    // execution
    $save -> execute();
    // redirection 
    header('location: ../../index.php');
}

