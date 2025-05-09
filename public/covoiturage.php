-<?php
-// variables $_POST['1'] / $_POST['33'] …
-?>
+<?php
+require_once dirname(__DIR__).'/config/config.php';
+
+// Vérifie que l’utilisateur est connecté
+if (!isset($_SESSION['user_id'])) {
+    http_response_code(403); exit('Accès refusé');
+}
+
+if ($_SERVER['REQUEST_METHOD'] === 'POST') {
+    $depart       = $_POST['depart']   ?? '';
+    $destination  = $_POST['arrivee'] ?? '';
+    $datetime     = $_POST['date']    ?? '';
+
+    $stmt = $pdo->prepare(
+        'INSERT INTO ride (driver_id, depart, arrivee, date)
+         VALUES (?,?,?,?)'
+    );
+    $stmt->execute([
+        $_SESSION['user_id'],
+        $depart,
+        $destination,
+        $datetime
+    ]);
+    header('Location: /rides.php'); exit;
+}
+?>
