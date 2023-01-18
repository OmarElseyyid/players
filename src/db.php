<?php
    $host = '127.0.0.1:3306';
    $user = 'root';
    $pass = '';
    $db = 'players';
    $connected = false;

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $connected = true;
        // set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("ERROR: Could not connect. " . $e->getMessage());
    }