<?php

$host='127.0.0.1';
$db = 'ecoride';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    echo " Vous étes connecté, vous bénéficiez de 20 crédits!";
} catch (PDOException $e) {
    echo "Connection echouée: " . $e->getMessage();
}

if(isset($_POST['id_utilisateur']) && isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['password'])){
    var_dump($_POST);
    $pseudo = $_POST["pseudo"];
    $email = $_POST["email"];
    $password = $_POST["password"];
   $requite = $pdo->prepare("INSERT INTO utilisateur  VALUES (5, :pseudo, :email, :password)");
   $requite->execute(
         array(
          'id_utilisateur' => 5,
          'pseudo' => $pseudo,
          'email' => $email,
          'password' => $password

     ));
     $reponse =$requite->fetchAll(PDO::FETCH_ASSOC);
     var_dump($reponse);
     }

?>