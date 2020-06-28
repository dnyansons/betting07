<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Result_model');
        $this->load->model('Wallet_model');
    }

    function auth_login() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/upcoming?sport_id=3&token=31078-kpUbOSVqHy7UPP");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'X-Application:rdMU1CEPHcoM8p5C'
        ));
        //Credential
        $postData = 'email=admin@atzcart.com&password=atz@123456';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        //$_SESSION['auth_token']=$response['token'];
        return $response['token'];
    }

    //Run Dailt and after in 10 Seconds

    function sons() {
        echo date('Y-m-d H:i:s', 1571176800) . '<br>';
//        echo"<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script><script>
//setInterval(function () {         
//$.ajax({
//                url: '" . base_url() . "cron/match_odds',
//                method: 'POST',
//                data: {},
//                success: function (data) {
//                    console.log('1st Script');
//                }
//            });
//$.ajax({
//                url: '" . base_url() . "cron/inplay',
//                method: 'POST',
//                data: {},
//                success: function (data) {
//                    console.log('2nd Script');
//                }
//            });
//            $.ajax({
//                url: '" . base_url() . "cron/get_score_use_match_id',
//                method: 'POST',
//                data: {},
//                success: function (data) {
//                    console.log('3rd Script');
//                }
//            });
//            }, 10000);
//</script>";
    }

    function upcoming_markets() {
        //Generate Token
        //$auth_token = $this->auth_login();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/upcoming?sport_id=3&token=31078-kpUbOSVqHy7UPP");
        //curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/events/upcoming?token=31078-kpUbOSVqHy7UPP&sport_id=3");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
//        echo'<pre>';
//        print_r($response);
//        exit;
        $res_data = $response['results'];
        $new_match_count = 0;
        foreach ($res_data as $rdata) {

            //check in Market Table
            $ch = $this->Common_model->getAll('market', array('event_id' => $rdata['our_event_id']))->num_rows();
            if ($ch == 0) {
                $insertData['sport_id'] = 3;
                $insertData['match_id'] = $rdata["id"];
                $insertData['event_id'] = $rdata["our_event_id"];
                $insertData['match_time'] = $rdata["time"];
                $insertData['league_id'] = $rdata["league"]["id"];
                $insertData['league_name'] = $rdata["league"]["name"];
                $insertData['home_id'] = $rdata["home"]["id"];
                $insertData['home_name'] = $rdata["home"]["name"];
                $insertData['away_id'] = $rdata["away"]["id"];
                $insertData['away_name'] = $rdata["away"]["name"];
                $insertData['m_status'] = 'New';
                $insertData['time_status'] = $rdata["time_status"];
                $this->Common_model->insert('market', $insertData);
                $new_match_count++;
            }
        }

        //take from inplay 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/inplay_filter?sport_id=3&token=31078-kpUbOSVqHy7UPP");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        $res_data_inply = $response['results'];
        foreach ($res_data_inply as $rdata) {

            //check in Market Table
            $ch = $this->Common_model->getAll('market', array('event_id' => $rdata['our_event_id']))->num_rows();
            if ($ch == 0) {
                $insertData['sport_id'] = 3;
                $insertData['match_id'] = $rdata["id"];
                $insertData['event_id'] = $rdata["our_event_id"];
                $insertData['match_time'] = $rdata["time"];
                $insertData['league_id'] = $rdata["league"]["id"];
                $insertData['league_name'] = $rdata["league"]["name"];
                $insertData['home_id'] = $rdata["home"]["id"];
                $insertData['home_name'] = $rdata["home"]["name"];
                $insertData['away_id'] = $rdata["away"]["id"];
                $insertData['away_name'] = $rdata["away"]["name"];
                $insertData['m_status'] = 'New';
                $insertData['time_status'] = $rdata["time_status"];
                $this->Common_model->insert('market', $insertData);
                $new_match_count++;
            }
        }

        //Insert Notification
        if ($new_match_count > 0) {
            $dat['user_id'] = 1;
            $dat['title'] = $new_match_count . ' New Matches';
            $dat['message'] = $new_match_count . ' New Matches of Cricket are Sheduled as New';
            $dat['notification_to'] = 'admin';
            $dat['created_at'] = date('Y-m-d H:i:s');
            $dat['status'] = 'Unread';
            $this->Common_model->insert('notification', $dat);
        }


        echo'Requested Upcoming Matches...';
    }

    function inplay() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/inplay_filter?sport_id=3&token=31078-kpUbOSVqHy7UPP");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
