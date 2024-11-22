<?php
session_start();
include '../includes/header.php';
?>

<main>
    <section style="text-align: center; margin-top: 20px;">
        <h1 style="color: #1e1e2f; font-size: 2.5rem; margin-bottom: 10px;">Sobre Mim</h1>
        <p style="font-size: 1.2rem; color: #555; margin-bottom: 20px;">
            Um pouco sobre minha formação, experiência e interesses.
        </p>
    </section>

    <section style="max-width: 800px; margin: 0 auto; padding: 20px; text-align: left;">
        <h2 style="color: #1e1e2f; font-size: 2rem; margin-bottom: 10px;">Formação Técnica</h2>
        <ul style="list-style: none; padding: 0; margin-bottom: 30px;">
            <li style="margin-bottom: 10px;">
                <strong>Curso: </strong> Análise e Desenvolvimento de Sistemas
            </li>
            <li style="margin-bottom: 10px;">
                <strong>Instituição: </strong> SENAI Centro de Tecnologia em Cerâmica Wildson Gonsalves
            </li>
            <li style="margin-bottom: 10px;">
                <strong>Período: </strong> 2021 - Atual
            </li>
        </ul>

        <h2 style="color: #1e1e2f; font-size: 2rem; margin-bottom: 10px;">Experiência Profissional</h2>
        <ul style="list-style: none; padding: 0; margin-bottom: 30px;">
            <li style="margin-bottom: 10px;">
                <strong>Cargo: </strong> CO-CEO
            </li>
            <li style="margin-bottom: 10px;">
                <strong>Empresa: </strong> Tecnobrain
            </li>
            <li style="margin-bottom: 10px;">
                <strong>Período: </strong> 2022 - Atual
            </li>
        </ul>

        <h2 style="color: #1e1e2f; font-size: 2rem; margin-bottom: 10px;">Habilidades Técnicas</h2>
        <ul style="list-style: none; padding: 0; margin-bottom: 30px;">
            <li style="margin-bottom: 10px;">HTML5, CSS3, JavaScript</li>
            <li style="margin-bottom: 10px;">PHP e MySQL</li>
            <li style="margin-bottom: 10px;">Git e Controle de Versionamento</li>
        </ul>

        <h2 style="color: #1e1e2f; font-size: 2rem; margin-bottom: 10px;">Áreas de Interesse</h2>
        <p style="font-size: 1.1rem; color: #555; margin-bottom: 30px;">
            Desenvolvimento Web, Inteligência Artificial, Ciência de Dados e Automação de Processos.
        </p>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
