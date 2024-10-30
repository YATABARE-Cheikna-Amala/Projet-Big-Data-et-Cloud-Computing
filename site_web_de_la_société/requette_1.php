<?php
// Inclusion du fichier de connexion
include('db_connect.php');

// Requête pour les appartements
$sql_appartements = "
SELECT 
    Type_Local AS 'Type de bien',
    COUNT(Type_Local) AS 'Nombre de biens vendus',
    departement.region_ID AS 'Région',
    Nom_region AS 'Nom Région'
FROM
    vente
    LEFT JOIN bien USING (ID_bien)
    LEFT JOIN commune USING (Code_Commune)
    LEFT JOIN departement USING (depart_ID)
    LEFT JOIN region USING (region_ID)
WHERE
    (date_vente >= '2020-01-01')
    AND (date_vente <= '2020-06-30')
    AND LOWER(Type_Local) = 'appartement'
GROUP BY departement.region_ID, Type_Local
ORDER BY COUNT(Type_Local) DESC
";

// Exécution de la requête pour les appartements
$result_appartements = $connect->query($sql_appartements);

// Vérification des erreurs
if (!$result_appartements) {
    die("Erreur dans la requête SQL pour les appartements : " . $connect->error);
}

// Requête pour les maisons
$sql_maisons = "
SELECT 
    Type_Local AS 'Type de bien',
    COUNT(Type_Local) AS 'Nombre de biens vendus',
    departement.region_ID AS 'Région',
    Nom_region AS 'Nom Région'
FROM
    vente
    LEFT JOIN bien USING (ID_bien)
    LEFT JOIN commune USING (Code_Commune)
    LEFT JOIN departement USING (depart_ID)
    LEFT JOIN region USING (region_ID)
WHERE
    (date_vente >= '2020-01-01')
    AND (date_vente <= '2020-06-30')
    AND LOWER(Type_Local) = 'maison'
GROUP BY departement.region_ID, Type_Local
ORDER BY COUNT(Type_Local) DESC
";

// Exécution de la requête pour les maisons
$result_maisons = $connect->query($sql_maisons);

// Vérification des erreurs
if (!$result_maisons) {
    die("Erreur dans la requête SQL pour les maisons : " . $connect->error);
}

// Début du HTML avec style CSS
echo "<!DOCTYPE html>";
echo "<html lang='fr'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Résultats des ventes d'appartements et de maisons - 2020</title>";
echo "<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        color: #000000;
        padding: 20px;
        text-align: center;
    }
    table {
        width: 80%;
        margin: auto;
        border-collapse: collapse;
        margin-top: 20px;
        border: 1px solid #b22222;
    }
    th, td {
        border: 1px solid #b22222;
        padding: 12px;
        text-align: center;
    }
    th {
        background-color: #b22222;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #ffcccc;
    }
    .back-button {
        margin-top: 20px;
        display: inline-block;
        padding: 10px 20px;
        background-color: #b22222;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }
    .back-button:hover {
        background-color: #ff3333;
    }
</style>";
echo "</head>";
echo "<body>";

// Affichage des résultats pour les appartements
echo "<h1>Ventes d'Appartements - T1 et T2 2020</h1>";
echo "<table>";
echo "<tr><th>Type de bien</th><th>Nombre de biens vendus</th><th>Région</th><th>Nom Région</th></tr>";
while ($row = $result_appartements->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['Type de bien']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Nombre de biens vendus']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Région']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Nom Région']) . "</td>";
    echo "</tr>";
}
echo "</table>";

// Affichage des résultats pour les maisons
echo "<h1>Ventes de Maisons - T1 et T2 2020</h1>";
echo "<table>";
echo "<tr><th>Type de bien</th><th>Nombre de biens vendus</th><th>Région</th><th>Nom Région</th></tr>";
while ($row = $result_maisons->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['Type de bien']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Nombre de biens vendus']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Région']) . "</td>";
    echo "<td>" . htmlspecialchars($row['Nom Région']) . "</td>";
    echo "</tr>";
}
echo "</table>";

// Bouton de retour
echo "<a href='index.html' class='back-button'>Retour</a>";

// Fermeture de la connexion
$connect->close();

echo "</body>";
echo "</html>";
?>
