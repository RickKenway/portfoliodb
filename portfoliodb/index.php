<?php 
session_start();
include './includes/header.php'; 
?>
<main>
    <section style="text-align: center;">
        <h1 style="color: #1e1e2f; font-size: 2.5rem;">Bem-vindo ao meu Portfólio!</h1>
        <p style="margin-top: 10px; font-size: 1.2rem; color: #555;">
            Explore meus projetos, habilidades e entre em contato comigo!
        </p>

        <!-- Espaço para Adicionar Fotos (2 fotos) -->
        <div class="photo-gallery" style="margin-top: 20px;">
            <h2 style="color: #1e1e2f; font-size: 1.8rem;">Minhas Fotos</h2>
            <div style="display: flex; justify-content: center; gap: 20px;">
                <!-- Foto 1 -->
                <div style="width: 200px; height: 200px; background-color: #ddd; display: flex; align-items: center; justify-content: center;">
                    <img src="assets/images/foto_1.jpeg" alt="Foto 1" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <!-- Foto 2 -->
                <div style="width: 200px; height: 200px; background-color: #ddd; display: flex; align-items: center; justify-content: center;">
                    <img src="assets/images/foto_2.jpeg" alt="Foto 1" style="width: 100%; height: 100%; object-fit: cover; object-position: center right;">
                </div>
            </div>
        </div>

        <a href="./pages/projects.php" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #00adb5; color: #fff; text-decoration: none; border-radius: 5px; font-size: 1.1rem; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#007f8a'" onmouseout="this.style.backgroundColor='#00adb5'">Veja meus projetos</a>
    </section>
</main>
<?php include './includes/footer.php'; ?>
