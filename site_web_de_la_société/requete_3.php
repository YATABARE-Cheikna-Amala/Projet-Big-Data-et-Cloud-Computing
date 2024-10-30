<?php
// Inclure le fichier de connexion à la base de données
include 'db_connect.php';

// Requête SQL pour les appartements
$sql_appartements = "
    SELECT 
        Type_Local AS 'Type de bien',
        Nbre_Piece_prin AS 'Nb de pièces',
        CONCAT(
            FORMAT(
                COUNT(Type_Local) * 100 / 
                (SELECT COUNT(Type_Local) FROM bien WHERE LOWER(Type_Local) = 'appartement'),
                4
            ),
            '%'
        ) AS '% du total des ventes',
        region.Nom_region AS 'Région' -- Ajout de la colonne région
    FROM
        bien
    JOIN vente ON bien.ID_bien = vente.ID_bien
    JOIN commune ON bien.Code_Commune = commune.Code_Commune -- Jointure avec la table commune
    JOIN departement ON commune.depart_ID = departement.depart_ID -- Jointure avec la table departement
    JOIN region ON departement.region_ID = region.region_ID -- Jointure avec la table région
    WHERE
        (date_vente >= '2020-01-01')
        AND (date_vente <= '2020-06-30')
        AND LOWER(Type_Local) = 'appartement'
    GROUP BY Type_Local, Nbre_Piece_prin, region.Nom_region
    ORDER BY Nbre_Piece_prin ASC
";

// Exécution de la requête pour les appartements
$resultat_appartements = $connect->query($sql_appartements);

// Vérifier si la requête a échoué
if (!$resultat_appartements) {
    die("Erreur dans la requête SQL (appartements): " . $connect->error);
}

// Requête SQL pour les maisons
$sql_maisons = "
    SELECT 
        Type_Local AS 'Type de bien',
        Nbre_Piece_prin AS 'Nb de pièces',
        CONCAT(
            FORMAT(
                COUNT(Type_Local) * 100 / 
                (SELECT COUNT(Type_Local) FROM bien WHERE LOWER(Type_Local) = 'maison'),
                4
            ),
            '%'
        ) AS '% du total des ventes',
        region.Nom_region AS 'Région' -- Ajout de la colonne région
    FROM
        bien
    JOIN vente ON bien.ID_bien = vente.ID_bien
    JOIN commune ON bien.Code_Commune = commune.Code_Commune -- Jointure avec la table commune
    JOIN departement ON commune.depart_ID = departement.depart_ID -- Jointure avec la table departement
    JOIN region ON departement.region_ID = region.region_ID -- Jointure avec la table région
    WHERE
        (date_vente >= '2020-01-01')
        AND (date_vente <= '2020-06-30')
        AND LOWER(Type_Local) = 'maison'
    GROUP BY Type_Local, Nbre_Piece_prin, region.Nom_region
    ORDER BY Nbre_Piece_prin ASC
";

// Exécution de la requête pour les maisons
$resultat_maisons = $connect->query($sql_maisons);

// Vérifier si la requête a échoué
if (!$resultat_maisons) {
    die("Erreur dans la requête SQL (maisons): " . $connect->error);
}

// Affichage de la table avec style CSS
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

// Affichage des résultats pour les appartements
echo "<h2>Résultats pour les Appartements</h2>";
if ($resultat_appartements->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Type de bien</th>
                <th>Nb de pièces</th>
                <th>% du total des ventes</th>
                <th>Région</th> <!-- Nouvelle colonne pour la région -->
            </tr>";
    while ($row = $resultat_appartements->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['Type de bien']) . "</td>
                <td>" . htmlspecialchars($row['Nb de pièces']) . "</td>
                <td>" . htmlspecialchars($row['% du total des ventes']) . "</td>
                <td>" . htmlspecialchars($row['Région']) . "</td> <!-- Nouvelle colonne pour la région -->
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun appartement vendu trouvé pour cette période.</p>";
}

// Affichage des résultats pour les maisons
echo "<h2>Résultats pour les Maisons</h2>";
if ($resultat_maisons->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Type de bien</th>
                <th>Nombre de pièces</th>
                <th>% du total des ventes</th>
                <th>Région</th> <!-- Nouvelle colonne pour la région -->
            </tr>";
    while ($row = $resultat_maisons->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['Type de bien']) . "</td>
                <td>" . htmlspecialchars($row['Nb de pièces']) . "</td>
                <td>" . htmlspecialchars($row['% du total des ventes']) . "</td>
                <td>" . htmlspecialchars($row['Région']) . "</td> <!-- Nouvelle colonne pour la région -->
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucune maison vendue trouvée pour cette période.</p>";
}

// Bouton pour retourner à la page d'accueil
echo "<a href='index.html' class='back-button'>Retour à l'accueil</a>";

// Fermer la connexion (si ce n'est pas déjà fait dans db_connect.php)
$connect->close();
?>
