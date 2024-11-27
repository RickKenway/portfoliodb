<?php
require_once '../config.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        // Verifica se o e-mail existe no banco de dados
        $query = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Gera um token de recuperação único
            $token = bin2hex(random_bytes(50));
            $query = "UPDATE usuarios SET reset_token = ?, reset_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss', $token, $email);
            $stmt->execute();

            // Gera o link de redefinição
            $resetLink = "http://localhost/portfoliodb/auth/redefinir.php?token=$token";

            // Mensagem de sucesso com o link de redefinição
            $message = "Um link de redefinição de senha foi gerado. Clique abaixo para redefinir sua senha:<br>";
            $message .= "<a href='$resetLink' target='_blank'>Clique aqui para redefinir sua senha</a>";
        } else {
            $error = 'E-mail não encontrado.';
        }
    } else {
        $error = 'Por favor, preencha o campo de e-mail.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <section style="text-align: center;">
            <h1 style="color: #1e1e2f; font-size: 2.5rem;">Recuperação de Senha</h1>

            <!-- Exibe mensagens de erro ou sucesso -->
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php elseif (!empty($message)): ?>
                <p style="color: green;"><?php echo $message; ?></p>
            <?php endif; ?>

            <!-- Formulário para recuperação de senha -->
            <form action="forgot_password.php" method="post" style="max-width: 400px; margin: auto; text-align: left;">
                <div style="margin-bottom: 15px;">
                    <label for="email" style="font-size: 1rem;">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>

                <button type="submit" style="padding: 10px 20px; background-color: #00adb5; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Recuperar Senha</button>
            </form>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
