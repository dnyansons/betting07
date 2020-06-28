<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_report extends CI_Controller {

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
        $this->load->view('admin/report/user_report_list');
        $this->load->view('admin/common/footer');
    }

    public function ajax_user_report_list() {

        $columns = array(
            0 => 'user_id',
            1 => 'username',
            2 => 'first_name',
            3 => 'role',
            4 => 'under',
            5 => 'mobile',
            6 => 'email',
            7 => 'status',
            8 => 'created_at',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Report_model->user_report_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $user_report = $this->Report_model->all_user_report($limit, $start, $order, $dir);
            //echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $user_report = $this->Report_model->user_report_search($limit, $start, $search, $dir);

            $totalFiltered = $this->Report_model->user_report_search_count($search);
        }
        $data = array();
        if (!empty($user_report)) {
            $i = 0;
            foreach ($user_report as $dat) {
                if (empty($dat->under)) {
                    $unser = '---';
                } else {
                    //get_name

                    $under = $dat->under;

                    $nm = $this->User_model->get_admin_agent($under);
                    if (empty($nm[0]->username)) {
                        $unser = '--';
                    } else {
                        $unser = $nm[0]->username;
                    }
                }
                if ($dat->status == 'Active') {
                    $status = '<span class="badge badge-success badge-pill">' . $dat->status . '</span>';
                } elseif ($dat->status == 'Block') {
                    $status = '<span class="badge badge-danger  badge-pill">' . $dat->status . '</span>';
                } else {
                    $status = '<span class="badge badge-warning badge-pill">' . $dat->status . '</span>';
                }

                $nestedData['user_id'] = 'ID-' . $dat->user_id;
                $nestedData['username'] = $dat->username;
                $nestedData['first_name'] = $dat->first_name;
                $nestedData['role'] = $dat->role;
                $nestedData['under'] = $unser;
                $nestedData['mobile'] = $dat->mobile;
                $nestedData['email'] = $dat->email;
                $nestedData['status'] = '<a onclick=change_status("' . $dat->user_id . '")>' . $status . '</a>';
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

    function check_league_status() {
        $m_id = $this->input->post('m_id');
        $this->db->select('m_status,sport_id');
        $this->db->from('market');
        $this->db->where('m_id', $m_id);
        $status_q = $this->db->get()->row_array();
        $status = $status_q['m_status'];
        $sport_id = $status_q['sport_id'];
        $str = '<div class="form-group row"><label class="col-sm-4 col-form-label">Change Status</label><div class="col-sm-8">
<input type="hidden" name="m_id" value="' . $m_id . '">                        
<input type="hidden" name="sport_id" value="' . $sport_id . '">                        
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



        $str.='</select>
                    </div></div>';
        echo $str;
    }

    function update_league_status() {
        $status = $this->input->post('m_status');
        $m_id = $this->input->post('m_id');
        $sport_id = $this->input->post('sport_id');
        $up['m_status'] = $status;
        $ch = $this->Common_model->update('market', $up, array('m_id' => $m_id));
        if ($ch) {
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Status Update Successfully aganist Sport ID : " . $sport_id . " !
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
        if ($m_id > 0) {
            $data['market'] = $this->Common_model->getAll('market', array('m_id' => $m_id))->row();
            if ($data['market']) {
                $data['mk_view'] = $this->Report_model->get_market_view($data['market']->match_id);
                $this->load->view('admin/common/header');
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
            $mk_view = $this->Report_model->get_market_view($match_id);

            echo json_encode($mk_view);
        } else {
            redirect("market/set_market");
        }
    }

    function user_market_bets($fancy_id = 0) {
        $ch = $this->Common_model->getAll('fancy_market', array('fancy_id' => $fancy_id))->num_rows();
        if ($ch > 0) {
            $data['fancy_market_info'] = $this->Common_model->getAll('fancy_market', array('fancy_id' => $fancy_id))->row();
            $data['fancy_id'] = $fancy_id;
            $this->load->view('admin/common/header');
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
            $user_report = $this->Betting_model->user_market_betting($limit, $start, $order, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $user_report = $this->Betting_model->user_market_betting_search($limit, $start, $search, $dir);

            $totalFiltered = $this->Betting_model->user_market_betting_search_count($search);
        }
        //echo $this->db->last_query();
        $data = array();
        if (!empty($user_report)) {
            $i = 0;
            foreach ($user_report as $dat) {
                $nestedData['sr_no'] = $i += 1;
                $nestedData['username'] = $dat->username;
                $nestedData['mobile'] = $dat->mobile;
                $nestedData['fancy_name'] = $dat->fancy_name;
                $nestedData['odd'] = $dat->odd;
                $nestedData['stake'] = $dat->stake;
                $nestedData['win_amount'] = number_format($dat->stake * $dat->odd, 2);
                $nestedData['bet_status'] = $dat->bet_status;
                $nestedData['win_status'] = $dat->win_status;
                $nestedData['created_at'] = $dat->created_at;
                $nestedData['updated_at'] = $dat->updated_at;
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
        echo date('Y-m-d H:i:s', 1571176800);
        //$res=Array ( [success] => 1 [results] => Array ( [0] => Array ( [0] => Array ( [type] => EV [AM] => [AS] => [AU] => 0 [BC] => [C1] => 858 [C2] => 44066517 [C3] => 0 [CB] => [CC] => C-PAKNATT20CM [CK] => [CL] => 3 [CM] => [CT] => Cricket [CU] => [DC] => 0 [DO] => 1 [DS] => 1 [EA] => [ED] => 1 [EI] => 3-858-5-44066517-2-858 [EL] => 0 [ES] => [ET] => 0 [EX] => [FB] => 0 [FF] => 1~J6 [FI] => 83516303 [HO] => 1 [HP] => 1 [ID] => 8585440665172C3_1_1 [IF] => [IM] => [IT] => 8585440665172C3_1_1 [LB] => 0 [LM] => 0 [LT] => [MC] => [MD] => 1 [ML] => 0 [MM] => 30154 [MS] => 0 [NA] => Balochistan vs Southern Punjab - Twenty20 [NT] => [NV] => 0 [PG] => W:0:1:2:1:1#16:5:5 [PS] => 0 [RI] => [RO] => 1 [S1] => [S2] => [S3] => [S4] => [S5] => 20 [S6] => [S7] => 1 [SB] => 0 [SD] => 0 [SE] => 0 [SI] => [SS] => 87/6 [SV] => 0 [SY] => 0 [T1] => 5 [T2] => 2 [T3] => 0 [TA] => [TD] => 0 [TM] => 0 [TO] => GD [TS] => 0 [TT] => 0 [TU] => [UC] => [VC] => 1206 [VI] => 0 [VS] => [XT] => 0 [XY] => ) [1] => Array ( [type] => TG [AD] => [CT] => Cricket [DS] => 1 [ED] => 1 [ID] => 83516303 [IT] => 8585440665172C3T_1_1 [OR] => 0 ) [2] => Array ( [type] => TE [D1] => [EX] => [ID] => 1 [IT] => 8585440665172C3T1_1_1 [KC] => #F0F0F0,#F0F0F0,#F0F0F0,#F0F0F0,#F0F0F0,#804040,#C40010 [KI] => 0 [NA] => Balochistan [OR] => 0 [PI] => 0 [PO] => 0 [S1] => 0 [S2] => 0 [S3] => 0 [S4] => 0 [S5] => [S6] => [S7] => [S8] => [SC] => [TC] => #F0F0F0 [TD] => 103924 ) [3] => Array ( [type] => TE [D1] => [EX] => [ID] => 2 [IT] => 8585440665172C3T2_1_1 [KC] => #0A0A0A,#FFFF00,#0A0A0A,#0A0A0A,#F0F0F0,#0000FF,#3D4A4E [KI] => 0 [NA] => Southern Punjab [OR] => 1 [PI] => 1 [PO] => 0 [S1] => 3 [S2] => 5 [S3] => 0 [S4] => 14 [S5] => 87#6 [S6] => [S7] => W Riaz#2#5#4 [S8] => [SC] => 87/6 [TC] => #0A0A0A [TD] => 113922 ) [4] => Array ( [type] => MA [CN] => 1 [DO] => 1 [FF] => [FI] => 0 [IB] => 0 [ID] => 30154 [IM] => 1 [IR] => [IT] => 8585440665172C3-30154_1_1 [MM] => 0 [NA] => Match Winner 2-Way [OR] => 0 [OT] => 0 [PI] => [PT] => [SU] => 0 [TO] => GD [UC] => ) [5] => Array ( [type] => CO [CN] => 2 [ID] => 1 [IT] => 8585440665172C3-30154-1_1_1 [NA] => [OR] => 0 [SY] => 0 ) [6] => Array ( [type] => PA [EW] => [FI] => 83516315 [HA] => [HD] => [ID] => 354470849 [IT] => P1522440703923870619_1_1 [LA] => [NA] => Balochistan [OD] => 2/9 [OR] => 0 [PX] => [SU] => 0 ) [7] => Array ( [type] => PA [EW] => [FI] => 83516315 [HA] => [HD] => [ID] => 354470850 [IT] => P1522440708218837915_1_1 [LA] => [NA] => Southern Punjab [OD] => 10/3 [OR] => 1 [PX] => [SU] => 0 ) [8] => Array ( [type] => MA [CN] => 1 [DO] => 1 [FF] => [FI] => 0 [IB] => 0 [ID] => 30150 [IM] => 1 [IR] => [IT] => 8585440665172C3-30150_1_1 [MM] => 0 [NA] => 17th Over, Southern Punjab - Runs Odd/Even [OR] => 1 [OT] => 0 [PI] => [PT] => [SU] => 0 [TO] => GD [UC] => ) [9] => Array ( [type] => CO [CN] => 2 [ID] => 1 [IT] => 8585440665172C3-30150-1_1_1 [NA] => [OR] => 0 [SY] => 0 ) [10] => Array ( [type] => PA [BS] => 17th Over Southern Punjab - Odd [EW] => [FI] => 83516315 [HA] => [HD] => [ID] => 354569263 [IT] => P1522863388835339163_1_1 [LA] => [NA] => Odd [OD] => 5/6 [OR] => 0 [PX] => [SU] => 0 ) [11] => Array ( [type] => PA [BS] => 17th Over Southern Punjab - Even [EW] => [FI] => 83516315 [HA] => [HD] => [ID] => 354569264 [IT] => P1522863393130306459_1_1 [LA] => [NA] => Even [OD] => 5/6 [OR] => 1 [PX] => [SU] => 0 ) [12] => Array ( [type] => MA [CN] => 1 [DO] => 1 [FF] => [FI] => 0 [IB] => 0 [ID] => 30151 [IM] => 1 [IR] => [IT] => 8585440665172C3-30151_1_1 [MM] => 0 [NA] => 17th Over, Southern Punjab - Wicket [OR] => 2 [OT] => 0 [PI] => [PT] => [SU] => 0 [TO] => GD [UC] => ) [13] => Array ( [type] => CO [CN] => 2 [ID] => 1 [IT] => 8585440665172C3-30151-1_1_1 [NA] => [OR] => 0 [SY] => 0 ) [14] => Array ( [type] => PA [BS] => 17th Over (Southern Punjab) - Yes [EW] => [FI] => 83516315 [HA] => [HD] => [ID] => 354569265 [IT] => P1522863397425273755_1_1 [LA] => [NA] => Yes [OD] => 11/8 [OR] => 0 [PX] => [SU] => 0 ) [15] => Array ( [type] => PA [BS] => 17th Over (Southern Punjab) - No [EW] => [FI] => 83516315 [HA] => [HD] => [ID] => 354569266 [IT] => P1522863401720241051_1_1 [LA] => [NA] => No [OD] => 8/15 [OR] => 1 [PX] => [SU] => 0 ) [16] => Array ( [type] => MA [CN] => 1 [DO] => 1 [FF] => [FI] => 0 [IB] => 0 [ID] => 30122 [IM] => 0 [IR] => Current Runs : 87 [IT] => 8585440665172C3-30122_1_1 [MM] => 1 [NA] => Southern Punjab 20 Overs Runs - 2-way [OR] => 3 [OT] => 0 [PI] => [PT] => [SU] => 0 [TO] => GD [UC] => ) [17] => Array ( [type] => CO [CN] => 2 [ID] => 1 [IT] => 8585440665172C3-30122-1_1_1 [NA] => [OR] => 0 [SY] => 0 ) [18] => Array ( [type] => PA [BS] => Southern Punjab (20 Overs) - Over [EW] => [FI] => 83516315 [HA] => 122.5 [HD] => [ID] => 354478174 [IT] => P1522472164559313819_1_1 [LA] => 122.5 [NA] => Over 122.5 [OD] => 10/11 [OR] => 0 [PX] => [SU] => 0 ) [19] => Array ( [type] => PA [BS] => Southern Punjab (20 Overs) - Under [EW] => [FI] => 83516315 [HA] => 122.5 [HD] => [ID] => 354478173 [IT] => P1522472160264346523_1_1 [LA] => 122.5 [NA] => Under 122.5 [OD] => 10/11 [OR] => 1 [PX] => [SU] => 0 ) [20] => Array ( [type] => ES [AD] => 1 1 1 1 . 2 . . 6 1 W . 1 2 1 1 [ID] => [IT] => 8585440665172C3ES_1_1 [NA] => [OR] => 0 [PE] => [SY] => ) [21] => Array ( [type] => ) ) ) [stats] => Array ( [event_id] => 2002660 [update_at] => 1571305470 [update_dt] => 2019-10-17 09:44:30 );
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
}
