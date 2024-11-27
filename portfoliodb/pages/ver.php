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
    $query = "SELECT titulo, descricao, tecnologias, link_codigo, link_demo, data_realizacao FROM projetos WHERE id = ?";
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

// Definir as imagens específicas para cada projeto
$project_images = [
    5 => ['foto_4.png', 'foto_5.png', 'foto_6.png'], // Projeto com ID 5
    6 => ['foto_8.png', 'foto_9.png', 'foto_10.png'],
    7 => ['foto_12.png', 'foto_13.png', 'foto_14.png'], // Projeto com ID 5
    // Adicione mais IDs e imagens conforme necessário
];

// Verificar se o projeto tem imagens associadas
if (array_key_exists($id, $project_images)) {
    $imagens = $project_images[$id];
} else {
    $imagens = []; // Caso não tenha imagens associadas
}

?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .project-detail {
        padding: 50px 20px;
        text-align: center;
    }

    .project-detail h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 20px;
    }

    .project-detail p {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 40px;
    }

    .project-info {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: 0 auto;
        text-align: left;
    }

    .project-info img {
        max-width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .project-info ul {
        list-style: none;
        padding: 0;
    }

    .project-info ul li {
        font-size: 1rem;
        color: #777;
        margin-bottom: 10px;
    }

    .project-info a {
        color: #00adb5;
        text-decoration: none;
        font-weight: bold;
    }

    .project-info a:hover {
        color: #007f8a;
    }

    .btn-back {
        display: inline-block;
        padding: 10px 20px;
        background-color: #00adb5;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 30px;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #007f8a;
    }
</style>

<main>
    <section class="project-detail">
        <h1><?php echo htmlspecialchars($project['titulo']); ?></h1>
        <p><?php echo htmlspecialchars($project['descricao']); ?></p>

        <div class="project-info">
            <!-- Exibindo as imagens específicas do projeto com base no ID -->
            <?php
            if (!empty($imagens)):
                foreach ($imagens as $imagem): ?>
                    <img src="../assets/images/<?php echo htmlspecialchars($imagem); ?>" alt="Imagem do Projeto: <?php echo htmlspecialchars($project['titulo']); ?>">
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
