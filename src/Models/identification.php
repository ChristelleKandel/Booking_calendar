<?php

//Ajouter un token pour mdp perdu
function ajoutToken($email){
    GLOBAL $connection;
    //Génerer un token unique et le stocker dans la base de données
    function token30(){
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurMax = strlen($caracteres);
        $token = '';
        for ($i = 0; $i < 64; $i++){
            $token .= $caracteres[rand(0, $longueurMax - 1)];
        }
        return $token;
    }
    $token = password_hash($email, PASSWORD_DEFAULT);
    $requete="UPDATE proprietaires SET token=? WHERE email=?";
    $ajout = $connection->prepare($requete);
    $ajout->bindValue(1, $token, PDO::PARAM_STR);
    $ajout->bindValue(2, $email, PDO::PARAM_STR);
    $ajout->execute();
    //Créer le message a envoyer par mail 
    $to = $email;    
    $subject = 'Modification de votre mot de passe';    
    $body =  '<h3>Modifier le mot de passe</h3>';
    $body .= ' <p> Bonjour, <br> cliquez sur le lien ci-dessous pour g&eacute;n&eacute;rer un nouveau mot de passe. <br> ' ;
    $body .= '<a href="https://eco-lab.fr/calendar/views/proprietaires/traitement_mdpOublie.php?token='.$token.'&email='.$to.'">Modifier mot de passe</a></p>';
    $headers = 'Content-type: text/html; charset=utf-8';
    $headers .= 'From: christelle.kandel@insercall.com \r\n';
    // ecolabx@cluster030.hosting.ovh.net
    $headers .= 'Reply-To: christelle.kandel@insercall.com \r\n';
    //Envoyer le mail
    mail($to,$subject,$body,$headers);
}