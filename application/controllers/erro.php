<?php

class Erro extends CI_Controller{
    public function index(){
        $this->load->view('inc/header_view');

        $this->load->view('erro/e404_view');

        $this->load->view('inc/footer_view');
    }
    
    public function  eautenticacao(){
        $this->load->view('inc/header_view');

        $this->load->view('erro/eautenticacao_view');

        $this->load->view('inc/footer_view');
    }
    public function  eacesso(){
        $this->load->view('inc/header_view');

        $this->load->view('erro/eacesso_view');

        $this->load->view('inc/footer_view');
    }
}
