<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - save resa
Date : Mars 2023
*************************************-->

<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');

// echo ("page de sauvegarde");

//Si les éléments du formulaire sont bien remplis
if (
    isset($_POST['date_debut']) && !empty($_POST['date_debut']) &&
    isset($_POST['date_fin']) && !empty($_POST['date_fin']) &&
    isset($_POST['emprunteur']) && !empty($_POST['emprunteur'])
    ){

//ACTION 1
//Affichage de la confirmation de la modification et lien vers la page des réservation de tous les jeux ou seulement du jeu concerné 
    if (isset($_GET["id_jeu"])) {
        $jeu = $_GET["id_jeu"];
        print '
        <div class="text-center m-5">
        <h3>Votre modification a bien été enregistrée.</h3>
        <a class="btn btn-green" href="../../views/reservations/form.php?id=' . $jeu . '">Retourner à la liste des réservations</a></br></br>
        <a class="btn btn-green" href="../../views/reservations/calendar.php?id=' . $jeu . '">Voir le calendrier</a>
        </div>
        ';
    }else{
        print '
        <div class="text-center m-5">
        <h3>Votre modification a bien été enregistrée.</h3>
        <a class="btn btn-green" href="../../views/reservations/liste_reservations.php">Retourner à la liste des réservations</a></br></br>
        <a class="btn btn-green" href="../../index.php">Retourner à la liste de tous les jeux</a>
        </div>
        ';
    }
    

//ACTION 2
// enregistrement des modifications
    //récupération des données du formulaire
    $idd = $_POST['idd'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $emprunteur = $_POST['emprunteur'];
    //requête préparée
    $sql = "UPDATE reservations SET date_debut=?, date_fin=?, emprunteur=? WHERE id_resa=?";
    $resultat = $connection -> prepare($sql);
    $resultat -> bindValue (1, $date_debut, PDO::PARAM_STR);
    $resultat -> bindValue (2, $date_fin, PDO::PARAM_STR);
    $resultat -> bindValue (3, $emprunteur, PDO::PARAM_STR);
    $resultat -> bindValue (4, $idd, PDO::PARAM_INT);
    //execution
    $resultat -> execute();
}
?>





