<?php
// Informations de connexion à la base de données
$URL = "database-1.cfgaa6gqqsvm.eu-west-3.rds.amazonaws.com";
$NOM = "admin";
$Mot_de_passe = "loufpass";
$NOM_BASE = "Laplace_Immo";

// Connexion à la base de données
$connect = mysqli_connect($URL, $NOM, $Mot_de_passe, $NOM_BASE);

// Vérification de la connexion
if (mysqli_connect_errno()) {
    die("Impossible de se connecter à MySQL : " . mysqli_connect_error());
}
?>
