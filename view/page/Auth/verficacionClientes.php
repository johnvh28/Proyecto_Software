<?php require_once "view/include/header_page.php" ?>
<div class="container mt-5">
    <h1 class="mb-4">Verificar tu cuenta</h1>

    <form method="post" action="index.php?c=page&a=VerificarUsuario">
        <div class="mb-3">
            <input type="text" name="correo" value="<?php echo $_GET['cliente'] ?>" hidden>
            <label for="codigo" class="form-label">Código:</label>
            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese su código" required>
            <div class="form-text">Ingrese el código proporcionado que ha sido enviado a correo electronico <strong><?php echo $_GET['cliente']; ?></strong> .</div>
        </div>
        <br>
        <!-- Puedes agregar más campos según tus necesidades -->

        <button type="submit" class="btn btn-primary mb-3">Enviar</button>
    </form>
</div>
<script>
    // Habilitar el botón de envío cuando el campo de código está completo y es válido
    document.getElementById('codigo').addEventListener('input', function() {
        var submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.disabled = this.value.trim() === '';
    });
</script>
<?php require_once "view/include/footer_page.php" ?>