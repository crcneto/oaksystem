<?php session_start();?>
<!DOCTYPE html>
<html lang="br">
    <head>
        <title>.: OakSystems :.</title>
        <link rel="stylesheet" href="<?= base_url() ?>public/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?= base_url() ?>public/css/style.css" />
        <link rel="shortcut icon" href="<?= base_url() ?>public/img/oak.ico" />
        <meta charset="utf-8">
        <script src="<?= base_url() ?>public/js/jquery-3.1.1.min.js"></script>
        <script src="<?= base_url() ?>public/js/bootstrap.js"></script>
        <script src="<?= base_url() ?>public/js/jquery.maskMoney.min.js"></script>
        <script src="<?= base_url() ?>public/js/bootstrap-datepicker.js"></script>
        <script>
            $(document).ready(function(){
               $(".datepicker").datepicker({format: 'dd/mm/yyyy'});
               $(".money").maskMoney({'thousands':''});
            });
        </script>
    </head>
    <body role="document">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= base_url() ?>">OakSystems</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?= base_url() ?>">Inicial <span class="sr-only"></span></a></li>
                        <!--li><a href="#">Link</a></li-->
                        <?php if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] != NULL) { ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header text-center">Cadastros</li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?=  base_url()?>usuario">Usuário</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li class="dropdown-header text-center">Configurações</li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Config</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Financeiro <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">Carteira</li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?=  base_url()?>expenses">Despesas</a></li>

                                </ul>
                            </li>
                        <?php } ?>
                    </ul>

                    <!--Se usuário não estiver autenticado, exibe formulário de login-->
                    <?php if (!isset($_SESSION['autenticado'])) { ?>

                        <form class="navbar-form navbar-right" method="post" action="<?=  base_url()?>autenticacao/login">
                            <div class="form-group">
                                <input type="text" name="login" class="form-control" size="8" placeholder="Usuário">
                            </div>
                            <div class="form-group">
                                <input type="password" name="senha" class="form-control" size="8" placeholder="Senha">
                            </div>
                            <button type="submit" class="btn btn-success">Entrar</button>
                        </form>

                    <?php } ?>

                    <!-- Se usuário autenticado, exibe opções de usuário -->
                    <?php if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] != NULL) { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Perfil</a></li>
                                    <li><a href="#">Alterar senha</a></li>
                                    <li><a href="#">Mensageiro</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="autenticacao/logout">Sair</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="row">
            <br>
            <br>
            <br>
        </div>

        <?php if (isset($_SESSION['erro_mensagem'])) { ?>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 alert-danger text-center" style="font-weight: bolder; font-size: 1.5em;">
                    <?php echo $_SESSION['erro_mensagem']; ?>
                </div>
                <div class="col-md-2"></div>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['sucesso_mensagem'])) { ?>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 alert-success text-center"  style="font-weight: bolder; font-size: 1.5em;">
                    <?php echo $_SESSION['sucesso_mensagem']; ?>
                </div>
                <div class="col-md-2"></div>
            </div>
        <?php } ?>
