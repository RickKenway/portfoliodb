<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfólio</title>
    <style>
        /* Estilo do Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1e1e2f; /* Cor de fundo */
            padding: 10px 20px; /* Espaçamento interno */
            color: #fff; /* Cor do texto */
            position: sticky; /* Fixa o topo ao rolar a página */
            top: 0;
            z-index: 1000;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2); /* Sombra sutil */
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00adb5; /* Cor destacada */
            text-decoration: none;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
        }

        header nav ul li {
            position: relative;
        }

        header nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 1rem;
            transition: color 0.3s ease-in-out;
        }

        header nav ul li a:hover {
            color: #00adb5;
        }

        header nav ul li::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #00adb5;
            transition: width 0.3s ease;
        }

        header nav ul li:hover::after {
            width: 100%;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: center;
                padding: 15px;
            }

            header nav ul {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
<header>
    <a href="/portfoliodb/index.php" class="logo">Meu Portfólio</a>
    <nav>
        <ul>
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
</body>
</html>
