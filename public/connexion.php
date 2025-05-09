-<?php
-session_start();
-// … connexion mysqli + mot de passe en clair …
-?>
+<?php
+require_once dirname(__DIR__).'/config/config.php';
+
+// Empêche la redirection d’un utilisateur déjà connecté
+if (isset($_SESSION['user_id'])) {
+    header('Location: /profil.php'); exit;
+}
+
+if ($_SERVER['REQUEST_METHOD'] === 'POST') {
+    $stmt = $pdo->prepare('SELECT id, password FROM user WHERE email = ? LIMIT 1');
+    $stmt->execute([ $_POST['email'] ]);
+    $user = $stmt->fetch(PDO::FETCH_ASSOC);
+
+    if ($user && password_verify($_POST['password'], $user['password'])) {
+        session_regenerate_id();        // évite la fixation de session
+        $_SESSION['user_id'] = $user['id'];
+        header('Location: /profil.php'); exit;
+    }
+    $error = 'Identifiants invalides';
+}
+?>
<!DOCTYPE html>
<!-- formulaire inchangé, mais afficher <?php echo $error ?? '' ?> -->
