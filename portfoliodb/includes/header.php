<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfólio</title>
    <link rel="stylesheet" href="/portfoliodb/assets/css/style.css"> <!-- Caminho absoluto -->
</head>
<body>
<header>
    <!-- Use caminho absoluto para o logo -->
    <a href="/portfoliodb/index.php" class="logo">Meu Portfólio</a>
    <nav>
        <ul>
            <!-- Caminhos absolutos para os links -->
            <li><a href="/portfoliodb/index.php">Início</a></li>
            <li><a href="/portfoliodb/pages/about.php">Sobre</a></li>
            <li><a href="/portfoliodb/pages/projects.php">Projetos</a></li>
            <li><a href="/portfoliodb/pages/contact.php">Contato</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/portfoliodb/auth/logout.php">Sair</a></li>
            <?php else: ?>
                <li><a href="/portfoliodb/auth/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
