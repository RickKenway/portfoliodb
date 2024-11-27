<?php
require_once '../config.php';

$error = ''; // Mensagens de erro

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = 'Por favor, preencha todos os campos.';
    } else {
        // Verifica se o e-mail existe no banco de dados
        $query = "SELECT id, senha FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verifica a senha
            if (password_verify($password, $user['senha'])) {
                // Senha correta, inicie a sessão e redirecione
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: ../index.php"); // Redirecionar para a página do painel
                exit();
            } else {
                $error = 'Senha incorreta.';
            }
        } else {
            $error = 'E-mail não encontrado.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #1e1e2f;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-section {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .login-section h1 {
            font-size: 2rem;
            color: #1e1e2f;
            margin-bottom: 15px;
        }

        .login-section .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .form-group label {
            font-size: 1rem;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #00adb5;
        }

        .btn-submit {
            padding: 10px 20px;
            background-color: #00adb5;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #007f8a;
        }

        .register-link, .forgot-password-link {
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .register-link a, .forgot-password-link a {
            color: #00adb5;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .register-link a:hover, .forgot-password-link a:hover {
            color: #007f8a;
        }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<main>
    <section class="login-section">
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post" class="login-form">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            </div>

            <button type="submit" class="btn-submit">Entrar</button>
        </form>
        <p class="register-link">Ainda não tem uma conta? <a href="register.php">Cadastre-se aqui</a>.</p>
        <p class="forgot-password-link">Esqueceu sua senha? <a href="forgot_password.php">Recupere-a aqui</a>.</p>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
</body>
</html>
