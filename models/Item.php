<?php
class Item {
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function getAll() 
  {
    return $this->pdo->query("SELECT * FROM items ORDER BY created_at DESC")->fetchAll();
  }
  public function getById($id) 
  {
    $stmt = $this->pdo->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }
  public function create($name, $description) 
  {
    $stmt = $this->pdo->prepare("INSERT INTO items (name, description) VALUES (?, ?)");
    $stmt->execute([$name, $description]);
    return $this->pdo->lastInsertId();
  }
  public function update($id, $name, $description) 
  {
    $stmt = $this->pdo->prepare("UPDATE items SET name = ?, description = ? WHERE id = ?");
    return $stmt->execute([$name, $description, $id]);
  }
  public function delete($id) 
  {
    $stmt = $this->pdo->prepare("DELETE FROM items where id = ?");
    return $stmt->execute([$id]);
  }
}
?>