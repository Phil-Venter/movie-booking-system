<?php
require_once('conn.php');

$instance = Connection::getInstance();
$conn = $instance->getConnection();

// run code once for database initialization,
// after which remove if statement or set value to false
if (true) {
    // setup users table
    // if it fails, remove the table completely to ensure all works
    try {
        $conn->query("CREATE TABLE IF NOT EXISTS `USER` (
            `id` NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(100) NOT NULL,
            `surname` VARCHAR(100) NOT NULL,
            `username` VARCHAR(100) NOT NULL UNIQUE,
            `password` VARCHAR(100) NOT NULL
        )");
    } catch (Throwable $th) {
        $conn->query("DROP TABLE IF EXIST `USER`");
        echo json_encode($th);
    }

    // setup cinema table
    // if it fails, remove the table completely to ensure all works
    try {
        $conn->query("CREATE TABLE IF NOT EXISTS `CINEMA` (
            `id` NOT NULL AUTO_INCREMENT PRIMARY KEY,
        )");
    } catch (Throwable $th) {
        $conn->query("DROP TABLE IF EXIST `CINEMA`");
        echo json_encode($th);
    }

    // setup theatres table
    // if it fails, remove the table completely to ensure all works
    try {
        $conn->query("CREATE TABLE IF NOT EXISTS `THEATRE` (
            `id` NOT NULL AUTO_INCREMENT PRIMARY KEY,
        )");
    } catch (Throwable $th) {
        $conn->query("DROP TABLE IF EXIST `THEATRE`");
        echo json_encode($th);
    }

    // setup films
    // if it fails, remove the table completely to ensure all works
    try {
        $conn->query("CREATE TABLE IF NOT EXISTS `FILM` (
            `id` NOT NULL AUTO_INCREMENT PRIMARY KEY,
        )");
    } catch (Throwable $th) {
        $conn->query("DROP TABLE IF EXIST `FILM`");
        echo json_encode($th);
    }
}
