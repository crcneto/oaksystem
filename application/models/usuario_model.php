<?php


class Usuario_model extends CI_Model{
    public function get($id = null){
        
        if($id === NULL){
            $this->db->order_by('nome');
            $q = $this->db->get('usuario');
        } else {
            $q = $this->db->get_where('usuario', ['id' => $id]);
        }
        
        return $q->result_array();
    }
    
    /**
     * @return array Retorna um array com o ID do usuário como índice e array com a tupla
     * 
     */
    public function getAllById(){
        $this->db->where('status', 2);
        $this->db->order_by('nome','ASC');
        $r = $this->db->get('usuario');
        $a = $r->result_array();
        $md = array();
        foreach ($a as $key => $value) {
            $md[$value['id']] = $value;
        }
        return $md;
    }
    /*
     * @usage
     */
    public function insert($data){
        $this->db->insert('usuario', $data);
        if($this->db->insert_id()>0){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * @usage 
     */
    public function update($data){
        $this->db->where(['id'=>$data['id']]);
        $this->db->update('usuario', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    public function delete($id){
        $this->db->delete('usuario', ['id'=>$id]);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function login($login, $senha){
            $q = $this->db->get_where('usuario', array(
                'email'=>  $login,
                'senha'=> md5($senha)
            ));
            return $q->result_array();
    }
}

