<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Market_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model');
    }

    function market_count() {
        $this->db->select("*");
        $this->db->from('market');
        if ($_POST['datefrom'] != '') {
            $this->db->where("match_time >=", strtotime($_POST['datefrom']));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("match_time <=", strtotime($_POST['dateto']));
        }
        if ($_POST['status'] != '') {
            $this->db->where("m_status", $_POST['status']);
        }
        $this->db->order_by('m_id', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function all_market($limit, $start, $col, $dir) {
        $this->db->select("*");
        $this->db->from('market');

        if ($_POST['datefrom'] != '') {
            $this->db->where("match_time >=", strtotime($_POST['datefrom']));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("match_time <=", strtotime($_POST['dateto']));
        }
        if ($_POST['status'] != '') {
            $this->db->where("m_status", $_POST['status']);
        }

        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('m_id', 'DESC');
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function market_search($limit, $start, $search, $dir) {
        $this->db->select("*");
        $this->db->from('market');
        if ($_POST['datefrom'] != '') {
            $this->db->where("match_time >=", strtotime($_POST['datefrom']));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("match_time <=", strtotime($_POST['dateto']));
        }
        if ($_POST['status'] != '') {
            $this->db->where("m_status", $_POST['status']);
        }
        $this->db->group_start();
        if (!empty($search)) {
            $this->db->like('league_name', $search);
            $this->db->or_like('home_name', $search);
            $this->db->or_like('away_name', $search);
            $this->db->or_like('sport_id', $search);
        }
        $this->db->group_end();
        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('m_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function market_search_count($search) {
        $this->db->select("*");
        $this->db->from('market');

        if ($_POST['datefrom'] != '') {
            $this->db->where("match_time >=", strtotime($_POST['datefrom']));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("match_time <=", strtotime($_POST['dateto']));
        }
        if ($_POST['status'] != '') {
            $this->db->where("m_status", $_POST['status']);
        }

        $this->db->group_start();
        if (!empty($search)) {
            $this->db->like('league_name', $search);
            $this->db->or_like('home_name', $search);
            $this->db->or_like('away_name', $search);
            $this->db->or_like('sport_id', $search);
            $this->db->or_like('match_id', $search);
        }
        $this->db->group_end();

        $this->db->order_by('m_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return null;
        }
    }

    function getCurrentTotalMatch() {
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");
        $this->db->select('*');
        $this->db->from('market a');
        $this->db->where("a.match_time >=", strtotime(date('Y-m-d 00:00:00')));
        $this->db->where("a.match_time <=", strtotime(date('Y-m-d 23:59:59')));
        return $this->db->get()->num_rows();
    }

    function get_market_view($match_id = 0) {
        $this->db->select("a.fancy_id,a.fancy_market_name,a.result,a.match_id,a.fancy_market_id");
        $this->db->from('fancy_market a');
        $this->db->join('market b', 'b.match_id=a.match_id', 'left');
        $this->db->where('a.match_id', $match_id);
        $this->db->order_by('a.fancy_id', 'desc');
        $res = $this->db->get()->result();
        $pro = array();
        foreach ($res as $res_dat) {

            $pro[] = array(
                'market_name' => $res_dat->fancy_market_name,
                'tot_bets' => $this->Common_model->getAll('bets', array('fancy_id' => $res_dat->fancy_id))->num_rows(),
                'result' => $res_dat->result,
                'match_id' => $res_dat->match_id,
                'fancy_id' => $res_dat->fancy_id,
            );
        }
        if ($pro) {
            return $pro;
        }
    }

    function get_all_matches()
    {
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");

        $where=array('m_status'=>'Active','fancy_market_id'=>30154);
        $this->db->select('*');
        $this->db->from('market a'); 
        $this->db->join('fancy_market b', 'b.match_id=a.match_id', 'left');
        $this->db->where($where);
        $this->db->group_start();
        $this->db->or_where('time_status','0');
        $this->db->or_where('time_status','1');
        /* show current datetime matches */
        
       $this->db->where("a.match_time >=", strtotime(date('Y-m-d 00:00:00'))); 
       $this->db->where("a.match_time <=", strtotime(date('Y-m-d 23:59:00')));

       $this->db->group_end();
        $this->db->group_by('a.match_id');  
        $query1 = $this->db->get()->result();
      
        $j=0;
        foreach ($query1 as $res_dat) {
           
          $query2= $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $res_dat->fancy_id))->result();
         
          $arr[$j]['match_id']=$res_dat->match_id;
          $arr[$j]['league_id']=$res_dat->league_id;
          $arr[$j]['league_name']=$res_dat->league_name;
          $arr[$j]['home_name']=$res_dat->home_name;  
          $arr[$j]['away_name']=$res_dat->away_name;  
          $arr[$j]['fancy_market_name']=$res_dat->fancy_market_name;  
          $arr[$j]['fancy_market_id']=$res_dat->fancy_market_id;  

          $i=1;
          foreach($query2 as $res_data)
            {
                $arr[$j]['participant_id']= $res_data->participant_id;
                $arr[$j]['participant_name'.$i]= $res_data->participant_name;
                $arr[$j]['odds'.$i]= $res_data->odds;
                 $i++;

            }
            $j++;
           
          }
          if ($arr) {
            return $arr;
        }
      
       
    }

    function get_inplay_result($match_id)
    {
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");

        $where=array('m_status'=>'Active','a.match_id'=>$match_id);
        
        $this->db->select('*');
        $this->db->from('market a'); 
        $this->db->join('fancy_market b', 'b.match_id=a.match_id', 'left');
        $this->db->where($where);
        $this->db->group_start();
        $this->db->or_where('time_status','0');
        $this->db->or_where('time_status','1');
        $this->db->group_end();
        $this->db->group_by('a.match_id');  
        // $this->db->order_by('c.participant_id','asc');  
       
        $query1 = $this->db->get()->result();
       
        $j=0;
        $arr=array();
        foreach ($query1 as $res_dat) {
           
          $query2= $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $res_dat->fancy_id))->result();
         
          $arr[$j]['match_id']=$res_dat->match_id;
          $arr[$j]['league_id']=$res_dat->league_id;
          $arr[$j]['league_name']=$res_dat->league_name;
          $arr[$j]['home_name']=$res_dat->home_name;  
          $arr[$j]['away_name']=$res_dat->away_name;  
          $arr[$j]['fancy_market_name']=$res_dat->fancy_market_name;  
          $arr[$j]['fancy_market_id']=$res_dat->fancy_market_id;  

          $i=1;
          foreach($query2 as $res_data)
            {
                $arr[$j]['participant_id']= $res_data->participant_id;
                $arr[$j]['participant_name'.$i]= $res_data->participant_name;
                $arr[$j]['odds'.$i]= $res_data->odds;
                 $i++;

            }
            $j++;
          
          }
          if ($arr) {
            return $arr;
        }
    }

    /* inplay show all matches */

    function show_inplay_all_match()
    {
        $where=array('m_status'=>'Active','b.fancy_market_id'=>30154);
        $this->db->select('*');
        $this->db->from('market a'); 
        $this->db->join('fancy_market b', 'b.match_id=a.match_id', 'left');
        $this->db->where($where);
        // $this->db->group_start();
        // $this->db->or_where('time_status','0');
        $this->db->or_where('time_status','1');
        // $this->db->group_end();
        /* show current dateTime */

        $this->db->where("a.match_time >=", strtotime(date('Y-m-d 00:00:00')));
        $this->db->where("a.match_time <=", strtotime(date('Y-m-d 23:59:00')));

        $this->db->group_by('a.match_id');  
        $query1 = $this->db->get()->result();
        
        $tot_part=array();
        $j=0;
        $arr=array();
        foreach ($query1 as $res_dat) {
           
          $query2= $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $res_dat->fancy_id))->result();
         
          $arr[$j]['match_id']=$res_dat->match_id;
          $arr[$j]['league_id']=$res_dat->league_id;
          $arr[$j]['league_name']=$res_dat->league_name;
          $arr[$j]['home_name']=$res_dat->home_name;  
          $arr[$j]['away_name']=$res_dat->away_name;  
          $arr[$j]['fancy_market_name']=$res_dat->fancy_market_name;  
          $arr[$j]['fancy_market_id']=$res_dat->fancy_market_id;  

          $i=1;
          foreach($query2 as $res_data)
            {
                $arr[$j]['participant_id']= $res_data->participant_id;
                $arr[$j]['participant_name'.$i]= $res_data->participant_name;
                $arr[$j]['odds'.$i]= $res_data->odds;
                 $i++;

            }
            $j++;
          
          }
          if ($arr) {
            return $arr;
        }
    }


    public function show_match_odds($match_id)
    {
        $where=array('participant_id'=>$match_id);

        $this->db->select('*');
        $this->db->from('fancy_market_participant a'); 
        $this->db->where($where);
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }

    }


    function display_upcoming_match()
    {
       $where=array('time_status'=>'0');

        $this->db->select('*');
        $this->db->from('market a'); 
        $this->db->join('fancy_market b', 'b.match_id=a.match_id', 'left');
        $this->db->where($where);
         $this->db->group_start();
         $this->db->or_where('m_status','New');
         $this->db->or_where('m_status','inactive');
         $this->db->group_end();
         
         $this->db->where("a.match_time >=", strtotime(date('m/d/Y 00:00:00', strtotime("+1 days"))));
         $this->db->where("a.match_time <=", strtotime(date('m/d/Y 23:59:00', strtotime("+1 days"))));
         
        $this->db->group_by('a.match_id');  
        $query1 = $this->db->get()->result();
  
        $tot_part=array();
        $j=0;
        $arr=array();
        foreach ($query1 as $res_dat) {
           
          $query2= $this->Common_model->getAll('fancy_market_participant', array('fancy_id' => $res_dat->fancy_id))->result();
         
          $arr[$j]['match_id']=$res_dat->match_id;
          $arr[$j]['league_id']=$res_dat->league_id;
          $arr[$j]['league_name']=$res_dat->league_name;
          $arr[$j]['home_name']=$res_dat->home_name;  
          $arr[$j]['away_name']=$res_dat->away_name;  
          $arr[$j]['fancy_market_name']=$res_dat->fancy_market_name;  
          $arr[$j]['fancy_market_id']=$res_dat->fancy_market_id;  

          $i=1;
          foreach($query2 as $res_data)
            {
                $arr[$j]['participant_id']= $res_data->participant_id;
                $arr[$j]['participant_name'.$i]= $res_data->participant_name;
                $arr[$j]['odds'.$i]= $res_data->odds;
                 $i++;

            }
            $j++;
          
          }
          if ($arr) {
            return $arr;
        }
      
    }
}
