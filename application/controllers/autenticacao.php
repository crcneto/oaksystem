<?php

class Autenticacao extends CI_Controller{
    
    public function login(){
        session_start();
        $login = $this->input->post('login');
        $senha = $this->input->post('senha');
        if($login != null && $login != "" && $senha != null && $senha != "")
        {
            $this->load->model('usuario_model');
            $r = $this->usuario_model->login($login, $senha);
            if(count($r)>0){
                $user = $r[0];
                unset($user['senha']);
                $_SESSION['autenticado'] = "sim";
                $_SESSION['sucesso_mensagem'] = "Bem-vindo, ".$user['nome']."!";
                $_SESSION['usuario'] = $user;
            }else{
                unset($_SESSION["autenticado"]);
                $_SESSION["erro_mensagem"] = "Combinação de usuário e senha incorretos.";
            }
        }else{
            unset($_SESSION["autenticado"]);
            $_SESSION["erro_mensagem"] = "Campos obrigatórios não preenchidos.";
        }
        
        redirect('/');
    }
    
    public function logout(){
        session_start();
        session_destroy();
        redirect('/');
    }
}
