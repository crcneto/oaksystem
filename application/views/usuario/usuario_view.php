<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <h3 class="text-center">Cadastro de Usuários</h3>

        <form action="<?= site_url('usuario/insert') ?>" method="post">
            <div class="form-group">
                <div class="col-md-4">
                    <label class="control-label">Nome</label>
                    <br>
                    <input class="form-control" name="nome" type="text" value="<?php if (isset($user['nome'])) {echo $user['nome'];} ?>"/>
                    <br>
                    <label class="control-label">E-mail</label>
                    <br>
                    <input class="form-control" name="email" type="text" value="<?php if (isset($user['email'])) {echo $user['email'];} ?>"/>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Administrador?</label>
                    <br>
                    <select class="form-control" name="administrador">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                    <br>
                    <label class="control-label">Senha</label>
                    <br>
                    <input type="password" name="senha" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label class="control-label">Status</label>&nbsp;<span title="Quando ativo, o usuário se torna selecionável. Quando desativado, se torna inacessível" data-toggle="tooltip" data-placement="top" ><i class="glyphicon glyphicon-question-sign"></i></span>
                    
                    <select class="form-control" name="status">
                        <option value="2">Ativo</option>
                        <option value="0">Desativado</option>
                    </select>
                    <br>
                    <?php if (isset($user['id'])) { ?>
                    <input type="hidden" name="id" value="<?php if (isset($user['id'])) {echo $user['id'];} ?>"/>
<?php } ?>
                    <button type="submit" class="btn btn-success col-md-12">Cadastrar</button>
                </div>
                
                

            </div>
        </form>
        <hr>
    </div>

    <div class="col-md-3"></div>
</div>
<hr>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <h3 class="text-center">Usuários Cadastrados</h3>
        <?php echo $tabela; ?>
    </div>
    <div class="col-md-3"></div>
</div>