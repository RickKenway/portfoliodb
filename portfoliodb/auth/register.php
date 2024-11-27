<?php
session_start();
require_once '../config.php';

$error = ''; // Variável para armazenar erros de cadastro

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);  // Campo de senha

    // Validações simples
    if (!empty($nome) && !empty($email) && !empty($senha)) {
        // Verifica se o e-mail já está cadastrado
        $query = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            // Criptografa a senha antes de salvar no banco
            $hashed_senha = password_hash($senha, PASSWORD_BCRYPT);

            // Insere o novo usuário no banco
            $query = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $nome, $email, $hashed_senha);

            if ($stmt->execute()) {
                // Login automático após cadastro
                $user_id = $stmt->insert_id;  // Obtém o id do usuário recém-criado
                $_SESSION['user_id'] = $user_id;

                header('Location: ../index.php'); // Redireciona para a página inicial
                exit;
            } else {
                $error = 'Erro ao cadastrar usuário. Tente novamente.';
            }
        } else {
            $error = 'E-mail já cadastrado.';
        }
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <section style="text-align: center;">
            <h1 style="color: #1e1e2f; font-size: 2.5rem;">Cadastro</h1>

            <!-- Exibe a mensagem de erro, se houver -->
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <!-- Formulário de cadastro -->
            <form action="register.php" method="post" style="max-width: 400px; margin: auto; text-align: left;">
                <div style="margin-bottom: 15px;">
                    <label for="nome" style="font-size: 1rem;">Nome:</label>
                    <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="email" style="font-size: 1rem;">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="senha" style="font-size: 1rem;">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>

                <button type="submit" style="padding: 10px 20px; background-color: #00adb5; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Cadastrar</button>
            </form>

            <p style="margin-top: 20px;">Já tem uma conta? <a href="login.php" style="color: #00adb5;">Faça login aqui</a>.</p>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
