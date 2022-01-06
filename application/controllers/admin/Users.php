<?php
defined('BASEPATH') or exit();

class Users extends CI_Controller{
	function __construct(){
		parent::__construct();	
		
		$this->load->model('Mymodel','m');
		$this->load->helpers('form');
		$this->load->helpers('url');

        if($this->session->userdata('level') != 'admin'){
            redirect('home');
        }

        $this->username = $this->session->userdata('username');
        $this->password = $this->session->userdata('password');
	}
	
	function index(){
		
		
		$data['title'] = "Data Users";
		$data['kelas'] = 0;//$this->kelas();
		$data['jurusan'] = 0;//$this->jurusan();
		$data['ruang'] = 0;//$this->ruang();
		
        $this->template->load('template','admin/users',$data);
	}

	function cetak(){

        $untuk = $this->input->get('untuk');
        $kustom = $this->input->get('kustom');
		$kelas = $this->input->get('kelas');
		$jurusan = $this->input->get('jurusan');
		$ke = $this->input->get('ke');
		
		
		$data = array();
		$data['siswa'] = array();
        $data['untuk'] = $untuk;
        $data['kustom'] = $kustom;
        $data['kelas'] = $kelas;
        $data['jurusan'] = $jurusan;
        $data['ke'] = $ke;
		
		$siswa = $this->db->select('*')->from('siswa');
        $siswa = $siswa->where(array(
            'siswa_kelas'=>$kelas,
            'siswa_jurusan'=>$jurusan
        ));

        if( !empty($ke) ){
            $siswa = $siswa->where('siswa_jurusan_ke',$ke);
        }

		$nomor_urut = 1;
		$siswa = $siswa->get();
		foreach ($siswa->result_array() as $row){
            $formatted_value = sprintf("%03d", $nomor_urut);

            $baris['urut'] = $formatted_value;
            $baris['siswa_id'] = $row['siswa_id'];
			$baris['siswa_nis'] = $row['siswa_nis'];	
			$baris['siswa_nama'] = $row['siswa_nama'];	
			$baris['siswa_jk'] = $row['siswa_jk'];	
			$baris['siswa_foto'] = $row['siswa_foto'];

            $baris['siswa_nomor'] = $row['siswa_nomor'];
            $baris['siswa_ruangan'] = $row['siswa_ruangan'];


            $baris['foto'] = base_url('assets/img/avatar.png');
            if( !empty($row['siswa_foto']) && file_exists(FCPATH . 'uploads/siswa/' .$row['siswa_foto']) ) {
                $baris['foto'] = base_url('thumb.php?size=200x300&src=./uploads/siswa/' . $row['siswa_foto']);
            }
			
			$baris['kelas'] = $row['siswa_kelas'];
			$baris['jurusan'] = $row['siswa_jurusan'];
            $baris['ke'] = $row['siswa_jurusan_ke'];
			
			$users = $this->db->get_where( 'users', array('siswa_id'=>$row['siswa_id']) )->result();
			
			$baris['user_id'] = '';
			$baris['username'] = '';
			$baris['password'] = '';
			foreach($users as $a){
				$baris['user_id'] = $a->user_id;	
				$baris['username'] = $a->username;
				$baris['password'] = $a->password;		
			}
			array_push($data['siswa'], $baris);
            $nomor_urut++;
		}

        $this->load->view('admin/cetak_siswa_kartu', $data);
		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($data);
	}

