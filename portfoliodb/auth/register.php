<?php
require_once '../config.php';

$error = ''; // Variável para armazenar erros de cadastro

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validações simples
    if (!empty($nome) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            // Verifica se o e-mail já está cadastrado
            $query = "SELECT id FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                // Criptografa a senha antes de salvar no banco
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insere o novo usuário no banco
                $query = "INSERT INTO usuarios (nome, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('sss', $nome, $email, $hashed_password);

                if ($stmt->execute()) {
                    header('Location: login.php'); // Redireciona para o login após o cadastro
                    exit;
                } else {
                    $error = 'Erro ao cadastrar usuário. Tente novamente.'; // Mensagem de erro
                }
            } else {
                $error = 'E-mail já cadastrado.'; // Se o e-mail já existe
            }
        } else {
            $error = 'As senhas não coincidem.'; // Se as senhas não forem iguais
        }
    } else {
        $error = 'Por favor, preencha todos os campos.'; // Se algum campo estiver vazio
    }
}
?>

<?php include '../includes/header.php'; ?>
<main>
    <section class="login-section">
        <h1>Cadastro</h1>

        <!-- Exibe a mensagem de erro, se houver -->
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Formulário de cadastro -->
        <form action="register.php" method="post" class="login-form">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmar Senha:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirme sua senha" required>
            </div>

            <button type="submit" class="btn-submit">Cadastrar</button>
        </form>

        <p class="register-link">Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
