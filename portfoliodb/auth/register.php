<?php
require_once '../config.php';

$error = ''; // Variável para armazenar erros de cadastro

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);  // Alterado para 'senha', pois essa é a coluna no banco

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
            $hashed_senha = password_hash($senha, PASSWORD_BCRYPT);  // Alterado para 'senha'

            // Insere o novo usuário no banco
            $query = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";  // Alterado para 'senha'
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $nome, $email, $hashed_senha);  // Alterado para 'senha'

            if ($stmt->execute()) {
                // Login automático após cadastro
                $user_id = $stmt->insert_id;  // Obtém o id do usuário recém-criado
                session_start();
                $_SESSION['user_id'] = $user_id;  // Armazena o id do usuário na variável de sessão

                header('Location: ../index.php'); // Redireciona para a página inicial após o cadastro bem-sucedido
                exit;
            } else {
                $error = 'Erro ao cadastrar usuário. Tente novamente.'; // Mensagem de erro
            }
        } else {
            $error = 'E-mail já cadastrado.'; // Se o e-mail já existe
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
                <label for="senha">Senha:</label>  <!-- Alterado para 'senha' -->
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>

            <button type="submit" class="btn-submit">Cadastrar</button>
        </form>

        <p class="register-link">Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
