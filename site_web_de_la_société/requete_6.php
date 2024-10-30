<?php
// Inclusion du fichier de connexion
include('db_connect.php');

// Cette requête calcule le prix moyen par m² des appartements de plus de 4 pièces, vendus entre le 1er janvier et le 30 juin 2020, par région.

$sql = "
WITH moyenne AS (
    SELECT 
        region.region_ID AS 'Région', 
        region.Nom_region AS 'NomRégion', 
        AVG(vente.prix / bien.Surface_Bati) AS 'AvgPpxM2Apparts4p'
    FROM 
        vente
        LEFT JOIN bien ON vente.ID_bien = bien.ID_bien
        LEFT JOIN commune ON bien.Code_Commune = commune.Code_Commune
        LEFT JOIN departement ON commune.depart_ID = departement.depart_ID
        LEFT JOIN region ON departement.region_ID = region.region_ID
    WHERE 
        vente.date_vente >= '2020-01-01' 
        AND vente.date_vente <= '2020-06-30' 
        AND LOWER(bien.Type_Local) = 'appartement'
        AND bien.Nbre_Piece_prin > 4
    GROUP BY 
        region.region_ID, region.Nom_region
)
SELECT 
    Région, 
    NomRégion AS 'Nom Région', 
    CONCAT(FORMAT(AvgPpxM2Apparts4p, 2), ' EUR/m2') AS 'Prix moyen appartements > 4 pièces'
FROM 
    moyenne
ORDER BY 
    AvgPpxM2Apparts4p DESC;
";

// Exécution de la requête
$result = $connect->query($sql);

// Vérification des erreurs
if (!$result) {
    die("Erreur dans la requête SQL : " . $connect->error);
}

// Affichage des résultats
echo "<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        color: #000000;
        padding: 20px;
        text-align: center;
    }
    table {
        width: 90%;
        max-width: 1000px;
        margin: auto;
        border-collapse: collapse;
        margin-top: 20px;
        border: 1px solid #b22222;
        font-size: 18px;
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
</style>";

// Vérification des résultats et affichage de la table
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Région</th><th>Nom Région</th><th>Prix moyen appartements > 4 pièces</th></tr>";
    
    // Affichage de chaque ligne de données
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Région']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Nom Région']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Prix moyen appartements > 4 pièces']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun résultat trouvé pour cette période.</p>";
}

// Libération des résultats
$result->free();
?>
