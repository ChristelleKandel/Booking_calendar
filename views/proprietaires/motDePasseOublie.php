<?php

/* +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - mdpoublié
Date : Mars 2023
*************************************/
include_once ($_SERVER['DOCUMENT_ROOT'] . '/calendar/views/_partials/_header.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/calendar/src/Models/Proprios.php');
require ($_SERVER['DOCUMENT_ROOT'] . '/calendar/src/Models/identification.php');
// require "../../src/Models/Proprios.php";
$admins= Proprios::getAllAdmin();
// debug($admins);

//Récupération de l'email posté
$email = trim(strip_tags($_POST['email_administrateur']));
// debug ($email);
//Verification de l'existence de l'email dans la connection
GLOBAL $connection;
$verifEmail = $connection->query("SELECT * FROM proprietaires WHERE email = '$email'");
$exist = $verifEmail->rowCount();
if($exist>0){
    ajoutToken($email);
    $message = "Un email a été envoyé à l'adresse $email avec un lien permettant la modification de votre mot de passe ";
}else{
    $message = "Cet email est inconnu";
}

?>
<body>
    <main class="container-fluid">
    <p> <?= $message?> </p>
</body>
</html>
