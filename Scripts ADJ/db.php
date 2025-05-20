<?php

try {
// variables globales​
    $server = "localhost";
    $dbname = "support";
    $user = "cocomelon"; // assure-toi que c’est correct
    $passwd = "mdp";
// connexion​
    $bdd = new PDO("mysql:host=$server;dbname=$dbname;charset=utf8", $user, $passwd);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $except) {
// message si problème avec BDD​
die('Erreur:'.$except->getMessage());
}
 
 // Create database
//$sql = "CREATE DATABASE IF NOT EXISTS support;
//        CREATE TABLE tickets (
//          id INT AUTO_INCREMENT PRIMARY KEY,
//          nom VARCHAR(100) NOT NULL,
//         email VARCHAR(150) NOT NULL,
//         type_probleme VARCHAR(100) NOT NULL,
//         probleme TEXT NOT NULL,
//        date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//          foregin key id_etat
//            affichage
//);";

?>