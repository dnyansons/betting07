<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {

            redirect("login", "refresh");
        }

        $models = array('Common_model', 'User_model', 'Betting_model', 'Wallet_model', 'Market_model');
        $this->load->model($models);
        $this->load->library('Common_data');
    }

    public function index() {

        $data['noti'] = $this->common_data->get_notification_data();

        $user_id = $this->session->userdata("user_id");
        $role = $this->session->userdata("user_role");
        $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
        $data['tot_uses'] = $this->Common_model->getAll('users')->num_rows();
        $data['today_bets'] = $this->Common_model->getAll('bets', array('date(created_at)' => date('Y-m-d')))->num_rows();
        $data['today_agent'] = $this->Common_model->getAll('users', array('role' => 2, 'date(created_at)' => date('Y-m-d')))->num_rows();

        $data['tot_bets'] = $this->Betting_model->getBettingDetails();

        $data['currd_user'] = $this->User_model->getCurrentUsers();
        $data['wallet_bal'] = $this->Wallet_model->getCurrentWalletBal();
        $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
        $data['tot_match'] = $this->Market_model->getCurrentTotalMatch();
        $data['role'] = $this->Common_model->getAll('role', array('role_id' => $role))->row();
//  
        if ($role == 1) {
            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/common/sidebar');
            $this->load->view('admin/home', $data);
            $this->load->view('admin/common/footer', $data);
        }else{
            redirect('login');
        }
        
    }

}
