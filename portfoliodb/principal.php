<?php
require_once './includes/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}
?>

<?php include './includes/header.php'; ?>
<main>
    <h1>Área protegida</h1>
    <p>Bem-vindo, usuário autenticado!</p>
</main>
<?php include './includes/footer.php'; ?>
