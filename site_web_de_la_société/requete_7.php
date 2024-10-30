<?php
// Inclusion du fichier de connexion
include('db_connect.php');

// Cette requête calcule le prix moyen par m² des appartements de 2 et 3 pièces, vendus entre le 1er janvier et le 30 juin 2020.

$sql = "
WITH Moy2pieces AS (
    SELECT AVG(prix / Surface_Bati) AS Apparts2Pieces
    FROM vente
    JOIN bien USING (ID_bien)
    WHERE (date_vente >= '2020-01-01') 
      AND (date_vente <= '2020-06-30') 
      AND LOWER(Type_Local) = 'appartement'  
      AND Nbre_Piece_prin = '2'
),
Moy3pieces AS (
    SELECT AVG(prix / Surface_Bati) AS Apparts3Pieces
    FROM vente
    JOIN bien USING (ID_bien)
    WHERE (date_vente >= '2020-01-01') 
      AND (date_vente <= '2020-06-30') 
      AND LOWER(Type_Local) = 'appartement'  
      AND Nbre_Piece_prin = '3'
)
SELECT 
    CONCAT(FORMAT(Apparts2Pieces, 2), ' EUR/m2') AS 'Prix moyen appartements 2 pièces', 
    CONCAT(FORMAT(Apparts3Pieces, 2), ' EUR/m2') AS 'Prix moyen appartements 3 pièces', 
    CONCAT(FORMAT((Apparts3Pieces - Apparts2Pieces) * 100 / Apparts2Pieces, 2), '%') AS 'Ecart' 
FROM 
    Moy2pieces
JOIN 
    Moy3pieces;
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
    echo "<tr><th>Prix moyen appartements 2 pièces</th><th>Prix moyen appartements 3 pièces</th><th>Ecart</th></tr>";
    
    // Affichage de chaque ligne de données
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Prix moyen appartements 2 pièces']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Prix moyen appartements 3 pièces']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Ecart']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun résultat trouvé pour cette période.</p>";
}

// Libération des résultats
$result->free();
?>
