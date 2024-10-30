<?php
// Inclusion du fichier de connexion
include('db_connect.php');

// Récupération des valeurs du formulaire
$bien_id = mysqli_real_escape_string($connect, $_POST['bien_id']);
$date_vente = mysqli_real_escape_string($connect, $_POST['date_vente']);
$mut_val = mysqli_real_escape_string($connect, $_POST['mut_val']);

// Requête d'insertion dans la table `vente`
$sql = "INSERT INTO vente (ID_bien, date_vente, prix) 
        VALUES ('$bien_id', '$date_vente','$mut_val')";

if (mysqli_query($connect, $sql)) {
    // Affichage d'un message de succès
    echo "Enregistrement effectué avec succès !";
} else {
    // Affichage d'un message d'erreur
    echo "Erreur : " . mysqli_error($connect);
}

// Fermeture de la connexion
mysqli_close($connect);

// Ajoutez un délai de redirection
echo '<script>
        setTimeout(function() {
            window.location.href = "index.html"; // Remplacez par le nom de votre fichier HTML
        }, 2000); // Redirige après 2 secondes
      </script>';
?>
