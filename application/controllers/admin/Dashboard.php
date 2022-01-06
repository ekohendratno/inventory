<?php
class Dashboard extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('Mymodel','m');

        if($this->session->userdata('level') != 'admin'){
            redirect('home');
        }


    }

    function index(){
		$data['title'] = 'Dashboard Admin';

        $this->template->load('template','admin/dashboard',$data);
		
		if($this->session->userdata('level') != 'admin'){
			redirect('auth/profile');
		}
    }


}
?>