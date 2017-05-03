<?php

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
    }

    public function index() {
        $this->load->view('inc/header_view');

        if (!isset($_SESSION['autenticado'])) {
            session_destroy();
            redirect(base_url() . 'erro/eautenticacao');
        } elseif ($_SESSION['usuario']['administrador'] < 1) {
            redirect(base_url() . 'erro/eacesso');
        } else {

            //inicio
            
            //Carrega a Library Table do Framework 
            $this->load->library('table');

            //configura tabela
            $template = array(
                'table_open' => '<table class="table table-hover table-striped">',
                'thead_open' => '<thead>',
                'thead_close' => '</thead>',
                'heading_row_start' => '<tr>',
                'heading_row_end' => '</tr>',
                'heading_cell_start' => '<th>',
                'heading_cell_end' => '</th>',
                'tbody_open' => '<tbody>',
                'tbody_close' => '</tbody>',
                'row_start' => '<tr>',
                'row_end' => '</tr>',
                'cell_start' => '<td>',
                'cell_end' => '</td>',
                'row_alt_start' => '<tr>',
                'row_alt_end' => '</tr>',
                'cell_alt_start' => '<td>',
                'cell_alt_end' => '</td>',
                'table_close' => '</table>'
            );

            //aplica o tempplate
            $this->table->set_template($template);


            //define a table head
            $this->table->set_heading(array(
                'Nome', 'E-mail', 'Status', 'Admin', 'Alterar', 'Excluir'
            ));


            //Carrega os usuarios cadastrados no banco de dados
            $rs = $this->usuario_model->get();
            
            


            //Cria array tab para inserção dos dados
            $tab = array();


            //Preenchimento da tabela
            foreach ($rs as $row) {

                $tab[] = array(
                    //$row['id'], 
                    $row['nome'],
                    $row['email'],
                    $row['status'],
                    $row['administrador'],
                    '<form action="' . site_url('usuario/index') . '" id="form' . $row['id'] . '" method="post"><input type="hidden" name="id" value="' . $row['id'] . '"/> <a href="#" onclick="javascript:document.getElementById(\'form' . $row['id'] . '\').submit();"><i class="glyphicon glyphicon-edit"></i></a></form>',
                    '<a href="' . site_url('usuario/delete') . '/' . $row['id'] . '"><i class="glyphicon glyphicon-remove"></i></a>');
            }


            //Monta a tabela

            $this->table->_set_from_array($tab);


            //Gera a tabela

            $a = $this->table->generate();
            $data = array();

            //Prepara para passar p/ a view

            $data['tabela'] = $a;
            
            

            if ($this->input->post('id') != null) {
                $id = $this->input->post('id');
                $m = $this->usuario_model->get($id);
                $data['user'] = $m[0];
            } else {
                $data['user'] = array('id' => '', 'nome' => '', 'email' => '', 'status' => '', 'administrador' => '');
            }

            $this->load->view('usuario/usuario_view', $data);


            $this->load->view('inc/footer_view');
        }
    }

    public function get() {
        //$this->output->set_content_type('application_json');

        //$a = $this->municipio_model->get();
        //$this->output->set_output(json_encode($a));
        //print_r($a);
    }

    public function insert() {
        $this->load->library('form_validation');
        //$this->output->set_content_type('application_json');

        $this->form_validation->set_rules('email', 'email', 'required', array('required' => 'email é obrigatório.'));
        $this->form_validation->set_rules('senha', 'senha', 'required', array('required' => 'senha é obrigatório.'));

        if ($this->form_validation->run()) {

            $id = $this->input->post('id');
            $nome = $this->input->post('nome');
            $email = $this->input->post('email');
            $senha = $this->input->post('senha');
            $status = $this->input->post('status');
            $administrador = $this->input->post('administrador');


            $user = array(
                'id' => $id,
                'nome' => $nome,
                'email' => $email,
                'senha' => md5($senha),
                'status' => $status,
                'administrador' => $administrador
            );

            session_start();
            if ($this->input->post('id') == NULL || $this->input->post('id') == "") {
                unset($user['id']);
                if ($this->usuario_model->insert($user)) {
                    $_SESSION['sucesso_mensagem'] = "Cadastrado com sucesso.";
                } else {
                    $_SESSION['erro_mensagem'] = "Erro ao cadastrar.";
                }
            } else {
                if ($this->usuario_model->update($user)) {
                    $_SESSION['sucesso_mensagem'] = "Cadastro alterado com sucesso.";
                } else {
                    $_SESSION['erro_mensagem'] = "Erro ao alterar o cadastro.";
                }
            }


            redirect(site_url() . 'usuario');
        } else {
            session_start();
            $_SESSION['erro_mensagem'] = "Campos inválidos";
            redirect(site_url() . 'usuario');
        }
    }

    public function delete($id) {
        if ($id != null || $id != "") {
            try {
                if ($this->usuario_model->delete($id)) {
                    session_start();
                    $_SESSION['sucesso_mensagem'] = "Excluído com sucesso.";
                } else {
                    session_start();
                    $_SESSION['erro_mensagem'] = "Erro ao excluir.";
                }
            } catch (PostgresSQLException $e) {
                $_SESSION['erro_mensagem'] = "Erro ao excluir.";
            }
            redirect('usuario');
        }
    }
}