<?php
require_once 'db_connection.php';
require_once 'crud_operations.php';

// Kontrola, zda byl odeslán POST požadavek
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získání dat z POST požadavku
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['id']) && !empty($data['id'])) {
        $id = (int)$data['id'];
        
        // Příprava dat pro aktualizaci
        $updateData = [
            'kod' => $conn->real_escape_string($data['kod']),
            'znacka_id' => (int)$data['znacka_id'],
            'material_id' => (int)$data['material_id'],
            'cena' => (float)$data['cena'],
            'popis' => $conn->real_escape_string($data['popis'])
        ];
        
        // Aktualizace produktu
        $result = updateProduct($conn, $id, $updateData);
        
        if ($result) {
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Produkt byl úspěšně aktualizován']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Při aktualizaci produktu došlo k chybě']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Chybí ID produktu']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Neplatná metoda požadavku']);
}
?>
