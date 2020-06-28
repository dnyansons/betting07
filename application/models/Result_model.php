<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Result_model extends CI_Model {

    public function __construct() {
        $this->load->database();
        $this->load->model('Common_model');
    }

    function nth_delivery_nth_over($match_id) {
        $get_ch = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30143, 'result' => 'Pending'))->num_rows();
        if ($get_ch > 0) {
            //Get Pending Result
            $get_q = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30143, 'result' => 'Pending'))->result();


            echo'<pre>';
            //print_r($get_q);
            foreach ($get_q as $row) {

                $fm_name = $row->fancy_market_name;
                preg_match_all('!\d+!', $fm_name, $matches);
                //print_r($matches);
                echo '<br>';
                $fancy_id = $row->fancy_id;
                $delivery = $matches[0][0];
                $over = $matches[0][1];
                // echo '<br>';
                //check in Match Score
                $check_ball = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $over, 'chk' => 'C', 'ball' => $delivery))->num_rows();

                if ($check_ball > 0) {
                    $get_run = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $over, 'chk' => 'C', 'ball' => $delivery))->row();
                    $run = $get_run->run;
                    //get Participant
                    $get_pa = $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $fancy_id))->result();
                    // print_r($get_pa);
                    foreach ($get_pa as $pa) {
                        $pa_id = $pa->participant_id;
                        $label = $pa->label;
                        $pa_name = $pa->participant_name[0]; // O(Over)--U(Under)
                        //get Bets
                        $bets = $this->Result_model->get_bets($fancy_id, $pa_id);
                        if ($bets->num_rows() > 0) {
                            foreach ($bets->result() as $bts) {
                                print_r($bts);
                                //for Yes
                                if ($pa_name == 'O') {//Over
                                    if ($run > $label && $pa_name == 'O') {
                                        $win_dat['bet_status'] = 'Declared';
                                        $win_dat['win_status'] = 'Win';
                                        $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                        $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                        if ($up) {
                                            //Add win amount in User Wallet
                                            $user_id = $bts->user_id;
                                            $bet_id = $bts->bet_id;
                                            $win_amt = $bts->odd * $bts->stake;
                                            $win_on = $bts->fancy_name;
                                            $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                        }
                                    } else {
                                        $loss_dat['bet_status'] = 'Declared';
                                        $loss_dat['win_status'] = 'Loss';
                                        $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                    }
                                }

                                //for No
                                if ($pa_name == 'U') {//Under
                                    if ($run < $label && $pa_name == 'U') {
                                        $win_dat['bet_status'] = 'Declared';
                                        $win_dat['win_status'] = 'Win';
                                        $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                        $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                        if ($up) {
                                            //Add win amount in User Wallet
                                            $user_id = $bts->user_id;
                                            $bet_id = $bts->bet_id;
                                            $win_amt = $bts->odd * $bts->stake;
                                            $win_on = $bts->fancy_name;
                                            $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                        }
                                    } else {
                                        $loss_dat['bet_status'] = 'Declared';
                                        $loss_dat['win_status'] = 'Loss';
                                        $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function nth_over_wicket($match_id) {
        $get_ch = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30151, 'result' => 'Pending'))->num_rows();
        if ($get_ch > 0) {
            //Get Pending Result
            $get_q = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30151, 'result' => 'Pending'))->result();


            echo'<pre>';
            //print_r($get_q);
            foreach ($get_q as $row) {
                echo $fm_name = $row->fancy_market_name;
                preg_match_all('!\d+!', $fm_name, $matches);
                //print_r($matches);
                echo '<br>';
                $fancy_id = $row->fancy_id;
                echo '|' . $over = $matches[0][0];
                echo'<br>';


                //check in Match Score
                $check_over_end = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $over, 'chk_over_end' => 'End'))->num_rows();

                if ($check_over_end > 0) {
                    $ch_wicket = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $over, 'run' => 'W'))->num_rows();

                    //get Participant
                    $get_pa = $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $fancy_id))->result();
                    foreach ($get_pa as $pa) {
                        $pa_id = $pa->participant_id;
                        $pa_name = $pa->participant_name;
                        //get Bets
                        $bets = $this->Result_model->get_bets($fancy_id, $pa_id);



                        if ($bets->num_rows() > 0) {
                            foreach ($bets->result() as $bts) {
                                //   print_r($bts);
                                //for Yes
                                if ($pa_name == 'Yes') {
                                    if ($ch_wicket > 0 && $pa_name == 'Yes') {
                                        $win_dat['bet_status'] = 'Declared';
                                        $win_dat['win_status'] = 'Win';
                                        $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                        $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                        if ($up) {
                                            //Add win amount in User Wallet
                                            $user_id = $bts->user_id;
                                            $bet_id = $bts->bet_id;
                                            $win_amt = $bts->odd * $bts->stake;
                                            $win_on = $bts->fancy_name;
                                            $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                        }
                                    } else {
                                        $loss_dat['bet_status'] = 'Declared';
                                        $loss_dat['win_status'] = 'Loss';
                                        $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                    }
                                }

                                //for No
                                if ($pa_name == 'No') {
                                    if ($ch_wicket == 0 && $pa_name == 'No') {
                                        $win_dat['bet_status'] = 'Declared';
                                        $win_dat['win_status'] = 'Win';
                                        $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                        $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                        if ($up) {
                                            //Add win amount in User Wallet
                                            $user_id = $bts->user_id;
                                            $bet_id = $bts->bet_id;
                                            $win_amt = $bts->odd * $bts->stake;
                                            $win_on = $bts->fancy_name;
                                            $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                        }
                                    } else {
                                        $loss_dat['bet_status'] = 'Declared';
                                        $loss_dat['win_status'] = 'Loss';
                                        $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                    }
                                }
                            }
                        }
                    }
                    // print_r($get_pa);
                }
                //update FaNCY Table
                $upFancy['result'] = 'Declared';
                $this->Common_model->update('fancy_market', $upFancy, array('fancy_id' => $fancy_id));
            }
        }
    }

    function nth_over_runs_odd_even($match_id) {
        $get_ch = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30150, 'result' => 'Pending'))->num_rows();
        if ($get_ch > 0) {
            //Get Pending Result
            $get_q = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30150, 'result' => 'Pending'))->result();

            echo'<pre>';
            //print_r($get_q);
            foreach ($get_q as $row) {
                echo $fm_name = $row->fancy_market_name;
                preg_match_all('!\d+!', $fm_name, $matches);
                //print_r($matches);
                echo '<br>';
                $fancy_id = $row->fancy_id;
                echo '|' . $over = $matches[0][0];
                echo'<br>';


                //check in Match Score
                $check_over_end = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $over, 'chk_over_end' => 'End'))->num_rows();

                if ($check_over_end > 0) {
                    $tot_run_over = $this->Result_model->get_tot_over_run($match_id, $over);

                    if ($tot_run_over % 2) {
                        //Odd Number
                        $ch_pa = 'Odd';
                    } else {
                        $ch_pa = 'Even';
                    }
                    //get Participant
                    $get_pa = $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $fancy_id))->result();
                    foreach ($get_pa as $pa) {
                        $pa_id = $pa->participant_id;
                        $pa_name = $pa->participant_name;
                        //get Bets
                        $bets = $this->Result_model->get_bets($fancy_id, $pa_id);



                        if ($bets->num_rows() > 0) {
                            foreach ($bets->result() as $bts) {
                                print_r($bts);
                                //for Yes
                                if ($pa_name == 'Odd') {
                                    if ($ch_pa == 'Odd' && $pa_name == 'Odd') {
                                        $win_dat['bet_status'] = 'Declared';
                                        $win_dat['win_status'] = 'Win';
                                        $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                        $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                        if ($up) {
                                            //Add win amount in User Wallet
                                            $user_id = $bts->user_id;
                                            $bet_id = $bts->bet_id;
                                            $win_amt = $bts->odd * $bts->stake;
                                            $win_on = $bts->fancy_name;
                                            $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                        }
                                    } else {
                                        $loss_dat['bet_status'] = 'Declared';
                                        $loss_dat['win_status'] = 'Loss';
                                        $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                    }
                                }

                                //for No
                                if ($pa_name == 'Even') {
                                    if ($ch_pa == 'Even' && $pa_name == 'Even') {
                                        $win_dat['bet_status'] = 'Declared';
                                        $win_dat['win_status'] = 'Win';
                                        $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                        $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                        if ($up) {
                                            //Add win amount in User Wallet
                                            $user_id = $bts->user_id;
                                            $bet_id = $bts->bet_id;
                                            $win_amt = $bts->odd * $bts->stake;
                                            $win_on = $bts->fancy_name;
                                            $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                        }
                                    } else {
                                        $loss_dat['bet_status'] = 'Declared';
                                        $loss_dat['win_status'] = 'Loss';
                                        $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                    }
                                }
                            }
                        }
                    }
                    // print_r($get_pa);
                }
                //update FaNCY Table
                $upFancy['result'] = 'Declared';
                $this->Common_model->update('fancy_market', $upFancy, array('fancy_id' => $fancy_id));
            }
        }
    }

    function nth_over_team_run($match_id) {
        $get_ch = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30149, 'result' => 'Pending'))->num_rows();
        if ($get_ch > 0) {
            //Get Pending Result
            $get_q = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30149, 'result' => 'Pending'))->result();

            echo'<pre>';
            //print_r($get_q);
            foreach ($get_q as $row) {
                echo $fm_name = $row->fancy_market_name;
                preg_match_all('!\d+!', $fm_name, $matches);
                //print_r($matches);
                $fancy_id = $row->fancy_id;
                $over = $matches[0][0];

                //check in Match Score
                $check_over_end = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $over, 'chk_over_end' => 'End'))->num_rows();

                if ($check_over_end > 0) {
                    $tot_run_over = $this->Result_model->get_tot_over_run($match_id, $over);

                    //get Participant
                    $get_pa = $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $fancy_id))->result();
                    foreach ($get_pa as $pa) {
                        $pa_id = $pa->participant_id;
                        $pa_name = $pa->participant_name[0]; // O(Over)--U(Under)
                        $label = $pa->label;
                        //get Bets
                        $bets = $this->Result_model->get_bets($fancy_id, $pa_id);



                        if ($bets->num_rows() > 0) {
                            foreach ($bets->result() as $bts) {
                                print_r($bts);
                                //for Yes
                                if ($pa_name == 'O') {
                                    if (($tot_run_over > $label) && ($pa_name == 'O')) {
                                        $win_dat['bet_status'] = 'Declared';
                                        $win_dat['win_status'] = 'Win';
                                        $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                        $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                        if ($up) {
                                            //Add win amount in User Wallet
                                            $user_id = $bts->user_id;
                                            $bet_id = $bts->bet_id;
                                            $win_amt = $bts->odd * $bts->stake;
                                            $win_on = $bts->fancy_name;
                                            $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                        }
                                    } else {
                                        $loss_dat['bet_status'] = 'Declared';
                                        $loss_dat['win_status'] = 'Loss';
                                        $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                    }
                                }

                                //for No
                                if ($pa_name == 'U') {
                                    if (($tot_run_over > $label) && ($pa_name == 'U')) {
                                        $win_dat['bet_status'] = 'Declared';
                                        $win_dat['win_status'] = 'Win';
                                        $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                        $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                        if ($up) {
                                            //Add win amount in User Wallet
                                            $user_id = $bts->user_id;
                                            $bet_id = $bts->bet_id;
                                            $win_amt = $bts->odd * $bts->stake;
                                            $win_on = $bts->fancy_name;
                                            $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                        }
                                    } else {
                                        $loss_dat['bet_status'] = 'Declared';
                                        $loss_dat['win_status'] = 'Loss';
                                        $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                    }
                                }
                            }
                        }
                    }
                    // print_r($get_pa);
                }
                //update FaNCY Table
                $upFancy['result'] = 'Declared';
                $this->Common_model->update('fancy_market', $upFancy, array('fancy_id' => $fancy_id));
            }
        }
    }

    function match_winner_two_way($match_id) {
        $get_ch = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30154, 'result' => 'Pending'))->num_rows();
        if ($get_ch > 0) {
            //Get Pending Result
            $get_q = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30154, 'result' => 'Pending'))->result();

            echo'<pre>';
            //print_r($get_q);
            foreach ($get_q as $row) {
                $fm_name = $row->fancy_market_name;
                preg_match_all('!\d+!', $fm_name, $matches);
                //print_r($matches);
                $fancy_id = $row->fancy_id;
                $way = $matches[0][0]; //2 way or 3 way
                //check in Match Score
                $check_match_end = $this->Common_model->getAll('market', array('match_id' => $match_id, 'time_status' => 3))->num_rows();

                if ($check_match_end > 0) {
                    $get_match_result = $this->match_result($match_id);
                    print_r($get_match_result);

                    if (!empty($get_match_result)) {
                        //get Participant
                        $get_pa = $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $fancy_id))->result();
                        foreach ($get_pa as $pa) {
                            $pa_id = $pa->participant_id;
                            $pa_name = $pa->participant_name;
                            $label = $pa->label;
                            //get Bets
                            $bets = $this->Result_model->get_bets($fancy_id, $pa_id);

                            if ($bets->num_rows() > 0) {
                                foreach ($bets->result() as $bts) {
                                    print_r($bts);
                                    //for Team A
                                    if ($pa_name == $get_match_result['teamA']) {
                                        if (($get_match_result['match_res'] == 'teamA_win') && ($pa_name == $get_match_result['teamA'])) {
                                            $win_dat['bet_status'] = 'Declared';
                                            $win_dat['win_status'] = 'Win';
                                            $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                            $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                            if ($up) {
                                                //Add win amount in User Wallet
                                                $user_id = $bts->user_id;
                                                $bet_id = $bts->bet_id;
                                                $win_amt = $bts->odd * $bts->stake;
                                                $win_on = $bts->fancy_name;
                                                $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                            }
                                        } else {
                                            $loss_dat['bet_status'] = 'Declared';
                                            $loss_dat['win_status'] = 'Loss';
                                            $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                        }
                                    }

                                    //for Team B
                                    if ($pa_name == $get_match_result['teamB']) {
                                        if (($get_match_result['match_res'] == 'teamB_win') && ($pa_name == $get_match_result['teamB'])) {
                                            $win_dat['bet_status'] = 'Declared';
                                            $win_dat['win_status'] = 'Win';
                                            $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                            $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                            if ($up) {
                                                //Add win amount in User Wallet
                                                $user_id = $bts->user_id;
                                                $bet_id = $bts->bet_id;
                                                $win_amt = $bts->odd * $bts->stake;
                                                $win_on = $bts->fancy_name;
                                                $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                            }
                                        } else {
                                            $loss_dat['bet_status'] = 'Declared';
                                            $loss_dat['win_status'] = 'Loss';
                                            $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //print_r($get_pa);
                }
                //update FaNCY Table
                $upFancy['result'] = 'Declared';
                //$this->Common_model->update('fancy_market', $upFancy, array('fancy_id' => $fancy_id));
            }
        }
    }

    function team_nth_overs_two_way($match_id) {
        //currently played team
        $this->db->select('curr_play');
        $this->db->from('market');
        $this->db->where('match_id', $match_id);
        $team_played = $this->db->get()->row();

        $get_ch = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30122, 'result' => 'Pending'))->num_rows();
        if ($get_ch > 0) {
            //Get Pending Result
            $get_q = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30122, 'result' => 'Pending'))->result();

            echo'<pre>';
            //print_r($get_q);
            foreach ($get_q as $row) {
                $fm_name = $row->fancy_market_name;
                preg_match_all('!\d+!', $fm_name, $matches);
                //print_r($matches);
                $fancy_id = $row->fancy_id;
                print_r($matches);

                $over_upto = $matches[0][0]; //Over
                $way = $matches[0][1]; //2 way or 3 way
                if ($way == 2) {
                    //check in Match Score
                    $check_over_end = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $over, 'chk_over_end' => 'End'))->num_rows();

                    if ($check_over_end > 0) {
                        $tot_run_over = $this->get_tot_over_upto_run($match_id, $over_upto, $team_played->curr_play);

                        if (!empty($tot_run_over)) {
                            //get Participant
                            $get_pa = $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $fancy_id))->result();
                            foreach ($get_pa as $pa) {
                                $pa_id = $pa->participant_id;
                                $pa_name = $pa->participant_name[0]; // O(Over)--U(Under)
                                $label = $pa->label;
                                //get Bets
                                $bets = $this->Result_model->get_bets($fancy_id, $pa_id);

                                if ($bets->num_rows() > 0) {
                                    foreach ($bets->result() as $bts) {
                                        print_r($bts);
                                        //for Team A
                                        //for Yes
                                        if ($pa_name == 'O') {
                                            if (($tot_run_over > $label) && ($pa_name == 'O')) {
                                                $win_dat['bet_status'] = 'Declared';
                                                $win_dat['win_status'] = 'Win';
                                                $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                                $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                                if ($up) {
                                                    //Add win amount in User Wallet
                                                    $user_id = $bts->user_id;
                                                    $bet_id = $bts->bet_id;
                                                    $win_amt = $bts->odd * $bts->stake;
                                                    $win_on = $bts->fancy_name;
                                                    $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                                }
                                            } else {
                                                $loss_dat['bet_status'] = 'Declared';
                                                $loss_dat['win_status'] = 'Loss';
                                                $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                            }
                                        }


                                        //for Team B
                                        if ($pa_name == 'U') {
                                            if (($tot_run_over < $label) && ($pa_name == 'U')) {
                                                $win_dat['bet_status'] = 'Declared';
                                                $win_dat['win_status'] = 'Win';
                                                $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                                $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                                if ($up) {
                                                    //Add win amount in User Wallet
                                                    $user_id = $bts->user_id;
                                                    $bet_id = $bts->bet_id;
                                                    $win_amt = $bts->odd * $bts->stake;
                                                    $win_on = $bts->fancy_name;
                                                    $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                                }
                                            } else {
                                                $loss_dat['bet_status'] = 'Declared';
                                                $loss_dat['win_status'] = 'Loss';
                                                $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        // print_r($get_pa);
                    }
                }
                //update FaNCY Table
                $upFancy['result'] = 'Declared';
                //$this->Common_model->update('fancy_market', $upFancy, array('fancy_id' => $fancy_id));
            }
        }
    }

    function team_nth_overs_three_way($match_id) {
        $this->db->select('curr_play');
        $this->db->from('market');
        $this->db->where('match_id', $match_id);
        $team_played = $this->db->get()->row();

        $get_ch = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30123, 'result' => 'Pending'))->num_rows();
        if ($get_ch > 0) {
            //Get Pending Result
            $get_q = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30123, 'result' => 'Pending'))->result();

            echo'<pre>';
            //print_r($get_q);
            foreach ($get_q as $row) {
                $fm_name = $row->fancy_market_name;
                preg_match_all('!\d+!', $fm_name, $matches);
                //print_r($matches);
                $fancy_id = $row->fancy_id;
                print_r($matches);

                $over_upto = $matches[0][0]; //Over
                $way = $matches[0][1]; //2 way or 3 way
                if ($way == 3) {
                    //check in Match Score
                    $check_over_end = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'over' => $over, 'chk_over_end' => 'End'))->num_rows();

                    if ($check_over_end > 0) {
                        $tot_run_over = $this->get_tot_over_upto_run($match_id, $over_upto, $team_played->curr_play);

                        if (!empty($tot_run_over)) {
                            //get Participant
                            $get_pa = $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $fancy_id))->result();
                            foreach ($get_pa as $pa) {
                                $pa_id = $pa->participant_id;
                                $pa_name = $pa->participant_name[0]; // O(Over)--U(Under)
                                $label = $pa->label;
                                //get Bets
                                $bets = $this->Result_model->get_bets($fancy_id, $pa_id);

                                if ($bets->num_rows() > 0) {
                                    foreach ($bets->result() as $bts) {
                                        print_r($bts);
                                        //for Team A
                                        //for Yes
                                        if ($pa_name == 'O') {
                                            if (($tot_run_over > $label) && ($pa_name == 'O')) {
                                                $win_dat['bet_status'] = 'Declared';
                                                $win_dat['win_status'] = 'Win';
                                                $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                                $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                                if ($up) {
                                                    //Add win amount in User Wallet
                                                    $user_id = $bts->user_id;
                                                    $bet_id = $bts->bet_id;
                                                    $win_amt = $bts->odd * $bts->stake;
                                                    $win_on = $bts->fancy_name;
                                                    $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                                }
                                            } else {
                                                $loss_dat['bet_status'] = 'Declared';
                                                $loss_dat['win_status'] = 'Loss';
                                                $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                            }
                                        }


                                        //for Team B
                                        if ($pa_name == 'U') {
                                            if (($tot_run_over < $label) && ($pa_name == 'U')) {
                                                $win_dat['bet_status'] = 'Declared';
                                                $win_dat['win_status'] = 'Win';
                                                $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                                $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                                if ($up) {
                                                    //Add win amount in User Wallet
                                                    $user_id = $bts->user_id;
                                                    $bet_id = $bts->bet_id;
                                                    $win_amt = $bts->odd * $bts->stake;
                                                    $win_on = $bts->fancy_name;
                                                    $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                                }
                                            } else {
                                                $loss_dat['bet_status'] = 'Declared';
                                                $loss_dat['win_status'] = 'Loss';
                                                $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                            }
                                        }

                                        //for Inclusive
                                        if (is_numeric($pa_name)) {
                                            preg_match_all('!\d+!', $pa_name, $inclusive_val);
                                            //Two Values
                                            $inclusive1 = $inclusive_val[0][0];
                                            $inclusive2 = $inclusive_val[0][1];

                                            if (($tot_run_over >= $inclusive1) && ($tot_run_over <= $inclusive2)) {
                                                $win_dat['bet_status'] = 'Declared';
                                                $win_dat['win_status'] = 'Win';
                                                $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                                $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                                if ($up) {
                                                    //Add win amount in User Wallet
                                                    $user_id = $bts->user_id;
                                                    $bet_id = $bts->bet_id;
                                                    $win_amt = $bts->odd * $bts->stake;
                                                    $win_on = $bts->fancy_name;
                                                    $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                                }
                                            } else {
                                                $loss_dat['bet_status'] = 'Declared';
                                                $loss_dat['win_status'] = 'Loss';
                                                $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        // print_r($get_pa);
                    }
                }
                //update FaNCY Table
                $upFancy['result'] = 'Declared';
                //$this->Common_model->update('fancy_market', $upFancy, array('fancy_id' => $fancy_id));
            }
        }
    }

    function runs_fall_nth_wicket_two_way($match_id) {
        //current played Team
        $this->db->select('curr_play');
        $this->db->from('market');
        $this->db->where('match_id', $match_id);
        $team_played = $this->db->get()->row();
        
        $get_ch = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30137, 'result' => 'Pending'))->num_rows();
        if ($get_ch > 0) {
            //Get Pending Result
            $get_q = $this->Common_model->getAll('fancy_market', array('match_id' => $match_id, 'fancy_market_id' => 30137, 'result' => 'Pending'))->result();

            echo'<pre>';
            //print_r($get_q);
            foreach ($get_q as $row) {
                echo $fm_name = $row->fancy_market_name;
                preg_match_all('!\d+!', $fm_name, $matches);
                //print_r($matches);
                $fancy_id = $row->fancy_id;
                print_r($matches);

                echo $wicket = $matches[0][0]; //Over
                exit;
                //check in Match Score
                $ch_wicket = $this->Common_model->getAll('match_score', array('match_id' => $match_id, 'playing_team' => $team_played->curr_play))->num_rows();

                if ($ch_wicket == $wicket) {
                    $tot_run_upto_wicket = $this->get_tot_run_upto_wicket($match_id, $over_upto);

                    if (!empty($tot_run_over)) {
                        //get Participant
                        $get_pa = $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $fancy_id))->result();
                        foreach ($get_pa as $pa) {
                            $pa_id = $pa->participant_id;
                            $pa_name = $pa->participant_name[0]; // O(Over)--U(Under)
                            $label = $pa->label;
                            //get Bets
                            $bets = $this->Result_model->get_bets($fancy_id, $pa_id);

                            if ($bets->num_rows() > 0) {
                                foreach ($bets->result() as $bts) {
                                    print_r($bts);
                                    //for Team A
                                    //for Yes
                                    if ($pa_name == 'O') {
                                        if (($tot_run_over > $label) && ($pa_name == 'O')) {
                                            $win_dat['bet_status'] = 'Declared';
                                            $win_dat['win_status'] = 'Win';
                                            $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                            $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                            if ($up) {
                                                //Add win amount in User Wallet
                                                $user_id = $bts->user_id;
                                                $bet_id = $bts->bet_id;
                                                $win_amt = $bts->odd * $bts->stake;
                                                $win_on = $bts->fancy_name;
                                                $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                            }
                                        } else {
                                            $loss_dat['bet_status'] = 'Declared';
                                            $loss_dat['win_status'] = 'Loss';
                                            $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                        }
                                    }


                                    //for Team B
                                    if ($pa_name == 'U') {
                                        if (($tot_run_over < $label) && ($pa_name == 'U')) {
                                            $win_dat['bet_status'] = 'Declared';
                                            $win_dat['win_status'] = 'Win';
                                            $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                            $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                            if ($up) {
                                                //Add win amount in User Wallet
                                                $user_id = $bts->user_id;
                                                $bet_id = $bts->bet_id;
                                                $win_amt = $bts->odd * $bts->stake;
                                                $win_on = $bts->fancy_name;
                                                $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                            }
                                        } else {
                                            $loss_dat['bet_status'] = 'Declared';
                                            $loss_dat['win_status'] = 'Loss';
                                            $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                        }
                                    }

                                    //for Inclusive
                                    if (is_numeric($pa_name)) {
                                        preg_match_all('!\d+!', $pa_name, $inclusive_val);
                                        //Two Values
                                        $inclusive1 = $inclusive_val[0][0];
                                        $inclusive2 = $inclusive_val[0][1];

                                        if (($tot_run_over >= $inclusive1) && ($tot_run_over <= $inclusive2)) {
                                            $win_dat['bet_status'] = 'Declared';
                                            $win_dat['win_status'] = 'Win';
                                            $win_dat['win_amt'] = $bts->odd * $bts->stake;
                                            $up = $this->Common_model->update('bets', $win_dat, array('bet_id' => $bts->bet_id));
                                            if ($up) {
                                                //Add win amount in User Wallet
                                                $user_id = $bts->user_id;
                                                $bet_id = $bts->bet_id;
                                                $win_amt = $bts->odd * $bts->stake;
                                                $win_on = $bts->fancy_name;
                                                $this->Wallet_model->bet_amount_credited($user_id, $bet_id, $win_amt, $win_on);
                                            }
                                        } else {
                                            $loss_dat['bet_status'] = 'Declared';
                                            $loss_dat['win_status'] = 'Loss';
                                            $this->Common_model->update('bets', $loss_dat, array('bet_id' => $bts->bet_id));
                                        }
                                    }
                                }
                            }
                        }
                    }
                    // print_r($get_pa);
                }

                //update FaNCY Table
                $upFancy['result'] = 'Declared';
                //$this->Common_model->update('fancy_market', $upFancy, array('fancy_id' => $fancy_id));
            }
        }
    }

    function match_result($match_id) {

        //Event ID (FI) from Bet365 Inplay
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/result?token=31078-kpUbOSVqHy7UPP&event_id=$match_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        //echo'<pre>';
        //print_r($response['results'][0]);
        $teamA = $response['results'][0]['home']['name'];
        $teamB = $response['results'][0]['away']['name'];
        $ss = $response['results'][0]['ss'];
        preg_match_all('!\d+!', $ss, $matches);
        $count = count($matches[0]);
        $teamA_score = $matches[0][0];
        $teamB_score = $matches[0][1];
        $arr = array();
        $arr['teamA'] = $teamA;
        $arr['teamB'] = $teamB;
        if ($count == 2) {
            if ($teamA_score == $teamB_score) {
                $arr['match_res'] = 'tie';
            } elseif ($teamA_score > $teamB_score) {
                $arr['match_res'] = 'teamA_win';
            } else {
                $arr['match_res'] = 'teamB_win';
            }
        } else {
            $arr['match_res'] = '0';
        }
        return $arr;
    }

    function get_bets($fancy_id = 0, $participant_id = 0) {
        $this->db->select('bet_id,fancy_id,user_id,beton,odd,stake,fancy_name');
        $this->db->from('bets');
        $this->db->where('bet_status', 'Pending');
        $this->db->where('win_status', 'Pending');
        $this->db->where('fancy_id', $fancy_id);
        $this->db->where('beton', $participant_id);
        return $this->db->get();
    }

    function get_tot_over_run($match_id, $over, $team) {
        $this->db->select('run');
        $this->db->from('match_score');
        $this->db->where('match_id', $match_id);
        $this->db->where('over', $over);
        $this->db->where('playing_team', $team);
        $res = $this->db->get()->result();
        $tot_run = 0;

        foreach ($res as $row) {
            //get Run 
            $run = $row->run;
            preg_match_all('!\d+!', $run, $matches);

            $actual_run = $matches[0][0];
            $tot_run = $tot_run + $actual_run;
        }
        return $tot_run;
    }

    function get_tot_over_upto_run($match_id, $over, $team) {
        $this->db->select('run');
        $this->db->from('match_score');
        $this->db->where('match_id', $match_id);
        $this->db->where('over', $over);
        $this->db->where('playing_team', $team);
        $res = $this->db->get()->result();
        $tot_run = 0;

        foreach ($res as $row) {
            //get Run 
            $run = $row->run;
            preg_match_all('!\d+!', $run, $matches);

            $actual_run = $matches[0][0];
            $tot_run = $tot_run + $actual_run;
        }
        return $tot_run;
    }

}

?>