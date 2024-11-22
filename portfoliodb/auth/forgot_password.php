<?php
require_once '../config.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        $query = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Gera um token de recuperação
            $token = bin2hex(random_bytes(50));
            $query = "UPDATE usuarios SET reset_token = ?, reset_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss', $token, $email);
            $stmt->execute();

            // Gera o link de redefinição
            $resetLink = "http://localhost/portfoliodb/auth/redefinir.php?token=$token";

            // Exibe o link de redefinição na tela (não envia por e-mail)
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

<?php include '../includes/header.php'; ?>
<main>
    <section class="forgot-password-section">
        <h1>Recuperação de Senha</h1>
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php elseif (!empty($message)): ?>
            <p class="success-message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="forgot_password.php" method="post" class="forgot-password-form">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>
            <button type="submit" class="btn-submit">Recuperar Senha</button>
        </form>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
