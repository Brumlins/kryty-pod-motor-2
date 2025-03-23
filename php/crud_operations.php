<?php
// Funkce pro získání všech produktů
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
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

// Funkce pro získání celkového počtu produktů
function getTotalProducts($conn, $filter) {
    $sql = "SELECT COUNT(*) as total FROM produkty 
            JOIN znacka ON produkty.znacka_id = znacka.id";
    
    if ($filter) {
        $sql .= " WHERE znacka.nazev LIKE '%$filter%'";
    }
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Funkce pro aktualizaci produktu
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

// Funkce pro získání detailu produktu
function getProduct($conn, $id) {
    $sql = "SELECT produkty.*, znacka.nazev AS znacka, material.nazev AS material 
            FROM produkty 
            JOIN znacka ON produkty.znacka_id = znacka.id 
            JOIN material ON produkty.material_id = material.id 
            WHERE produkty.id = $id";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

// Funkce pro získání všech značek
function getZnacky($conn) {
    $sql = "SELECT * FROM znacka ORDER BY nazev";
    $result = $conn->query($sql);
    
    $znacky = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $znacky[] = $row;
        }
    }
    return $znacky;
}

// Funkce pro získání všech materiálů
function getMaterialy($conn) {
    $sql = "SELECT * FROM material ORDER BY nazev";
    $result = $conn->query($sql);
    
    $materialy = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $materialy[] = $row;
        }
    }
    return $materialy;
}
?>
