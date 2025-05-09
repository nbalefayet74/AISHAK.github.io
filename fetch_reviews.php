<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ecoride";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

$sql = "SELECT id_employe, commentaire, date FROM avis ORDER BY date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Afficher les avis
    while($row = $result->fetch_assoc()) {
        echo "<div class='avis'>";
        echo "<h3>" . htmlspecialchars($row["id_employe"]) . "</h3>";
        echo "<p>" . htmlspecialchars($row["commentaire"]) . "</p>";
        echo "<small>" . htmlspecialchars($row["date"]) . "</small>";
        echo "</div>";
    }
} else {
    echo "Aucun avis trouvé.";
}

$conn->close();