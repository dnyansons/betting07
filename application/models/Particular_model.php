<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Particular_model extends CI_Model {

    public function __construct() {

        $this->load->database();
    }
    //<==Playing Users (Role 3) Start==>
    
    function particular_count() {
        $this->db->select('*');
        $this->db->from('perticulars a');
        return $this->db->get()->num_rows();
    }

    function all_particular_($limit, $start, $col, $dir) {
        $this->db->select('*');
        $this->db->from('perticulars a');
        $this->db->limit($limit, $start);
        $this->db->order_by("a.".$col,$dir);
        return $this->db->get()->result();
    }

    function particular_search($limit, $start, $search, $col, $dir) {
        $this->db->select('*');
        $this->db->from('perticulars a');
        $this->db->group_start();
        $this->db->or_like('a.per_name', $search);
        $this->db->or_like('a.status', $search);
        $this->db->or_like('a.created_at', $search);
        $this->db->group_end();
        return $this->db->get()->result();
    }

    function particular_search_count($search) {
        $this->db->select('*');
        $this->db->from('perticulars a');
        $this->db->group_start();
        $this->db->or_like('a.per_name', $search);
        $this->db->or_like('a.status', $search);
        $this->db->or_like('a.created_at', $search);
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }
  

}

?>