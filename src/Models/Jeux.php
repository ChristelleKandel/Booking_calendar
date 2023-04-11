<?php
/* +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - Model/Entity Jeux
Date : Mars 2023
*************************************/

require_once 'DBconnect.php';
class Jeux{
    public $id;
    public $nom;
    public $id_proprio;

    public function __construct(array $jeux){
        $this->id = $jeux['id'];
        $this->nom = $jeux['nom'];
        $this->id_proprio = $jeux['id_proprio'];
    }

    public static function getAllJeux() {
        GLOBAL $connection;        
        $requete = "SELECT * FROM jeux ORDER BY nom";
        $resultat = $connection->query($requete);
        $listeJeux = $resultat->fetchAll(PDO::FETCH_OBJ);
        return $listeJeux;
    }
}

//Supprimer un jeu
function supprJeu() {
    GLOBAL $connection; 
    // echo $_POST['id'];
    $sql = "DELETE FROM jeux WHERE id=?";
    echo($sql);
    echo $_POST['id'];
    $delete = $connection -> prepare ($sql);
    // echo($delete);
    $delete -> bindValue(1, $_POST['id'], PDO::PARAM_INT);
    $delete -> execute();
    $success = "Jeu supprimé";
    if ($success) {
        echo $success;
    }
    // redirection vers la page Devis
    header('location:../../index.php?id=1'); 
}

//Modifier un jeu
function saveJeu(){
    GLOBAL $connection;
    // recuperation des informations du formulaire
    //stockage des $variables saisies dans le formulaire sans espace ni code html pour sécuriser 
    $id = $_POST['id'];
    $nom = trim(strip_tags($_POST['nom']));
    $proprio = trim(strip_tags($_POST['proprio']));
    // preparation de la requete        
    $requete = "UPDATE proprietaires SET nom=?, id_proprio=? WHERE id=?";
    $save = $connection -> prepare($requete);
    // on associe chaque ? à une variable et un type str, int...
    $save -> bindValue(1, $nom, PDO::PARAM_STR);
    $save -> bindValue(2, $proprio, PDO::PARAM_INT);
    $save -> bindValue(3, $id, PDO::PARAM_INT);
    // execution
    $save -> execute();
    // redirection vers la page d'accueil admin
    $success = "Modification effectuée";
    if ($success) {
        echo $success;
    }
    // redirection vers la page Devis
    header('location:../../index.php?id=1');
}

    //Ajouter un jeu
    function addJeu($nom, $proprio) {
        GLOBAL $connection; 
        // recuperation des informations du formulaire et stockage sécurisé
        $nom = trim(strip_tags($_POST['nom']));
        $proprio = $_POST['id_proprio'];
        // requete préparée pour la sécurité      
        $requete = "INSERT INTO jeux (nom, id_proprio) values (?, ?)";
        // preparation de la requete
        $save = $connection -> prepare($requete);
        // on va associer chaque ? (1er, 2eme, ...) à une variable et un type str, int...
        $save -> bindValue(1, $nom, PDO::PARAM_STR);
        $save -> bindValue(2, $proprio, PDO::PARAM_INT);   
        // execution
        $save -> execute();
        $success = "Nouveau jeu ajouté";
        if ($success) {
            echo $success;
        }
        // redirection vers la page Devis
        header('location:../../index.php?id=1');
    }