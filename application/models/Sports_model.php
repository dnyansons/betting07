<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sports_model extends CI_Model {

    public function __construct() {

        $this->load->database();
    }
    //<==Playing Users (Role 3) Start==>
    
    function sports_count() {
        $this->db->select('*');
        $this->db->from('sports a');
        return $this->db->get()->num_rows();
    }

    function all_sports_($limit, $start, $col, $dir) {
        $this->db->select('*');
        $this->db->from('sports a');
        $this->db->limit($limit, $start);
        $this->db->order_by("a.".$col,$dir);
        return $this->db->get()->result();
    }

    function sports_search($limit, $start, $search, $col, $dir) {
        $this->db->select('*');
        $this->db->from('sports a');
        $this->db->group_start();
        $this->db->or_like('a.sport_name', $search);
        $this->db->or_like('a.sport_status', $search);
        $this->db->or_like('a.created_at', $search);
        $this->db->group_end();
        return $this->db->get()->result();
    }

    function sports_search_count($search) {
        $this->db->select('*');
        $this->db->from('sports a');
        $this->db->group_start();
        $this->db->or_like('a.sport_name', $search);
        $this->db->or_like('a.sport_status', $search);
        $this->db->or_like('a.created_at', $search);
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }
  

}

?>