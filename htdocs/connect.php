<?php
try {
    $pdo = new PDO('mysql:host=mysqldb;dbname=my_database', 'root', 'root');
} catch (Exception $e) {
    die('Error :' . $e->getMessage());
}
