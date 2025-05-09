-<?php
-// mysqli + interpolation directe
-?>
+<?php
+require_once dirname(__DIR__).'/config/config.php';
+
+if ($_SERVER['REQUEST_METHOD'] === 'POST') {
+    $nom      = trim($_POST['nom']);
+    $email    = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
+    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
+
+    if (!$email) { $error = 'Email invalide'; }
+
+    if (empty($error)) {
+        $stmt = $pdo->prepare(
+            'INSERT INTO employe (nom, email, password) VALUES (?,?,?)'
+        );
+        $stmt->execute([ $nom, $email, $password ]);
+        header('Location: /employes.php?ok'); exit;
+    }
+}
+?>
