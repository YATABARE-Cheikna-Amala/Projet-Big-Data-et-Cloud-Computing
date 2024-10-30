<?php
// Inclusion du fichier de connexion
include('db_connect.php');

// Récupération des valeurs du formulaire
$type_de_bien = mysqli_real_escape_string($connect, $_POST['type_de_bien']);
$surface_bati = (float)$_POST['surface_bati'];
$ID_bien = (int)$_POST['ID_bien'];
$nombre_pieces = (int)$_POST['nombre_pieces']; // Corrigé
$code_commune = (int)$_POST['commune'];

// Requête d'insertion dans la table `bien`
$sql = "INSERT INTO bien (ID_bien,Type_Local, Surface_Bati, Nbre_Piece_Prin, Code_Commune) 
        VALUES ('$ID_bien','$type_de_bien', '$surface_bati', '$nombre_pieces', '$code_commune')";

if (mysqli_query($connect, $sql)) {
    // Affichage d'un message de succès
    echo "Nouveau bien ajouté avec succès !";
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
