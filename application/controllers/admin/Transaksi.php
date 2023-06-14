<?php
defined('BASEPATH') or exit();

class Transaksi extends CI_Controller{
	function __construct(){
		parent::__construct();	
		
		//load in folder Zend
		$this->load->model('Mymodel','m');
		
		
		$this->load->helpers('form');
		$this->load->helpers('url');
		
		if($this->session->userdata('level') != 'admin'){
			redirect('auth/profile');
		}

	}
	
	function index(){
		
		
		$data['title'] = "Transaksi";
		
        $this->template->load('template','admin/transaksi',$data);
	}


    function getRows($params = array()){

        $denda_perhari = 0;


        $this->db->select('*');
        $this->db->from('transaksi');

        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('transaksi.transaksi_tanggal_kembali',$params['search']['sortBy']);
        }else{
            $this->db->order_by('transaksi.transaksi_tanggal_kembali','desc');
        }

        if(!empty($params['search']['statusBy'])){
            $this->db->where('transaksi.transaksi_jenis',$params['search']['statusBy']);
        }


        $this->db->order_by('transaksi.transaksi_tanggal','desc');

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
            $items['transaksi_id'] = $row['transaksi_id'];
            $items['transaksi_jenis'] = $row['transaksi_jenis'];
            $items['transaksi_nota'] = $row['transaksi_nota'];
            $items['transaksi_tanggal_pinjam'] = $row['transaksi_tanggal_pinjam'];
            $items['transaksi_tanggal_kembali'] = $row['transaksi_tanggal_kembali'];
            $items['transaksi_keterangan'] = $row['transaksi_keterangan'];
            $items['transaksi_jumlah'] = $row['transaksi_jumlah'];
            $items['transaksi_peminjam'] = $row['transaksi_peminjam'];


            $selisih_hari_kembali = $this->_selisihHari($row['transaksi_tanggal_kembali'], date('Y-m-d') );

            $items['terlambat_hari'] = 0;

            if( $selisih_hari_kembali > 0 && $row['transaksi_jenis'] == 'pinjam'){

                $items['terlambat_hari'] = $selisih_hari_kembali;

            }


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
        $config['target']      = '#postList0 tbody';
        $config['base_url']    = base_url().'transaksi/ajaxPaginationData';
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



    function transaksi_detail(){

        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->where('transaksi_nota', $this->input->get('notaBy') );

        //get records
        $query = $this->db->get();

        $data = array();
        foreach($query->result_array() as $row){

            $items = array();
            $items['transaksi_id'] = $row['transaksi_id'];
            $items['transaksi_jenis'] = $row['transaksi_jenis'];
            $items['transaksi_nota'] = $row['transaksi_nota'];
            $items['transaksi_tanggal_pinjam'] = $row['transaksi_tanggal_pinjam'];
            $items['transaksi_tanggal_kembali'] = $row['transaksi_tanggal_kembali'];
            $items['transaksi_keterangan'] = $row['transaksi_keterangan'];
            $items['transaksi_jumlah'] = $row['transaksi_jumlah'];
            $items['transaksi_peminjam'] = $row['transaksi_peminjam'];


            $selisih_hari_kembali = $this->_selisihHari($row['transaksi_tanggal_kembali'], date('Y-m-d') );

            $items['terlambat_hari'] = 0;

            if( $selisih_hari_kembali > 0 && $row['transaksi_jenis'] == 'pinjam'){

                $items['terlambat_hari'] = $selisih_hari_kembali;

            }



            $items['barang'] = array();
            $barang = json_decode($row['transaksi_barang']);
            foreach ($barang as $b){

                $item_b = array();
                $item_b["barang_kode"] = $b->kode_barang;
                $item_b["barang_jumlah"] = $b->jumlah_barang;
                $item_b["barang_nama"] = "Nama tidak diketahui";

                $query_barang = $this->db->select('*')->from('barang')->where('barang_nomor', $b->kode_barang)->limit(1)->get();
                foreach ($query_barang->result_array() as $row3) {
                    $item_b['barang_nama'] = $row3['barang_nama'];
                }

                array_push($items['barang'],$item_b);
            }



            array_push($data,$items);
        }


        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }


