<?php include '../includes/header.php'; ?>
<main>
    <section class="contact-section">
        <h1>Entre em Contato</h1>
        <p>Se você tem dúvidas, sugestões ou quer trabalhar comigo, envie uma mensagem!</p>
        
        <form action="#" method="post" class="contact-form">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" placeholder="Seu nome completo" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
            </div>

            <div class="form-group">
                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" rows="5" placeholder="Escreva sua mensagem aqui..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">Enviar Mensagem</button>
        </form>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
