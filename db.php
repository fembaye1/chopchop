<?php
/**
 * db.php
 * 
 * Handles the database connection for the Chop app.
 * 
 * This file should be included anywhere you need database access.
 * Example:
 *    require_once "db.php";
 *    $stmt = $pdo->query("SELECT * FROM recipes");
 * 
 * Note:
 * Replace yournetid with your actual UVA NetID.
 */
$host = "localhost";            // Usually localhost for CS4640
$dbname = "cs4640_yournetid";   // Your class database name
$user = "mbv7xs";            // Your NetID
$password = "VYXkL8WeKEnE";    // Your DB password (from class setup)

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

    // Throw exceptions on errors — helps debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Return associative arrays by default
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Handle connection failure gracefully
    echo "Database connection failed: " . htmlspecialchars($e->getMessage());
    exit;
}
?>
