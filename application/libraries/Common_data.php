<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_data {

    private $CI;
    public function __construct() {
        $this->CI = get_instance();
        $this->CI->load->model('Common_model');
        $this->CI->load->library('email');
    }

    function get_notification_data(){
        $this->CI->db->select('title,message,created_at');
        $this->CI->db->from('blog_notification');
        $this->CI->db->where('status','Unread');
        $this->CI->db->order_by('noti_id','desc');
        $this->CI->db->limit(5);
        return $this->CI->db->get()->result();
    }


    function email_template($to,$message)
    {
        $data['title']='Betting07 Email Verification';
        $data['message']=$message;
        $config = array(
                        'protocol'  => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'support@betting07.com',
                        'smtp_pass' => 'asdfghjklQWE123@',
                        'mailtype'  => 'html',
                        'charset'   => 'utf-8',
                        'crlf' => "\r\n",
                        'newline' => "\r\n"
                        );

                $this->CI->email->initialize($config);
                $this->CI->email->set_mailtype("html");
                $this->CI->email->set_newline("\r\n");
                $this->CI->email->to($to);
                $this->CI->email->from($this->CI->config->item("default_email_from"), "Betting07");
                $this->CI->email->subject('Email For Password Verification');
                $body = $this->CI->load->view('front/emailtemplates/verify_email',$data,TRUE);
                $this->CI->email->message($body);
                if ($this->CI->email->send()) {
                    return true;
                } else {
                    return false;
                }
    }

}
