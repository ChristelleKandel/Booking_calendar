<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - delete resa
Date : Mars 2023
*************************************-->

<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');


if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username, $dbpassword, $options);

    $id = $_GET["id"];
    $sql = "DELETE FROM reservations WHERE id_resa = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $success = "Réservation supprimée";
    
    if ($success) 
        echo $success;
    
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
  if (isset($_GET["id_jeu"])) {
    $jeu = $_GET["id_jeu"];
    header("location:../../views/reservations/form.php?id=$jeu");
  }else{
    header('location:../../views/reservations/liste_reservations.php');
  }
}
