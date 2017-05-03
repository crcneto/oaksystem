<?php

class Expenses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //carrega model EXPENSES
        $this->load->model('expenses_model');
    }

    private function verificaAutenticacao() {
        if (!isset($_SESSION['autenticado'])) {
            return false;
        } elseif ($_SESSION['autenticado'] == null) {
            return false;
        } elseif ($_SESSION['autenticado'] == '') {
            return false;
        } else {
            return true;
        }
    }

    private function erro($pagina, $erro) {
        $this->load->view('inc/header_view');
        $toView = array();
        $toView['erro_mensagem'] = $erro;

        $this->load->view($pagina, $toView);
        $this->load->view('inc/footer_view');
    }

    public function index() {

        //carrega cabeçalho
        $this->load->view('inc/header_view');


        $toView = array();

        //verifica se está autenticado
        if (!$this->verificaAutenticacao()) {
            $_SESSION['erro_mensagem'] = "É necessário estar logado para entrar neste módulo.";
        } else {
            //carrega usuário
            $user = $_SESSION['usuario'];

            //envia usuário p/ view
            $toView['usuario'] = $user;

            if (isset($_POST['mes'])) {
                $mes = $this->input->post('mes'); //$_POST['mes'];
            } else {
                $mes = date('m');
            }
            if (isset($_POST['ano'])) {
                $ano = $this->input->post('ano'); //$_POST['ano'];
            } else {
                $ano = date('Y');
            }
            $toView['mes'] = $mes;
            $toView['ano'] = $ano;
            $meses = [
                '1' => 'Janeiro',
                '2' => 'Fevereiro',
                '3' => 'Março',
                '4' => 'Abril',
                '5' => 'Maio',
                '6' => 'Junho',
                '7' => 'Julho',
                '8' => 'Agosto',
                '9' => 'Setembro',
                '10' => 'Outubro',
                '11' => 'Novembro',
                '12' => 'Dezembro'
            ];
            $toView['meses'] = $meses;
            $toView['hoje'] = date('d-m-Y');

            $toView['totaldespesas'] = $this->expenses_model->getSum($user['id'], $mes, $ano);
            $toView['totalpendentes'] = $this->expenses_model->getSumPendentes($user['id'], $mes, $ano);


            $toView['xp'] = $this->expenses_model->get($user['id'], $mes, $ano);
            $this->load->view('expenses/expenses_view', $toView);
        }

        $this->load->view('inc/footer_view');
    }

    public function pagar() {
        session_start();
        if (!$this->verificaAutenticacao()) {
            $toView = array();
            $toView['erro_mensagem'] = "É necessário ter sido autenticado para acessar esta página.";
            $this->load->view('inc/header_view');
            $this->load->view('home/home_view', $toView);
            $this->load->view('inc/footer_view');
        } else {
            if (isset($_POST['id'])) {
                $id = $this->input->post('id');
                if ($this->expenses_model->pagar($id)) {
                    $_SESSION['sucesso_mensagem'] = "Despesa paga.";
                } else {
                    $_SESSION['erro_mensagem'] = "Erro ao pagar.";
                }
                redirect(site_url() . 'expenses');
            } else {
                $_SESSION['erro_mensagem'] = "Identificador inválido.";
                redirect(site_url() . 'expenses');
            }
        }
    }
    public function restaurar() {
        session_start();
        if (!$this->verificaAutenticacao()) {
            $toView = array();
            $toView['erro_mensagem'] = "É necessário ter sido autenticado para acessar esta página.";
            $this->load->view('inc/header_view');
            $this->load->view('home/home_view', $toView);
            $this->load->view('inc/footer_view');
        } else {
            if (isset($_POST['id'])) {
                $id = $this->input->post('id');
                if ($this->expenses_model->restaurar($id)) {
                    $_SESSION['sucesso_mensagem'] = "Despesa restaurada.";
                } else {
                    $_SESSION['erro_mensagem'] = "Erro ao restaurar.";
                }
                redirect(site_url() . 'expenses');
            } else {
                $_SESSION['erro_mensagem'] = "Identificador inválido.";
                redirect(site_url() . 'expenses');
            }
        }
    }
    public function delete() {
        session_start();
        if (!$this->verificaAutenticacao()) {
            $toView = array();
            $toView['erro_mensagem'] = "É necessário ter sido autenticado para acessar esta página.";
            $this->load->view('inc/header_view');
            $this->load->view('home/home_view', $toView);
            $this->load->view('inc/footer_view');
        } else {
            if (isset($_POST['id'])) {
                $id = $this->input->post('id');
                if ($this->expenses_model->delete($id)) {
                    $_SESSION['sucesso_mensagem'] = "Despesa excluida.";
                } else {
                    $_SESSION['erro_mensagem'] = "Erro ao excluir.";
                }
                redirect(site_url() . 'expenses');
            } else {
                $_SESSION['erro_mensagem'] = "Identificador inválido.";
                redirect(site_url() . 'expenses');
            }
        }
    }

    public function insert() {
        session_start();
        if (!$this->verificaAutenticacao()) {
            $toView = array();
            $toView['erro_mensagem'] = "É necessário ter sido autenticado para acessar esta página.";
            $this->load->view('inc/header_view');
            $this->load->view('home/home_view', $toView);
            $this->load->view('inc/footer_view');
        }
        $usuario = $_SESSION['usuario']['id'];
        if (isset($_POST['descricao'])) {
            $descricao = $this->input->post('descricao');
        } else {
            $this->erro('expenses/expenses_view', 'Descrição é um campo obrigatório.');
        }
        if (isset($_POST['categoria'])) {
            $categoria = $this->input->post('categoria');
        } else {
            $categoria = 1;
        }
        if (isset($_POST['valor'])) {
            $valor = $this->input->post('valor');
        } else {
            $valor = 0;
        }

        if (isset($_POST['repetir']) && $_POST['repetir'] != '') {
            $repeat = $this->input->post('repetir');
        } else {
            $repeat = 0;
        }

        if ($repeat <= 0) {

            if (isset($_POST['vencimento']) && $_POST['vencimento'] != '') {
                $v = $this->input->post('vencimento');
                $vv = explode('/', $v);
                $vencimento = $vv[2] . "-" . $vv[1] . "-" . $vv[0];
                $m = $vv[1];
            } else {
                $vencimento = date('Y-m-d');
                $m = date('m');
            }
            $data = [
                'usuario' => $usuario,
                'descricao' => $descricao,
                'categoria' => $categoria,
                'valor' => $valor,
                'vencimento' => $vencimento,
            ];

            if ($this->expenses_model->insert($data)) {
                $_SESSION['sucesso_mensagem'] = "Despesa cadastrada.";
            } else {
                $_SESSION['erro_mensagem'] = "Erro ao cadastrar.";
            }
            redirect(site_url() . 'expenses');
        } else {

            if (isset($_POST['vencimento']) && $_POST['vencimento'] != '') {
                $v = $this->input->post('vencimento');
                $vv = explode('/', $v);
                if($vv[0]>28){
                    $vv[0] = 28;
                }
                $vencimento = $vv[2] . "-" . $vv[1] . "-" . $vv[0];
                $m = $vv[1];
                $a = $vv[2];
                $d = $vv[0];
            } else {
                $vencimento = date('Y-m-d');
                $m = date('m');
                $a = date('Y');
                if(date('d')>28){
                    $d = 28;
                }else{
                    $d = date('d');
                }
            }
            $result = array();
            $mm = $m;
            $aa = $a;
            $confirm = $repeat;
            for ($i = 1; $i <= $repeat; $i++) {
                $b = explode('-', $vencimento);
                $data = [
                    'usuario' => $usuario,
                    'descricao' => $descricao,
                    'categoria' => $categoria,
                    'valor' => $valor,
                    'vencimento' => $aa . "-" . $mm . "-" . $d,
                ];
                $mm++;
                if ($mm > 12) {
                    $mm = $mm - 12;
                    $aa++;
                }
                $this->expenses_model->insert($data);
                $confirm--;
            }
            if ($confirm < 1) {
                $_SESSION['sucesso_mensagem'] = "Despesa cadastrada.";
            } else {
                $_SESSION['erro_mensagem'] = "Erro ao cadastrar a despesa em todos os meses.";
            }
            redirect(site_url() . 'expenses');
        }
    }

}