	function cetaksiswa(){

        $data = array();
        $data['k'] = array();

        $a = $this->db->select('*')->from('siswa')->group_by('siswa_kelas')->get();


        $nomor_urut = 1;
        $nomor_ruangan = 1;
        foreach ($a->result_array() as $a1){
            $baris['j'] = array();
            $baris['kelas'] = $a1['siswa_kelas'];

            $b = $this->db->select('*')->from('siswa')->where(array(
                'siswa_kelas' => $a1['siswa_kelas']
            ))->group_by('siswa_jurusan')->order_by('siswa_jurusan','asc')->get();

            foreach ($b->result_array() as $b1){
                $item1['r'] = array();

                $item1['jurusan'] = $b1['siswa_jurusan'];
                $item1['ruang'] = $b1['siswa_jurusan_ke'];

                $c = $this->db->select('*')->from('siswa')->where(array(
                    'siswa_jurusan' => $b1['siswa_jurusan']
                ))->group_by('siswa_jurusan_ke')->order_by('siswa_jurusan_ke','asc')->get();

                foreach ($c->result_array() as $c1){
                    $item2['s'] = array();

                    $item2['ruang'] = $c1['siswa_jurusan_ke'];

                    $d = $this->db->select('*')->from('siswa')->where(array(
                        'siswa_kelas' => $a1['siswa_kelas'],
                        'siswa_jurusan' => $b1['siswa_jurusan'],
                        'siswa_jurusan_ke' => $c1['siswa_jurusan_ke']
                    ))->order_by('siswa_nama','asc')->get();

                    foreach ($d->result_array() as $d1){
                        $item3['urut'] = sprintf("%03d", $nomor_urut);
                        $item3['ruangan'] = $this->_numberToRomanRepresentation( $nomor_ruangan );
                        $item3['siswa_id'] = $d1['siswa_id'];
                        $item3['siswa_nis'] = $d1['siswa_nis'];
                        $item3['siswa_nama'] = $d1['siswa_nama'];
                        $item3['siswa_jk'] = $d1['siswa_jk'];
                        $item3['siswa_foto'] = $d1['siswa_foto'];

                        $item3['siswa_kelas'] = $d1['siswa_kelas'];
                        $item3['siswa_jurusan'] = $d1['siswa_jurusan'];
                        $item3['siswa_jurusan_ke'] = $d1['siswa_jurusan_ke'];

                        $item3['siswa_nomor'] = $d1['siswa_nomor'];
                        $item3['siswa_ruangan'] = $d1['siswa_ruangan'];


                        array_push($item2['s'], $item3);

                        $nomor_urut++;
                    }
                    array_push($item1['r'], $item2);
                    $nomor_ruangan++;
                }

                array_push($baris['j'], $item1);
            }

            array_push($data['k'], $baris);
        }

        $this->load->view('admin/cetak_siswa_hadir', $data);
        //$this->output->set_header('Content-Type: application/json; charset=utf-8');
        //echo json_encode($data);
    }

    function cetakguru(){

        $hadir = $this->input->get('hadir');

        $data = array();
        $data['guru'] = array();

        $siswa = $this->db->select('*')->from('guru')->where(array(
            'guru_aktif'=>1
        ));

        $siswa = $siswa->get();
        foreach ($siswa->result_array() as $row){
            $baris['guru_id'] = $row['guru_id'];
            $baris['guru_nip'] = $row['guru_nip'];
            $baris['guru_nama'] = $row['guru_nama'];
            $baris['guru_jk'] = $row['guru_jk'];
            $baris['guru_foto'] = $row['guru_foto'];

            $users = $this->db->get_where( 'users', array('guru_id'=>$row['guru_id']) )->result();
            $pengajar = $this->db->get_where( 'pengajar', array('guru_id'=>$row['guru_id']) )->result();

            $baris['user_id'] = '';
            $baris['username'] = '';
            $baris['email'] = '';
            $baris['password'] = '';
            foreach($users as $a){
                $baris['user_id'] = $a->user_id;
                $baris['username'] = $a->username;
                $baris['email'] = $a->email;
                $baris['password'] = $a->password;
            }

            $baris['pelajaran'] = array();
            foreach($pengajar as $b){
                $pelajaran = $this->db->get_where( 'pelajaran', array('pelajaran_id'=>$b->pelajaran_id) )->result();

                $pelajaran_item = array();
                $pelajaran_item['pelajaran_id'] = $b->pelajaran_id;
                $pelajaran_item['pelajaran_title'] = $pelajaran[0]->pelajaran_title;

                array_push($baris['pelajaran'], $pelajaran_item);
            }
            array_push($data['guru'], $baris);
        }


        if( $hadir == 1 ){
            $this->load->view('admin/cetak_guru_hadir',$data);
        }else {
            $this->load->view('admin/cetak_guru', $data);
        }


        //$this->output->set_header('Content-Type: application/json; charset=utf-8');
        //echo json_encode($data);
    }


