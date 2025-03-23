<?php
require_once 'db_connection.php';
require_once 'crud_operations.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $sql = "SELECT produkty.*, znacka.nazev AS znacka, material.nazev AS material 
            FROM produkty 
            JOIN znacka ON produkty.znacka_id = znacka.id 
            JOIN material ON produkty.material_id = material.id 
            WHERE produkty.id = $id";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Produkt nebyl nalezen']);
    }
} else {
    echo json_encode(['error' => 'Chybí ID produktu']);
}
?>
