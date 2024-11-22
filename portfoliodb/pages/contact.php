<?php 
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Se não estiver logado, redireciona para a página de login
    header('Location: ../auth/login.php');
    exit();
}

include '../includes/header.php'; 
require_once '../config.php'; // Conexão com o banco de dados

// Inicializa mensagens de sucesso ou erro
$feedback = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar e validar os dados do formulário
    $nome = trim($_POST['name']);
    $email = trim($_POST['email']);
    $assunto = trim($_POST['subject']);
    $mensagem = trim($_POST['message']);

    if (!empty($nome) && !empty($email) && !empty($assunto) && !empty($mensagem)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Inserir dados na tabela 'mensagens'
            $query = "INSERT INTO mensagens (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssss', $nome, $email, $assunto, $mensagem);

            if ($stmt->execute()) {
                $feedback = "<p class='success'>Mensagem enviada com sucesso!</p>";
            } else {
                $feedback = "<p class='error'>Erro ao enviar a mensagem. Tente novamente mais tarde.</p>";
            }

            $stmt->close();
        } else {
            $feedback = "<p class='error'>Por favor, insira um e-mail válido.</p>";
        }
    } else {
        $feedback = "<p class='error'>Todos os campos são obrigatórios.</p>";
    }
}

?>

<main>
    <section class="contact-section">
        <h1>Entre em Contato</h1>
        <p>Se você tem dúvidas, sugestões ou quer trabalhar comigo, envie uma mensagem!</p>

        <!-- Mensagem de feedback -->
        <?php echo $feedback; ?>

        <form action="" method="post" class="contact-form">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" placeholder="Seu nome completo" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
            </div>

            <div class="form-group">
                <label for="subject">Assunto:</label>
                <input type="text" id="subject" name="subject" placeholder="Digite o assunto" required>
            </div>

            <div class="form-group">
                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" rows="5" placeholder="Escreva sua mensagem aqui..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">Enviar Mensagem</button>
        </form>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
