<?php
require_once 'db_connection.php';
require_once 'crud_operations.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $product = getProduct($conn, $id);
    
    if ($product) {
        header('Content-Type: application/json');
        echo json_encode($product);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Produkt nebyl nalezen']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Chybí ID produktu']);
}
?>
