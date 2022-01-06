<?php

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
		
		$this->load->model('Mymodel','m');		
		$this->load->library('upload');
        $this->load->library('user_agent');

        $this->level = $this->session->userdata('level');
		
    }

    function index(){


        //if ($this->agent->is_mobile()){
            //redirect('auth/mobile');
        //}

		if ( $this->level == 'admin' ) redirect('admin/dashboard');
		else $this->load->view('auth/login');
		
    }

	function signin(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
			
		$data = array();
		if(empty($username) || empty($password)){
			$data['pesan'] = '<div class="alert alert-danger" role="alert"><strong>Maaf!</strong> Username dan Password kosong!</div>';
			$data['redirect'] = null;
		}else{

            $users = $this->db->get_where('users',array('username'=>$username,'password'=>$password))->row_array();

            if ( !empty($users) && $users['level'] == 'admin' ) {

                $userdata = array();
                $userdata['uid']    = $users['user_id'];
                $userdata['username']   = $users['username'];
                $userdata['password']   = $users['password'];
                $userdata['nama']       = $users['username'];
                $userdata['foto']       = base_url('assets/images/avatar.png');
                $userdata['level']      = "admin";

                $this->session->set_userdata($userdata);


                $data['pesan'] = '';
                $data['redirect'] = 'admin/dashboard';
            }



		}

        $this->output->set_header('Content-Type: application/json; charset=utf-8,Access-Control-Allow-Origin: *');
		echo json_encode($data);
		
	}

    function logout() {
        $is = $this->session->userdata('level');
        if( $is == 'siswa' or $is == 'pengawas' ){
            $this->session->sess_destroy();
            redirect('auth/client');
        }else{
            $this->session->sess_destroy();
            redirect('');
        }
    }

}