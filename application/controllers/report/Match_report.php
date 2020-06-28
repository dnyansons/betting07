<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Match_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {

            redirect("auth/login", "refresh");
        }
        $this->load->model('Common_model');
        $this->load->model('Report_model');
        $this->load->model('Wallet_model');
        $this->load->model('User_model');
        $this->load->library('Common_data');
    }

    public function index() {

        $user_id = $this->session->userdata("user_id");
        $data['noti'] = $this->common_data->get_notification_data();
        $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
        $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/common/sidebar');
        $this->load->view('admin/report/match_report_list');
        $this->load->view('admin/common/footer');
    }

    public function ajax_match_report_list() {

        $columns = array(
            0 => '',
            1 => 'sport_id',
            2 => 'match_id',
            3 => 'league_name',
            4 => 'home_name',
            5 => 'match_time',
            6 => '',
            7 => 'm_status',
            8 => 'time_status',
            9 => 'action',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Report_model->market_report_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $markets = $this->Report_model->all_market_report($limit, $start, $order, $dir);
             //echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $markets = $this->Report_model->market_report_search($limit, $start, $search, $dir);

            $totalFiltered = $this->Report_model->market_report_search_count($search);
        }
        //echo $this->db->last_query();
        $data = array();
        if (!empty($markets)) {
            $i = 0;
            foreach ($markets as $mar) {
                if ($mar->time_status == 0) {
                    $time_status = 'Pending';
                }
                if ($mar->time_status == 1) {
                    $time_status = 'Running';
                }

                if ($mar->time_status == 3) {
                    $time_status = 'Match End';
                }
                if ($mar->m_status == 'Active') {
                    $status = '<a onclick=change_status("' . $mar->m_id . '") class="badge badge-success badge-pill text-white">' . $mar->m_status . '</a>';
                    $action = '<a href="' . base_url() . 'market/set_market/view_market/' . $mar->m_id . '" class="btn btn-sm btn-warning btn-rounded">View Bets</a>';
                } elseif ($mar->m_status == 'Inactive') {
                    $status = '<a onclick=change_status("' . $mar->m_id . '") class="badge badge-danger  badge-pill text-white">' . $mar->m_status . '</a>';
                    $action = '<a href="' . base_url() . 'market/set_market/view_market/' . $mar->m_id . '" class="btn btn-sm btn-warning btn-rounded">View Bets</a>';
                } else {
                    $status = '<a onclick=change_status("' . $mar->m_id . '") class="badge badge-pink badge-pill text-white">' . $mar->m_status . '</a>';
                    $action = '--';
                }
                if (!empty($mar->league_name)) {
                    $league_name = $mar->league_name;
                } else {
                    $league_name = 'No Name';
                }


                $nestedData['sr_no'] = $i += 1;
                $nestedData['sport_id'] = $mar->sport_id;
                $nestedData['match_id'] = $mar->match_id;
                $nestedData['league_name'] = $league_name;
                $nestedData['home_name'] = $mar->home_name . ' Vs. ' . $mar->away_name;
                $nestedData['match_time'] = date('d-m-Y H:i', $mar->match_time);
                $nestedData['time_status'] = $time_status;
                $nestedData['tot_bets'] =$mar->tot_bets;
                $nestedData['m_status'] = $status;
                $nestedData['action'] = $action;
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
