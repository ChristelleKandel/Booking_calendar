<?php

    require "DBconnect.php";
    
    try {

        $dbco = new PDO($dsn, $username, $dbpassword, $options);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "TRUNCATE TABLE reservations";
        $sth = $dbco->prepare($sql);
        $sth->execute();
        
    }
        
    catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
    }
    
    header('location:../../views/reservations/liste_reservations.php');
