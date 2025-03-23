<?php
function fetchProducts($conn, $limit, $offset, $sort, $filter) {
    $sql = "SELECT produkty.id, produkty.kod, znacka.nazev AS znacka, material.nazev AS material, produkty.cena, produkty.popis FROM produkty 
            JOIN znacka ON produkty.znacka_id = znacka.id 
            JOIN material ON produkty.material_id = material.id";

    if ($filter) {
        $sql .= " WHERE znacka.nazev LIKE '%$filter%'";
    }

    if ($sort) {
        $sql .= " ORDER BY $sort";
    }

    $sql .= " LIMIT $limit OFFSET $offset";

    $result = $conn->query($sql);

    $products = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

function updateProduct($conn, $id, $data) {
    $sql = "UPDATE produkty SET ";
    $updates = [];
    foreach ($data as $key => $value) {
        $updates[] = "$key = '$value'";
    }
    $sql .= implode(", ", $updates);
    $sql .= " WHERE id = $id";

    return $conn->query($sql);
}
?>
