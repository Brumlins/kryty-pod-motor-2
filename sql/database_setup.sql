CREATE DATABASE IF NOT EXISTS kryty_pod_motor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE kryty_pod_motor;

CREATE TABLE IF NOT EXISTS znacka (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazev VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS material (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazev VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS produkty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kod VARCHAR(10) NOT NULL,
    znacka_id INT NOT NULL,
    material_id INT NOT NULL,
    cena DECIMAL(10, 2) NOT NULL,
    popis TEXT,
    vytvoreno TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (znacka_id) REFERENCES znacka(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES material(id) ON DELETE CASCADE
) ENGINE=InnoDB;



INSERT INTO znacka (nazev) VALUES 
('Audi'), ('BMW'), ('Citroën'), ('Ford'), ('Škoda'), 
('Volkswagen'), ('Peugeot'), ('Renault'), ('Toyota'), ('Mercedes');

INSERT INTO material (nazev) VALUES 
('Plast'), ('Plech'), ('Hliník');

INSERT INTO produkty (kod, znacka_id, material_id, cena, popis) VALUES
('PM00001', 1, 1, 1210.00, 'Kryt pod motor AUDI A6 C6 Sedan (4F2)'),
('PM00002', 1, 2, 1450.00, 'Kryt pod motor AUDI A4 B8 Sedan (8K2)'),
('PM00003', 2, 1, 1320.00, 'Kryt pod motor BMW 3 (E90)'),
('PM00004', 2, 3, 1780.00, 'Kryt pod motor BMW X5 (E70)'),
('PM00005', 3, 1, 1150.00, 'Kryt pod motor CITROËN C4 Picasso'),
('PM00006', 3, 2, 1420.00, 'Kryt pod motor CITROËN C5 II (RC_)'),
('PM00007', 4, 1, 980.00, 'Kryt pod motor FORD Focus II Hatchback (DA_)'),
('PM00008', 4, 3, 1650.00, 'Kryt pod motor FORD Mondeo IV Sedan (BA7)'),
('PM00009', 5, 1, 1050.00, 'Kryt pod motor ŠKODA Octavia II Combi (1Z5)'),
('PM00010', 5, 2, 1380.00, 'Kryt pod motor ŠKODA Superb II (3T4)'),
('PM00011', 6, 1, 1120.00, 'Kryt pod motor VOLKSWAGEN Golf VI (5K1)'),
('PM00012', 6, 3, 1720.00, 'Kryt pod motor VOLKSWAGEN Passat B7 (362)'),
('PM00013', 7, 1, 1090.00, 'Kryt pod motor PEUGEOT 308 I (4A_, 4C_)'),
('PM00014', 7, 2, 1410.00, 'Kryt pod motor PEUGEOT 508 I (8D_)'),
('PM00015', 8, 1, 1030.00, 'Kryt pod motor RENAULT Megane III Grandtour (KZ0/1)'),
('PM00016', 8, 3, 1690.00, 'Kryt pod motor RENAULT Laguna III (BT0/1)'),
('PM00017', 9, 1, 1180.00, 'Kryt pod motor TOYOTA Avensis III Sedan (_T27_)'),
('PM00018', 9, 2, 1440.00, 'Kryt pod motor TOYOTA RAV4 III (_A3_)'),
('PM00019', 10, 1, 1250.00, 'Kryt pod motor MERCEDES C-CLASS (W204)'),
('PM00020', 10, 3, 1850.00, 'Kryt pod motor MERCEDES E-CLASS (W212)');
