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
$query = "SELECT id, titulo, descricao, tecnologias, link_codigo, link_demo, data_realizacao, imagens FROM projetos";
$result = $conn->query($query);
?>

<main>
    <section class="projects-section">
        <h1>Meus Projetos</h1>
        <p>Aqui estão alguns dos projetos que desenvolvi recentemente.</p>
        
        <div class="projects-gallery">
            <?php while ($project = $result->fetch_assoc()): ?>
                <div class="project-card">
                    <!-- Exibindo a primeira imagem do campo JSON 'imagens' -->
                    <?php 
                    $imagens = json_decode($project['imagens'], true);
                    $imagemPrincipal = $imagens[0] ?? 'default.jpg'; // Exibe uma imagem padrão se o campo estiver vazio
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
