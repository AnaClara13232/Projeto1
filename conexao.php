<?php
$host = "localhost";
$db = "seu_banco";
$user = "root";
$pass = "";

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
