<?php
// Inclure le fichier de connexion à la base de données
include 'db_connect.php';

// Initialiser des variables pour les résultats
$resultat = null;

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire, en s'assurant qu'elles sont sécurisées
    $type_bien = strtolower(trim($_POST['type_bien'])); // Convertir le type de bien en minuscules
    $region_id = trim($_POST['region_id']); // Récupérer l'ID de la région

    // Requête SQL pour obtenir les informations sur les biens vendus
    $sql = "
        SELECT 
            Type_Local AS 'Type de bien', /* Sélectionner le type de bien */
            CONCAT(FORMAT(AVG(prix / Surface_Bati), 2), ' EUR/m2') AS 'Valeur foncière moyenne', /* Calculer la valeur foncière moyenne par m² */
            region.region_ID AS 'Région', /* Récupérer l'ID de la région */
            Nom_region AS 'Nom Région' /* Récupérer le nom de la région */
        FROM
            vente /* Table des ventes */
        LEFT JOIN bien ON bien.ID_bien = vente.ID_bien /* Jointure avec la table des biens */
        LEFT JOIN commune ON bien.Code_Commune = commune.Code_Commune /* Jointure avec la table des communes */
        LEFT JOIN departement ON commune.depart_ID = departement.depart_ID /* Jointure avec la table des départements */
        LEFT JOIN region ON departement.region_ID = region.region_ID /* Jointure avec la table des régions */
        WHERE
            (date_vente >= '2020-01-01') /* Filtrer les ventes à partir du 1er janvier 2020 */
            AND (date_vente <= '2020-06-30') /* Filtrer les ventes jusqu'au 30 juin 2020 */
            AND LOWER(Type_Local) = '$type_bien' /* Filtrer par type de bien (insensible à la casse) */
            AND region.region_ID = '$region_id' /* Filtrer par ID de région */
        GROUP BY region.region_ID, Type_Local /* Regrouper par ID de région et type de bien */
    ";

    // Exécution de la requête
    $resultat = $connect->query($sql);

    // Vérifier si la requête a échoué
    if (!$resultat) {
        die("Erreur dans la requête SQL : " . $connect->error); // Arrêter le script en cas d'erreur
    }
}

// Affichage de la page
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

// Formulaire de filtrage
echo "<h2>Filtrer les Ventes Immobilières</h2>";
echo "<form method='post' action=''>
        <label for='type_bien'>Type de Bien:</label>
        <select name='type_bien' id='type_bien' required>
            <option value='maison'>Maison</option>
            <option value='appartement'>Appartement</option>
            
        </select>
        
        <label for='region_id'>ID de la Région:</label>
        <input type='text' name='region_id' id='region_id' required>

        <input type='submit' value='Afficher les Résultats'> <!-- Bouton pour soumettre le formulaire -->
    </form>";

// Affichage des résultats
if ($resultat && $resultat->num_rows > 0) { // Vérifier si des résultats existent
    echo "<h2>Résultats de la Recherche</h2>";
    echo "<table>
            <tr>
                <th>Type de bien</th>
                <th>Valeur foncière moyenne</th>
                <th>Région</th>
                <th>Nom Région</th>
            </tr>";
    // Afficher chaque ligne de résultat dans le tableau
    while ($row = $resultat->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['Type de bien']) . "</td>
                <td>" . htmlspecialchars($row['Valeur foncière moyenne']) . "</td>
                <td>" . htmlspecialchars($row['Région']) . "</td>
                <td>" . htmlspecialchars($row['Nom Région']) . "</td>
              </tr>";
    }
    echo "</table>"; // Fin du tableau
} else {
    echo "<p>Aucun résultat trouvé pour cette recherche.</p>"; // Message si aucun résultat n'est trouvé
}

// Bouton pour retourner à la page d'accueil
echo "<a href='index.html' class='back-button'>Retour à l'accueil</a>";

// Fermer la connexion (si ce n'est pas déjà fait dans db_connect.php)
$connect->close();
?>
