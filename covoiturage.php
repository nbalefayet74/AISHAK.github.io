<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecoride";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);
// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $action = $_POST['action'];
    $id_utilisateur = $_POST['1']; // ID de l'utilisateur qui a demandé le covoiturage
    $id_covoiturage = $_POST['33']; // ID du covoiturage demandé
    $id_participant = $_POST['1']; // ID de l'utilisateur qui participe au covoiturage
    if ($action == 'start') {
        echo "Le covoiturage a démarré.";
 
        session_start();
 
        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données du formulaire
            $depart = htmlspecialchars($_POST['lieu_depart']);
            $destination = htmlspecialchars($_POST['lieu_arrivee']);
            $date = htmlspecialchars($_POST['date_depart']);
            $heure = htmlspecialchars($_POST['heure_depart']);
            $places_disponibles = intval($_POST['nb_place']);
        
            // Stocker les données dans la session (ou base de données)
            $_SESSION['covoiturage'] = [
                'lieu_depart' => $lieu_depart,
                'lieu_arrivee' => $lieu_arrivee,
                'date_depart' => $date_depart,
                'heure_depart' => $heure_depart,
                'nb_place' => $nb_place
            ];
        // Ajoutez ici le code pour démarrer le covoiturage (ex: mise à jour de la base de données)
        }
    } elseif ($action == 'stop') {
        echo "Le covoiturage est arrêté.";
        // Ajoutez ici le code pour arrêter le covoiturage (ex: mise à jour de la base de données)
    } else {
        echo "Action non reconnue.";
    }
} else {
    echo "Méthode de requête non supportée.";
}