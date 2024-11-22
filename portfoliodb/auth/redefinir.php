<?php
require_once '../config.php';

$message = '';
$error = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica se o token existe e não expirou
    $query = "SELECT id FROM usuarios WHERE reset_token = ? AND reset_expira > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token válido, agora o usuário pode redefinir a senha
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = trim($_POST['new_password']);
            $confirm_password = trim($_POST['confirm_password']);

            if (!empty($new_password) && $new_password === $confirm_password) {
                // Atualiza a senha
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = "UPDATE usuarios SET senha = ?, reset_token = NULL, reset_expira = NULL WHERE reset_token = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param('ss', $hashed_password, $token);
                $update_stmt->execute();

                $message = 'Senha redefinida com sucesso! Você já pode fazer login.';
            } else {
                $error = 'As senhas não correspondem.';
            }
        }
    } else {
        $error = 'Token inválido ou expirado.';
    }
} else {
    $error = 'Token não fornecido!';
}
?>

<?php include '../includes/header.php'; ?>
<main>
    <section class="reset-password-section">
        <h1>Redefinir Senha</h1>
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php elseif (!empty($message)): ?>
            <p class="success-message"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if (empty($message)): ?>
        <form action="redefinir.php?token=<?php echo htmlspecialchars($token); ?>" method="post" class="reset-password-form">
            <div class="form-group">
                <label for="new_password">Nova Senha:</label>
                <input type="password" id="new_password" name="new_password" placeholder="Digite sua nova senha" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirme a Nova Senha:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirme sua nova senha" required>
            </div>
            <button type="submit" class="btn-submit">Redefinir Senha</button>
        </form>
        <?php endif; ?>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
