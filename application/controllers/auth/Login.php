<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata("user_logged_in")) {
            if ($this->session->userdata("user_role") == 1) {
                redirect("dashboard/", "refresh");
            } else {
                redirect("agent/dashboard/", "refresh");
            }
        }
        $this->load->model('Common_model');
    }

    public function index() {

        $this->load->library("form_validation");
        $this->form_validation->set_rules("username", "Username", "required");
        $this->form_validation->set_rules("password", "password", "required");


        if ($this->form_validation->run() === false) {

            $this->load->view("admin/auth/login");
        } else {
            $username = htmlentities($this->input->post("username"));
            $password = htmlentities($this->input->post("password"));

            $user = $this->Common_model->getAll('users', array('username' => $username))->row();
            if ($user) {
                if ($user->status == 'Inactive' || $user->status == 'Block') {
                    $error = "<div class='text-center mb-4' style='color: red;text-align: center;'>
                                                <span><b>Error! : </b></strong>Your account has been banned! Please contact support. </span>
                                                </div>";
                    $this->session->set_flashdata("message", $error);
                    redirect("login", "refresh");
                }

                $v_password = password_verify($password, $user->password);

                if ($v_password == 1) {
                    $session_data = array(
                        "user_logged_in" => TRUE,
                        "user_id" => $user->user_id,
                        "user_name" => $user->first_name . " " . $user->last_name,
                        "user_role" => $user->role,
                        "user_email" => $user->email,
                        "mobile" => $user->mobile,
                    );
                    $this->session->set_userdata($session_data);
                    //Update Last Login Time
                    $get_last_time = $this->Common_model->getAll("users", array("user_id" => $user->user_id))->row_array();
                    $dat_time['last_login_activity'] = $get_last_time['updated_at'];
                    $dat_time['updated_at'] = date('Y-m-d H:i:s');
                    $this->Common_model->update("users", $dat_time, array("user_id" => $user->user_id));

                    //redirect($refferer);
                    if ($user->role == 1) {
                        redirect("dashboard");
                    } elseif ($user->role == 2) {
                        redirect("agent/agent_dashboard");
                    }
                }
            }
            $error = "<div class='text-center mb-4' style='color: red;text-align: center;'>
				<span>Error!</strong> Invalid Username Or Password.</span>
			</div>";
            $this->session->set_flashdata("message", $error);
            redirect("login", "refresh");
        }
    }

}
