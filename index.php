<?php
require_once 'php/db_connection.php';
require_once 'php/crud_operations.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'produkty.id';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$total_products = getTotalProducts($conn, $filter);
$total_pages = ceil($total_products / $limit);

$products = fetchProducts($conn, $limit, $offset, "$sort $order", $filter);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa produktů - Kryty pod motor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Správa produktů - Kryty pod motor</h1>
    
    <div class="controls">
        <form method="GET" action="">
            <div class="filter-section">
                <label for="filter">Filtrovat podle značky:</label>
                <input type="text" id="filter" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
                <button type="submit">Filtrovat</button>
            </div>
            
            <div class="sort-section">
                <label for="sort">Řadit podle:</label>
                <select id="sort" name="sort">
                    <option value="produkty.kod" <?php echo $sort == 'produkty.kod' ? 'selected' : ''; ?>>Kód produktu</option>
                    <option value="znacka.nazev" <?php echo $sort == 'znacka.nazev' ? 'selected' : ''; ?>>Značka</option>
                    <option value="material.nazev" <?php echo $sort == 'material.nazev' ? 'selected' : ''; ?>>Materiál</option>
                    <option value="produkty.cena" <?php echo $sort == 'produkty.cena' ? 'selected' : ''; ?>>Cena</option>
                </select>
                
                <label for="order">Pořadí:</label>
                <select id="order" name="order">
                    <option value="ASC" <?php echo $order == 'ASC' ? 'selected' : ''; ?>>Vzestupně</option>
                    <option value="DESC" <?php echo $order == 'DESC' ? 'selected' : ''; ?>>Sestupně</option>
                </select>
                
                <button type="submit">Seřadit</button>
            </div>
        </form>
        
        <a href="php/export.php?export=1&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>&filter=<?php echo urlencode($filter); ?>" class="export-btn">Exportovat do CSV</a>

    </div>
    
    <div id="product-table">
        <table>
            <thead>
                <tr>
                    <th>Kód</th>
                    <th>Značka</th>
                    <th>Materiál</th>
                    <th>Cena (Kč)</th>
                    <th>Popis</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr data-id="<?php echo $product['id']; ?>">
                    <td><?php echo htmlspecialchars($product['kod']); ?></td>
                    <td><?php echo htmlspecialchars($product['znacka']); ?></td>
                    <td><?php echo htmlspecialchars($product['material']); ?></td>
                    <td><?php echo number_format($product['cena'], 2, ',', ' '); ?></td>
                    <td><?php echo htmlspecialchars($product['popis']); ?></td>
                    <td>
                        <button class="edit-btn" data-id="<?php echo $product['id']; ?>">Upravit</button>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>&filter=<?php echo urlencode($filter); ?>">Předchozí</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <?php if ($i == $page): ?>
                <span class="current-page"><?php echo $i; ?></span>
            <?php else: ?>
                <a href="?page=<?php echo $i; ?>&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>&filter=<?php echo urlencode($filter); ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>&sort=<?php echo urlencode($sort); ?>&order=<?php echo urlencode($order); ?>&filter=<?php echo urlencode($filter); ?>">Další</a>
        <?php endif; ?>
    </div>
    
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Upravit produkt</h2>
            <form id="edit-form">
                <input type="hidden" id="product-id" name="id">
                
                <div class="form-group">
                    <label for="kod">Kód produktu:</label>
                    <input type="text" id="kod" name="kod" required>
                </div>
                
                <div class="form-group">
                    <label for="znacka">Značka:</label>
                    <select id="znacka" name="znacka_id" required>
                        <?php
                        $znacky = getZnacky($conn);
                        foreach ($znacky as $znacka) {
                            echo '<option value="' . $znacka['id'] . '">' . htmlspecialchars($znacka['nazev']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="material">Materiál:</label>
                    <select id="material" name="material_id" required>
                        <?php
                        $materialy = getMaterialy($conn);
                        foreach ($materialy as $material) {
                            echo '<option value="' . $material['id'] . '">' . htmlspecialchars($material['nazev']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="cena">Cena (Kč):</label>
                    <input type="number" id="cena" name="cena" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="popis">Popis:</label>
                    <textarea id="popis" name="popis" rows="4" required></textarea>
                </div>
                
                <button type="submit">Uložit změny</button>
            </form>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>
