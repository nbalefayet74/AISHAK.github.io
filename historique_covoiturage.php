<?php
// Connexion à la base de données
$host = '127.0.0.1';
$db = 'ecoride';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
// ID de l'utilisateur dont on veut afficher l'historique
$id_utilisateur = 9;
// Requête pour récupérer l'historique des covoiturages
$sql = "SELECT  id_covoiturage, date_depart, heure_depart, lieu_depart, date_arrivee, heure_arrivee, lieu_arrivee, statut, nb_place, prix_personne, id_utilisateur FROM covoiturage WHERE id_utilisateur = :id_utilisateur";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
$stmt->execute();
$covoiturage = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($covoiturage) {
    echo "<h1>Historique des covoiturages</h1>";
    echo "<table border='1'>";
    echo "<tr><th>id_covoiturage</th><th>date_depart</th><th>heure_depart</th><th>lieu_depart</th><th>date_arrivee</th><th>heure_arrivee</th><th>lieu_arrivee</th><th>statut</th><th>nb_place</th><th>Prix_personne</th><th>id_utilisateur</th></tr>";
    foreach ($covoiturage as $covoiturage) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($covoiturage['id_covoiturage']) . " </td>";
        echo "<td>" . htmlspecialchars($covoiturage['date_depart']) . "</td>";
        echo "<td>" . htmlspecialchars($covoiturage['heure_depart']) . "</td>";
        echo "<td>" . htmlspecialchars($covoiturage['lieu_depart']) . "</td>";
        echo "<td>" . htmlspecialchars($covoiturage['date_arrivee']) . "</td>";
        echo "<td>" . htmlspecialchars($covoiturage['heure_arrivee']) . "</td>";
        echo "<td>" . htmlspecialchars($covoiturage['lieu_arrivee']) . "</td>";
        echo "<td>" . htmlspecialchars($covoiturage['statut']) . "</td>";
        echo "<td>" . htmlspecialchars($covoiturage['nb_place']) . "</td>";
        echo "<td>" . htmlspecialchars($covoiturage['prix_personne']) . " €</td>";
        echo "<td>" . htmlspecialchars($covoiturage['id_utilisateur']) . " </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun covoiturage trouvé pour cet utilisateur.</p>";
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>historique Covoiturage</title>
    <style>
         .container {
        max-width: 600px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
    h1 {
        text-align: center;
        color: #28a745;
        }
    input[type="email"],
    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    button {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        
    }
    button:hover {
        background-color:rgb(51, 61, 203);
    }
    </style>
</head>
<body>
    <br>
<form action="annuler_covoiturage.php" method="post">
        <input type="hidden" name="id_covoiturage" value="id_covoiturage"> 
        <div class="cancel">
        <button type="submit">Annuler Covoiturage</button>
        <button type="submit">Modifier le nombre de places</button>
    </form>
<br>
<div class="container">
    <h1>Envoyer un email aux participants</h1>
    <form  action="" method="post">
        Email <input type="email" name="email" value="" required><br>
          Subject <input type="text" name="subject" value="" required><br>
          Messsage <input type="text" name="message" value="" required><br>
          <button type="submit" name="send">Envoyer</button>
          </div>
      </form>

      <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
if(isset($_POST['send'])) {
    // Connexion à la base de données
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth= true;
    $mail->Username = 'aliamira930@gmail.com';
    $mail->Password = 'zzoxluguwpkhjkfx';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('aliamira930@gmail.com');
    $mail->addAddress($_POST['email']);
    $mail->isHTML(true);
    $mail->Subject = $_POST['sujet'];
    $mail->Body = $_POST['message'];
    $mail->send();
    
    echo
"<script>alert('Email envoyé avec succès');
document.location.href = 'annuler_covoiturage.php';
</script>";
}
?>
</body>
</html>


