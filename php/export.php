<?php
require_once 'db_connection.php';

if (isset($_GET['export'])) {
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'produkty.id';
    $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

    $sql = "SELECT produkty.kod, znacka.nazev AS znacka, material.nazev AS material, produkty.cena, produkty.popis FROM produkty 
            JOIN znacka ON produkty.znacka_id = znacka.id 
            JOIN material ON produkty.material_id = material.id";

    if ($filter) {
        $sql .= " WHERE znacka.nazev LIKE '%$filter%'";
    }

    $sql .= " ORDER BY $sort $order";

    $result = $conn->query($sql);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=produkty_' . date('Y-m-d') . '.csv');

    $output = fopen('php://output', 'w');
    
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    fputcsv($output, ['Kód', 'Značka', 'Materiál', 'Cena (Kč)', 'Popis'], ';');

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['cena'] = str_replace('.', ',', $row['cena']);
            fputcsv($output, $row, ';');
        }
    }
    
    fclose($output);
    exit;
}
