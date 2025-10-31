<?php
    //Handles the database connection for the Chop app.
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
