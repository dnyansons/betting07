<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sports extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {

            redirect("admin/auth/login", "refresh");
        }
        $this->load->model('Sports_model');
        $this->load->model('User_model');
        $this->load->model('Common_model');
        $this->load->model('Particular_model');
        $this->load->model('Betting_model');
        $this->load->model('Wallet_model');
        $this->load->library('Common_data');
    }

    public function index() {
        $user_id=$this->session->userdata("user_id");
         $data['noti']=$this->common_data->get_notification_data();
        $data['user_deatil']=$this->Common_model->getAll('users',array('user_id'=>$user_id))->result();
        $data['tot_wallet_bal']=$this->Wallet_model->getTotalWalletBal();
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/common/sidebar');
        $this->load->view('admin/sports/list');
        $this->load->view('admin/common/footer');
    }

    public function add() {
        $this->form_validation->set_rules('sport_name', 'Sports', 'required');
        $this->form_validation->set_rules('sport_status', 'Status', 'required');
        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);
            $user_id=$this->session->userdata("user_id");
            $data['user_deatil']=$this->Common_model->getAll('users',array('user_id'=>$user_id))->result();
            $data['tot_wallet_bal']=$this->Wallet_model->getTotalWalletBal();
            $data['noti'] = $this->common_data->get_notification_data();
            $this->load->view('admin/common/header',$data);
            $this->load->view('admin/common/sidebar');
            $this->load->view('admin/sports/add');
            $this->load->view('admin/common/footer');
        } else {
            
            $data['sport_name'] = $this->input->post('sport_name');
            $data['sport_status'] = $this->input->post('sport_status');
            //$data['created_at'] = date('Y-m-d H:i:s');
            
            $this->Common_model->insert('sports', $data);
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Sports Added successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
            redirect("sports");
        }
    }

    public function edit($id) {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);
            $data['sports'] = $this->Common_model->getAll('sports', array('sp_id' => $id))->row();
            $user_id=$this->session->userdata("user_id");
            $data['user_deatil']=$this->Common_model->getAll('users',array('user_id'=>$user_id))->result();
            $data['tot_wallet_bal']=$this->Wallet_model->getTotalWalletBal();
            $data['noti'] = $this->common_data->get_notification_data();
            $this->load->view('admin/common/header',$data);
            $this->load->view('admin/common/sidebar');
            $this->load->view('admin/sports/edit', $data);
            $this->load->view('admin/common/footer');
        } else {
            $data['sport_name'] = $this->input->post('name');
            $data['sport_status'] = $this->input->post('status');
            
            $up=$this->Common_model->update('sports', $data, array('sp_id' => $id));
            if($up){
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Sports Updated successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
            }else{
                $message = "<div class='alert alert-info alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Info!</strong> No Changes on Record.
                          </div>";
            $this->session->set_flashdata("message", $message);
            }
            redirect("sports");
        }
    }

    function delete($id) {
        //check used in User Data first
        $check = $this->Common_model->getAll('sports', array('sp_id' => $id))->num_rows();
        if ($check > 0) {
            $this->Common_model->delete('sports', array('sp_id' => $id));
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Sports Deleted Successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
        } else {
            //$this->Common_model->delete('perticulars', array('per_id' => $id));
            $message = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Sports Delete Successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
        }
        redirect("sports");
    }
    
    
  public function ajax_list() {
        $columns = array(
            0 => 'sp_id',
            1 => 'sport_name',
            2 => 'sport_status',
            3 => 'created_at',
            4 => 'action',
        );
        
        if($this->input->server("REQUEST_METHOD")!=='POST')
        {
            show_error('Direct script access not allowed');
        }
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $col = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Sports_model->sports_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $users = $this->Sports_model->all_sports_($limit, $start, $col, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $users = $this->Sports_model->sports_search($limit, $start, $search, $col, $dir);
            // echo $this->db->last_query();
            $totalFiltered = $this->Sports_model->sports_search_count($search);
        }
       
        $data = array();
        if (!empty($users)) {
            $i = 0;
            
            foreach ($users as $dat) {
               
                $nestedData['sp_id'] = $dat->sp_id;
                $nestedData['sport_name'] = $dat->sport_name;
                $nestedData['sport_status'] = $dat->sport_status;
                //$nestedData['created_at'] = $dat->current_bal;
                $nestedData['created_at'] = date("d-m-Y h:i", strtotime($dat->created_at));
                $nestedData['action'] = ' <a class="text-muted font-16" onclick="return confirm(Are You Sure ?)" href="'.base_url().'sports/delete/' . $dat->sp_id .'"><i class="ti-trash"></i></a>'
                        . '&nbsp;&nbsp;&nbsp;<a class="text-muted font-16" href="'. base_url().'sports/edit/'.$dat->sp_id.'"><i class="ti-pencil-alt"></i></a>';
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
