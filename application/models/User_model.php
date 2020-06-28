<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_Model extends CI_Model {

    public function __construct() {

        $this->load->database();
    }

    //<==Playing Users (Role 3) Start==>

    function all_user_count_playing($block = 0) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`c.username` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->join('users c', 'c.user_id=a.created_by', 'left');
        if ($block > 0) {
            $this->db->where('a.status', 'Block');
        }
        return $this->db->get()->num_rows();
    }

    function all_user_playing($limit, $start, $col, $dir, $block = 0) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`a.created_by` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->limit($limit, $start);
        if ($block > 0) {
            $this->db->where('a.status', 'Block');
        }
        $this->db->order_by("a." . $col, $dir);
        return $this->db->get()->result();
    }

    function user_search_playing($limit, $start, $search, $col, $dir, $block = 0) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`a.created_by` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        if ($block > 0) {
            $this->db->where('a.status', 'Block');
        }
        $this->db->group_start();
        $this->db->or_like('a.username', $search);
        $this->db->or_like('a.first_name', $search);
        $this->db->or_like('a.last_name', $search);
        $this->db->or_like('a.mobile', $search);
        $this->db->or_like('a.email', $search);
        $this->db->or_like('a.status', $search);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->order_by("a." . $col, $dir);
        return $this->db->get()->result();
    }

    function user_search_count_playing($search, $block = 0) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`a.created_by` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        if ($block > 0) {
            $this->db->where('a.status', 'Block');
        }

        $this->db->group_start();
        $this->db->or_like('a.username', $search);
        $this->db->or_like('a.first_name', $search);
        $this->db->or_like('a.last_name', $search);
        $this->db->or_like('a.mobile', $search);
        $this->db->or_like('a.email', $search);
        $this->db->or_like('a.status', $search);
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }

    //<==Playing Users (Role 3) Ens==>
    //<==Agent Users  Start==>

    function agent_all_user_count_playing($user_id = 0) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`c.username` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->join('users c', 'c.user_id=a.created_by', 'left');
        $this->db->where('a.created_by', $user_id);
        return $this->db->get()->num_rows();
    }

    function agent_all_user_playing($limit, $start, $col, $dir, $user_id = 0) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`a.created_by` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->limit($limit, $start);
        $this->db->where('a.created_by', $user_id);
        $this->db->order_by("a." . $col, $dir);
        return $this->db->get()->result();
    }

    function agent_user_search_playing($limit, $start, $search, $col, $dir, $user_id = 0) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`a.created_by` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->where('a.created_by', $user_id);
        $this->db->group_start();
        $this->db->or_like('a.username', $search);
        $this->db->or_like('a.first_name', $search);
        $this->db->or_like('a.last_name', $search);
        $this->db->or_like('a.mobile', $search);
        $this->db->or_like('a.email', $search);
        $this->db->or_like('a.status', $search);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->order_by("a." . $col, $dir);
        return $this->db->get()->result();
    }

    function agent_user_search_count_playing($search, $user_id = 0) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`a.created_by` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->where('a.created_by', $user_id);
        $this->db->group_start();
        $this->db->or_like('a.username', $search);
        $this->db->or_like('a.first_name', $search);
        $this->db->or_like('a.last_name', $search);
        $this->db->or_like('a.mobile', $search);
        $this->db->or_like('a.email', $search);
        $this->db->or_like('a.status', $search);
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }

    //<==Agent  Users  End==>

    function get_state($id) {
        $this->db->select('id,name');
        $this->db->from('states');
        $this->db->where('country_id', $id);
        return $this->db->get()->result();
    }

    function get_admin_agent($user = 0) {
        $this->db->select('`a.user_id`,`a.username`,`a.first_name`,`a.last_name`,b.name');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->where('a.status', 'Active');
        if ($user > 0) {
            $this->db->where('a.user_id', $user);
        }
        $this->db->group_start();
        $this->db->where('a.role', 1);
        $this->db->or_where('a.role', 2);
        $this->db->group_end();
        return $this->db->get()->result();
    }

    function get_user_detail($user_id = '0') {
        $this->db->select('a.*,c.name as country_name,d.name as state_name');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->join('countries c', 'a.country=c.id');
        $this->db->join('states d', 'a.state=d.id');
        $this->db->where('a.user_id', $user_id);
        return $this->db->get()->row();
    }
    function get_agent_user_detail($user_id = '0',$agent_id=0) {
        $this->db->select('a.*,c.name as country_name,d.name as state_name');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->join('countries c', 'a.country=c.id');
        $this->db->join('states d', 'a.state=d.id');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.created_by', $agent_id);
        return $this->db->get()->row();
    }

    function getCurrentUsers() {
        $this->db->select('a.username,d.curr_balance,b.name as rol_name');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id', 'left');
        $this->db->join('wallet d', 'a.user_id=d.user_id', 'left');
        $this->db->where('date(a.created_at)', date('Y-m-d'));
        $this->db->order_by("a.user_id", "desc");
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    public function getUserInfoByEmail($email) {
        $q = $this->db->get_where('users', array('email' => $email), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $email . ')');
            return false;
        }
    }

    public function insertToken($email) {
        $token = substr(sha1(rand()), 0, 30);
        $date = date('Y-m-d');

        $string = array(
            'token' => $token,
            'user_id' => $email,
            'created' => $date
        );
        $query = $this->db->insert_string('tokens', $string);
        $this->db->query($query);
        return $token . $email;
    }

    public function isTokenValid($token) {
        $tkn = substr($token, 0, 30);
        $uid = substr($token, 30);

        $q = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn,
            'tokens.user_id' => $uid), 1);

        if ($this->db->affected_rows() > 0) {
            $row = $q->row();

            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d');
            $todayTS = strtotime($today);

            if ($createdTS != $todayTS) {
                return false;
            }

            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
        } else {
            return false;
        }
    }

    public function getUserInfo($id) {
        $q = $this->db->get_where('users', array('user_id' => $id), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return false;
        }
    }

    public function updatePassword($post) {
        $this->db->where('user_id', $post['user_id']);
        $this->db->update('users', array('password' => $post['password']));
        $success = $this->db->affected_rows();

        if (!$success) {
            error_log('Unable to updatePassword(' . $post['user_id'] . ')');
            return false;
        }
        return true;
    }

}

?>