<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

include '../includes/header.php'; 
require_once '../config.php';

// Verificar se o ID do projeto foi passado pela URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitiza o ID recebido pela URL

    // Consultar o banco para obter as informações do projeto
    $query = "SELECT titulo, descricao, tecnologias, link_codigo, link_demo, data_realizacao, imagens FROM projetos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $project = $result->fetch_assoc();
    } else {
        echo "<p>Projeto não encontrado.</p>";
        exit();
    }
} else {
    echo "<p>ID do projeto não informado. Verifique a URL.</p>";
    exit();
}
?>

<main>
    <section class="project-detail">
        <h1><?php echo htmlspecialchars($project['titulo']); ?></h1>
        <p><?php echo htmlspecialchars($project['descricao']); ?></p>

        <div class="project-info">
            <!-- Exibindo todas as imagens do campo JSON 'imagens' -->
            <?php 
            $imagens = json_decode($project['imagens'], true);
            if ($imagens):
                foreach ($imagens as $imagem): ?>
                    <img src="../assets/images/<?php echo htmlspecialchars($imagem); ?>" alt="<?php echo htmlspecialchars($project['titulo']); ?>" style="max-width: 300px; margin: 10px;">
                <?php endforeach;
            else: ?>
                <p>Nenhuma imagem disponível para este projeto.</p>
            <?php endif; ?>
            
            <ul>
                <li><strong>Tecnologias:</strong> <?php echo htmlspecialchars($project['tecnologias']); ?></li>
                <li><strong>Data:</strong> <?php echo htmlspecialchars($project['data_realizacao']); ?></li>
            </ul>
            
            <p><strong>Código:</strong> <a href="<?php echo htmlspecialchars($project['link_codigo']); ?>" target="_blank">Repositório</a></p>
            <p><strong>Demonstração:</strong> <a href="<?php echo htmlspecialchars($project['link_demo']); ?>" target="_blank">Demo</a></p>
        </div>

        <a href="projects.php" class="btn-back">Voltar para os projetos</a>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
