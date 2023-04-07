<?php

class Dashboard_model extends  CI_Model
{

    public function fetchdata($data, $table, $where){
        $query = $this->db->select($data)
        ->from($table)
        ->where($where)
        ->get();
        return $query->result_array(); 
    }

    public function add_data_model($data){
        $query = $this->db->insert('user', $data);
        return $query;
    }

    public function fetch_edit_data($select, $table, $where){
        $query = $this->db->select($select)
                 ->from($table)
                 ->where($where['id'])
                 ->get();
        return $query->row_array();
    }

    public function update_data_modal($table, $data, $where){
        $query = $this->db->update($table, $data, $where);
        return $query;
    }

    public function delete_data_modal($table, $where){
        $query = $this->db->delete($table, $where);
        return $query;
    }

}
?>