<?php
$host   = 'db';
$dbname = 'stockfacil';
$user   = 'appuser';
$pass   = 'apppass123';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('<p style="color:red;padding:20px">Erro de conexão: ' . htmlspecialchars($conn->connect_error) . '</p>');
}

$conn->set_charset('utf8mb4');
