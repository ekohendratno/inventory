<?php
defined('BASEPATH') or exit();

class Barang extends CI_Controller{
	function __construct(){
		parent::__construct();	
		
		//load in folder Zend
		//$this->zend->load('Zend/Barcode');
		$this->load->model('Mymodel','m');
		
		
		$this->load->helpers('form');
		$this->load->helpers('url');
		
		if($this->session->userdata('level') != 'admin'){
			redirect('auth/profile');
		}

	}
	
	function index(){
		
		
		$data['title'] = "Data barang Perpus";
		
        $this->template->load('template','admin/barang',$data);
	}
	
	public function barcode(){		
		$code = $this->input->get('code');
		
		Zend_Barcode::render('code128', 'image', array('text'=>$code), array());
	}

	
	function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('barang');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('barang_nama',$params['search']['keywords']);
            $this->db->or_like('barang_nomor',$params['search']['keywords']);
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('barang_tanggal_diinput',$params['search']['sortBy']);
        }else{
            $this->db->order_by('barang_tanggal_diinput','desc');
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
			$items['barang_id'] = $row['barang_id'];
			$items['barang_nama'] = $row['barang_nama'];
			$items['barang_nomor'] = $row['barang_nomor'];
			$items['barang_nomor_kode'] = $row['barang_nomor_kode'];
			$items['barang_nomor_register'] = $row['barang_nomor_register'];
			$items['barang_nomor_seripabrik'] = $row['barang_nomor_seripabrik'];
			$items['barang_merk'] = $row['barang_merk'];
			$items['barang_ukuran'] = $row['barang_ukuran'];
			$items['barang_bahan'] = $row['barang_bahan'];
			$items['barang_tahun_pembelian'] = $row['barang_tahun_pembelian'];
			$items['barang_kondisi'] = $row['barang_kondisi'];
			$items['barang_jumlah'] = $row['barang_jumlah'];
			$items['barang_harga'] = $row['barang_harga'];
			$items['barang_stok'] = $this->hitung_stok_barang($row['barang_id']);
			$items['barang_keterangan'] = $row['barang_keterangan'];
            $items['barang_kondisi_saatini'] = $row['barang_kondisi_saatini'];
            $items['barang_katalog'] = $row['barang_katalog'];
            $items['barang_tanggal_diupdate'] = $row['barang_tanggal_diupdate'];
            $items['barang_tanggal_diinput'] = $row['barang_tanggal_diinput'];
            $items['barang_keterangan'] = $row['barang_keterangan'];
			$items['barang_lokasi'] = $row['barang_lokasi'];

			
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
        $limitBy = $this->input->post('limitBy');
        $kurikulumBy = $this->input->post('kurikulumBy');
	
		
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($kurikulumBy)){
            $conditions['search']['kurikulumBy'] = $kurikulumBy;
        }
        if(!empty($limitBy)){
            $this->perPage = (int) $limitBy;
        }
        
		
        //total rows count
        $totalRec = count($this->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList tbody';
        $config['base_url']    = base_url().'barang/ajaxPaginationData';
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

	function hitung_stok_barang($barang_id = 0){
		if($barang_id < 1 ) return 0;

		/**
		$this->db->select('*');
		$this->db->from('transaksi');
		$this->db->where('barang_id',$barang_id);
		//$this->db->where('transaksi_jenis','pinjam');
		//$this->db->or_where('transaksi_jenis','diperpanjang');
		$transaksi = $this->db->get();
		$jumlah_barang = count( $transaksi->result() );

		$barang = $this->db->get_where('barang',array('barang_id'=>$barang_id))->result();

		$stok_barang = $barang[0]->barang_jumlah - $jumlah_barang;

		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($stok_barang);

		return $stok_barang;*/
		return 0;

	}

	function generateNomorbarangPerpus($katalog_kd = 0, $continue = true){
		
		$katalog = $this->db->get_where('katalog',array('katalog_kd'=>$katalog_kd))->result();
		
		
		$this->db->select('*');
		$this->db->from('barang');
		
		$this->db->order_by('barang_kode_tahun','desc');
		$this->db->order_by('barang_kode_urutan','desc');
		$this->db->limit(1);
		$users = $this->db->get();
		
		$baris = array();
		$baris['barang_kode_tahun'] = date('y');
		$baris['barang_kode_urutan'] = 0;
		
		foreach ($users->result_array() as $row){
			$baris['barang_kode_tahun'] = date('y',strtotime($row['barang_kode_tahun']));
			$baris['barang_kode_urutan'] = $row['barang_kode_urutan'];
		}
		
		if($baris['barang_kode_tahun'] < date('y') ) $baris['barang_kode_tahun'] = date('y');
		
		$baris['barang_kode_urutan'] = $baris['barang_kode_urutan']+1;
		
		$baris['barang_kode'] = $baris['barang_kode_tahun'] . ' ' . sprintf("%03d", $katalog[0]->katalog_id). ' ' . sprintf("%04d", $baris['barang_kode_urutan']);
		
		
		if($continue) return $baris;
		
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($baris);
	}



    function simpan(){

        $id 	            = $this->input->post('id');
        $barang_nama		    = $this->input->post('barang_nama');
        $barang_nomor_kode		    = $this->input->post('barang_nomor_kode');
        $barang_nomor_register 	    = $this->input->post('barang_nomor_register');
        $barang_nomor_seripabrik		    = $this->input->post('barang_nomor_seripabrik');
        $barang_merk		    = $this->input->post('barang_merk');
        $barang_ukuran		    = $this->input->post('barang_ukuran');
        $barang_bahan		    = $this->input->post('barang_bahan');
        $barang_tahun_pembelian		    = $this->input->post('barang_tahun_pembelian');
        $barang_kondisi		    = $this->input->post('barang_kondisi');
        $barang_jumlah		    = $this->input->post('barang_jumlah');
        $barang_harga		    = $this->input->post('barang_harga');
        $barang_keterangan		    = $this->input->post('barang_keterangan');
        $barang_kondisi_saatini		    = $this->input->post('barang_kondisi_saatini');
        //$barang_tanggal_diinput		    = $this->input->post('barang_tanggal_diinput');
        $barang_katalog		    = $this->input->post('barang_katalog');
        $barang_lokasi		    = $this->input->post('barang_lokasi');

        $response = array();
        $response["response"] = array();
        $response["success"] = false;


        $barang_tanggal_diinput = date("d-m-y");

        if(empty($barang_nama)) $this->query_error("Nama Barang kosong!");
        else {

            $data = array();
            $data['barang_nama'] = $barang_nama;
            $data['barang_nomor'] = 0;
            $data['barang_nomor_kode'] = $barang_nomor_kode;
            $data['barang_nomor_register'] = $barang_nomor_register;
            $data['barang_nomor_seripabrik'] = $barang_nomor_seripabrik;
            $data['barang_merk'] = $barang_merk;
            $data['barang_ukuran'] = $barang_ukuran;
            $data['barang_bahan'] = $barang_bahan;
            $data['barang_tahun_pembelian'] = $barang_tahun_pembelian;
            $data['barang_kondisi'] = $barang_kondisi;
            $data['barang_jumlah'] = $barang_jumlah;
            $data['barang_harga'] = $barang_harga;
            $data['barang_keterangan'] = $barang_keterangan;
            $data['barang_kondisi_saatini'] = $barang_kondisi_saatini;
            $data['barang_katalog'] = $barang_katalog;
            $data['barang_lokasi'] = $barang_lokasi;

            if ($id > 0) {
                $this->db->where('barang_id', $id);
                $master = $this->db->update('barang', $data);
            } else {
                $data['barang_tanggal_diinput'] = $barang_tanggal_diinput;

                $master = $this->db->insert('barang', $data);
                $id = $this->db->insert_id();
            }


            if ($master) {
                $this->output->set_header('Content-Type: application/json; charset=utf-8,Access-Control-Allow-Origin: *');
                echo json_encode(array('id' => $id, 'status' => 1, 'pesan' => "<font color='green'><i class='fa fa-check'></i> Data berhasil disimpan !</font>"));
            } else {
                $this->query_error();
            }


        }

    }

    function ambildatabyid(){
        $id = $this->input->get('id');
        $users = $this->db->get_where('barang', array('barang_id'=>$id));


        $data = array();
        foreach ($users->result_array() as $row){
            $data['barang_nama'] = $row['barang_nama'];
            $data['barang_nomor'] = !empty($row['barang_nomor']) ? $row['barang_nomor'] : date('Ymd-His');
            $data['barang_nomor_kode'] = $row['barang_nomor_kode'];
            $data['barang_nomor_register'] = $row['barang_nomor_register'];
            $data['barang_nomor_seripabrik'] = $row['barang_nomor_seripabrik'];
            $data['barang_merk'] = $row['barang_merk'];
            $data['barang_ukuran'] = $row['barang_ukuran'];
            $data['barang_bahan'] = $row['barang_bahan'];
            $data['barang_tahun_pembelian'] = $row['barang_tahun_pembelian'];
            $data['barang_kondisi'] = $row['barang_kondisi'];
            $data['barang_jumlah'] = $row['barang_jumlah'];
            $data['barang_harga'] = $row['barang_harga'];
            $data['barang_keterangan'] = $row['barang_keterangan'];
            $data['barang_kondisi_saatini'] = $row['barang_kondisi_saatini'];
            $data['barang_katalog'] = $row['barang_katalog'];
            $data['barang_lokasi'] = $row['barang_lokasi'];
        }

        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }


	
	function hapusdatabyid(){
		$id = $this->input->post('id');
		
		$where = array(
			'barang_id'=>$id
		);
		$this->m->hapusbyid($where,'barang');		
		
	}

	
	
	function cetak(){		
		$id = $this->input->get('id');
		$ranga = $this->input->get('ranga');
		$rangb = $this->input->get('rangb');
		
		$data = array();
		
		
        $this->db->select('*');
        $this->db->from('barang');
		
		if(!empty($id)){

			$this->db->where("barang_id",$id);
			
		}else{
		
			$this->db->where("barang_tanggal>='$ranga' AND barang_tanggal<='$rangb'");
			
		}
		
		$this->db->order_by('barang_tanggal','desc');
		
        //get records
        $query = $this->db->get();
		
		$data = array();
		$data['barang'] = array();
		
		foreach($query->result_array() as $row){
			$total = 1;
			if( $row['barang_jumlah'] > 1){
				$total = $row['barang_jumlah'];
			}
			
			
			for($a=1;$a<=$total; $a++){
				
				$items = array();
				$items['barang_id'] = $row['barang_id'];
				$items['barang_judul'] = $row['barang_judul'];
				$items['barang_penerbit'] = $row['barang_penerbit'];
				$items['barang_penulis'] = $row['barang_penulis'];
				$items['barang_kurikulum'] = $row['barang_kurikulum'];
				$items['barang_kode'] = $row['barang_kode'];
				$items['barang_kode_tahun'] = $row['barang_kode_tahun'];
				$items['barang_kode_urutan'] = $row['barang_kode_urutan'];
				$items['barang_isbn'] = $row['barang_isbn'];			
				$items['barang_tahun_terbit'] = $row['barang_tahun_terbit'];
				$items['barang_tanggal_masuk'] = $row['barang_tanggal_masuk'];
				$items['barang_tanggal'] = $row['barang_tanggal'];
				$items['barang_gambar'] = $row['barang_gambar'];
				$items['barang_jenis'] = $row['barang_jenis'];
				$items['barang_jumlah'] = $row['barang_jumlah'];
				$items['barang_harga'] = $row['barang_harga'];

				$items['lokasi_kd'] = $row['lokasi_kd'];
				$items['katalog_kd'] = $row['katalog_kd'];


				array_push($data['barang'],$items);
				
			}
		}
		
		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($data);
		
		
        $this->load->view('admin/cetak_barang',$data);
	}
	
	function cetakdata(){		
		
		$data = array();
		
		
        $this->db->select('*');
        $this->db->from('barang');	
		
		$this->db->order_by('barang_judul','asc');
		
        //get records
        $query = $this->db->get();
		
		$data = array();
		$data['barang'] = array();
		
		foreach($query->result_array() as $row){
			
			$items = array();
			$items['barang_id'] = $row['barang_id'];
			$items['barang_judul'] = $row['barang_judul'];
			$items['barang_penerbit'] = $row['barang_penerbit'];
			$items['barang_penulis'] = $row['barang_penulis'];
			$items['barang_kurikulum'] = $row['barang_kurikulum'];
			$items['barang_kode'] = $row['barang_kode'];
			$items['barang_kode_tahun'] = $row['barang_kode_tahun'];
			$items['barang_kode_urutan'] = $row['barang_kode_urutan'];
			$items['barang_isbn'] = $row['barang_isbn'];			
			$items['barang_tahun_terbit'] = $row['barang_tahun_terbit'];
			$items['barang_tanggal_masuk'] = $row['barang_tanggal_masuk'];
			$items['barang_tanggal'] = $row['barang_tanggal'];
			$items['barang_gambar'] = $row['barang_gambar'];
			$items['barang_jenis'] = $row['barang_jenis'];
			$items['barang_jumlah'] = $row['barang_jumlah'];
			$items['barang_harga'] = $row['barang_harga'];

			$items['lokasi_kd'] = $row['lokasi_kd'];
			$items['katalog_kd'] = $row['katalog_kd'];
			
			array_push($data['barang'],$items);
		}
		
		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($data);
		
		
        $this->load->view('admin/cetak_barang_data',$data);
	}


    function cetakqr(){
        $id = $this->input->get('id');

        $this->db->select('*');
        $this->db->from('barang');
        $this->db->where("barang_id",$id);

        //get records
        $query = $this->db->get();

        $data = array();
        $data['barang'] = array();

        foreach($query->result_array() as $row){

            $items = array();

            $items['barang_id'] = $row['barang_id'];
            $items['barang_nama'] = $row['barang_nama'];
            $items['barang_nomor'] = $row['barang_nomor'];
            $items['barang_nomor_kode'] = $row['barang_nomor_kode'];
            $items['barang_nomor_register'] = $row['barang_nomor_register'];
            $items['barang_nomor_seripabrik'] = $row['barang_nomor_seripabrik'];
            $items['barang_merk'] = $row['barang_merk'];
            $items['barang_ukuran'] = $row['barang_ukuran'];
            $items['barang_bahan'] = $row['barang_bahan'];
            $items['barang_tahun_pembelian'] = $row['barang_tahun_pembelian'];
            $items['barang_kondisi'] = $row['barang_kondisi'];
            $items['barang_jumlah'] = $row['barang_jumlah'];
            $items['barang_harga'] = $row['barang_harga'];
            $items['barang_stok'] = $this->hitung_stok_barang($row['barang_id']);
            $items['barang_keterangan'] = $row['barang_keterangan'];
            $items['barang_kondisi_saatini'] = $row['barang_kondisi_saatini'];
            $items['barang_katalog'] = $row['barang_katalog'];
            $items['barang_tanggal_diupdate'] = $row['barang_tanggal_diupdate'];
            $items['barang_tanggal_diinput'] = $row['barang_tanggal_diinput'];
            $items['barang_keterangan'] = $row['barang_keterangan'];
            $items['barang_lokasi'] = $row['barang_lokasi'];

            array_push($data['barang'],$items);
        }

        $this->load->view('admin/cetak_qr',$data);
    }

    public function stok(){
        $kode = $this->input->get('kode');
        $stok = $this->input->get('stok');

        $query = $this->db->select('*')->from('barang')->where('barang_nomor',$kode)->get();

        if($stok > $query->row()->barang_jumlah){
            echo json_encode(array('status' => 0, 'pesan' => "Stok untuk <b>".$query->row()->barang_nama."</b> saat ini hanya tersisa <b>".$query->row()->barang_jumlah."</b> !"));
        }
        else
        {
            echo json_encode(array('status' => 1));
        }
    }
	
}
?>