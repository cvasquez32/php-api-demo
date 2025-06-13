<?php
header('Content-Type: application/json');
require 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    echo "Return items";
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