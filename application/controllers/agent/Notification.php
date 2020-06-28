<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {

            redirect("auth/login", "refresh");
        }
        $this->load->model('Common_model');
        $this->load->model('Notification_model');
        $this->load->model('Wallet_model');
        $this->load->model('User_model');
        $this->load->library('Common_data');
    }

    public function index() {

        $user_id = $this->session->userdata("user_id");
        $data['noti'] = $this->common_data->get_notification_data();
        $up_status['status']='Read';
        $this->Common_model->update('notification',$up_status,array('status'=>'Unread'));
        $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
        $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
        $this->load->view('agent/common/header', $data);
        $this->load->view('agent/common/sidebar');
        $this->load->view('agent/notification_list');
        $this->load->view('agent/common/footer');
    }

    public function ajax_notification_list() {

        $columns = array(
            0 => '',
            1 => 'username',
            2 => 'title',
            3 => 'message',
            4 => 'created_at',
            5 => 'status'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Notification_model->all_notification_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $noti = $this->Notification_model->all_notification($limit, $start, $order, $dir);
            //echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $noti = $this->Notification_model->all_notification_search($limit, $start, $search, $dir);

            $totalFiltered = $this->Notification_model->all_notification_search_count($search);
        }
        $data = array();
        if (!empty($noti)) {
            $i = 1;
            foreach ($noti as $dat) {
                $nestedData['sr_no'] = $i;
                $nestedData['username'] = $dat->username;
                $nestedData['title'] = $dat->title;
                $nestedData['message'] = $dat->message;
                $nestedData['created_at'] = date('d M Y H:i', strtotime($dat->created_at));
                $nestedData['status'] = $dat->status;
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

}
