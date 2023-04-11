<!DOCTYPE html>
<!-- +++++++++++++++++++++++++++++++++
Auteur : Christelle pour Insercall
Desc : Projet EcoLab calendrier de réservation - DBconnect
Date : Mars 2023
*************************************-->

<?php 

// $dbhost      = "ecolabxbdd800.mysql.db";
// $username    = "ecolabxbdd800";
// $dbpassword  = "VY823k4nDCtFCyG";
// $dbname      = "ecolabxbdd800";
// $dsn         = "mysql:host=$dbhost;dbname=$dbname";
// $options     = array(
//                 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
//             );
// $connection = new PDO($dsn, $username, $dbpassword, $options);



// En LOCAL
$dbhost      = "localhost";
$username    = "root";
$dbpassword  = "";
$dbname      = "ecolab_calendar";
$dsn         = "mysql:host=$dbhost;dbname=$dbname";
$options     = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                //J'utilise le FETCH_ASSOC par defaut au lieu du PDO::FETCH_BOTH
                //qui indexe deux fois chaque valeur dans le tableau : 
                // 1 fois par sa position dans le jeu de résultats (0 à x) et 1 fois par son nom de colonne.
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            );

$connection = new PDO($dsn, $username, $dbpassword, $options);