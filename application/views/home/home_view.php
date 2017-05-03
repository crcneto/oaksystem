<?php if (isset($erro_mensagem)) { ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 alert-danger">
            <?= $erro_mensagem ?>
        </div>
        <div class="col-md-4"></div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 text-center">
        <img src="<?= base_url() ?>public/img/carvalho.jpg" width="400" height="400"/>
    </div>
    <div class="col-md-3"></div>
</div>