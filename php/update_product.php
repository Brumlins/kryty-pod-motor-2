<?php
require_once 'db_connection.php';
require_once 'crud_operations.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id']) && !empty($input['id'])) {
    $id = (int)$input['id'];
    
    $updateData = [
        'kod' => $conn->real_escape_string($input['kod']),
        'znacka_id' => (int)$input['znacka_id'],
        'material_id' => (int)$input['material_id'],
        'cena' => (float)$input['cena'],
        'popis' => $conn->real_escape_string($input['popis'])
    ];
    
    $sql = "UPDATE produkty SET ";
    $updates = [];
    foreach ($updateData as $key => $value) {
        $updates[] = "$key = '$value'";
    }
    $sql .= implode(", ", $updates);
    $sql .= " WHERE id = $id";

    $result = $conn->query($sql);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Produkt byl úspěšně aktualizován']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Při aktualizaci produktu došlo k chybě: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Chybí ID produktu']);
}
?>
