<?php
require_once dirname(__DIR__).'/config/config.php';

header("Content-Type: application/json; charset=utf-8");
header("Content-Security-Policy: default-src 'self'");   // XSS hardening

$page  = max(1, (int)($_GET['page']  ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare(
    'SELECT author, comment, created_at
       FROM review
      ORDER BY created_at DESC
      LIMIT :l OFFSET :o'
);
$stmt->bindValue(':l', $limit,  PDO::PARAM_INT);
$stmt->bindValue(':o', $offset, PDO::PARAM_INT);
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_THROW_ON_ERROR);
