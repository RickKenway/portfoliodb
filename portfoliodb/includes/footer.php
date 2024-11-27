<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfólio</title>
    <style>
        /* Estilo do Footer */
        footer {
            background-color: #1e1e2f; /* Cor de fundo */
            color: #fff; /* Cor do texto */
            text-align: center; /* Centraliza o conteúdo */
            padding: 15px 20px; /* Espaçamento interno */
            font-size: 0.9rem;
            margin-top: 20px;
            border-top: 2px solid #00adb5; /* Linha decorativa */
        }

        footer .social-icons {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 15px; /* Espaçamento entre os links */
        }

        footer .social-icons a {
            text-decoration: none;
            color: #00adb5; /* Cor destacada */
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        footer .social-icons a:hover {
            color: #fff; /* Efeito hover para destacar */
        }

        @media (max-width: 768px) {
            footer .social-icons {
                flex-direction: column; /* Links empilhados em telas menores */
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <footer>
        <p>&copy; 2024 Meu Portfólio. Todos os direitos reservados.</p>
        <div class="social-icons">
            <a href="https://www.linkedin.com/in/rick-luis-985109256/" target="_blank">LinkedIn</a>
            <a href="https://github.com/RickKenway" target="_blank">GitHub</a>
        </div>
    </footer>
</body>
</html>
