<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {

            redirect("admin/auth/login", "refresh");
        }
        $this->load->model('Common_model');
        $this->load->model('User_model');
        $this->load->model('Wallet_model');
        $this->load->model('Betting_model');
        $this->load->library('Common_data');
    }

    public function index() {
        $user_id = $this->session->userdata("user_id");
        $data['noti'] = $this->common_data->get_notification_data();
        $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
        $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
        $data['perticular'] = $this->Common_model->getAll('perticulars', array('status' => 'active'))->result();
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/common/sidebar');
        $this->load->view('admin/wallet/list', $data);
        $this->load->view('admin/common/footer');
    }

    public function ajax_list() {
        $columns = array(
            0 => 'wallet_id',
            1 => 'user_id',
            2 => 'username',
            3 => 'first_name',
            4 => 'mobile',
            5 => 'curr_balance',
            6 => 'tot_credit',
            7 => 'tot_debit',
            8 => 'created_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $col = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Wallet_model->wallet_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $users = $this->Wallet_model->all_wallet_($limit, $start, $col, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $users = $this->Wallet_model->wallet_search($limit, $start, $search, $col, $dir);
            // echo $this->db->last_query();
            $totalFiltered = $this->Wallet_model->wallet_search_count($search);
        }

        $data = array();
        if (!empty($users)) {
            $i = 0;

            foreach ($users as $dat) {
                if ($dat->curr_balance > 0) {
                    $cbal = '<span class="badge badge-success badge-pill">' . $dat->curr_balance . '</span>';
                } elseif($dat->curr_balance < 0) {
                    $cbal = '<span class="badge badge-danger badge-pill">' . $dat->curr_balance . '</span>';
                }else{
                    $cbal = '<span class="badge badge-default badge-pill">' .$dat->curr_balance.'</span>';
                }
                $nestedData['wallet_id'] = $dat->wallet_id;
                $nestedData['user_id'] ='<span class="badge badge-default badge-pill"> ID-' . $dat->user_id.'</span>';
                $nestedData['username'] = $dat->username;
                $nestedData['first_name'] = $dat->first_name;
                $nestedData['mobile'] = $dat->mobile;
                $nestedData['curr_balance'] = $cbal;
                $nestedData['tot_credit'] = $dat->tot_credit;
                $nestedData['tot_debit'] = $dat->tot_debit;
                $nestedData['created_at'] = date("d-m-Y h:i", strtotime($dat->updated_at));
                $nestedData['action'] = '<a href="#" user-id="' . $dat->user_id . '" data-toggle="modal" data-target="#wallet_model" class="tabledit-edit-button btn btn-info waves-effect waves-light btn-sm wallet_data" data-toggle="tooltip" title="Credit/Debit" >C / D</a>&nbsp;'
                        . '<a href="' . base_url() . 'wallet/wallet_history/' . $dat->user_id . '" class="tabledit-edit-button btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" title="History" ><i class="fa fa-history" aria-hidden="true"></i></a>';
                $data[] = $nestedData;
                $i++;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }

    public function store_wallet_particular() {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error("Direct script access not allowed !");
        }
        $user_id = $this->input->post('user_id');
     
        $userData = $this->Common_model->getAll('wallet', array('user_id' => $user_id))->row();
        $userDetail = $this->Common_model->getAll('users', array('user_id' => $user_id))->row();

        $description = '';
        $updateAmt = '';
        if ($this->input->post('amount_type') == 'credit') {
            $description = 'Amount Credited By: ' . $this->session->userdata("user_name");
            $totalAmount = $userData->curr_balance + $this->input->post('curr_amount');
            $totalCr = $userData->tot_credit + $this->input->post('curr_amount');
            $wallelUpdateData['tot_credit'] = $totalCr;
            //$wallelUpdateData['tot_debit']='';
        } else if ($this->input->post('amount_type') == 'debit') {
            $description = 'Amount Debited By: ' . $this->session->userdata("user_name");
            $totalDr = $userData->tot_debit + $this->input->post('curr_amount');
            //$wallelUpdateData['tot_credit']='';
            $wallelUpdateData['tot_debit'] = $totalDr;
            if ($userData->curr_balance >= $this->input->post('curr_amount')) {
                $totalAmount = $userData->curr_balance - $this->input->post('curr_amount');
            } else {
                $totalAmount = '';
                $json_data = array(
                    "status" => 2,
                    "message" => 'Invalid Amount',
                );
                echo json_encode($json_data);
                exit;
            }
        }

        $wallet_particular_data = array(
            'user_id' => $this->input->post('user_id'),
            'amt_type' => $this->input->post('amount_type'),
            'pre_amount' => $userData->curr_balance,
            'current_amount' => round($totalAmount, 2),
            'trans_amount' => $this->input->post('curr_amount'),
            'particular' => $this->input->post('per_type'),
            'amt_description' => $description,
            'trans_status' => 'success',
            'added_by' => $user_id,
        );

        $result_history = $this->Common_model->insert('wallet_history', $wallet_particular_data);

        $wallelUpdateData['curr_balance'] = round($totalAmount, 2);

        $where = array('user_id' => $user_id);

        $result = $this->Common_model->update('wallet', $wallelUpdateData, $where);

        if ($result_history && $result) {
            $json_data = array(
                "status" => 1,
                "message" => 'success',
            );

            echo json_encode($json_data);
        } else {
            $json_data = array(
                "status" => 0,
                "message" => 'failed',
            );

            echo json_encode($json_data);
        }
    }

    function wallet_history($user_id = 0) {
        $data['noti'] = $this->common_data->get_notification_data();
        $data['user_detail'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->row();

        $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
        if ($user_id !== '') {
            //$user_id=$this->uri->segment(4);
            $data['user_id'] = $user_id;
            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/common/sidebar');
            $this->load->view('admin/wallet/wallet_history', $data);
            $this->load->view('admin/common/footer');
        } else {
            show_error('Direct script access not allowed !');
        }
    }

    public function ajax_wallet_historylist() {


        $columns = array(
            0 => 'hist_id',
            1 => 'amt_type',
            2 => 'pre_amount',
            3 => 'current_amount',
            4 => 'trans_amount',
            5 => 'amt_description',
            //7 => 'trans_status',
            7 => 'created_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $col = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";
        $user_id = $this->input->post('user_id');

        $totalData = $this->Wallet_model->all_wallet_hisory($user_id);

        $data = array();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $users = $this->Wallet_model->all_wallet_history($limit, $start, $col, $dir, $user_id);
        } else {
            $search = $this->input->post('search')['value'];

            $users = $this->Wallet_model->wallet_search_history($limit, $start, $search, $col, $dir, $user_id);
            $totalFiltered = $this->Wallet_model->wallet_history_search_count($search, $user_id);
        }

        if (!empty($users)) {
            $i = 0;

            foreach ($users as $dat) {

                $nestedData['hist_id'] = $dat->hist_id;
                $nestedData['amount_type'] = $dat->amt_type;
                $nestedData['pre_amount'] = $dat->pre_amount;
                $nestedData['current_amount'] = $dat->current_amount;
                $nestedData['trans_amount'] = $dat->trans_amount;
                $nestedData['amt_description'] = $dat->amt_description;
                //$nestedData['trans_status'] = $dat->trans_status;
                $nestedData['created_at'] = date("d-m-Y h:i", strtotime($dat->created_at));
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }

}