    function simpan(){

        $nomor_nota	            = $this->input->post('nomor_nota');
        $tanggal 	            = $this->input->post('tanggal');
        $peminjam 	            = $this->input->post('peminjam');
        $catatan 	            = $this->input->post('catatan');
        $grand_total            = $this->input->post('grand_total');

        $transaksi_barang = array();
        if( !empty($_POST['kode_barang'])) {
            $total = 0;
            $no_array	= 0;
            foreach ($_POST['kode_barang'] as $k) {
                if (!empty($k)) {
                    $total++;

                    $barang_item = array();
                    $barang_item['kode_barang'] 	= $_POST['kode_barang'][$no_array];
                    $barang_item['jumlah_barang'] 	= $_POST['jumlah_barang'][$no_array];

                    array_push($transaksi_barang,$barang_item);

                    $no_array++;
                }
            }
        }

        $response = array();
        $response["response"] = array();
        $response["success"] = false;

        $transaksi_tanggal = date("y-m-d");
        $transaksi_tanggal_jam = date("y-m-d H:i:s");

        if(empty($nomor_nota)) $this->query_error("Nomor transaksi kosong!");
        else {
            $data = array();
            //$data['transaksi_jenis'] = "";
            $data['transaksi_tanggal_pinjam'] = $transaksi_tanggal;
            $data['transaksi_tanggal_pinjam_diperpanjang'] = $transaksi_tanggal;
            $data['transaksi_tanggal_kembali'] = $transaksi_tanggal;
            $data['transaksi_tanggal_kembali_diperpanjang'] = $transaksi_tanggal;
            $data['transaksi_tanggal_dikembalikan'] = $transaksi_tanggal;
            $data['transaksi_keterangan'] = $catatan;
            $data['transaksi_jumlah'] = $grand_total;
            $data['transaksi_denda'] = 0;
            $data['transaksi_tanggal'] = $transaksi_tanggal_jam;
            $data['transaksi_nota'] = $nomor_nota;
            $data['transaksi_barang'] = json_encode($transaksi_barang);
            $data['transaksi_peminjam'] = $peminjam;

            $master = $this->db->insert('transaksi', $data);
            $id = $this->db->insert_id();

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
        $users = $this->db->get_where('transaksi', array('transaksi_id'=>$id));


        $data = array();
        foreach ($users->result_array() as $row){
            $data['transaksi_nama'] = $row['transaksi_nama'];
            $data['transaksi_nomor'] = 0;
            $data['transaksi_nomor_kode'] = $row['transaksi_nomor_kode'];
            $data['transaksi_nomor_register'] = $row['transaksi_nomor_register'];
            $data['transaksi_nomor_seripabrik'] = $row['transaksi_nomor_seripabrik'];
            $data['transaksi_merk'] = $row['transaksi_merk'];
            $data['transaksi_ukuran'] = $row['transaksi_ukuran'];
            $data['transaksi_bahan'] = $row['transaksi_bahan'];
            $data['transaksi_tahun_pembelian'] = $row['transaksi_tahun_pembelian'];
            $data['transaksi_kondisi'] = $row['transaksi_kondisi'];
            $data['transaksi_jumlah'] = $row['transaksi_jumlah'];
            $data['transaksi_harga'] = $row['transaksi_harga'];
            $data['transaksi_keterangan'] = $row['transaksi_keterangan'];
            $data['transaksi_kondisi_saatini'] = $row['transaksi_kondisi_saatini'];
            $data['transaksi_katalog'] = $row['transaksi_katalog'];
            $data['transaksi_lokasi'] = $row['transaksi_lokasi'];
        }

        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }


	
	function hapusdatabyid(){
		$id = $this->input->post('id');
		
		$where = array(
			'transaksi_id'=>$id
		);
		$this->m->hapusbyid($where,'transaksi');		
		
	}

	
	
	function cetak(){		
		$id = $this->input->get('id');
		$ranga = $this->input->get('ranga');
		$rangb = $this->input->get('rangb');
		
		$data = array();
		
		
        $this->db->select('*');
        $this->db->from('transaksi');
		
		if(!empty($id)){
		
			$this->db->where("transaksi_id",$id);
			
		}else{
		
			$this->db->where("transaksi_tanggal>='$ranga' AND transaksi_tanggal<='$rangb'");
			
		}
		
		$this->db->order_by('transaksi_tanggal','desc');
		
        //get records
        $query = $this->db->get();
		
		$data = array();
		$data['transaksi'] = array();
		
		foreach($query->result_array() as $row){
			$total = 1;
			if( $row['transaksi_jumlah'] > 1){
				$total = $row['transaksi_jumlah'];
			}
			
			
			for($a=1;$a<=$total; $a++){
				
				$items = array();
				$items['transaksi_id'] = $row['transaksi_id'];
				$items['transaksi_judul'] = $row['transaksi_judul'];
				$items['transaksi_penerbit'] = $row['transaksi_penerbit'];
				$items['transaksi_penulis'] = $row['transaksi_penulis'];
				$items['transaksi_kurikulum'] = $row['transaksi_kurikulum'];
				$items['transaksi_kode'] = $row['transaksi_kode'];
				$items['transaksi_kode_tahun'] = $row['transaksi_kode_tahun'];
				$items['transaksi_kode_urutan'] = $row['transaksi_kode_urutan'];
				$items['transaksi_isbn'] = $row['transaksi_isbn'];			
				$items['transaksi_tahun_terbit'] = $row['transaksi_tahun_terbit'];
				$items['transaksi_tanggal_masuk'] = $row['transaksi_tanggal_masuk'];
				$items['transaksi_tanggal'] = $row['transaksi_tanggal'];
				$items['transaksi_gambar'] = $row['transaksi_gambar'];
				$items['transaksi_jenis'] = $row['transaksi_jenis'];
				$items['transaksi_jumlah'] = $row['transaksi_jumlah'];
				$items['transaksi_harga'] = $row['transaksi_harga'];

				$items['lokasi_kd'] = $row['lokasi_kd'];
				$items['katalog_kd'] = $row['katalog_kd'];


				array_push($data['transaksi'],$items);
				
			}
		}
		
		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($data);
		
		
        $this->load->view('admin/cetak_transaksi',$data);
	}
	
	function cetakdata(){		
		
		$data = array();
		
		
        $this->db->select('*');
        $this->db->from('transaksi');	
		
		$this->db->order_by('transaksi_judul','asc');
		
        //get records
        $query = $this->db->get();
		
		$data = array();
		$data['transaksi'] = array();
		
		foreach($query->result_array() as $row){
			
			$items = array();
			$items['transaksi_id'] = $row['transaksi_id'];
			$items['transaksi_judul'] = $row['transaksi_judul'];
			$items['transaksi_penerbit'] = $row['transaksi_penerbit'];
			$items['transaksi_penulis'] = $row['transaksi_penulis'];
			$items['transaksi_kurikulum'] = $row['transaksi_kurikulum'];
			$items['transaksi_kode'] = $row['transaksi_kode'];
			$items['transaksi_kode_tahun'] = $row['transaksi_kode_tahun'];
			$items['transaksi_kode_urutan'] = $row['transaksi_kode_urutan'];
			$items['transaksi_isbn'] = $row['transaksi_isbn'];			
			$items['transaksi_tahun_terbit'] = $row['transaksi_tahun_terbit'];
			$items['transaksi_tanggal_masuk'] = $row['transaksi_tanggal_masuk'];
			$items['transaksi_tanggal'] = $row['transaksi_tanggal'];
			$items['transaksi_gambar'] = $row['transaksi_gambar'];
			$items['transaksi_jenis'] = $row['transaksi_jenis'];
			$items['transaksi_jumlah'] = $row['transaksi_jumlah'];
			$items['transaksi_harga'] = $row['transaksi_harga'];

			$items['lokasi_kd'] = $row['lokasi_kd'];
			$items['katalog_kd'] = $row['katalog_kd'];
			
			array_push($data['transaksi'],$items);
		}
		
		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($data);
		
		
        $this->load->view('admin/cetak_transaksi_data',$data);
	}



    function barang_kode(){
        $keyword 	= $this->input->post('keyword');
        $registered	= $this->input->post('registered');


        $this->db->select('*')->from('barang');
        if(!empty($keyword)){
            $this->db->like("barang_nomor",$keyword);
            $this->db->or_like("barang_nama",$keyword);
        }

        $query3 = $this->db->get();

        if($query3->num_rows() > 0)
        {
            $json['status'] 	= 1;
            $json['datanya'] 	= "<ul id='daftar-autocomplete'>";
            foreach($query3->result() as $row3){
                $json['datanya'] .= "
						<li>
							<b>Kode</b> : 
							<span id='kodenya'>".$row3->barang_nomor."</span> <br />
							<span id='barangnya'>".$row3->barang_nama."</span> <br />
							<span id='harganya'>".$row3->barang_jumlah."</span>
						</li>
					";
            }
            $json['datanya'] .= "</ul>";
        }
        else
        {
            $json['status'] 	= 0;
        }

        echo json_encode($json);
    }



    function _selisihHari($tglAwal, $tglAkhir){
        // list tanggal merah selain hari minggu
        $tglLibur = array();

        // memecah string tanggal awal untuk mendapatkan
        // tanggal, bulan, tahun
        $pecah1 = explode("-", $tglAwal);
        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];

        // memecah string tanggal akhir untuk mendapatkan
        // tanggal, bulan, tahun
        $pecah2 = explode("-", $tglAkhir);
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0];

