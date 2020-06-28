<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Betsapi {

    public function __construct() {
        $this->CI = get_instance();
        $this->CI->load->model('Common_model');
    }

    public function getMarket($market_id = 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.betsapi.com/v1/bet365/event?token=31078-kpUbOSVqHy7UPP&FI=$market_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        //echo'<pre>';
        // print_r($response);
        // exit;
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
    }

}
