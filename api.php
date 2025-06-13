<?php
header('Content-Type: application/json');
require 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['id']) ? '/item' : '/items';
$id = $_GET['id'] ?? null;
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
  case 'GET':
    if ($id) {
      $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
      $stmt->execute([$id]);
      $item = $stmt->fetch();
      if ($item) {
        echo json_encode($item);
      } else {
        http_response_code(400);
        echo json_encode(['error' => "Iten with ID $id not found"]);
      }
    } else {
      $stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC");
      echo json_encode($stmt->fetchAll());
    }
    break;
  case 'POST':
    if (empty($input['name'])) {
      http_response_code(400);
      echo json_encode(['error' => 'Name is required']);
      break;
    }
    $stmt = $pdo->prepare("INSERT INTO items (name, description) VALUES (?, ?)");
    $stmt->execute([$input['name'], $input['description'] ?? null]);
    http_response_code(201);
    echo json_encode(['id' => $pdo->lastInsertId()]);
    break;
  case 'PUT':
    if (!$id || empty($input['name'])) {
      http_response_code(400);
      echo json_encode(['error' => 'ID and name is required']);
    }
    $stmt = $pdo->prepare("UPDATE items SET name = ?, description = ? WHERE id = ?");
    $updated = $stmt->execute([$input['name'], $input['description'] ?? null, $id]);
    echo json_encode(['updated' => $updated]);
    break;
  case 'DELETE':
    if (!$id) {
      http_response_code(400);
      echo json_encode(['error' => 'ID is required']);
    }
    $stmt = $pdo->prepare("DELETE FROM items where id = ?");
    $deleted = $stmt->execute([$id]);
    echo json_encode(['error' => $deleted]);
    break;
  default:
    http_response_code(405);
    json_encode(['error' => 'Method Not Allowed']);
    break;
}
?>