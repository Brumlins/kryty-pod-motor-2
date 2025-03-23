# Aplikace pro správu produktů

Toto je jednoduchá PHP aplikace pro správu informací o produktech. Aplikace umožňuje:

- Zobrazit informace o produktech v tabulce s stránkováním
- Filtrovat a řadit produkty
- Upravovat detaily produktů
- Exportovat data produktů do CSV souboru

## Funkce

- **Databáze**: MySQL databáze se třemi tabulkami (`produkty`, `znacka`, `material`) propojenými pomocí cizích klíčů.
- **Frontend**: HTML5, CSS3 a JavaScript pro responzivní a interaktivní uživatelské rozhraní.
- **Backend**: PHP pro zpracování CRUD operací a export dat.

## Instalace

1. Stáhněte nebo naklonujte repozitář:

git clone https://github.com/vas-repo/php_project.git

text

2. Přejděte do adresáře projektu:

cd php_project

text

3. Nastavte databázi:
- Importujte SQL skript umístěný v `sql/database_setup.sql` do vašeho MySQL serveru pomocí phpMyAdmin nebo příkazové řádky MySQL.

4. Nakonfigurujte připojení k databázi:
- Aktualizujte soubor `php/db_connection.php` s vašimi přihlašovacími údaji k MySQL serveru.

5. Spusťte server:
- Použijte XAMPP nebo jiný lokální server pro hostování projektu.

6. Přístup k aplikaci:
- Otevřete prohlížeč a přejděte na `http://localhost/php_project/index.php`.

## Použití

- **Zobrazení produktů**: Hlavní stránka zobrazuje produkty v tabulce se stránkováním.
- **Filtrování a řazení**: Použijte možnosti filtrování a řazení pro přizpůsobení zobrazení.
- **Úprava produktů**: Klikněte na produkt pro úpravu jeho detailů.
- **Export do CSV**: Klikněte na tlačítko exportu pro stažení aktuálního zobrazení jako CSV souboru.

## Technické požadavky

- PHP 7.0 nebo vyšší
- MySQL 5.7 nebo vyšší
- Webový server (Apache, Nginx)
- Webový prohlížeč s podporou JavaScriptu

## Struktura projektu

php_project/
├── css/
│ └── style.css
├── js/
│ └── script.js
├── php/
│ ├── db_connection.php
│ ├── crud_operations.php
│ └── export.php
├── sql/
│ └── database_setup.sql
├── index.php
└── README.md

text

## Řešení problémů

- **Problém s připojením k databázi**: Zkontrolujte správnost přihlašovacích údajů v souboru `db_connection.php`.
- **Chyba 404**: Ujistěte se, že všechny soubory jsou umístěny ve správném adresáři.
- **Prázdná tabulka produktů**: Zkontrolujte, zda byla databáze správně naplněna daty.

## Podpora

V případě problémů nebo dotazů se obraťte na správce projektu prostřednictvím e-mailu nebo vytvořením issue v repozitáři GitHub.