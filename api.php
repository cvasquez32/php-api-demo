<?php
header('Content-Type: application/json');
require 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['id']) ? '/item' : '/items';
$id = $_GET['id'] ?? null;

switch ($method) {
  case 'GET':
    if ($id) {
      $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
      $stmt->execute([$id]);
      $item = $stmt->fetch();
      echo $item ? json_encode($item) : json_encode([]);
    } else {
      $stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC");
      echo json_encode($stmt->fetchAll());
    }
    break;
  case 'POST':
    echo "Post item";
    break;
  case 'PUT':
    echo "Update items";
    break;
  case 'DELETE':
    echo "DELTE itens";
    break;
  default:
    http_response_code(405); // Method Not Allowed
    break;
}
?>