<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - vérification
Date : Mars 2023
*************************************-->

<?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php'); ?>
<body>

<?php

$nu_temp = ($_POST['nom_administrateur']); //stockage ds $nu_temp identifiant sans espace et code html
$mp_temp = trim(strip_tags($_POST['mdp_administrateur'])); //stockage ds variable $mp_temp mdp sans espace et code html

$query  = "SELECT * FROM proprietaires WHERE nom='$nu_temp'";  // requête vérification si email présent dans table
$result = $connection->query($query); // exécution requête et stockage résultat ds $result
$nbligne=$result->rowCount(); // compte nbre de lignes du résultat requête, stockage ds variable $nbligne. Si 0 alors identifiant non présent (pas de ligne trouvée)  
if ($nbligne) // si nbre ligne égal à 1 alors 1 utilisateur trouvé donc $nbligne=True sinon 0 donc False
{
    $verif=$result->fetch(); // stockage ds $verif de l'enregistrement trouvé ds la table 
    $dehachage_mdp=password_verify($mp_temp,$verif['mdp']); // si déhachage égal à 1 alors mdp ok sinon 0 donc False
  if  ($dehachage_mdp)// si mdp du formulaire identique au mdp de la table
  {
    // ouverture session admin
    session_start();
    $_SESSION['nom_administrateur']=trim(strip_tags($_POST['nom_administrateur']));
    $id = $verif['id'];
    // stockage de l'identifiant dans la variable $administrateur
    $administrateur=$_SESSION['nom_administrateur'];
  //redirection
  header("location:../../index.php?id=$id");
  }   
  else   //si mot de passe incorrect:
  { ?>
    <main class="container-fluid">
      <h2>Saisie non valide !!</h2>
    <?php
  } 
}
else //si rien n'a été rentré (nbligne=0)
{ ?>
  <main class="container-fluid">
    <h2>Veuillez vous identifier.</h2>
  <?php
}   
$result->closeCursor(); // fermeture requête 
?>
