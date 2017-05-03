<?php


class Expenses_model extends CI_Model{
    
    public function get($usuario, $mes, $ano){
        $sql = 'select * from expenses where extract(month from vencimento)=? and extract(year from vencimento)=? and usuario=? order by vencimento ASC, descricao ASC';
        $q = $this->db->query($sql, array($mes, $ano, $usuario));
        
        return $q->result_array();
    }
    
    public function getSum($usuario, $mes, $ano){
        $sql = "select sum(valor) from expenses where usuario=? and extract(month from vencimento)=? and extract(year from vencimento)=?";
        $q = $this->db->query($sql, array($usuario, $mes, $ano));
        $r = $q->result_array();
        $valor = $r[0];
        return $valor['sum'];
    }
    public function getSumPagos($usuario, $mes, $ano){
        $sql = "select sum(valor) from expenses where usuario=? and extract(month from vencimento)=? and extract(year from vencimento)=? and pagamento is not null";
        $q = $this->db->query($sql, array($usuario, $mes, $ano));
        $r = $q->result_array();
        $valor = $r[0];
        return $valor['sum'];
    }
    public function getSumPendentes($usuario, $mes, $ano){
        $sql = "select sum(valor) from expenses where usuario=? and extract(month from vencimento)=? and extract(year from vencimento)=? and pagamento is null";
        $q = $this->db->query($sql, array($usuario, $mes, $ano));
        $r = $q->result_array();
        $valor = $r[0];
        return $valor['sum'];
    }


    public function insert($data){
        $this->db->insert('expenses', $data);
        if($this->db->insert_id()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function pagar($id){
        $this->db->where(['id'=>$id]);
        $this->db->set('pagamento', 'now()', false);
        $this->db->update('expenses');
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    public function restaurar($id){
        $this->db->where(['id'=>$id]);
        $this->db->set('pagamento', 'null', false);
        $this->db->update('expenses');
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function update($data){
        $this->db->where(['id'=>$data['id']]);
        $this->db->update('expenses', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    public function delete($id){
        $this->db->delete('expenses', ['id'=>$id]);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
}

