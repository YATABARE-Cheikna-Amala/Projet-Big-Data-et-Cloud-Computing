<?php
// Inclusion du fichier de connexion
include('db_connect.php');

// Vérifiez si le formulaire a été soumis
$departements = isset($_POST['departements']) ? $_POST['departements'] : [];

// Convertir le tableau en une chaîne pour l'utiliser dans la requête SQL
$departementsStr = implode("', '", $departements);

// Requête SQL
$sql = "
WITH OrdreCommunesParDept AS (
    SELECT 
        departement.depart_ID AS 'Département', 
        commune.Code_Commune AS Commune,  
        CONCAT(FORMAT(AVG(prix), 2), ' EUR') AS 'Valeur foncière moyenne',
        RANK() OVER(PARTITION BY departement.depart_ID ORDER BY AVG(prix) DESC) AS 'Classement'
    FROM 
        bien
    LEFT JOIN 
        vente USING (ID_bien)
    LEFT JOIN 
        commune USING (Code_Commune)
    LEFT JOIN 
        departement USING (depart_ID)
    GROUP BY 
        Code_Commune
)
SELECT * FROM OrdreCommunesParDept
WHERE Classement <= 3 AND Département IN ('$departementsStr');
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
        margin: 20px auto; /* Ajout d'une marge au-dessus de la table */
        border-collapse: collapse;
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
    form {
        margin-bottom: 20px; /* Espace en bas du formulaire */
    }
    select {
        padding: 10px; /* Ajout de remplissage pour le select */
        font-size: 16px; /* Taille de police */
        border-radius: 5px; /* Coins arrondis */
        border: 1px solid #ccc; /* Bordure */
        margin-right: 10px; /* Espace à droite */
    }
    button {
        padding: 10px 20px; /* Ajouter du remplissage */
        font-size: 16px; /* Agrandir la taille du texte */
        background-color: #b22222; /* Couleur de fond verte */
        color: white; /* Couleur du texte */
        border: none; /* Supprime la bordure */
        border-radius: 5px; /* Coins arrondis */
        cursor: pointer; /* Curseur main */
    }
    button:hover {
        background-color: #45a049; /* Couleur au survol */
    }
</style>";

// Affichage du formulaire pour sélectionner les départements
echo '<form method="POST" action="" style="text-align: center; margin-bottom: 20px;">';
echo '<label for="departements">Sélectionnez les départements :</label><br>';
echo '<select name="departements[]" multiple>';
echo '<option value="11">Département 11</option>';
echo '<option value="13">Département 13</option>';
echo '<option value="33">Département 33</option>';
echo '<option value="59">Département 59</option>';
echo '<option value="69">Département 69</option>';
// Ajoutez d'autres départements si nécessaire
echo '</select>';
echo '<button type="submit">Afficher les résultats</button>'; // Bouton de soumission
echo '</form>';

// Vérification des résultats et affichage de la table
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Département</th><th>Commune</th><th>Valeur foncière moyenne</th><th>Classement</th></tr>";
    
    // Affichage de chaque ligne de données
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Département']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Commune']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Valeur foncière moyenne']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Classement']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun résultat trouvé.</p>";
}
echo "<a href='index.html' class='back-button'>Retour à l'accueil</a>";
// Libération des résultats
$result->free();
?>
