<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Particular extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {

            redirect("auth/login", "refresh");
        }
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
        $this->load->view('admin/particular/list');
        $this->load->view('admin/common/footer');
    }

    public function add() {
        $this->form_validation->set_rules('particular_name', 'Particular', 'required');
        $this->form_validation->set_rules('particular_status', 'Status', 'required');
        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);
            $user_id=$this->session->userdata("user_id");
            $data['user_deatil']=$this->Common_model->getAll('users',array('user_id'=>$user_id))->result();
            $data['tot_wallet_bal']=$this->Wallet_model->getTotalWalletBal();
            $data['noti'] = $this->common_data->get_notification_data();
            $this->load->view('admin/common/header',$data);
            $this->load->view('admin/common/sidebar');
            $this->load->view('admin/particular/add');
            $this->load->view('admin/common/footer');
        } else {
            $data['per_name'] = $this->input->post('particular_name');
            $data['status'] = $this->input->post('particular_status');
            
            $this->Common_model->insert('perticulars', $data);
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Added successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
            redirect("particular");
        }
    }

    public function edit($id) {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);
            $data['perticulars'] = $this->Common_model->getAll('perticulars', array('per_id' => $id))->row();
            $user_id=$this->session->userdata("user_id");
            $data['user_deatil']=$this->Common_model->getAll('users',array('user_id'=>$user_id))->result();
            $data['tot_wallet_bal']=$this->Wallet_model->getTotalWalletBal();
            $data['noti'] = $this->common_data->get_notification_data();
            $this->load->view('admin/common/header',$data);
            $this->load->view('admin/common/sidebar');
            $this->load->view('admin/particular/edit', $data);
            $this->load->view('admin/common/footer');
        } else {
            $data['per_name'] = $this->input->post('name');
            $data['status'] = $this->input->post('status');
            
            $up=$this->Common_model->update('perticulars', $data, array('per_id' => $id));
            if($up){
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Update successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
            }else{
                $message = "<div class='alert alert-info alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> No Changes on Record.
                          </div>";
            $this->session->set_flashdata("message", $message);
            }
            redirect("particular");
        }
    }

    function delete($id) {
        //check used in User Data first
        $check = $this->Common_model->getAll('perticulars', array('per_id' => $id))->num_rows();
        if ($check > 0) {
            $this->Common_model->delete('perticulars', array('per_id' => $id));
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Error!</strong> Particular Delete Successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
        } else {
            
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Something went wrong.
                          </div>";
            $this->session->set_flashdata("message", $message);
        }
        redirect("particular");
    }
    
    
  public function ajax_list() {
        $columns = array(
            0 => 'per_id',
            1 => 'per_name',
            2 => 'status',
            3 => 'created_at',
            4 => 'action',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $col = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Particular_model->particular_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $users = $this->Particular_model->all_particular_($limit, $start, $col, $dir);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $users = $this->Particular_model->particular_search($limit, $start, $search, $col, $dir);
            // echo $this->db->last_query();
            $totalFiltered = $this->Particular_model->particular_search_count($search);
        }
       
        $data = array();
        if (!empty($users)) {
            $i = 0;
            
            foreach ($users as $dat) {
                if (empty($dat->under)) {
                    $unser = '---';
                } else {
                    $unser = $dat->under;
                }
               
                $nestedData['per_id'] = $dat->per_id;
                $nestedData['per_name'] = $dat->per_name;
                $nestedData['status'] = $dat->status;
                //$nestedData['created_at'] = $dat->current_bal;
                $nestedData['created_at'] = $dat->created_at;
                $nestedData['action'] = ' <a class="text-muted font-16" onclick="return confirm(Are You Sure ?)" href="'.base_url().'particular/delete/' . $dat->per_id .'"><i class="ti-trash"></i></a>'
                        . '&nbsp;&nbsp;&nbsp;<a class="text-muted font-16" href="'. base_url().'particular/edit/'.$dat->per_id.'"><i class="ti-pencil-alt"></i></a>';
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
