<?php
/**
 * One-time setup script (local development).
 * Run this once in the browser AFTER starting MySQL in XAMPP:
 *   http://localhost/portfolio/seed.php
 *
 * It creates the database + tables and inserts the default content.
 * For DEPLOYMENT, you do NOT need this script — import install.sql
 * through AwardSpace's phpMyAdmin instead (your real data is in there).
 */

require_once __DIR__ . '/config.php';

header('Content-Type: text/plain; charset=utf-8');

function run_sql($pdo, $sql) {
    $pdo->exec($sql);
}

// 1) Try to connect directly to the database (works when it exists).
//    If it doesn't exist yet, connect without a database to create it.
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "Connected to database '" . DB_NAME . "'.\n";
} catch (PDOException $e) {
    echo "Database '" . DB_NAME . "' not reachable — trying to create it...\n";
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        echo "Database '" . DB_NAME . "' created.\n";
        $pdo->exec('USE `' . DB_NAME . '`');
    } catch (PDOException $e2) {
        echo "Cannot connect to MySQL. Check config.php — is XAMPP MySQL running?\n";
        echo "Error: " . $e2->getMessage() . "\n";
        exit(1);
    }
}

// 2) Create tables if they don't exist
$tables = [
    'projects' => "CREATE TABLE IF NOT EXISTS projects (
      id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      slug VARCHAR(255) NOT NULL UNIQUE,
      short_description TEXT NOT NULL,
      full_description LONGTEXT,
      tech_used TEXT,
      live_url VARCHAR(500),
      sort_order INT DEFAULT 0,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",
    'project_images' => "CREATE TABLE IF NOT EXISTS project_images (
      id INT AUTO_INCREMENT PRIMARY KEY,
      project_id INT NOT NULL,
      image_path VARCHAR(500) NOT NULL,
      caption VARCHAR(255) DEFAULT NULL,
      sort_order INT DEFAULT 0,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      CONSTRAINT fk_project_images_project
        FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
    ) ENGINE=InnoDB",
    'certificates' => "CREATE TABLE IF NOT EXISTS certificates (
      id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      issuer VARCHAR(255) DEFAULT NULL,
      cert_date VARCHAR(100) DEFAULT NULL,
      image_path VARCHAR(500) DEFAULT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",
    'site_settings' => "CREATE TABLE IF NOT EXISTS site_settings (
      id INT AUTO_INCREMENT PRIMARY KEY,
      setting_key VARCHAR(100) NOT NULL UNIQUE,
      setting_value LONGTEXT
    ) ENGINE=InnoDB",
];

foreach ($tables as $name => $sql) {
    try {
        run_sql($pdo, $sql);
        echo "Table '$name' ready.\n";
    } catch (PDOException $e) {
        echo "Table '$name' error: " . $e->getMessage() . "\n";
    }
}

// 3) Seed default site settings (INSERT IGNORE)
$settings = [
    ['hero_heading', 'Welcome, I\'m <span class="highlight">Omayma</span>.'],
    ['hero_subheading', 'A Full-Stack Developer combining the precision of backend engineering with the beauty of frontend design. I transform creative ideas into living digital experiences delivered right on time.'],
    ['about_text', 'I build web experiences that help small businesses and individuals turn visitors into customers. My work spans web development, with UI/UX design and video editing as complementary skills I bring to every project.'],
    ['contact_email', 'okhelfaoui23@gmail.com'],
];

$st = $pdo->prepare('INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES (?, ?)');
foreach ($settings as $s) {
    $st->execute($s);
}
echo "Site settings seeded.\n";

// 4) Insert the bookstore project if it isn't there
$exists = $pdo->query("SELECT id FROM projects WHERE slug='bookstore-ecommerce-site'")->fetch();
if (!$exists) {
    $stmt = $pdo->prepare("INSERT INTO projects (title, slug, short_description, full_description, tech_used, live_url, sort_order)
        VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([
        "Bookstore E-Commerce Site",
        "bookstore-ecommerce-site",
        "A complete online bookstore where customers can browse, search, and place orders — with a full admin side to manage stock, products, and orders.",
        "The Problems:\nA local bookstore wanted its catalog online. Physical browsing or phone orders weren't scaleable, and they needed a place where customers could see what was in stock and place an order without calling.\n\nMy Approach:\nI built it as a full e-commerce experience with two clear sides — a customer-facing storefront and an admin panel for the owner. The storefront pulls books from the database with category filters, a search bar, product detail pages, a shopping cart, and an order checkout flow. The admin side lets the owner add, edit, and remove books, manage stock and pricing, and view incoming orders.\n\nDesign Decisions:\nBooks are a visual product, so I let clear product cards and cover art do the heavy lifting. Category filters and search sit up front to keep browsing friction low, and the admin interface is deliberately simple because its user isn't technical.\n\nWhat I'd Improve:\nI'd add a payment gateway so orders settle online, improve image handling for faster loads, and add stock-level alerts so the owner knows when to reorder.",
        "PHP, MySQL, HTML, CSS, JavaScript",
        "http://okhelfaoui23.atwebpages.com/main.html",
        1
    ]);
    $project_id = $pdo->lastInsertId();

    // Add placeholder image rows so the gallery has structure.
    // Replace these paths with your real screenshots in /assets/images/
    $imgSt = $pdo->prepare("INSERT INTO project_images (project_id, image_path, caption, sort_order) VALUES (?,?,?,?)");
    $imgSt->execute([$project_id, 'assets/images/placeholder-bookstore.svg', 'Homepage', 0]);
    $imgSt->execute([$project_id, 'assets/images/placeholder-bookstore-2.svg', 'Product page', 1]);
    $imgSt->execute([$project_id, 'assets/images/placeholder-bookstore-3.svg', 'Admin panel', 2]);

    echo "Bookstore project inserted with placeholder image rows.\n";
    echo "NOTE: For your REAL content (screenshots, rescue book, certificate),\n";
    echo "import install.sql instead — it contains everything from your local DB.\n";
} else {
    echo "Bookstore project already exists, skipping.\n";
}

echo "\nSetup complete! Visit index.php to view the site.\n";