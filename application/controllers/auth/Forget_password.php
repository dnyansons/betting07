<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forget_password extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('User_model');
    }

    public function index() {
        $this->load->view('admin/auth/forget_password');
    }

    public function forgot_pass() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/auth/forget_password');
        } else {
            $email = $this->input->post('email');
            $clean = $this->security->xss_clean($email);
            $userInfo = $this->User_model->getUserInfoByEmail($clean);
            if (!$userInfo) {
                $message = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Error !</strong> We cant find your email address.
                          </div>";
                $this->session->set_flashdata("message", $message);
                redirect('auth/forget_password');
                exit;
            }

            //build token 

            $token = $this->User_model->insertToken($userInfo->user_id);
            $qstring = urlencode($token);
            $url = site_url() . 'auth/forget_password/reset_password/token/' . $qstring;
            $link = '<a href="' . $url . '">' . $url . '</a>';

            $message = '';
            $message .= '<strong>A password reset has been requested for this email account Betting 07</strong><br>';
            $message .= '<strong>Please click:</strong> ' . $link;
            echo $message; //send this through mail
            exit;
        }
    }

    public function reset_password() {
        $token =urldecode($this->uri->segment(5));
        $cleanToken = $this->security->xss_clean($token);

        $user_info = $this->User_model->isTokenValid($cleanToken); //either false or array();               
//       echo'<pre>';
//       print_r($user_info);
//       exit;
        if (!$user_info) {
            $this->session->set_flashdata('message', 'Token is invalid or expired');
            redirect('login');
        }
        $data = array(
            'firstName' => $user_info->first_name,
            'email' => $user_info->email,
            'token' => urlencode($token)
        );

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/auth/reset_password', $data);
        } else {

            $post = $this->input->post(NULL, TRUE);
            
            $cleanPost = $this->security->xss_clean($post);
            $cleanPost['password'] =password_hash($this->input->post("password"),PASSWORD_DEFAULT);
            $cleanPost['user_id'] = $user_info->user_id;
            unset($cleanPost['passconf']);
            if (!$this->User_model->updatePassword($cleanPost)) {
                $this->session->set_flashdata('message', 'There was a problem updating your password');
            } else {
                $this->session->set_flashdata('message', 'Your password has been updated. You may now login');
            }
            redirect('login');
        }
    }

}
