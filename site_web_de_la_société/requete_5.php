<?php
// Inclusion du fichier de connexion
include('db_connect.php');

// Requête SQL pour compter les ventes du premier et du deuxième trimestre 2020
$sql = "
WITH Trim1 AS (
    SELECT COUNT(ID_bien) AS Ventes20Q1 
    FROM vente 
    WHERE date_vente >= '2020-01-01' AND date_vente <= '2020-03-31'
),
Trim2 AS (
    SELECT COUNT(ID_bien) AS Ventes20Q2 
    FROM vente 
    WHERE date_vente >= '2020-04-01' AND date_vente <= '2020-06-30'
)
SELECT Trim1.Ventes20Q1, Trim2.Ventes20Q2
FROM Trim1, Trim2;
";

// Exécution de la requête
$result = $connect->query($sql);

// Vérification des erreurs
if (!$result) {
    die("Erreur dans la requête SQL : " . $connect->error);
}

// Récupération des résultats
$row = $result->fetch_assoc();

// Affichage des résultats dans un tableau HTML
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Ventes T1 2020</th><th>Ventes T2 2020</th></tr>";
echo "<tr>";
echo "<td>" . $row['Ventes20Q1'] . "</td>";
echo "<td>" . $row['Ventes20Q2'] . "</td>";
echo "</tr>";
echo "</table>";

// Fermeture de la connexion
$connect->close();
?>
