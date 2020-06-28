<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
        $this->load->view('agent/common/header', $data);

        $this->load->view('agent/common/sidebar');
        $this->load->view('agent/user/list');
        $this->load->view('agent/common/footer');
    }

    public function block_user() {
        $data['noti'] = $this->common_data->get_notification_data();
        $this->load->view('agent/common/header', $data);
        $this->load->view('agent/common/sidebar');
        $this->load->view('agent/user/block_list');
        $this->load->view('agent/common/footer');
    }

    public function ajax_list() {
        $user_id = $this->session->userdata("user_id");
        $columns = array(
            0 => 'user_id',
            1 => 'username',
            2 => 'first_name',
            3 => 'role',
            4 => 'under',
            5 => 'mobile',
            6 => 'email',
            7 => 'status',
            8 => 'created_at',
        );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $col = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->User_model->agent_all_user_count_playing($user_id);

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $users = $this->User_model->agent_all_user_playing($limit, $start, $col, $dir, $user_id);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $users = $this->User_model->agent_user_search_playing($limit, $start, $search, $col, $dir, $user_id);
            // echo $this->db->last_query();
            $totalFiltered = $this->User_model->user_search_count_playing($search, $user_id);
        }

        $data = array();
        if (!empty($users)) {
            $i = 0;
            foreach ($users as $dat) {
                if (empty($dat->under)) {
                    $unser = '---';
                } else {
                    //get_name

                    $under = $dat->under;

                    $nm = $this->User_model->get_admin_agent($under);
                    if (empty($nm[0]->username)) {
                        $unser = '--';
                    } else {
                        $unser = $nm[0]->username;
                    }
                }
                if ($dat->status == 'Active') {
                    $status = '<span class="badge badge-success badge-pill">' . $dat->status . '</span>';
                } elseif ($dat->status == 'Block') {
                    $status = '<span class="badge badge-danger  badge-pill">' . $dat->status . '</span>';
                } else {
                    $status = '<span class="badge badge-warning badge-pill">' . $dat->status . '</span>';
                }
                $nestedData['user_id'] = 'ID-' . $dat->user_id;
                $nestedData['username'] = $dat->username;
                $nestedData['first_name'] = $dat->first_name;
                $nestedData['role'] = $dat->role;
                $nestedData['under'] = $unser;
                $nestedData['mobile'] = $dat->mobile;
                $nestedData['email'] = $dat->email;
                $nestedData['status'] = '<a onclick=change_status("' . $dat->user_id . '")>' . $status . '</a>';
                $nestedData['created_at'] = date("d-m-Y h:i", strtotime($dat->created_at));
                $nestedData['action'] = '&nbsp;&nbsp;&nbsp;<a class="text-muted font-16" href="' . base_url() . 'agent/users/edit/' . $dat->user_id . '"><i class="ti-pencil-alt"></i></a>';
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

    public function add() {
        $user_id = $this->session->userdata("user_id");
        $data['noti'] = $this->common_data->get_notification_data();
        $data['role'] = $this->Common_model->getAll('role', array('status' => 'Active'))->result();
        $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $user_id))->result();
        $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
        //get agent/admin
        $data['admin_agent'] = $this->User_model->get_admin_agent();

        $data['country'] = $this->Common_model->getAll('countries')->result();
        $this->form_validation->set_rules('username', 'UserName', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);
            $this->load->view('agent/common/header', $data);
            $this->load->view('agent/common/sidebar');
            $this->load->view('agent/user/add', $data);
            $this->load->view('agent/common/footer');
        } else {
            $check_email = $this->Common_model->getAll('users', array('email' => $this->input->post('email')))->num_rows();
            $check_mobile = $this->Common_model->getAll('users', array('mobile' => $this->input->post('mobile')))->num_rows();
            if ($check_mobile > 0) {
                $message = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Error!</strong> Mobile Number Already Exist.
                          </div>";
                $this->session->set_flashdata("message", $message);
                redirect("agent/users");
            } elseif ($check_email > 0) {
                $message = "<div class='alert alert-danger alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Error!</strong> Email Already Exist.
                          </div>";
                $this->session->set_flashdata("message", $message);
                redirect("agent/users");
            } else {
                $insertdata['username'] = $this->input->post('username');
                $insertdata['first_name'] = $this->input->post('first_name');
                $insertdata['last_name'] = $this->input->post('last_name');
                $insertdata['email'] = $this->input->post('email');
                $insertdata['mobile'] = $this->input->post('mobile');
                $insertdata['country'] = $this->input->post('country');
                $insertdata['state'] = $this->input->post('state');
                $insertdata['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));
                $insertdata['role'] = 3;
                $insertdata['addr1'] = $this->input->post('addr1');
                $insertdata['addr2'] = $this->input->post('addr2');
                $insertdata['status'] = $this->input->post('status');

                $insertdata['created_by'] = $user_id; //Under User

                $insert_id = $this->Common_model->insert('users', $insertdata);

                //Insert into Wallet
                $insert_wallet['user_id'] = $insert_id;
                //$insert_wallet['updated_at'] = date('Y-m-d H:i:s');
                $this->Common_model->insert('wallet', $insert_wallet);
                
                $dat['user_id'] = 1;
                $dat['title'] = 'New User Joined';
                $dat['message'] = $this->input->post('username') . ' Joined as User';
                $dat['notification_to'] = 'admin';
                $dat['created_at'] = date('Y-m-d H:i:s');
                $dat['status'] = 'Unread';
                $this->Common_model->insert('notification', $dat);

                $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success! </strong>User Added successfully.
                          </div>";
                $this->session->set_flashdata("message", $message);
                redirect("agent/users");
            }
        }
    }

    public function edit($id = 0) {

        if ($id != 0) {
            $user_id = $this->session->userdata("user_id");
            $this->form_validation->set_rules('username', 'UserName', 'required');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required');
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('state', 'State', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            if ($this->form_validation->run() == false) {
                $err_msg = validation_errors();
                $this->session->set_flashdata('error', $err_msg);
                $user_id = $this->session->userdata("user_id");
                $data['noti'] = $this->common_data->get_notification_data();
                $data['role'] = $this->Common_model->getAll('role', array('status' => 'Active'))->result();
                $data['country'] = $this->Common_model->getAll('countries')->result();
                $data['states'] = $this->Common_model->getAll('states')->result();
                $data['users'] = $this->User_model->get_agent_user_detail($id,$user_id);
                
                if(empty($data['users'])){
                    redirect('agent/users'); 
                }
                $data['admin_agent'] = $this->User_model->get_admin_agent();
                $data['user_deatil'] = $this->Common_model->getAll('users', array('user_id' => $id))->result();
               $data['tot_wallet_bal'] = $this->Wallet_model->getTotalWalletBal();
                $data['role'] = $this->Common_model->getAll('role', array('status' => 'Active'))->result();
                $this->load->view('agent/common/header', $data);
                $this->load->view('agent/common/sidebar');
                $this->load->view('agent/user/edit', $data);
                $this->load->view('agent/common/footer');
            } else {
                //$updata['username'] = $this->input->post('username');
                $updata['first_name'] = $this->input->post('first_name');
                $updata['last_name'] = $this->input->post('last_name');
                $updata['email'] = $this->input->post('email');
                $updata['mobile'] = $this->input->post('mobile');
                $updata['country'] = $this->input->post('country');
                $updata['state'] = $this->input->post('state');
                $updata['role'] = 3;
                $updata['addr1'] = $this->input->post('addr1');
                $updata['addr2'] = $this->input->post('addr2');
                $updata['status'] = $this->input->post('status');
                $updata['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));
                $updata['created_by'] = $user_id; //Under User

                $up = $this->Common_model->update('users', $updata, array('user_id' => $id));
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
                redirect("agent/users");
            }
        } else {
            redirect("agent/users");
        }
    }

//    function delete($id) {
//        //check used in User Data first
//        $check = $this->Common_model->getAll('users', array('user_id' => $id))->num_rows();
//        if ($check > 0) {
//            $message = "<div class='alert alert-danger alert-dismissible'>
//                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
//                            <strong>Error!</strong> User Already in Used.
//                          </div>";
//            $this->session->set_flashdata("message", $message);
//        } else {
//            $this->Common_model->delete('users', array('user_id' => $id));
//            $message = "<div class='alert alert-success alert-dismissible'>
//                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
//                            <strong>Success!</strong> User Delete Successfully.
//                          </div>";
//            $this->session->set_flashdata("message", $message);
//        }
//        redirect("agent/users");
//    }

    function get_state() {
        $country_id = $this->input->post('country_id');
        $dat = $this->User_model->get_state($country_id);
        echo json_encode($dat);
    }

    function check_mobile_exist() {
        $mob = $this->input->post('mobile');
        $check = $this->Common_model->getAll('users', array('mobile' => $mob))->num_rows();
        echo $check;
    }

    function check_email_exist() {
        $email = $this->input->post('email');
        $check = $this->Common_model->getAll('users', array('email' => $email))->num_rows();
        echo $check;
    }

    function check_username_exist() {
        $uname = $this->input->post('uname');
        $check = $this->Common_model->getAll('users', array('username' => $uname))->num_rows();
        echo $check;
    }

    function check_user_status() {
        $user_id = $this->input->post('user_id');
        $this->db->select('status');
        $this->db->from('users');
        $this->db->where('user_id', $user_id);
        $status_q = $this->db->get()->row_array();
        $status = $status_q['status'];
        $str = '<div class="form-group row"><label class="col-sm-4 col-form-label">Change Status</label><div class="col-sm-8">
<input type="hidden" name="user_id" value="' . $user_id . '">                        
<select name="status" class="form-control">';
        $str.='<option value="Active"';
        if ($status == 'Active') {
            $str.= 'selected';
        }
        $str.='>Active</option>';

        $str.='<option value="Inactive"';
        if ($status == 'Inactive') {
            $str.= 'selected';
        }
        $str.='>Inactive</option>';

        $str.='<option value="Block"';
        if ($status == 'Block') {
            $str.= 'selected';
        }
        $str.='>Block</option>';

        $str.='</select>
                    </div></div>';
        echo $str;
    }

    function update_user_status() {
        $status = $this->input->post('status');
        $user_id = $this->input->post('user_id');
        $up['status'] = $status;
        $ch = $this->Common_model->update('users', $up, array('user_id' => $user_id));
        if ($ch) {
            $message = "<div class='alert alert-success alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Success!</strong> Status Update Successfully !
                          </div>";
        } else {
            $message = "<div class='alert alert-info alert-dismissible'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                            <strong>Info !</strong> No Changes !
                          </div>";
        }
        $this->session->set_flashdata("message", $message);
        redirect("agent/users");
    }

//    function test() {
//        $i=1;
//        while ($i <= 1000) {
//            $data['username'] ='User'.$i;
//            $data['first_name'] ='User'.$i;
//            $data['last_name'] = '--';
//            $data['email'] = 'demo'.$i.'@gmail.com';
//            $data['mobile'] ='7020'.$i;
//            $data['country'] ='101';
//            $data['state'] =22;
//            $data['role'] =3;
//            $data['addr1'] ='abc'.$i;
//            $data['addr2'] = 'cde'.$i;
//            $data['status'] ='Active';
//            $data['commission'] =0; //Agent Commsion
//            $data['created_by'] =1; //Under User
//
//           // $insert_id = $this->Common_model->insert('users', $data);
//
//            //Insert into Wallet
//            $insert_wallet['user_id'] = $insert_id;
//            $insert_wallet['updated_at'] = date('Y-m-d H:i:s');
//            //$this->Common_model->insert('wallet', $insert_wallet);
//            $i++;
//        }
//    }
}