//        echo'<pre>';
//        print_r($response['results']);
//        exit;
        //get Today Matches
        $this->db->select('match_id');
        $this->db->from('market');
        $this->db->where("match_time >=", strtotime(date('Y-m-d 00:00:00')));
        $this->db->where("match_time <=", strtotime(date('Y-m-d 23:59:59')));
        $match = $this->db->get()->result();

        $pre_array = array();

//        if (!empty($response['results'])) {
        $res_data = $response['results'];
        foreach ($res_data as $rdata) {
            $pre_array[] = $rdata['id'];
        }
        foreach ($match as $mat) {

            if (in_array($mat->match_id, $pre_array)) {
                $up['time_status'] = $rdata['time_status'];
                if ($rdata['time_status'] == 1) {
                    $up['m_status'] = 'Active';
                }
                $this->Common_model->update('market', $up, array('match_id' => $mat->match_id));
            } else {

                $up_status['time_status'] = 0;
                $up_status['m_status'] = 'Inactive';
                $this->Common_model->update('market', $up_status, array('match_id' => $mat->match_id));
            }
        }
//        }
    }

    function match_odds_demo() {
        //get Market
        $match_id = 83807339;
        if (!empty($match_id)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/event?token=31078-kpUbOSVqHy7UPP&FI=$match_id");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

            $response = json_decode(curl_exec($ch), TRUE);
            curl_close($ch);
            echo'<pre>';

            print_r($response['results'][0]);
            exit;
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
                        $fm_det['label'] = $mar['LA'];
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

    function match_odds() {
        //get Market
        $this->inplay();
        $dt['nm'] = 'in';
        $this->Common_model->insert('sons', $dt);
        $getData = $this->Common_model->getAll('market', array('m_status' => 'Active', 'time_status' => 1))->result();
        foreach ($getData as $active_market) {
            $match_id = $active_market->match_id;
            // $this->get_score_use_match_id($match_id);

            if (!empty($match_id)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/event?token=31078-kpUbOSVqHy7UPP&FI=$match_id");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

                $response = json_decode(curl_exec($ch), TRUE);
                curl_close($ch);
                // echo'<pre>';
//           
                // print_r($response['results']);
//            exit;
                //getMarket
                if (!empty($response['results'][0])) {

                    //print_r($response['results'][0]);
                    ///Update Score
                    if (!empty($response['results'][0]) && ($response['results'][0][0]['PG'] != '#1:1:1')) {
                        $match_id = $response['results'][0][0]['FI'];

                        //Update Team Score
                        if (!empty($response['results'][0][2]['SC'])) {
                            $up_score['home_score'] = $response['results'][0][2]['SC'];
                            $this->Common_model->update('market', $up_score, array('match_id' => $match_id));
                        }
                        if (!empty($response['results'][0][3]['SC'])) {
                            $up_score['away_score'] = $response['results'][0][3]['SC'];
                            $this->Common_model->update('market', $up_score, array('match_id' => $match_id));
                        }

                        $score = $response['results'][0][0]['PG'];

                        if (!empty($score)) {
                            //extracy Data
                            $dat = explode(':', $score);
                            //get Over from array
                            $over_dat = array_slice($dat, -3, 1);
                            $over_exp = explode('#', $over_dat[0]);

                            $attempt_ball_dat = array_slice($dat, -2, 1);
                            $ch_over_ball = array_slice($dat, -1, 1);
                            //  print_r($dat);
                            $attempt_ball = $attempt_ball_dat[0];
                            $ch_over_ball = $ch_over_ball[0];
                            $fi_run = $over_exp[0];
                            $fi_over = $over_exp[1];


                            //check prev ball
                            //$pvr_ball=$attempt_ball-1;
                            //check in Current entry

                            $ch = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $fi_over, 'ball' => $attempt_ball))->num_rows();
                            if ($ch == 0) {
                                //getPlaying Team
                                $market = $response['results'][0];
                                foreach ($market as $mar) {

                                    if ($mar['type'] == 'TE') {
                                        if ($mar['PI'] == 1) {
                                            $insertData['playing_team'] = $mar['NA'];

                                            //currently played
                                            $curr_played['curr_play'] = $mar['NA'];
                                            $this->Common_model->update('market', $curr_played, array('match_id' => $match_id));
                                        }
                                    }
                                }
                                if ($ch_over_ball == 6) {
                                    $insertData['chk_over_end'] = 'End';
                                }
                                if ($fi_run == 'W' || $fi_run >= 0) {
                                    $insertData['chk'] = 'C';
                                } else {
                                    $insertData['chk'] = 'NC';
                                }
                                $insertData['match_id'] = $match_id;
                                $insertData['over'] = $fi_over;
                                $insertData['ball'] = $attempt_ball;
                                $insertData['run'] = $fi_run;
                                $insertData['score'] = $score;
                                $insertData['created_at'] = date('Y-m-d H:i:s');
                                $this->Common_model->insert('match_score', $insertData);
                            }
                        }
                    }

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
                            $fm_det['label'] = $mar['LA'];

                            if ($fancy_market_id == 30123) {
                                preg_match_all('!\d+!', $mar['NA'], $inclusive); //160 - 170 Inclusive  
                                $fm_det['label'] = $inclusive[0][0] . '|' . $inclusive[0][1];
                            }

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

    function pre_match_odds() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/prematch?token=31078-kpUbOSVqHy7UPP&FI=83792831");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response['results'][0]);
//        foreach ($response['results'][0]['main']['sp'] as $mar) {
//            print_r($mar);
//        }
        exit;
        $fancy_market_id = 0;
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
        exit;
    }

    function match_result() {

        //Event ID (FI) from Bet365 Inplay
        $match_id = 83792831;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/result?token=31078-kpUbOSVqHy7UPP&event_id=$match_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        echo'<pre>';
        print_r($response['results'][0]);

        $ss = $response['results'][0]['ss'];
        preg_match_all('!\d+!', $ss, $matches);
        //print_r($matches);

        echo $way = count($matches[0]);

        //Update Match Status
        $up['time_status'] = $response['results'][0]['time_status'];
        if (!empty($up['time_status'])) {
            $this->Common_model->update('market', $up, array('match_id' => $match_id));
        }
        exit;
    }

    function get_score() {
        $match_id = 83792831;
        if (!empty($match_id)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/event?token=31078-kpUbOSVqHy7UPP&FI=$match_id");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

            $response = json_decode(curl_exec($ch), TRUE);
//            curl_close($ch);
//            echo'<pre>';
//             print_r($response['results'][0]);
            // getMarket
//            echo'<br>';
            if (!empty($response['results'][0]) && ($response['results'][0][0]['PG'] != '#1:1:1')) {
                $match_id = $response['results'][0][0]['FI'];
                $score = $response['results'][0][0]['PG'];

                //extracy Data
                $dat = explode(':', $score);
                //get Over from array
                $over_dat = array_slice($dat, -3, 1);
                $over_exp = explode('#', $over_dat[0]);

                $attempt_ball_dat = array_slice($dat, -2, 1);
                $attempt_ball = $attempt_ball_dat[0];

                $fi_run = $over_exp[0];
                $fi_over = $over_exp[1];

                //check in entry
                $ch = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $fi_over, 'ball' => $attempt_ball))->num_rows();
                if ($ch == 0) {
                    //getPlaying Team
                    $market = $response['results'][0];
                    foreach ($market as $mar) {
                        if ($mar['type'] == 'TE') {
                            if ($mar['PI'] == 1) {
                                $insertData['playing_team'] = $mar['NA'];
                            }
                        }
                    }
                    $insertData['match_id'] = $match_id;
                    $insertData['over'] = $fi_over;
                    $insertData['ball'] = $attempt_ball;
                    $insertData['run'] = $fi_run;
                    $insertData['created_at'] = date('Y-m-d H:i:s');
                    $this->Common_model->insert('match_score', $insertData);
                }
            } else {
                echo'Not Started';
            }
        }
    }

    function get_score_use_match_id($match_id) {
        //$match_id = 83792831;
        //$match_id = $this->input->post('match_id');
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
//            print_r($response['results'][0]);
            //getMarket
//            echo'<br>';
            if (!empty($response['results'][0]) && ($response['results'][0][0]['PG'] != '#1:1:1')) {
                $match_id = $response['results'][0][0]['FI'];
                $score = $response['results'][0][0]['PG'];

                //extracy Data
                $dat = explode(':', $score);
                //get Over from array
                $over_dat = array_slice($dat, -3, 1);
                $over_exp = explode('#', $over_dat[0]);

                $attempt_ball_dat = array_slice($dat, -2, 1);
                $attempt_ball = $attempt_ball_dat[0];
                $fi_run = $over_exp[0];
                $fi_over = $over_exp[1];

                //check prev ball
                //check in Current entry
                $ch = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $fi_over, 'ball' => $attempt_ball))->num_rows();
                if ($ch == 0) {
                    //getPlaying Team
                    $market = $response['results'][0];
                    foreach ($market as $mar) {

                        if ($mar['type'] == 'TE') {
                            if ($mar['PI'] == 1) {
                                $insertData['playing_team'] = $mar['NA'];
                            }
                        }
                    }

                    $insertData['match_id'] = $match_id;
                    $insertData['over'] = $fi_over;
                    $insertData['ball'] = $attempt_ball;
                    $insertData['run'] = $fi_run;
                    $insertData['created_at'] = date('Y-m-d H:i:s');
                    $this->Common_model->insert('match_score', $insertData);
                }
            } else {
                echo'Not Started';
            }
        }
    }

    function declare_result() {
        $match_id = 83792831;
        if (!empty($match_id)) {
            // 1] for Runs off nth Delivery, nth Over,ID-30143
            //$this->Result_model->nth_delivery_nth_over($match_id);
            // 2] nth Over, Team - Wicket,ID-30151
            //$this->Result_model->nth_over_wicket($match_id);
            // 3] nth Over, Team - Runs Odd/Even,ID-30150
            //$this->Result_model->nth_over_runs_odd_even($match_id);
            // 4] nth Over, Team - Runs-30149
            //$this->Result_model->nth_over_team_run($match_id);
            //5] Match Winner 2-Way-30154
            //$this->Result_model->match_winner_two_way($match_id);
            // 6] Team  nth Overs Runs - 2-way -30122
            //$this->Result_model->team_nth_overs_two_way($match_id);
            // 7] Team  nth Overs Runs - 3-way -30123
            //$this->Result_model->team_nth_overs_three_way($match_id);
            //8] Runs at Fall of nth Wicket (team) - 2-way- 30137
            $this->Result_model->runs_fall_nth_wicket_two_way($match_id);
        }
    }

    function events_ended() {
        $url = 'https://api.betsapi.com/v1/events/ended?token=31078-kpUbOSVqHy7UPP&sport_id=3';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if ($data === false) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($ch);
        echo'<pre>';
        print_r(json_decode($data));
    }

    function events_history() {
        $event_id = 2038072;
        $url = 'https://api.betsapi.com/v1/event/history?token=31078-kpUbOSVqHy7UPP&event_id=' . $event_id . '&qty=1';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if ($data === false) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($ch);
        echo'<pre>';
        print_r(json_decode($data));
    }

    function odds_summery() {
        $event_id = 2038072;
        $url = 'https://api.betsapi.com/v2/event/odds?token=31078-kpUbOSVqHy7UPP&event_id=' . $event_id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if ($data === false) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($ch);
        echo'<pre>';
        print_r(json_decode($data));
    }

    function event_video() {
        $url = 'https://api.betsapi.com/v1/event/videos?token=31078-kpUbOSVqHy7UPP&event_id=83807339';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if ($data === false) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($ch);
        echo'<pre>';
        print_r(json_decode($data));
    }

    function team_squad() {
        $url = 'https://api.betsapi.com/v1/team?token=31078-kpUbOSVqHy7UPP&sport_id=3';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if ($data === false) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($ch);
        echo'<pre>';
        $response = json_decode($data, TRUE);
        //getPlaying Team
        $team = $response['results'];
        foreach ($team as $te) {
            print_r($te);
            $ch = $this->Common_model->getAll('team_squad', array('team_id' => $te['id']))->num_rows();
            if ($ch == 0) {
                $insertData['team_id'] = $te['id'];
                $insertData['team_name'] = $te['name'];
                $insertData['cc'] = $te['cc'];
                $insertData['image_id'] = $te['image_id'];
                $insertData['created_at'] = date('Y-m-d H:i:s');
                $this->Common_model->insert('team_squad', $insertData);
            }
        }
    }

    function test() {
        $number = 4;
        if ($number % 2) {
            echo $number % 2;
            // echo 'Odd number!';
        } else {
            echo $number % 2;
        }

        $a = '270 - 290 Inclusive';
        echo'|' . $a[1] . '<br>';
        if (is_numeric($a[1])) {
            echo "$a[1] is Numeric.<br>";
        } else {
            echo "$a[1] is not Numeric.<br>";
        }
    }

}
