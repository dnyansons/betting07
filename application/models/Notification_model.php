<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {

    public function __construct() {

        $this->load->database();
    }

    function all_notification_count($block = 0) {
        $this->db->select('a.`title`,a.status,a.message,a.created_at,b.`username`');
        $this->db->from('notification a');
        $this->db->join('users b', 'a.user_id=b.user_id');
        $this->db->where('a.notification_to', 'admin');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created_at) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created_at)<=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        if ($_POST['status'] != '') {
            $this->db->where("a.status", $_POST['status']);
        }
        return $this->db->get()->num_rows();
    }

    function all_notification($limit, $start, $col, $dir) {
        $this->db->select('a.`title`,a.status,a.message,a.created_at,b.`username`');
        $this->db->from('notification a');
        $this->db->join('users b', 'a.user_id=b.user_id');
        $this->db->where('a.notification_to', 'admin');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created_at) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created_at)<=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        if ($_POST['status'] != '') {
            $this->db->where("a.status", $_POST['status']);
        }
        $this->db->order_by("a.noti_id", $dir);
        return $this->db->get()->result();
    }

    function all_notification_search($limit, $start, $search, $dir) {
        $this->db->select('a.`title`,a.status,a.message,a.created_at,b.`username`');
        $this->db->from('notification a');
        $this->db->join('users b', 'a.user_id=b.user_id');
        $this->db->where('a.notification_to', 'admin');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created_at) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created_at)<=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        if ($_POST['status'] != '') {
            $this->db->where("a.status", $_POST['status']);
        }
        $this->db->group_start();
        $this->db->or_like('b.username', $search);
        $this->db->or_like('a.title', $search);
        $this->db->or_like('a.message', $search);
        $this->db->or_like('a.status', $search);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->order_by("a.noti_id", $dir);
        return $this->db->get()->result();
    }

    function all_notification_search_count($search) {
        $this->db->select('a.`title`,a.status,a.message,a.created_at,b.`username`');
        $this->db->from('notification a');
        $this->db->join('users b', 'a.user_id=b.user_id');
        $this->db->where('a.notification_to', 'admin');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created_at) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created_at)<=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        if ($_POST['status'] != '') {
            $this->db->where("a.status", $_POST['status']);
        }
        $this->db->group_start();
        $this->db->or_like('b.username', $search);
        $this->db->or_like('a.title', $search);
        $this->db->or_like('a.message', $search);
        $this->db->or_like('a.status', $search);
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }

}

?>