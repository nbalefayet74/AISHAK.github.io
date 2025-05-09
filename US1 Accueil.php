

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" media="screen and (min-width: 768px) and (max-width: 1025px)" href="styles-tablet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    
</head>

<body >
   
        
        <div class="overlay | hidden"></div>
        <nav class="nav | padding ">
            <a href="US1 Accueil.html"> <img src="img\electric-vehicle_17165746.png" class="imglogo" alt="logo EcoRide" >
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
                
                <div class="connexion-menu | "> 
                    <h2>Connexion</h2>
                    <form action="traitement.php" method="POST">
                           <div class="connexion-form-utilisateur">
                            <label for="connexion-utilisateur">Nom </label>
                            <input type="text" placeholder="Email ou ID" name="connexion-utilisateur" id="connexion-utilisateur" class="connexion-utilisateur">
                        </div>
                        <div class="connexion-form-password">
                            <label for="connexion-password">password</label>
                            <input type="password" minlength="8" placeholder="Mot de passe" name="connexion-password" id="connexion-password" class="connexion-password"  required />
                        </div>
                        
                        <input type="submit" value="Se connecter" class="button">
                        
                    </form>
                    <p id="error-message" style="color:red;"></p>
                    <a href="Création-compte.php">Pas encore de compte?</a>
        </div>
        

        
        <header class="header" style="background-image: url('img/petr-magera-8czDAmtXdfs-unsplash.jpg');  height:450px; background-repeat: no-repeat" >

            <h1 style="color:rgb(255, 255, 255)">EcoRide</h1>
            <h3 style="color:rgb(255, 255, 255)">Votre sécurité, notre objectif</h3>
        </header>
      <main class="main">    
    <form class="form" id="form-recherche" action="US1 Accueil.php" method="GET">
      <div>
        <input type="text" name="depart" id="depart-input" list="depart-suggestions" placeholder="Départ" class="depart" value>
        <datalist id="depart-suggestions">
            <option value="Paris"></option>
            <option value="Nîmes"></option>
            <option value="Nice"></option>
            <option value="Marseille"></option>
            <option value="Lyon"></option>
            <option value="Caen"></option>
            <option value="Toulouses"></option>
            <option value="Grenoble"></option>
            <option value="Strasbourg"></option>
            <option value="Toulon"></option>
            <option value="Nantes"></option>
            <option value="Montpellier"></option>
            <option value="Bordeaux"></option>
            <option value="Annecy"></option>
            <option value="Lille"></option>
            <option value="Valence"></option>
            </datalist>

            
        <input type="text" name="destination" id="destination-input" list="destination-suggestions" placeholder="Destination" class="destination" value>
                  <datalist id="destination-suggestions">
                      <option value="Paris"></option>
                      <option value="Nîmes"></option>
                      <option value="Nice"></option>
                      <option value="Marseille"></option>
                      <option value="Lyon"></option>
                      <option value="Caen"></option>
                      <option value="Toulouses"></option>
                      <option value="Grenoble"></option>
                      <option value="Strasbourg"></option>
                      <option value="Toulon"></option>
                      <option value="Nantes"></option>
                      <option value="Montpellier"></option>
                      <option value="Bordeaux"></option>
                      <option value="Annecy"></option>
                      <option value="Lille"></option>
                      <option value="Valence"></option>
                      </datalist>
        <input type="date" name="date" placeholder="Aujourd'hui" class="date" value >
        <input type="number" name="passagers" id="nombre-passagers" min="1" placeholder="nombre de passagers" class="nombre-passagers" value >
</div>
<a href="Vue detail.php">
    <input type="button" value="Rechercher" class="button_rechercher" >
</a>
    </form>

</main>
<section class="section | trajets padding">
    <img src="img\covoiturage-Adobe-web.jpeg"  >
    <div class="section-text">
        <b>
        <h2 class="larger">Vos trajets préférés à petits prix</h2>
    </b>
        <p>
            Où que vous alliez, EcoRide vous fournit le trajet idéal parmi notre large choix de destination à petits prix, Facile d'utilisation et dotée de technologies avancées, 
            notre appli vous permet de réserver un trajet à proximité en un rien de temps.
        </p>
    </div>

</section>
<section class="section | covoiturages padding">
    <img src="img\Packa_ratt.jpg" >
    <div class="section-text">
        <b>
        <h2> Voyagez en toute confiance</h2>
    </b>
        <p>
Nous prenons le temps qu’il faut pour connaître nos membres et nos compagnies de bus partenaires. 
Nous vérifions les avis, les profils et les pièces d’identité.
 Vous savez donc avec qui vous allez voyager pour réserver en toute confiance sur notre plateforme sécurisée.
        </p>
    
<a href="Vue covoiturages.html">
   
    <button class="button">Covoiturages</button>

</a>

    
</section>

<hr>
        <footer class="footer ">
        
            <p>EcoRide@covoiturage.fr</p>
              <a href="https://blog.EcoRide.fr/about-us/terms-and-condition" target="-blank" class="link">Mentions Legales</a>
        </footer>
</hr>
<script src="https://code.jqueries.com/jqueries-3.2.1.slim.min.js"></script>
    <script src = "scripts/app.js"></script>
</body>
</html>