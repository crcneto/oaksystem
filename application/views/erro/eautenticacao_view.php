<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4 alert-danger text-center" style="font-weight: bolder; font-size: 1.8em;">
        É necessário estar logado para acessar esta função.
    </div>
    <div class="col-md-4"></div>
</div>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <form action="<?=  base_url()?>autenticacao/login" method="post">
            <div class="form-group">
                <label class="label">E-mail</label>
                <input type="text" name="login" class="form-control" />
            </div>
            <div class="form-group">
                <label class="label">Senha</label>
                <input type="password" name="senha" class="form-control" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Entrar</button>
            </div>
        </form>
    </div>
    <div class="col-md-4"></div>
</div>