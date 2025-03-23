<?php
if (isset($_GET['export'])) {
    $sort = $_GET['sort'] ?? '';
    $filter = $_GET['filter'] ?? '';

    $sql = "SELECT produkty.kod, znacka.nazev AS znacka, material.nazev AS material, produkty.cena, produkty.popis FROM produkty 
            JOIN znacka ON produkty.znacka_id = znacka.id 
            JOIN material ON produkty.material_id = material.id";

    if ($filter) {
        $sql .= " WHERE znacka.nazev LIKE '%$filter%'";
    }

    if ($sort) {
        $sql .= " ORDER BY $sort";
    }

    $result = $conn->query($sql);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=products.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Code', 'Brand', 'Material', 'Price', 'Description']);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
    exit;
}
?>
