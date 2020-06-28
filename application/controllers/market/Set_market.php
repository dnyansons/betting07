<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Set_market extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {

            redirect("auth/login", "refresh");
        }
        $this->load->model('Common_model');
        $this->load->model('Market_model');
        $this->load->model('Wallet_model');
        $this->load->model('Betting_model');
        $this->load->library('Common_data');
    }

    public function index() {

        $user_id = $this->session->userdata("user_id");
        $data['noti'] = $this->common_data->get_notification_data();
        $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
        $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/common/sidebar');
        $this->load->view('admin/market/set_market_list');
        $this->load->view('admin/common/footer');
    }

    public function ajax_market_list() {

        $columns = array(
            0 => '',
            1 => 'sport_id',
            2 => 'match_id',
            3 => 'league_name',
            4 => 'home_name',
            5 => 'match_time',
            6 => 'm_status',
            7 => 'time_status',
            8 => 'action',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Market_model->market_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $markets = $this->Market_model->all_market($limit, $start, $order, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $markets = $this->Market_model->market_search($limit, $start, $search, $dir);

            $totalFiltered = $this->Market_model->market_search_count($search);
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
                if ($mar->time_status == 2) {
                    $time_status = 'TO BE FIXED';
                }
                if ($mar->time_status == 3) {
                    $time_status = 'Match End';
                }
                if ($mar->time_status == 4) {
                    $time_status = 'Postponed';
                }
                if ($mar->time_status == 5) {
                    $time_status = 'Cancelled';
                }
                if ($mar->m_status == 'Active') {
                    $status = '<a onclick=change_status("' . $mar->m_id . '") class="badge badge-success badge-pill text-white">' . $mar->m_status . '</a>';
                    $action = '<a href="' . base_url() . 'market/set_market/view_market/' . $mar->m_id . '" class="btn btn-sm btn-warning btn-rounded">View Bets</a>';
                } elseif ($mar->m_status == 'Inactive') {
                    $status = '<a onclick=change_status("' . $mar->m_id . '") class="badge badge-danger  badge-pill text-white">' . $mar->m_status . '</a>';
                    $action = '<a href="' . base_url() . 'market/set_market/view_market/' . $mar->m_id . '" class="btn btn-sm btn-warning btn-rounded">View Bets</a>';
                }
                elseif ($mar->m_status == 'End') {
                    $status = '<a onclick=change_status("' . $mar->m_id . '") class="badge badge-danger  badge-pill text-white">' . $mar->m_status . '</a>';
                    $action = '<a href="' . base_url() . 'market/set_market/view_market/' . $mar->m_id . '" class="btn btn-sm btn-warning btn-rounded">View Bets</a>';
                }else {
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

    function check_league_status() {
        $m_id = $this->input->post('m_id');
        $this->db->select('m_status,sport_id,match_id,time_status');
        $this->db->from('market');
        $this->db->where('m_id', $m_id);
        $status_q = $this->db->get()->row_array();
        $status = $status_q['m_status'];
        $match_id = $status_q['match_id'];
        $time_status = $status_q['time_status'];
        $str = '<div class="form-group row"><label class="col-sm-4 col-form-label">Current Status</label><div class="col-sm-8">
<input type="hidden" name="m_id" value="' . $m_id . '">                        
<input type="hidden" name="match_id" value="' . $match_id . '">                        
<input type="hidden" name="time_status" value="' . $time_status . '">                        
<select name="m_status" class="form-control">';
        $str.='<option value="New"';
        if ($status == 'New') {
            $str.= 'selected';
        }
        $str.='>New</option>';
        $str.='<option value="Active"';
        if ($status == 'Active') {
            $str.= 'selected';
        }
        $str.='>Active</option>';

        $str.='<option value="Inactive"';
        if ($status == 'Inactive') {
            $str.= 'selected';
        }
        $str.='>Inactive</option>';
        
        $str.='<option value="End"';
        if ($status == 'End') {
            $str.= 'selected';
        }
        $str.='>End</option>';
        $str.='</select>
                    </div></div>';
        echo $str;
    }

    function update_league_status() {
        $status = $this->input->post('m_status');
        $m_id = $this->input->post('m_id');
        $match_id = $this->input->post('match_id');
        $time_status = $this->input->post('time_status');
        $up['m_status'] = $status;
        $ch = $this->Common_model->update('market', $up, array('m_id' => $m_id));
        if ($ch) {
            if ($status == 'Active' && $time_status == 1) {
                //Hit Contune for Live Match
               
            }
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Status Update Successfully aganist Sport ID : #" . $match_id . " !
                          </div>";
        } else {
            $message = "<div class='alert alert-info alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Info !</strong> No Changes !
                          </div>";
        }
        $this->session->set_flashdata("message", $message);
        redirect("market/set_market");
    }

    function view_market($m_id = 0) {
        $data['noti'] = $this->common_data->get_notification_data();
        if ($m_id > 0) {
            $data['market'] = $this->Common_model->getAll('market', array('m_id' => $m_id))->row();
            if ($data['market']) {
                $data['mk_view'] = $this->Market_model->get_market_view($data['market']->match_id);
                $this->load->view('admin/common/header', $data);
                $this->load->view('admin/common/sidebar');
                $this->load->view('admin/market/view_market', $data);
                $this->load->view('admin/common/footer');
            } else {
                redirect("market/set_market");
            }
        } else {
            redirect("market/set_market");
        }
    }

    function get_market_view() {
        $match_id = $this->input->post('match_id');
        $ch = $this->Common_model->getAll('market', array('match_id' => $match_id))->num_rows();
        if ($ch > 0) {
            $mk_view = $this->Market_model->get_market_view($match_id);
            if (!empty($mk_view)) {
                echo json_encode($mk_view);
            }
        } else {
            redirect("market/set_market");
        }
    }

    function user_market_bets($fancy_id = 0) {
        $data['noti'] = $this->common_data->get_notification_data();
        $ch = $this->Common_model->getAll('fancy_market', array('fancy_id' => $fancy_id))->num_rows();
        if ($ch > 0) {
            $data['fancy_market_info'] = $this->Common_model->getAll('fancy_market', array('fancy_id' => $fancy_id))->row();
            $data['fancy_id'] = $fancy_id;
            $this->load->view('admin/common/header', $data);
            $this->load->view('admin/common/sidebar');
            $this->load->view('admin/market/view_bets', $data);
            $this->load->view('admin/common/footer');
        } else {
            redirect("market/set_market");
        }
    }

    function user_market_bets_ajax_list() {

        $columns = array(
            0 => '',
            1 => 'username',
            2 => 'mobile',
            3 => 'fancy_name',
            4 => 'odds',
            5 => 'stake',
            6 => 'bet_amount',
            9 => 'win_status',
            8 => 'bet_status',
            9 => 'created_at',
            10 => 'updated_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Betting_model->user_market_betting_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $markets = $this->Betting_model->user_market_betting($limit, $start, $order, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $markets = $this->Betting_model->user_market_betting_search($limit, $start, $search, $dir);

            $totalFiltered = $this->Betting_model->user_market_betting_search_count($search);
        }
        //echo $this->db->last_query();
        $data = array();
        if (!empty($markets)) {
            $i = 0;
            foreach ($markets as $mar) {
                $nestedData['sr_no'] = $i += 1;
                $nestedData['username'] = $mar->username;
                $nestedData['mobile'] = $mar->mobile;
                $nestedData['fancy_name'] = $mar->fancy_name;
                $nestedData['odd'] = $mar->odd;
                $nestedData['stake'] = $mar->stake;
                $nestedData['win_amount'] = number_format($mar->stake * $mar->odd, 2);
                $nestedData['bet_status'] = $mar->bet_status;
                $nestedData['win_status'] = $mar->win_status;
                $nestedData['created_at'] = $mar->created_at;
                $nestedData['updated_at'] = $mar->updated_at;
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

    function test() {
        echo date('Y-m-d H:i:s', 1571176800) . '<br>';
        
    }
    function test2(){
        echo'Success';
    }

//    function test() {
//        $i = 1;
//        $date = "2019-10-01";
//        //$date1 = str_replace('-', '/', $date);
//        
//        while ($i <= 1000) {
//            $day = '+' . $i . ' day';
//            $data['sport_id'] = '1000' . $i;
//            $data['match_time'] =strtotime(date('Y-m-d', strtotime($date . "+$i days")));
//            $data['league_id'] = '--';
//            $data['league_name'] = 'Cricket' . $i;
//            $data['home_id'] = '7020' . $i;
//            $data['home_name'] = 'Team 1';
//            $data['away_id'] = $i;
//            $data['away_name'] ='Team 2';
//            $data['m_status'] = 'Active';
//
//            $insert_id = $this->Common_model->insert('market', $data);
//
//            $i++;
//        }
//    }


    function match_odds() {
        //get Market
        $getData = $this->Common_model->getAll('market', array('m_status' => 'Active', 'time_status' => 1))->result();
        foreach ($getData as $active_market) {
            $match_id = $active_market->match_id;
            if (!empty($match_id)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/event?token=31078-kpUbOSVqHy7UPP&FI=$match_id");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

                $response = json_decode(curl_exec($ch), TRUE);
                curl_close($ch);
//            echo'<pre>';
//           
//            print_r($response['results'][0]);
//            exit;
                //getMarket
                if (!empty($response['results'][0])) {
                    $market = $response['results'][0];
                    $match_id = $response['results'][0][0]['FI'];
                    $insert_id = 0;

                    foreach ($market as $mar) {

                        if ($mar['type'] == 'MA') {

                            $fancy_market_id = $mar['ID'];
                            $fancy_market_nm = $mar['NA'];
                            //check existing
                            $ch = $this->Common_model->getAll('fancy_market', array('fancy_market_name' => $fancy_market_nm, 'match_id' => $match_id))->num_rows();

                            if ($ch == 0) {
                                $fm['match_id'] = $match_id;
                                $fm['fancy_market_name'] = $mar['NA'];
                                $fm['fancy_market_id'] = $fancy_market_id;
                                $fm['ch_suspended'] = $mar['SU'];
                                $insert_id = $this->Common_model->insert('fancy_market', $fm);
                            } else {
                                $up_fm['ch_suspended'] = $mar['SU'];
                                $this->Common_model->update('fancy_market', $up_fm, array('fancy_market_name' => $fancy_market_nm, 'match_id' => $match_id));
                            }
                        }
                        if ($mar['type'] == 'PA') {
                            $pa_id = $mar['ID'];

                            //Participant ID
                            $ch = $this->Common_model->getAll('fancy_market_participant', array('participant_id' => $pa_id))->num_rows();
                            $fm_det['fancy_market_id'] = $fancy_market_id;
                            $fm_det['participant_id'] = $mar['ID'];
                            $fm_det['fancy_id'] = $insert_id;
                            $fm_det['participant_name'] = $mar['NA'];
                            $fm_det['odds'] = $mar['OD'];

                            if ($ch == 0) {
                                //Insert into Participant 
                                $this->Common_model->insert('fancy_market_participant', $fm_det);
                            } else {
                                $up_fm_det['odds'] = $mar['OD'];
                                $this->Common_model->update('fancy_market_participant', $up_fm_det, array('fancy_market_id' => $fancy_market_id));
                            }
                        }
                    }
                    //echo 'Updated';
                } else {
                    // echo '|No Result';
                }
            }
        }
    }

}
