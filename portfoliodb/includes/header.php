<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfólio</title>
    <link rel="stylesheet" href="/portfoliodb/assets/css/style.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">Meu Portfólio</a>
    <nav>
        <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="../pages/about.php">Sobre</a></li>
            <li><a href="../pages/projects.php">Projetos</a></li>
            <li><a href="../pages/contact.php">Contato</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="../auth/logout.php">Sair</a></li>
            <?php else: ?>
                <li><a href="../auth/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
