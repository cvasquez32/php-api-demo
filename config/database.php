<?php
$host = '';
$port = '';
$db = '';
$username = '';
$password = '';
$charset = '';

$dsn = "mysql:host=$host;port=$port;dbname=$db;chartset=$charset";
$options = [
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Database Connection Failed']);
  exit;
}
?>