        // mencari selisih hari dari tanggal awal dan akhir
        $jd1 = gregoriantojd($month1, $date1, $year1);
        $jd2 = gregoriantojd($month2, $date2, $year2);

        $selisih = $jd2 - $jd1;
        $libur1 = $libur2 = 0;

        // proses menghitung tanggal merah dan hari minggu
        // di antara tanggal awal dan akhir
        for($i=1; $i<=$selisih; $i++)
        {
            // menentukan tanggal pada hari ke-i dari tanggal awal
            $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
            $tglstr = date("Y-m-d", $tanggal);

            // menghitung jumlah tanggal pada hari ke-i
            // yang masuk dalam daftar tanggal merah selain minggu
            if (in_array($tglstr, $tglLibur))
            {
                $libur1++;
            }

            // menghitung jumlah tanggal pada hari ke-i
            // yang merupakan hari minggu
            if ((date("N", $tanggal) == 7))
            {
                $libur2++;
            }
        }

        // menghitung selisih hari yang bukan tanggal merah dan hari minggu
        return $selisih-$libur1-$libur2;
    }



    function query_error($text){
        $this->output->set_header('Content-Type: application/json; charset=utf-8,Access-Control-Allow-Origin: *');
        echo json_encode(array('status' => 0, 'pesan' => "<font color='red'><i class='fas fa-exclamation-triangle'></i> ".$text."</font>"));
    }
}
?>