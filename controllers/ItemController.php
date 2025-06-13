<?php
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../helpers/response.php';

class ItemController {
  private $itemModel;

  public function __construct($pdo)
  {
    $this->itemModel = new Item($pdo);
  }

  public function handleRequest($method, $id = null, $data = null)
  {
    switch ($method) {
      case 'GET':
        if ($id) {
          $item = $this->itemModel->getById($id);
          $item ? jsonResponse($item) : jsonResponse(['error' => 'Item Not Found'], 400);
        } else {
          jsonResponse($this->itemModel->getAll());
        }
        break;
      case 'POST':
        if (empty($data['name'])) jsonResponse(['error' => 'Name is required'], 400);
        $newId = $this->itemModel->create($data['name'], $data['description'] ?? null);
        jsonResponse(['id' => $newId], 201);
      case 'PUT':
        if (!$id || empty($data['name'])) jsonResponse(['error' => 'ID and name is required'], 400);
        $updated = $this->itemModel->update($id, $data['name'], $data['description'] ?? null);
        jsonResponse(['updated' => $updated]);
        break;
      case 'DELETE':
        if (!$id) jsonResponse(['error' => 'ID is required'], 400);
        $deleted = $this->itemModel->delete($id);
        jsonResponse(['deleted' => $deleted]);
        break;
      default:
        jsonResponse(['error' => 'Method Not Allowed'], 405);
    }
  }
}
?>