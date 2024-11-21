<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    header('Location: login.php');
    exit;
}
?>

<form method="post" action="">
    <label for="name">Nome:</label>
    <input type="text" name="name" required>
    <label for="email">E-mail:</label>
    <input type="email" name="email" required>
    <label for="password">Senha:</label>
    <input type="password" name="password" required>
    <button type="submit">Cadastrar</button>
</form>
