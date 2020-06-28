<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Match_event extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user_logged_in")) {

            redirect("auth/login", "refresh");
        }
        $this->load->model('Common_model');
        $this->load->model('User_model');
        $this->load->model('Wallet_model');
        $this->load->model('Betting_model');
        $this->load->library('Common_data');
    }

    public function index() {

        $user_id = $this->session->userdata("user_id");
        $data['noti'] = $this->common_data->get_notification_data();
        $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
        $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
        $data['match_event'] = $this->Common_model->getAll('match_event')->result();
        $this->load->view('admin/common/header', $data);
        $this->load->view('admin/common/sidebar');
        $this->load->view('admin/matchevent/list', $data);
        $this->load->view('admin/common/footer');
    }

    public function add() {
        $this->form_validation->set_rules('match_event_id', 'Event ID', 'required');
        $this->form_validation->set_rules('match_event_name', 'Match Event Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);
            $user_id = $this->session->userdata("user_id");
            $data['noti'] = $this->common_data->get_notification_data();
            $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
            $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
            $this->load->view('admin/common/header',$data);
            $this->load->view('admin/common/sidebar');
            $this->load->view('admin/matchevent/add', $data);
            $this->load->view('admin/common/footer');
        } else {
            $data['match_event_id'] = $this->input->post('match_event_id');
            $data['match_event_name'] = $this->input->post('match_event_name');
            $data['status'] = $this->input->post('status');

            $this->Common_model->insert('match_event', $data);
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Added successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
            redirect("match_event");
        }
    }

    public function edit($id = 0) {
        if ($id != 0) {
            $this->form_validation->set_rules('match_event_id', 'Event ID', 'required');
            $this->form_validation->set_rules('match_event_name', 'Event Name', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            if ($this->form_validation->run() == false) {
                $err_msg = validation_errors();
                $this->session->set_flashdata('error', $err_msg);
                $data['mt'] = $this->Common_model->getAll('match_event', array('me_id' => $id))->row();
                $user_id = $this->session->userdata("user_id");
                $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
                $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
                $data['noti'] = $this->common_data->get_notification_data();
                $this->load->view('admin/common/header', $data);
                $this->load->view('admin/common/sidebar');
                $this->load->view('admin/matchevent/edit', $data);
                $this->load->view('admin/common/footer');
            } else {
                $data['match_event_id'] = $this->input->post('match_event_id');
                $data['match_event_name'] = $this->input->post('match_event_name');
                $data['status'] = $this->input->post('status');

                $up = $this->Common_model->update('match_event', $data, array('me_id' => $id));
                if ($up) {
                    $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Update successfully.
                          </div>";
                    $this->session->set_flashdata("message", $message);
                } else {
                    $message = "<div class='alert alert-info alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> No Changes on Record.
                          </div>";
                    $this->session->set_flashdata("message", $message);
                }
                redirect("match_event");
            }
        } else {
            redirect("match_event");
        }
    }

    function delete($id) {
        //check used in User Data first
        $check = $this->Common_model->getAll('fancy_market', array('fancy_market_id' => $id))->num_rows();
        if ($check > 0) {
            $message = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Error!</strong> Already in Used.
                          </div>";
            $this->session->set_flashdata("message", $message);
        } else {
            $this->Common_model->delete('match_event', array('me_id' => $id));
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong>Event  Delete Successfully.
                          </div>";
            $this->session->set_flashdata("message", $message);
        }
        redirect("match_event");
    }
    
    

}
