<?php
defined('BASEPATH') or exit();

class Lokasi extends CI_Controller{
	function __construct(){
		parent::__construct();	
		
		$this->load->model('Mymodel','m');
		$this->load->helpers('form');
		$this->load->helpers('url');
		
		if($this->session->userdata('level') != 'admin'){
			redirect('auth/profile');
		}

	}
	
	function index(){
		$data['title'] = "Lokasi";
		
        $this->template->load('template','admin/lokasi',$data);
	}

	
	function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('lokasi');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('lokasi_title',$params['search']['keywords']);
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('lokasi_title',$params['search']['sortBy']);
        }else{
            $this->db->order_by('lokasi_title','asc');
        }
		
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
		
        //get records
        $query = $this->db->get();
		
		$data = array();
		foreach($query->result_array() as $row){
			
			$items = array();
			$items['lokasi_id'] = $row['lokasi_id'];
			$items['lokasi_title'] = $row['lokasi_title'];
			$items['lokasi_kd'] = $row['lokasi_kd'];
				
			
			array_push($data,$items);
		}
		
		
        //return fetched data
        return $data;
    }
	
	function ajaxPaginationData(){
		
        $this->perPage = 10;
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $sortBy = $this->input->post('sortBy');
	
		
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($limitBy)){
            $this->perPage = (int) $limitBy;
        }
        
		
        //total rows count
        $totalRec = count($this->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList tbody';
        $config['base_url']    = base_url().'lokasi/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
		
		
		// integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['empData'] = $this->getRows($conditions);
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->ajax_pagination->create_links();
        
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);	
    }
	
	
	function tambahdata(){					
						
		$lokasi_title = $this->input->post('lokasi_title');
		$lokasi_kd = $this->input->post('lokasi_kd');
		if( $lokasi_title == ""){
			$result['pesan'] = "Judul Lokasi Kosong!";
		}elseif( $lokasi_kd == ""){
			$result['pesan'] = "Kode Lokasi Kosong!";
		}else{
			$result['pesan'] = "";
			$data =  array(
				'lokasi_title' => $lokasi_title,
				'lokasi_kd' => $lokasi_kd
			);
			

			$this->db->insert('lokasi',$data);
			
			$id = $this->db->insert_id();
			$result['id'] = $id;
			
		}
		
		
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($result);
	}
	
	function simpandatabyid(){		
		$id = $this->input->post('id');			
						
		$lokasi_title = $this->input->post('lokasi_title');
		$lokasi_kd = $this->input->post('lokasi_kd');
		if( $lokasi_title == ""){
			$result['pesan'] = "Judul Lokasi Kosong!";
		}elseif( $lokasi_kd == ""){
			$result['pesan'] = "Kode Lokasi Kosong!";
		}else{
			$result['pesan'] = "";
			
			
			$where = array(
				'lokasi_id'=>$id
			);
			$data =  array(
				'lokasi_title' => $lokasi_title,
				'lokasi_kd' => $lokasi_kd
			);
			$this->db->where($where);
			$this->db->update('lokasi',$data);
			$result['id'] = $id;
			
		}
		
		
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($result);
	}
	
	function ambildatabyid(){
		$id =  $this->input->post('id');
		$where = array(
			'lokasi_id'=>$id
		);
		$lokasi = $this->m->ambilbyid($where,'lokasi')->result();
		
		
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($lokasi);
	}
	
	function hapusdatabyid(){
		$id = $this->input->post('id');
		
		$where = array(
			'lokasi_id'=>$id
		);
		$this->m->hapusbyid($where,'lokasi');		
		
	}
}

?>