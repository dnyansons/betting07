<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model');
    }

    function user_report_count() {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`c.username` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->join('users c', 'c.user_id=a.created_by', 'left');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created_at) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created_at)<=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        if ($_POST['status'] != '') {
            $this->db->where("a.status", $_POST['status']);
        }
        if ($_POST['role'] != '') {
            $this->db->where("a.role", $_POST['role']);
        }

        return $this->db->get()->num_rows();
    }

    function all_user_report($limit, $start, $col, $dir, $block = 0) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`c.username` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->join('users c', 'c.user_id=a.created_by', 'left');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created_at) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created_at)<=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        if ($_POST['status'] != '') {
            $this->db->where("a.status", $_POST['status']);
        }
        if ($_POST['role'] != '') {
            $this->db->where("a.role", $_POST['role']);
        }
        $this->db->limit($limit, $start);
        $this->db->order_by('a.user_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function user_report_search($limit, $start, $search, $dir) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`c.username` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->join('users c', 'c.user_id=a.created_by', 'left');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created_at) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created_at)<=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        if ($_POST['status'] != '') {
            $this->db->where("a.status", $_POST['status']);
        }
        if ($_POST['role'] != '') {
            $this->db->where("a.role", $_POST['role']);
        }
        $this->db->group_start();
        if (!empty($search)) {
            $this->db->like('a.username', $search);
            $this->db->or_like('a.mobile', $search);
            $this->db->or_like('a.email', $search);
            $this->db->or_like('a.status', $search);
        }
        $this->db->group_end();
        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('a.user_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function user_report_search_count($search) {
        $this->db->select('a.`user_id`,a.`username`,b.`name` as role,`c.username` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->join('users c', 'c.user_id=a.created_by', 'left');

        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.created_at) >=", date('Y-m-d', strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.created_at)<=", date('Y-m-d', strtotime($_POST['dateto'])));
        }
        if ($_POST['status'] != '') {
            $this->db->where("a.status", $_POST['status']);
        }
        if ($_POST['role'] != '') {
            $this->db->where("a.role", $_POST['role']);
        }

        $this->db->group_start();
        if (!empty($search)) {
            $this->db->like('a.username', $search);
            $this->db->or_like('a.mobile', $search);
            $this->db->or_like('a.email', $search);
            $this->db->or_like('a.status', $search);
        }
        $this->db->group_end();

        $this->db->order_by('a.user_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return null;
        }
    }

    //Match Report _start
    function market_report_count() {
        $this->db->select("*,count(b.bet_id)tot_bets,m.match_id");
        $this->db->from('market m');
        $this->db->join('bets b', 'm.match_id=b.match_id', 'left');
        if ($_POST['datefrom'] != '') {
            $this->db->where("m.match_time >=", strtotime($_POST['datefrom']));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("m.match_time <=", strtotime($_POST['dateto']));
        }
        if ($_POST['status'] != '') {
            $this->db->where("m.m_status", $_POST['status']);
        }
        $this->db->group_by('m.match_id');
        $this->db->order_by('m.m_id', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function all_market_report($limit, $start, $col, $dir) {
        $this->db->select("*,count(b.bet_id)tot_bets,m.match_id");
        $this->db->from('market m');
        $this->db->join('bets b', 'm.match_id=b.match_id', 'left');

        if ($_POST['datefrom'] != '') {
            $this->db->where("match_time >=", strtotime($_POST['datefrom']));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("match_time <=", strtotime($_POST['dateto']));
        }
        if ($_POST['status'] != '') {
            $this->db->where("m_status", $_POST['status']);
        }

        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }
        $this->db->group_by('m.match_id');
        $this->db->order_by('m_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function market_report_search($limit, $start, $search, $dir) {
        $this->db->select("*,count(b.bet_id)tot_bets,m.match_id");
        $this->db->from('market m');
        $this->db->join('bets b', 'm.match_id=b.match_id', 'left');
        if ($_POST['datefrom'] != '') {
            $this->db->where("match_time >=", strtotime($_POST['datefrom']));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("match_time <=", strtotime($_POST['dateto']));
        }
        if ($_POST['status'] != '') {
            $this->db->where("m_status", $_POST['status']);
        }
        $this->db->group_start();
        if (!empty($search)) {
            $this->db->like('league_name', $search);
            $this->db->or_like('home_name', $search);
            $this->db->or_like('away_name', $search);
            $this->db->or_like('sport_id', $search);
        }
        $this->db->group_end();
        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }
        $this->db->group_by('m.match_id');
        $this->db->order_by('m_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function market_report_search_count($search) {
        $this->db->select("*,count(b.bet_id)tot_bets,m.match_id");
        $this->db->from('market m');
        $this->db->join('bets b', 'm.match_id=b.match_id', 'left');

        if ($_POST['datefrom'] != '') {
            $this->db->where("match_time >=", strtotime($_POST['datefrom']));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("match_time <=", strtotime($_POST['dateto']));
        }
        if ($_POST['status'] != '') {
            $this->db->where("m_status", $_POST['status']);
        }

        $this->db->group_start();
        if (!empty($search)) {
            $this->db->like('league_name', $search);
            $this->db->or_like('home_name', $search);
            $this->db->or_like('away_name', $search);
            $this->db->or_like('sport_id', $search);
            $this->db->or_like('m.match_id', $search);
        }
        $this->db->group_end();
        $this->db->group_by('m.match_id');
        $this->db->order_by('m_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return null;
        }
    }

    function getCurrentTotalMatch() {
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");
        $this->db->select('*');
        $this->db->from('market a');
        $this->db->where("a.match_time >=", strtotime(date('Y-m-d 00:00:00')));
        $this->db->where("a.match_time <=", strtotime(date('Y-m-d 23:59:59')));
        return $this->db->get()->num_rows();
    }

    function get_market_view($match_id = 0) {
        $this->db->select("a.fancy_id,a.fancy_market_name,a.result,a.match_id,a.fancy_market_id");
        $this->db->from('fancy_market a');
        $this->db->join('market b', 'b.match_id=a.match_id', 'left');
        $this->db->where('a.match_id', $match_id);
        $this->db->order_by('a.fancy_id', 'desc');
        $res = $this->db->get()->result();
        $pro = array();
        foreach ($res as $res_dat) {

            $pro[] = array(
                'market_name' => $res_dat->fancy_market_name,
                'tot_bets' => $this->Common_model->getAll('bets', array('fancy_id' => $res_dat->fancy_id))->num_rows(),
                'result' => $res_dat->result,
                'match_id' => $res_dat->match_id,
                'fancy_id' => $res_dat->fancy_id,
            );
        }
        if ($pro) {
            return $pro;
        }
    }

}
