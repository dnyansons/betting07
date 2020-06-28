<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Betting_model extends CI_Model {

    public function __construct() {

        $this->load->database();
        $this->load->model('Common_model');
    }

    function betting_count() {

        $this->db->select('a.*,b.*,d.*,a.created_at as created,a.updated_at as updated,e.league_name,e.home_name,e.away_name');
        $this->db->from('bets a');
        $this->db->join('sports c', 'c.sp_id=a.sport_on', 'left');
        $this->db->join('users b', 'b.user_id=a.user_id', 'left');
        $this->db->join('fancy_market d', 'd.fancy_id=a.fancy_id');
        $this->db->join('market e', 'e.match_id=a.match_id', 'left');

        if ($_POST['datefrom'] != '' && $_POST['dateto'] != '' || $_POST['datefrom'] != NULL) { // To process our custom input parameter
            $this->db->where('date(a.created_at) BETWEEN "' . date('Y-m-d', strtotime($_POST['datefrom'])) . '" and "' . date('Y-m-d', strtotime($_POST['dateto'])) . '"');
        }
        if ($_POST['bet_status'] != '') {

            $this->db->where("a.bet_status", $_POST['bet_status']);
        }
        if ($_POST['win_status'] != '') {

            $this->db->where("a.win_status", $_POST['win_status']);
        }
        if ($_POST['match_id'] != '') {
            $this->db->where("a.match_id", $_POST['match_id']);
        }
        if ($_POST['user_id'] != '') {
            $this->db->where("a.user_id", $_POST['user_id']);
        }

        $this->db->order_by('bet_id', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function all_betting_($limit, $start, $col, $dir) {
        $this->db->select('a.*,b.*,d.*,a.created_at as created,a.updated_at as updated,e.league_name,e.home_name,e.away_name');
        $this->db->from('bets a');
        $this->db->join('sports c', 'c.sp_id=a.sport_on', 'left');
        $this->db->join('users b', 'b.user_id=a.user_id', 'left');
        $this->db->join('fancy_market d', 'd.fancy_id=a.fancy_id');
        $this->db->join('market e', 'e.match_id=a.match_id', 'left');
        if ($_POST['datefrom'] != '' && $_POST['dateto'] != '' || $_POST['datefrom'] != NULL) { // To process our custom input parameter
            $this->db->where('date(a.created_at) BETWEEN "' . date('Y-m-d', strtotime($_POST['datefrom'])) . '" and "' . date('Y-m-d', strtotime($_POST['dateto'])) . '"');
        }

        if ($_POST['bet_status'] != '') {

            $this->db->where("a.bet_status", $_POST['bet_status']);
        }
        if ($_POST['win_status'] != '') {

            $this->db->where("a.win_status", $_POST['win_status']);
        }
        if ($_POST['match_id'] != '') {
            $this->db->where("a.match_id", $_POST['match_id']);
        }
        if ($_POST['user_id'] != '') {
            $this->db->where("a.user_id", $_POST['user_id']);
        }
        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('a.' . $col, $dir);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function betting_search($limit, $start, $search, $dir) {
        $this->db->select('*');
        $this->db->from('bets b');
        $this->db->join('sports c', 'c.sp_id=b.sport_on', 'left');
        $this->db->join('users a', 'a.user_id=b.user_id', 'left');
        $this->db->join('fancy_market d', 'd.fancy_id=b.fancy_id');
        $this->db->join('market e', 'e.match_id=b.match_id', 'left');
        if ($_POST['datefrom'] != '' && $_POST['dateto'] != '' || $_POST['datefrom'] != NULL) { // To process our custom input parameter
            $this->db->where('date(b.created_at) BETWEEN "' . date('Y-m-d', strtotime($_POST['datefrom'])) . '" and "' . date('Y-m-d', strtotime($_POST['dateto'])) . '"');
        }
        if ($_POST['bet_status'] != '') {

            $this->db->where("b.bet_status", $_POST['bet_status']);
        }
        if ($_POST['win_status'] != '') {

            $this->db->where("b.win_status", $_POST['win_status']);
        }
        if ($_POST['match_id'] != '') {
            $this->db->where("b.match_id", $_POST['match_id']);
        }
        if ($_POST['user_id'] != '') {
            $this->db->where("a.user_id", $_POST['user_id']);
        }
        $this->db->group_start();

        if ($search !== '') {
           // $this->db->or_like('a.username', $search);
            $this->db->or_like('a.mobile', $search);
            $this->db->or_like('b.sport_on', $search);
            $this->db->or_like('b.event_id', $search);
            $this->db->or_like('b.league_id', $search);
            $this->db->or_like('b.beton', $search);
            $this->db->or_like('b.odd', $search);
            $this->db->or_like('b.stake', $search);
            $this->db->or_like('b.expose', $search);
            $this->db->or_like('b.bet_status', $search);
            $this->db->or_like('b.win_status', $search);
            $this->db->or_like('b.created_at', $search);
            $this->db->or_like('b.updated_at', $search);
        }

        $this->db->group_end();
        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by("bet_id", 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function betting_search_count($search) {
        $this->db->select('*');
        $this->db->from('bets b');
        $this->db->join('sports c', 'c.sp_id=b.sport_on', 'left');
        $this->db->join('users a', 'a.user_id=b.user_id', 'left');
        $this->db->join('fancy_market d', 'd.fancy_id=b.fancy_id', 'left');
        $this->db->join('market e', 'e.match_id=b.match_id', 'left');
        if ($_POST['datefrom'] != '' && $_POST['dateto'] != '' || $_POST['datefrom'] != NULL) { // To process our custom input parameter
            $this->db->where('date(b.created_at) BETWEEN "' . date('Y-m-d', strtotime($_POST['datefrom'])) . '" and "' . date('Y-m-d', strtotime($_POST['dateto'])) . '"');
        }

        if ($_POST['bet_status'] != '') {
            $this->db->where("b.bet_status", $_POST['bet_status']);
        }
        if ($_POST['win_status'] != '') {
            $this->db->where("b.win_status", $_POST['win_status']);
        }
        if ($_POST['match_id'] != '') {
            $this->db->where("b.match_id", $_POST['match_id']);
        }
        if ($_POST['user_id'] != '') {
            $this->db->where("b.user_id", $_POST['user_id']);
        }
        $this->db->group_start();
        if ($search !== '') {
            //$this->db->or_like('a.username', $search);
            $this->db->or_like('a.mobile', $search);
            $this->db->or_like('b.sport_on', $search);
            $this->db->or_like('b.event_id', $search);
            $this->db->or_like('b.league_id', $search);
            $this->db->or_like('b.beton', $search);
            $this->db->or_like('b.odd', $search);
            $this->db->or_like('b.stake', $search);
            $this->db->or_like('b.expose', $search);
            $this->db->or_like('b.bet_status', $search);
            $this->db->or_like('b.win_status', $search);
            $this->db->or_like('b.created_at', $search);
            $this->db->or_like('b.updated_at', $search);
        }

        $this->db->group_end();

        $this->db->order_by('bet_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return null;
        }
    }

    function getBettingDetails() {
        $from_dt = date('Y-m-d');
        $from_time = '00:00:00';
        $to_time = '23:59:00';
        $this->db->select('home_name,away_name,match_id');
        $this->db->from('market');
        $this->db->where("match_time >=", strtotime($from_dt . ' ' . $from_time));
        $this->db->where("match_time <=", strtotime($from_dt . ' ' . $to_time));
        $this->db->order_by('m_id', 'desc');
        $this->db->limit(4);
        $market = $this->db->get()->result();
        $betting = array();
        foreach ($market as $mar) {
            $betting[] = array(
                'match_name' => $mar->home_name . ' Vs. ' . $mar->away_name,
                'tot_bets' => $this->Common_model->getAll('bets', array('match_id' => $mar->match_id))->num_rows(),
            );
        }
        return $betting;
    }

    function user_market_betting_count() {
        $this->db->select("*");
        $this->db->from('bets a');
        $this->db->join('users b', 'a.user_id=b.user_id', 'left');
        if ($_POST['fancy_id'] != '') {
            $this->db->where("a.fancy_id", $_POST['fancy_id']);
        }
        if ($_POST['datefrom'] != '' && $_POST['dateto'] != '' || $_POST['datefrom'] != NULL) { // To process our custom input parameter
            $this->db->where('date(a.created_at) BETWEEN "' . date('Y-m-d', strtotime($_POST['datefrom'])) . '" and "' . date('Y-m-d', strtotime($_POST['dateto'])) . '"');
        }
        if ($_POST['status'] != '') {
            if ($_POST['status'] == 'Win') {
                $this->db->where("win_status", $_POST['status']);
            } elseif ($_POST['status'] == 'Loss') {
                $this->db->where("a.win_status", $_POST['status']);
            } else {
                $this->db->where("a.bet_status", $_POST['status']);
            }
        }

        $this->db->order_by('bet_id', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function user_market_betting($limit, $start, $col, $dir) {
        $this->db->select("*");
        $this->db->from('bets a');
        $this->db->join('users b', 'a.user_id=b.user_id', 'left');
        if ($_POST['fancy_id'] != '') {
            $this->db->where("fancy_id", $_POST['fancy_id']);
        }
        if ($_POST['datefrom'] != '' && $_POST['dateto'] != '' || $_POST['datefrom'] != NULL) { // To process our custom input parameter
            $this->db->where('date(a.created_at) BETWEEN "' . date('Y-m-d', strtotime($_POST['datefrom'])) . '" and "' . date('Y-m-d', strtotime($_POST['dateto'])) . '"');
        }
        if ($_POST['status'] != '') {
            if ($_POST['status'] == 'Win') {
                $this->db->where("win_status", $_POST['status']);
            } elseif ($_POST['status'] == 'Loss') {
                $this->db->where("win_status", $_POST['status']);
            } else {
                $this->db->where("bet_status", $_POST['status']);
            }
        }

        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('bet_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function user_market_betting_search($limit, $start, $search, $dir) {
        $this->db->select("*");
        $this->db->from('bets a');
        $this->db->join('users b', 'a.user_id=b.user_id', 'left');
        if ($_POST['fancy_id'] != '') {
            $this->db->where("fancy_id", $_POST['fancy_id']);
        }
        if ($_POST['datefrom'] != '' && $_POST['dateto'] != '' || $_POST['datefrom'] != NULL) { // To process our custom input parameter
            $this->db->where('date(a.created_at) BETWEEN "' . date('Y-m-d', strtotime($_POST['datefrom'])) . '" and "' . date('Y-m-d', strtotime($_POST['dateto'])) . '"');
        }
        if ($_POST['status'] != '') {
            if ($_POST['status'] == 'Win') {
                $this->db->where("win_status", $_POST['status']);
            } elseif ($_POST['status'] == 'Loss') {
                $this->db->where("win_status", $_POST['status']);
            } else {
                $this->db->where("bet_status", $_POST['status']);
            }
        }
        $this->db->group_start();
        if (!empty($search)) {
            $this->db->like('mobile', $search);
            $this->db->or_like('username', $search);
            $this->db->or_like('fancy_name', $search);
            $this->db->or_like('bet_status', $search);
        }
        $this->db->group_end();
        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('bet_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function user_market_betting_search_count($search) {
        $this->db->select("*");
        $this->db->from('bets a');
        $this->db->join('users b', 'a.user_id=b.user_id', 'left');
        if ($_POST['fancy_id'] != '') {
            $this->db->where("fancy_id", $_POST['fancy_id']);
        }
        if ($_POST['datefrom'] != '' && $_POST['dateto'] != '' || $_POST['datefrom'] != NULL) { // To process our custom input parameter
            $this->db->where('date(a.created_at) BETWEEN "' . date('Y-m-d', strtotime($_POST['datefrom'])) . '" and "' . date('Y-m-d', strtotime($_POST['dateto'])) . '"');
        }
        if ($_POST['status'] != '') {
            if ($_POST['status'] == 'Win') {
                $this->db->where("win_status", $_POST['status']);
            } elseif ($_POST['status'] == 'Loss') {
                $this->db->where("win_status", $_POST['status']);
            } else {
                $this->db->where("bet_status", $_POST['status']);
            }
        }

        $this->db->group_start();
        if (!empty($search)) {
            $this->db->like('mobile', $search);
            $this->db->or_like('username', $search);
            $this->db->or_like('fancy_name', $search);
            $this->db->or_like('bet_status', $search);
        }
        $this->db->group_end();

        $this->db->order_by('bet_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return null;
        }
    }

}

?>