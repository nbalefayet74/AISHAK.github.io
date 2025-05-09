<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen and (min-width: 768px) and (max-width: 1025px)" href="styles-tablet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Validation des Avis de Covoiturage</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav class="nav |  ">
            <a href="US1 Accueil.php">
                 <img src="img\electric-vehicle_17165746.png" class="imglogo" alt="logo EcoRide" >
            </a> 
            <button class="mobile-open-modal">
                <span>
                    <img src="img\menu_9777339.png" alt="Open Menu">
                    
                </span>
            </button>
                    <ul class="nav-links" id="nav-links">
                   <a href="US1 Accueil.php" >Accueil</a>
                  <a href="Vue covoiturages.html" >Covoiturages</a>
                  <a href="contact.html" >Contact</a>
                  <a href="Création-compte.php">
                  <button class="button">Connexion</button>
                    </a>
                </ul>
                </nav>

    <header>
    <style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #16890b;
}

#avis-container {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(106, 209, 92, 0.1);
}

.avis-item {
    padding: 10px 0;
    border-radius: 20px;
}

.avis-item p {
    margin: 5px 0;
    color: #555;
}

.avis-item small {
    color: #666;
}
.avis-item button {
    background-color: #115b13; /* Green */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
}

    </style>
    <h1>Bienvenue dans l'Espace Employé</h1>

    <div id="avis-container">
        <form action="fetch_reviews.php" method="post"></form>
    <h2>Validation des Avis de Covoiturage</h2>
    <form action="process_review.php" method="post">
        <label for="review_id">ID de l'avis :</label>
        <input type="text" id="review_id" name="review_id" required><br><br>
        
        <label for="action">Action :</label>
        <select id="action" name="action" required>
            <option value="valider">Valider</option>
            <option value="refuser">Refuser</option>
        </select><br><br>
        
        <input type="submit" value="Soumettre">
    </form>

    <h3>Avis de Covoiturage</h3>
        

        <!-- Les avis de covoiturage seront affichés ici -->
        <div class="avis-item">
            <h4>Avis 1</h4>
            <p>Commentaire : Trajet parfait, Jean est très agréable, très arrangeant et réactif. Un grand merci!</p>
            <p>Note : 4.8/5</p>
            <button onclick="document.getElementById('review_id').value='1';">Sélectionner</button>
        </div>
        
        <div class="avis-item">
            <h5>Avis 2</h5>
            <p>Commentaire : Merci pour ce trajet agréable, Jean est un conducteur très professionnel et sympathique. Je recommande vivement!</p>
            <p>Note : 5/5</p>
            <button onclick="document.getElementById('review_id').value='2';">Sélectionner</button>
        </div>

        <!-- Ajoutez d'autres avis ici -->
        
    </div>
</body>
</html>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Visionner les covoiturages problématiques</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Liste des covoiturages problématiques</h1>
    <table>
        <thead>
            <tr>
                <th>ID Covoiturage</th>
                <th>Pseudo Chauffeur</th>
                <th>Email Chauffeur</th>
                <th>Pseudo Passager</th>
                <th>Email Passager</th>
                <th>Date départ</th>
                <th>Date d'arrivée</th>
                <th>descriptif du trajet</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Connexion à la base de données
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "ecoride";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Connexion échouée: " . $conn->connect_error);
            }

            // Requête pour obtenir les covoiturages problématiques
            $sql = "SELECT ID_Covoiturage, Pseudo Chauffeur, Email Chauffeur, Pseudo Passager, Email Passager, Date départ, Date d'arrivée, descriptif du trajet FROM covoiturage WHERE descriptif du trajet IS NOT NULL";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                // Afficher les données de chaque ligne
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["ID_Covoiturage"]. "</td><td>" . $row["Pseudo chauffeur"]. "</td><td>" . $row["Email Chauffeur"]. "</td> <td>" . $row["Pseudo Passager"]. "</td> <td>" . $row["Email Passager"]. "</td> <td>" . $row["date départ"]. "</td> <td>" . $row["Date d'arrivée"]. "</td> <td>" . $row["descriptif du trajet"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Aucun covoiturage problématique trouvé</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
