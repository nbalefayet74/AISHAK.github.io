<?php


$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecoride";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer l'ID de l'utilisateur depuis le formulaire
$id_utilisateur = $_POST['id_utilisateur'];

// Préparer et exécuter la requête de mise à jour
$sql = "UPDATE utilisateur SET status='suspended' WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "Le compte utilisateur a été suspendu avec succès.";
} else {
    echo "Erreur lors de la suspension du compte : " . $conn->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>