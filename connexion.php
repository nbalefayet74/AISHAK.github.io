
<?php
session_start();
$host = "127.0.0.1"; 
$user = "root"; 
$password = ""; 
$database = "ecoride"; 

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

$utilisateur = [
    ["email" => "jean.dupont@hotmail.fr", "password" => "jean3519@"],
];

foreach ($utilisateur as $utilisateur) {
    echo " - Email: " . $utilisateur["email"] . " - Password: " . $utilisateur["password"] . "<br>";
}

class email {
    public $email;
    public function __construct($nom) {
        $this->email = $nom;
    }
}
class password {
    public $password;
    public function __construct($password) {
        $this->password = $password;
    }
    public function __isset($nom) : bool
    {
        return isset($this->$nom);
    }
}
$utilisateur= [ 
    new email("jean.dupont@hotmail.fr"),
    new password ("jean3519@"),
];
// Assuming $nom and $password are retrieved from user input (e.g., a form submission)
$nom = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $nom, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['email'] = $nom;
    header("Location: http://localhost:3000/ecoride/US1%20Accueil.php"); // Redirige vers la page principale
    exit();
} else {

    echo '<a href="http://localhost:3000/ecoride/US1%20Accueil.php">Cliquez ici pour visiter EcoRide</a>';
}


$conn->close();
?>