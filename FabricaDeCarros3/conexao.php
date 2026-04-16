<?php
$host = "localhost";
$db = "fabrica";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>