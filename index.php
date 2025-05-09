<?php
require 'traitement.php';
//récupérer tous les utilisateurs
$sql = "SELECT * FROM utilisateur";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Liste des utilisateurs</title>
        </head>
    <body>
        <h1>Liste des utilisateurs</1>
        <table border="1">
            <tr>
                <th>id_utilisateur</th>
                <th>nom</th>
                <th>prenom</th>
                <th>email</th>
                <th>password</th>
                <th>telephone</th>
                <th>adresse</th>
                <th>date_naissance</th>
                <th>pseudo</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id_utilisateur']); ?></td>
                <td><?php echo htmlspecialchars($user['nom']); ?></td>
                <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['password']); ?></td>
                <td><?php echo htmlspecialchars($user['telephone']); ?></td>
                <td><?php echo htmlspecialchars($user['adresse']); ?></td>
                <td><?php echo htmlspecialchars($user['date_naissance']); ?></td>
                <td><?php echo htmlspecialchars($user['pseudo']); ?></td>
            </tr>
            <?php endforeach; ?>
            </table>
            </body>
            </html>