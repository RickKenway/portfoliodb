<?php
require_once '../config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // A tabela correta no banco de dados é 'usuarios', não 'users'
        $query = "SELECT id, senha FROM usuarios WHERE email = ?";  // Alterado para 'usuarios' e 'senha'
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verifica se a senha fornecida é válida
            if (password_verify($password, $user['senha'])) {
                // Armazena o id do usuário na sessão
                $_SESSION['user_id'] = $user['id'];
                header('Location: ../index.php');  // Redireciona para a página inicial
                exit;
            } else {
                $error = 'Senha incorreta.';
            }
        } else {
            $error = 'Usuário não encontrado.';
        }
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }
}
?>

<?php include '../includes/header.php'; ?>
<main>
    <section class="login-section">
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post" class="login-form">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            </div>

            <button type="submit" class="btn-submit">Entrar</button>
        </form>
        <p class="register-link">Ainda não tem uma conta? <a href="register.php">Cadastre-se aqui</a>.</p>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
