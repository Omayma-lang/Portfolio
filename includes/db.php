<?php
/**
 * Database connection using PDO.
 * Credentials are read from config.php at the project root
 * (local XAMPP defaults are set there — see config.php to deploy).
 */

require_once __DIR__ . '/../config.php';

function db() {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Database connection failed. Check config.php credentials: ' . htmlspecialchars($e->getMessage()));
        }
    }
    return $pdo;
}