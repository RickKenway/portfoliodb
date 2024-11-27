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
            // Inserir dados na tabela 'mensagens' (opcional, pois estamos usando Formspree)
            $query = "INSERT INTO mensagens (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssss', $nome, $email, $assunto, $mensagem);

            if ($stmt->execute()) {
                $feedback = "<p style='color: green; font-size: 1.2rem; margin-top: 15px;'>Mensagem enviada com sucesso!</p>";
            } else {
                $feedback = "<p style='color: red; font-size: 1.2rem; margin-top: 15px;'>Erro ao enviar a mensagem. Tente novamente mais tarde.</p>";
            }

            $stmt->close();
        } else {
            $feedback = "<p style='color: red; font-size: 1.2rem; margin-top: 15px;'>Por favor, insira um e-mail válido.</p>";
        }
    } else {
        $feedback = "<p style='color: red; font-size: 1.2rem; margin-top: 15px;'>Todos os campos são obrigatórios.</p>";
    }
}
?>

<main>
    <section style="text-align: center; max-width: 800px; margin: 0 auto;">
        <h1 style="color: #1e1e2f; font-size: 2.5rem; margin-bottom: 10px;">Entre em Contato</h1>
        <p style="font-size: 1.2rem; color: #555; margin-bottom: 20px;">
            Se você tem dúvidas, sugestões ou quer trabalhar comigo, envie uma mensagem!
        </p>

        <!-- Mensagem de feedback -->
        <?php echo $feedback; ?>

        <form action="https://formspree.io/f/mnnqgbnv" method="POST" style="background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div style="margin-bottom: 15px;">
                <label for="name" style="display: block; font-size: 1rem; color: #333; margin-bottom: 5px;">Nome:</label>
                <input type="text" id="name" name="name" placeholder="Seu nome completo" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; font-size: 1rem; color: #333; margin-bottom: 5px;">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Seu e-mail" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="subject" style="display: block; font-size: 1rem; color: #333; margin-bottom: 5px;">Assunto:</label>
                <input type="text" id="subject" name="subject" placeholder="Digite o assunto" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="message" style="display: block; font-size: 1rem; color: #333; margin-bottom: 5px;">Mensagem:</label>
                <textarea id="message" name="message" rows="5" placeholder="Escreva sua mensagem aqui..." required 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; resize: vertical;"></textarea>
            </div>

            <button type="submit" style="padding: 10px 20px; background-color: #00adb5; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem;">
                Enviar Mensagem
            </button>
        </form>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
