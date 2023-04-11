<?php
/* +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - mdpoublié
Date : Mars 2023
*************************************/

include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/calendar/src/Models/Proprios.php');
$admins= Proprios::getAllAdmin();

//Récupération du token depuis la variable $_GET
$token = $_GET['token'];
//print $token; exit;
//Vérification de l'existance du token dans la base de données 
//+ vérification de date de demande de nouveau mot de passe 
//+ vérification de changement déjà effectué.
GLOBAL $connection;
$query = $connection->query("SELECT * FROM proprietaires WHERE token ='$token'");
//Verification de l'existence du token
$verifToken = $connection->query("SELECT * FROM proprietaires WHERE token = '$token'");
$exist = $verifToken->rowCount();
?>
<!DOCTYPE html>
<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php'); 
?>
<body>
<main class="container-fluid">
<?php
if($exist>0){
    //Affichage du formulaire de changement de mot de passe
    ?>
    <h3> Entrez votre nouveau Mot de Passe </h3>
    <form action="../../src/Models/saveMdP.php" method="post">
        <div class="form-group row">
            <input type="hidden" name="email"   value="<?= $_GET['email'] ?>">
            <label for="mdp2" class="col-sm-2 col-form-label">Nouveau mot de passe: </label>
            <div class="col-sm-10">
            <input type="text" name="mdp" id="mdp2"></div>
            <input type="hidden"  name="token" value="">
            <button class="bg-beige" type="submit">Enregistrer le nouveau mot de passe</button>
        </div>
    </form>
    <?php
}else{
    echo "Le lien est invalide";
}
?>
</main>
</body>
</html>
