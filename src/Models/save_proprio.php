<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - save proprio
Date : Mars 2023
*************************************-->

<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');

// echo ("page de sauvegarde");

//Si les éléments du formulaire sont bien remplis
if (
    isset($_POST['nom']) && !empty($_POST['nom']) &&
    isset($_POST['email']) && !empty($_POST['email'])
    ){

//ACTION 1
//Affichage de la confirmation de la modification et lien retour vers la liste des propriétaires 
    print '
    <div class="text-center m-5">
    <h3>Votre modification a bien été enregistrée.</h3>
    <a class="btn btn-green" href="../../views/proprietaires/liste_proprietaires.php">Retourner à la liste des propriétaires</a></br></br>
    </div>
    ';

//ACTION 2
// enregistrement des modifications
    //récupération des données du formulaire
    $idd = $_POST['id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    //requête préparée
    $sql = "UPDATE proprietaires SET nom=?, email=? WHERE id=?";
    $resultat = $connection -> prepare($sql);
    $resultat -> bindValue (1, $nom, PDO::PARAM_STR);
    $resultat -> bindValue (2, $email, PDO::PARAM_STR);
    $resultat -> bindValue (3, $idd, PDO::PARAM_INT);
    //execution
    $resultat -> execute();
}
?>





