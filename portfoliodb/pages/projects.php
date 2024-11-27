<?php 
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit(); 
}

include '../includes/header.php'; 
require_once '../config.php'; 

// Buscar todos os projetos do banco de dados
$query = "SELECT id, titulo, descricao, tecnologias, link_codigo, link_demo, data_realizacao FROM projetos";
$result = $conn->query($query);

// Associar uma imagem a cada projeto
$project_images = [
    5 => 'foto_3.png',
    6 => 'foto_7.png',
    7 => 'foto_11.png',
    // Adicione mais IDs e imagens conforme necessário
];
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .projects-section {
        padding: 50px 20px;
        text-align: center;
    }

    .projects-section h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 20px;
    }

    .projects-section p {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 40px;
    }

    .projects-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        justify-content: center;
        padding: 0 20px;
    }

    .project-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: left;
        transition: transform 0.3s ease;
    }

    .project-card:hover {
        transform: translateY(-5px);
    }

    .project-card img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-bottom: 2px solid #f4f4f4;
    }

    .project-card h2 {
        font-size: 1.5rem;
        color: #333;
        margin: 20px 0 10px;
        padding: 0 10px;
    }

    .project-card p {
        font-size: 1rem;
        color: #666;
        margin: 0 10px 15px;
    }

    .project-card ul {
        list-style: none;
        padding: 0;
        margin: 0 10px 15px;
    }

    .project-card ul li {
        font-size: 1rem;
        color: #777;
    }

    .project-link {
        display: inline-block;
        padding: 10px 20px;
        background-color: #00adb5;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        margin: 0 10px 20px;
        transition: background-color 0.3s ease;
    }

    .project-link:hover {
        background-color: #007f8a;
    }
</style>

<main>
    <section class="projects-section">
        <h1>Meus Projetos</h1>
        <p>Aqui estão alguns dos projetos que desenvolvi recentemente.</p>
        
        <div class="projects-gallery">
            <?php while ($project = $result->fetch_assoc()): ?>
                <div class="project-card">
                    <!-- Associa a imagem com base no ID do projeto -->
                    <?php 
                    // Usar a imagem associada ao ID do projeto
                    $imagemPrincipal = $project_images[$project['id']] ?? 'default.jpg'; // Usa a imagem do array ou a padrão
                    ?>
                    <img src="../assets/images/<?php echo $imagemPrincipal; ?>" alt="<?php echo htmlspecialchars($project['titulo']); ?>">
                    
                    <h2><?php echo htmlspecialchars($project['titulo']); ?></h2>
                    <p><?php echo htmlspecialchars($project['descricao']); ?></p>
                    <ul>
                        <li><strong>Tecnologias:</strong> <?php echo htmlspecialchars($project['tecnologias']); ?></li>
                        <li><strong>Data:</strong> <?php echo htmlspecialchars($project['data_realizacao']); ?></li>
                    </ul>
                    <!-- Link dinâmico para o projeto -->
                    <a href="ver.php?id=<?php echo $project['id']; ?>" class="project-link">Ver mais</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
