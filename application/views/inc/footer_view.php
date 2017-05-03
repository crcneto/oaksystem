<footer class="footer text-center">
    <br>
    <br>
    <br>
    <span style="font-size: 0.6em;">Copyright&copy; OakSystems <?= date('Y') ?></span>
</footer>
<script>
    $(document).ready(function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    });
</script>
</body>
</html>
<?php unset($_SESSION['erro_mensagem']); ?>
<?php unset($_SESSION['sucesso_mensagem']); ?>