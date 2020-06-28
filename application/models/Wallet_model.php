<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wallet_model extends CI_Model {

    public function __construct() {

        $this->load->database();
        $this->load->model('Common_model');
    }

    //<==Playing Users (Role 3) Start==>

    function wallet_count() {
        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('wallet c', 'c.user_id=a.updated_at', 'left');
        $this->db->join('role b', 'b.role_id=a.role', 'left');
        return $this->db->get()->num_rows();
    }

    function all_wallet_hisory($user_id) {
        $this->db->select('*');
        $this->db->from('wallet_history a');
        $this->db->where('user_id',$user_id);
        return $this->db->get()->num_rows();
    }

    function all_wallet_($limit, $start, $col, $dir) {
        $this->db->select('a.`user_id`,b.`wallet_id`,c.`name`,a.`username`,b.`curr_balance`,b.`tot_credit` ,b.`tot_debit`,b.`updated_at` ,`a.created_by` ,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('wallet b', 'a.user_id=b.user_id', 'left');
        $this->db->join('role c', 'c.role_id=a.role', 'left');
        $this->db->limit($limit, $start);
        if ($col == 'wallet_id' || $col == 'curr_balance' || $col == 'tot_credit' || $col == 'tot_debit') {
            $this->db->order_by("b." . $col, $dir);
        } else {
            $this->db->order_by("a." . $col, $dir);
        }

        return $this->db->get()->result();
    }

    function all_wallet_history($limit, $start, $col, $dir, $user_id) {
        $where = array('a.user_id' => $user_id);
        $this->db->select('a.`user_id`,a.`hist_id`,a.`amt_type`,a.`pre_amount`,a.`current_amount`,a.`trans_amount` ,a.`trans_status`,a.`amt_description`,`a.created_at`');
        $this->db->from('wallet_history a');
        $this->db->where($where);
        $this->db->limit($limit, $start);
        $this->db->order_by("a." . $col, $dir);

        return $this->db->get()->result();
    }

    function wallet_search($limit, $start, $search, $col, $dir) {
        $this->db->select('a.`user_id`,b.`wallet_id`,c.`name`,a.`username`,b.`curr_balance` ,b.`tot_credit`,b.`tot_debit`,b.`updated_at`,`a.created_by`,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('wallet b', 'a.user_id=b.user_id');
        $this->db->join('role c', 'c.role_id=a.role', 'left');
        $this->db->group_start();
        $this->db->or_like('a.username', $search);
        $this->db->or_like('a.first_name', $search);
        $this->db->or_like('a.last_name', $search);
        $this->db->or_like('a.mobile', $search);
        $this->db->or_like('a.email', $search);
        $this->db->or_like('a.status', $search);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->order_by("b." . $col, $dir);
        return $this->db->get()->result();
    }

    function wallet_search_history($limit, $start, $search, $col, $dir, $user_id) {
        $this->db->select('a.`hist_id`,a.`user_id`,a.`amt_type`,a.`pre_amount`,a.`current_amount`,a.`trans_amount`,a.`trans_status`,a.`amt_description`,`a.created_at`');
        $this->db->from('wallet_history a');
        if ($user_id !== '') {
            $this->db->where('a.user_id', $user_id);
        }
        $this->db->group_start();
        $this->db->or_like('a.amt_type', $search);
        $this->db->or_like('a.pre_amount', $search);
        $this->db->or_like('a.current_amount', $search);
        $this->db->or_like('a.trans_amount', $search);
        $this->db->or_like('a.trans_status', $search);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->order_by("a." . $col, $dir);
        return $this->db->get()->result();
    }

    function wallet_search_count($search) {
        $this->db->select('a.`user_id`,b.`wallet_id`,a.`username`,`a.created_by` as under,`a.first_name`,`a.last_name`,a.`mobile`,a.`email`,a.`created_at`,a.`status`');
        $this->db->from('users a');
        $this->db->join('wallet b', 'a.user_id=b.user_id');
        $this->db->join('role c', 'c.role_id=a.role', 'left');
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

    function wallet_history_search_count($search, $user_id) {
        $where = array('user_id' => $user_id);
        $this->db->select('a.`hist_id`,a.`user_id`,a.`amt_type`,a.`pre_amount`,a.`current_amount`,a.`trans_amount`,a.`trans_status`,`a.created_at`');
        $this->db->from('wallet_history a');
        if ($user_id != '') {
            $this->db->where('a.user_id', $user_id);
        }
        $this->db->group_start();
        $this->db->or_like('a.amt_type', $search);
        $this->db->or_like('a.pre_amount', $search);
        $this->db->or_like('a.current_amount', $search);
        $this->db->or_like('a.trans_amount', $search);
        $this->db->or_like('a.trans_status', $search);
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }

    function getCurrentWalletBal() {
        $this->db->select('sum(curr_balance) as total_bal');
        $this->db->from('wallet a');
        $this->db->where('date(a.updated_at)', date('Y-m-d'));
        return $this->db->get()->row();
    }

    function getTotalWalletBal() {
        $this->db->select('sum(curr_balance) as total_bal');
        $this->db->from('wallet a');
        return $this->db->get()->result();
    }
    function getTotalWalletBal_agent() {
        $this->db->select('curr_balance as total_bal');
        $this->db->from('wallet a');
        $this->db->where('user_id',$this->session->userdata("user_id"));
        return $this->db->get()->result();
    }

    //Bet Amount Credited to Account
    function bet_amount_credited($user_id, $bet_id, $win_amt, $win_on) {

        //check User Active 
        $ch = $this->Common_model->getAll('users', array('user_id' => $user_id, 'status' => 'Active'))->num_rows();
        if ($ch == 1) {
            if ($win_amt > 0) {
                $userWallet = $this->Common_model->getAll('wallet', array('user_id' => $user_id))->row();
                $totalAmount = $win_amt + $userWallet->curr_balance;

                $upWallet['curr_balance'] = $totalAmount;
                $upWallet['updated_at'] = date('Y-m-d H:i:s');
                $up = $this->Common_model->update('wallet', $upWallet, array('user_id' => $user_id));
                if ($up) {
                    //Wallet History
                    $wallet_particular_data = array(
                        'user_id' => $user_id,
                        'amt_type' => 'credit',
                        'pre_amount' => $userWallet->curr_balance,
                        'current_amount' => round($totalAmount, 2),
                        'trans_amount' => $win_amt,
                        'amt_description' => 'Win on  ' . $win_on,
                        'trans_status' => 'success',
                        'added_by' => 1,
                    );
                    $result_history = $this->Common_model->insert('wallet_history', $wallet_particular_data);
                }
            }
        }
    }

}

?>