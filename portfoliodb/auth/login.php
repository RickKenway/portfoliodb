<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['senha'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: ../principal.php');
        exit;
    } else {
        $error = "Credenciais inválidas.";
    }
}
?>

<form method="post" action="">
    <label for="email">E-mail:</label>
    <input type="email" name="email" required>
    <label for
