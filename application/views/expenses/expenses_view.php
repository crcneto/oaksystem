<hr>
<div class="row">
    <div class="col-md-4">
        <h4 class="text-center text-info" style="font-weight: bolder;">Selecione o mês e o ano para exibição</h4>
        <form action="<?= site_url() ?>expenses" method="post" class="form-inline">
            <div class="col-md-4">
                <label>Mês</label><br>
                <select name="mes" class="form-control">
                    <?php foreach ($meses as $key => $value) { ?>
                        <option value="<?= $key ?>" <?php
                        if ($key == $mes) {
                            echo "selected";
                        }
                        ?>><?= $value ?></option>
                            <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Ano</label><br>
                <select name="ano" class="form-control">
                    <?php for ($i = 2016; $i < 2020; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php
                        if ($i == date('Y')) {
                            echo "selected";
                        }
                        ?>><?php echo $i; ?></option>
                            <?php } ?>
                </select>
            </div>
            <div class="col-md-4"><br><button type="submit" class="btn btn-info">Selecionar</button></div>
        </form>
        <br>&nbsp;<br>
        <br>&nbsp;<br>
    </div>
    <div class="col-md-5">

        <h4 class="text-center text-info" style="font-weight: bolder;">Cadastrar despesa</h4>
        <div class="row">
            <form action="<?= site_url() ?>expenses/insert" method="post" class="form-inline">

                <div class="col-md-4">
                    <label>Categoria</label><br>
                    <select name="categoria" class="form-control">
                        <option value="1">Geral</option>
                    </select><br>
                    <label>Descrição</label>
                    <input type="text" name="descricao" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>Vencimento</label>
                    <input type="text" name="vencimento"  id="vencimento" class="form-control datepicker"/>
                    <br>
                    <label>Valor</label><br>
                    <input type="text" name="valor"  id="valordespesa" class="form-control money" />

                </div>
                <div class="col-md-4">
                    <label style="font-size: 0.8em">Nº de repetições (dia < 28)</label>
                    <input type="text" name="repetir" class="form-control" />
                    &nbsp;<br>
                    <button type="submit" class="btn btn-warning">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-3">
        <h3 class="text-center"  style="font-weight: bolder;">Total de Despesas: 
            <br>
            <span class="text-danger">R$&nbsp;<?= $totaldespesas ?></span>
        </h3>
        <h3 class="text-center"  style="font-weight: bolder;">Total de Pendências: 
            <br> 
            <span class="text-danger">R$&nbsp;<?= $totalpendentes ?></span>
        </h3>
        <br>&nbsp;
    </div>
</div>
<hr>
<div class="row">
    <h3 class="text-center text-info">Minhas despesas</h3>
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th>Vencimento</th>
                    <th>Pagar</th>
                    <th>Restaurar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($xp as $key => $value) { ?>
                    <tr>
                        <td><?= $value['descricao'] ?></td>
                        <td class="text-center"><?php //echo $value['categoria']; ?>Geral</td>
                        <td>R$&nbsp;<span class="money"><?= $value['valor'] ?></span></td>
                        <td class="text-center">
                            <?php 
                                $e = explode('-', $value['vencimento']);
                                echo $e[2] . "-" . $e[1] . "-" . $e[0];
                            ?>
                        </td>
                        <td class="text-center">
                            <form action="<?php echo site_url(); ?>expenses/pagar" id="form<?php echo $value['id']; ?>" method="post">
                                <input type="hidden" name="id" value="<?= $value['id'] ?>" />
                                <?php if ($value['pagamento'] == '') { ?>
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-usd"></span></button>
                                
                                </a>
                                <?php }?>
                            </form>
                        </td>
                        <td class="text-center">
                            <?php if ($value['pagamento'] != '') { ?>
                            <form action="<?php echo site_url(); ?>expenses/restaurar" method="post">
                                <input type="hidden" name="id" value="<?= $value['id'] ?>" />
                                <button class="btn btn-warning"><span class="glyphicon glyphicon-repeat"></span></button>
                            </form>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <form action="<?php echo site_url(); ?>expenses/delete" method="post">
                                <input type="hidden" name="id" value="<?= $value['id'] ?>" />
                                <button type="submit" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </form>
                        </td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-3"></div>
</div>