<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Saisir-voyage</title>
        <link href="styles.css" rel="stylesheet">
        <link rel="stylesheet" media="screen and (min-width: 768px) and (max-width: 1025px)" href="styles-tablet.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
       
    </head>
    <body>
        <nav class="nav | padding ">
            <a href="US1 Accueil.php"> <img src="img\electric-vehicle_17165746.png" class="imglogo" alt="logo EcoRide" >
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
                <div class="seize">
                    <h1 class="Clacul-trajet">Organisez votre voyage </h1>
                    <div class="organize">
                        <form action="Vue detail.php" method="post">
                               <div class="Mon-depart">
                            <input type="text" name="depart" id="depart-input" list="depart-suggestions" placeholder="Départ" class="Mon-depart" value>
</div>
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
            
                        <input type="text" name="arriver" id="arriver-input" list="arriver-suggetions" placeholder="Destination" class="arriver" value>
                      

            <datalist id="arriver-suggetions">
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

                <input type="number" name="prix" id="prix-passager" placeholder="prix" class="prix" value>

                <input type="text" name="véhicule" id="véhicule" list="vehicule_suggestions"     placeholder="sélectionner véhicule" class="my-vehicle" value>
                <datalist id="vehicule_suggestions">
                    <option value="peugeot 3008"></option>
                    <option value="peugeot 308"></option>
                    <option value="peugeot 5008"></option>
                    <option value="Renault scenic"></option>
                    <option value="Renault clio"></option>
                    <option value="Ford Puma"></option>
                    <option value="Ford fiesta"></option>
                    <option value="Ford focus"></option>
                    <option value="Mercedes classe A"></option>
                    <option value="Mercedes classe B"></option>
                    <option value="Citroen"></option>
                    <option value="BMW serie1"></option>
                </datalist>
             <div class="butt-publication">
                <button type="submit" name="Publier" >Publier</button>
            </div>
                </form>

                <?php
    if (isset($_POST['Publier'])) {
        header("voyage: Vue detail.php");
        exit();
    }
    ?>

                        </div>

                    </div>
                </div>


                </header>
                <script src="script.js"></script>
    </body>
</html>