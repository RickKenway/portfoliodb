<?php
$host = 'localhost'; // Endereço do servidor do banco de dados
$dbname = 'portfoliodb'; // Nome do banco de dados
$username = 'root'; // Usuário do banco de dados
$password = ''; // Senha do banco de dados

// Criação da conexão
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifique se a sessão já está ativa antes de iniciar uma nova sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>