    function cetakpengawas(){

        $hadir = $this->input->get('hadir');

        $data = array();
        $data['pengawas'] = array();

        $siswa = $this->db->select('*')->from('users')->where(array(
            'level'=>'pengawas'
        ));

        $siswa = $siswa->get();
        foreach ($siswa->result_array() as $row){

            $baris['user_id'] = $row['user_id'];
            $baris['username'] = $row['username'];
            $baris['email'] = $row['email'];
            $baris['password'] = $row['password'];

            array_push($data['pengawas'], $baris);
        }

        if( $hadir == 1 ){
            $this->load->view('admin/cetak_pengawas_hadir',$data);
        }else {
            $this->load->view('admin/cetak_pengawas', $data);
        }
        //$this->output->set_header('Content-Type: application/json; charset=utf-8');
        //echo json_encode($data);
    }

	function cobaQuery($params = array()){
		
		$data = array();
		$users = $this->db->select('*')->from('users');
		
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $users = $users->like('username',$params['search']['keywords']);
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $users = $users->order_by('username',$params['search']['sortBy']);
        }else{
            $users = $users->order_by('username','asc');
        }
		
        //filter data by searched keywords
        if(!empty($params['search']['levelBy'])){
            $users = $users->where('level',$params['search']['levelBy']);
        }

		
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $users = $users->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $users = $users->limit($params['limit']);
        }
		$users = $users->get();
		
		foreach ($users->result_array() as $row){
			$baris['user_id'] = $row['user_id'];	
			$baris['username'] = $row['username'];	
			$baris['password'] = $row['password'];
			$baris['level'] = $row['level'];
			$baris['last_active'] = $row['last_active'];
			

			$baris['foto'] = base_url('assets/img/avatar.png');

			if($row['level'] == "siswa"){
                $baris['id'] = $row['siswa_id'];

                $siswa = $this->db->from( 'siswa')->where( array(
                    'siswa_id'=>$row['siswa_id']
                ) )->get()->result();

                foreach($siswa as $b){
                    $baris['nomorinduk'] = $b->siswa_nis;
                    $baris['nama'] = $b->siswa_nama;
                    $baris['jk'] = $b->siswa_jk;
                    if( !empty($b->siswa_foto) && file_exists(FCPATH . 'uploads/siswa/' . $b->siswa_foto) ) {
                        $baris['foto'] = base_url('thumb.php?size=70x100&src=./uploads/siswa/' . $b->siswa_foto);
                    }
                    $baris['kelas'] = $b->siswa_kelas;
                    $baris['jurusan'] = $b->siswa_jurusan;
                    $baris['jurusan_ke'] = $b->siswa_jurusan_ke;

                }

            }
			
			array_push($data, $baris);
		}
		
		return $data;
		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($data);
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
        $levelBy = $this->input->post('levelBy');
        $limitBy = $this->input->post('limitBy');
        $jurusanBy = $this->input->post('jurusanBy');
	
		
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($levelBy)){
            $conditions['search']['levelBy'] = $levelBy;
        }
        if(!empty($jurusanBy)){
            $conditions['search']['jurusanBy'] = $jurusanBy;
        }
        if(!empty($limitBy)){
            $this->perPage = (int) $limitBy;
        }
        
		
        //total rows count
        $totalRec = count($this->cobaQuery($conditions));
        
        //pagination configuration
        $config['target']      = '#postList tbody';
        $config['base_url']    = base_url().'users/ajaxPaginationData';
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
        $data['empData'] = $this->cobaQuery($conditions);
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->ajax_pagination->create_links();
        
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);	
    }
	
	function ambildatabyid(){		
		$id = $this->input->post('id');
		$users = $this->m->ambilbyid(array('user_id'=>$id),'users');
		
		
		$baris = array();
		
		foreach ($users->result_array() as $row){
			$baris['user_id'] = $row['user_id'];	
			$baris['username'] = $row['username'];	
			$baris['password'] = $row['password'];
			
			$baris['level'] = $row['level'];
			$baris['last_active'] = $row['last_active'];
			
			$baris['id'] = '';	
			$baris['nomorinduk'] = '';	
			$baris['nama'] = '';	
			$baris['jk'] = '';	
			$baris['foto'] = base_url('assets/img/avatar.png');
			$baris['siswa_kelas'] = '';
			$baris['siswa_jurusan'] = '';
			$baris['siswa_jurusan_ke'] = '';
			
			if($row['level'] == 'siswa'){
			
				$siswa = $this->db->get_where('siswa', array('siswa_id'=> $row['siswa_id']) )->result();
		
				foreach($siswa as $b){
                    $baris['id'] = $b->siswa_id;
                    $baris['nomorinduk'] = $b->siswa_nis;
					$baris['nama'] = $b->siswa_nama;	
					$baris['jk'] = $b->siswa_jk;
                    if( !empty($b->siswa_foto) && file_exists(FCPATH . 'uploads/users/' . $b->siswa_foto) ) {
                        $baris['foto'] = base_url('thumb.php?size=70x100&src=./uploads/users/' . $b->siswa_foto);
                    }
					$baris['siswa_kelas'] = $b->siswa_kelas;
					$baris['siswa_jurusan'] = $b->siswa_jurusan;
					$baris['siswa_jurusan_ke'] = $b->siswa_jurusan_ke;

				}
				
			}
		}
		
		
		
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($baris);
	}


    function generateuser($string1 = '', $continue = false) {

        if( empty($string1) )
            $string1 = $this->input->post('string');

        $string2 = $this->m->splitName($string1);

        $string3 = $string2['firstname'];
        if( $string2['lastname'] != null ) $string3 = $string3.$string2['lastname'];

        $string4 = strtolower($string3);
        $nrRand = rand(1000, 9999);
        $nrRand2 = rand(100000, 999999);

        $data = array();
        $data['username'] = trim( $this->m->post_slug($string4) ).trim($nrRand);
        $data['password'] = '*' . trim($nrRand2);

        if( $continue ) return $data;
        //return $username;
        // Return results as json encoded array
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

	function tambahdata(){						

        $username = $this->input->post('username');
		$password = $this->input->post('password');
        $level = $this->input->post('level');
		
		if( $username == ""){
			$result['pesan'] = "Username Kosong!";
		}elseif( $password == ""){
			$result['pesan'] = "Password Kosong!";
        }elseif( $level == ""){
            $result['pesan'] = "Level Belum dipilih!";
        }else{
			$result['pesan'] = "";
			$data =  array(
				'username' => $username,
				'password' => $password,
                'level' => $level
			);
			$this->db->insert('users',$data);
			$id = $this->db->insert_id();
		}
		
		
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($result);
	}
	
	function simpandatabyid(){
		$user_id = $this->input->post('user_id');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $level = $this->input->post('level');

        if( $username == ""){
            $result['pesan'] = "Username Kosong!";
        }elseif( $password == ""){
            $result['pesan'] = "Password Kosong!";
        }elseif( $level == ""){
            $result['pesan'] = "Level Belum dipilih!";
        }else{
            $result['pesan'] = "";
            $data =  array(
                'username' => $username,
                'password' => $password,
                'level' => $level
            );
			$this->m->simpanbyid($data,array('user_id'=>$user_id),'users');
		}
		
		
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($result);
	}
	
	function hapusdatabyid(){
		$id = $this->input->post('id');	
		
		$this->m->hapusbyid(array('user_id'=>$id),'users');
		
	}

    function resetdata(){
        /*$this->db->where( array(
            'pengaturan_key'=>$this->pengaturan_key
        ));
        $this->db->delete('soal');*/

        $this->db->truncate('users');
        $this->db->insert('users',array(
            'username'  => $this->username,
            'password'  => $this->password,
            'level'     => 'admin'
        ));
    }

    function _numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
?>