<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - enregistrement new resa
Date : Mars 2023
*************************************-->

<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');


//Enregistrement de la nouvelle réservation si elle existe
if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $dbpassword, $options);
        $sql3 = sprintf("INSERT INTO reservations (date_debut, date_fin, emprunteur, id_jeu) VALUES (?, ?, ?, ?)");
        $new_resa = array(
            $_POST['date_debut'],
            $_POST['date_fin'],
            $_POST['emprunteur'],
            $_POST['id_jeu'],
        );
    
        $statement3 = $connection->prepare($sql3);
        $statement3->execute($new_resa);
        $success = "Réservation supprimée";
        if ($success) {
            echo $success;
        }
        
        } catch(PDOException $error) {
        echo $sql3 . "<br>" . $error->getMessage();
        }
    if (isset($_GET["id_jeu"])) {
    $jeu = $_GET["id_jeu"];
    header("location:../../views/reservations/form.php?id=$jeu");
    }else{
        header('location:../../views/reservations/liste_reservations.php');
    }
}
    