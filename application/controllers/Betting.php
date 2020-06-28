<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Betting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {

            redirect("admin/auth/login", "refresh");
        }
        $models = array('Common_model', 'User_model', 'Betting_model', 'Wallet_model');
        $this->load->model($models);
        $this->load->library('Common_data');
    }

    public function index() {
        $user_id = $this->session->userdata("user_id");
        $data['noti'] = $this->common_data->get_notification_data();
        $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
        $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
        $data['betting'] = $this->Common_model->getAll('perticulars', array('status' => 'active'))->result();
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/common/sidebar');
        $this->load->view('admin/betting/betting_list', $data);
        $this->load->view('admin/common/footer');
    }

    public function ajax_list() {

        if ($this->input->server("REQUEST_METHOD") == !'post') {
            show_error('Direct script access not allowed !');
        }

        $user_id = $this->session->userdata("user_id");

        $columns = array(
            0 => 'bet_id',
            1 => 'user_id',
            2 => 'username',
            3 => 'mobile',
            4 => 'sport_on',
            5 => 'event_id',
            6 => 'league_id',
            7 => 'beton',
            8 => 'odd',
            9 => 'stake',
            10 => 'expose',
            11 => 'bet_status',
            12 => 'win_status',
            13 => 'created_at',
            14 => 'updated_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $col = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Betting_model->betting_count($user_id);

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $users = $this->Betting_model->all_betting_($limit, $start, $col, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $users = $this->Betting_model->betting_search($limit, $start, $search, $col, $dir);
            // echo $this->db->last_query();
            $totalFiltered = $this->Betting_model->betting_search_count($search);
        }

        $data = array();
        if (!empty($users)) {
            $i = 0;

            foreach ($users as $dat) {

                $nestedData['bet_id'] = $dat->bet_id;
                $nestedData['user_id'] = 'ID-' . $dat->user_id;
                $nestedData['username'] = $dat->username;
                $nestedData['mobile'] = $dat->mobile;
                $nestedData['sport_on'] = $dat->sport_on;
                $nestedData['event_id'] = $dat->away_name . ' Vs. ' . $dat->away_name;
                $nestedData['league_id'] = $dat->league_name;
                $nestedData['beton'] = $dat->beton;
                $nestedData['odd'] = $dat->odd;
                $nestedData['stake'] = $dat->stake;
                $nestedData['expose'] = $dat->expose;
                $nestedData['bet_status'] = $dat->bet_status;
                if ($dat->win_status === 'Win') {
                    $nestedData['win_status'] = "<span class='label label-success'>$dat->win_status</span>";
                } else if ($dat->win_status === 'Loss') {
                    $nestedData['win_status'] = "<span class='label label-danger'>$dat->win_status</span>";
                }
                $nestedData['created_at'] = date("d-m-Y h:i", strtotime($dat->created));
                $nestedData['updated_at'] = date("d-m-Y h:i", strtotime($dat->updated));
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
