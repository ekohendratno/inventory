<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {
    function __construct() {
        parent::__construct();
		
		if( $this->session->userdata('level') != ('guru'||'admin') ){
			redirect('auth');
		}


    }

	function soal() {


		$pelajaran = $this->input->get("pelajaran");
		$guru = $this->input->get("guru");
		$kelas = $this->input->get("kelas");
		$untuk = $this->input->get("untuk");

		$data['soal_soal'] = array();
		$daftar_soal = $this->db->get_where('soal',array(
			'soal_pelajaran'=> $pelajaran,
			'soal_guru'=> $guru,
			'soal_kelas'=> $kelas,
			'soal_untuk'=> $untuk,
		))->result_array();
		foreach ($daftar_soal as $soal){


			array_push($data['soal_soal'],$soal);

		}

		//$this->load->library('pdf');

		//$this->pdf->setPaper('A4', 'potrait');

		//$this->pdf->filename = "soal.pdf";
		//$this->pdf->load_view('soal', $data);


		$this->load->view('soal',$data);

	}

	function ujian() {

		$id = $this->input->get('id');

		$ujian_list = $this->db->get_where("ujian",array("ujian_id" => $id))->result();


		$ujian = $this->db->select(
			'soal_jawab.ujian_id,soal_jawab.siswa_id,soal_jawab.soal_jawab_jumlah_soal,,soal_jawab.soal_jawab_nilai,'.
			'soal_jawab.soal_jawab_kelas,soal_jawab.soal_jawab_jurusan,soal_jawab.soal_jawab_jurusan_ke,'.
			'soal_jawab.soal_jawab_benar,soal_jawab.soal_jawab_salah,soal_jawab.soal_jawab_jumlah_soal,'.
			'soal_jawab.soal_jawab_pelajaran,'.
			'peserta.peserta_id,peserta.peserta_nama,peserta.peserta_jk'
		)
			->from('soal_jawab')
			->join('peserta', 'peserta.peserta_id = soal_jawab.siswa_id', 'LEFT');

		$ujian = $ujian->order_by('soal_jawab.soal_jawab_jurusan','asc');
		$ujian = $ujian->order_by('soal_jawab.soal_jawab_jurusan_ke','asc');
		$ujian = $ujian->order_by('soal_jawab.soal_jawab_kelas','asc');

		$ujian = $ujian->order_by('peserta.peserta_nama','asc');


		$ujian = $ujian->where('soal_jawab.ujian_id',$id);
		$ujian = $ujian->get()->result();


		//$data = array();
		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($ujian);





		$data = array();
		if(sizeof($ujian) > 0){


			include APPPATH.'third_party/PHPExcel/PHPExcel.php';

			$excel = new PHPExcel();


			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
			$style_col = array(
				'font' => array('bold' => true), // Set font nya jadi bold
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);
			$style_col2 = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);
			// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);
			$style_row2 = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('K5', "PERHITUNGAN NILAI 40 SOAL");
			$excel->setActiveSheetIndex(0)->setCellValue('K6', "(BENAR*25) / 10");

			$excel->setActiveSheetIndex(0)->setCellValue('K8', "PERHITUNGAN NILAI 30 SOAL");
			$excel->setActiveSheetIndex(0)->setCellValue('K9', "(BENAR/3) x 10");

			$excel->setActiveSheetIndex(0)->setCellValue('K11', "PERHITUNGAN NILAI 25 SOAL");
			$excel->setActiveSheetIndex(0)->setCellValue('K12', "BENAR x 4");

			$excel->getActiveSheet()->getStyle('K5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('K5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);

			$excel->getActiveSheet()->getStyle('K8')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('K8')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('K8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);

			$excel->getActiveSheet()->getStyle('K11')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('K11')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('K11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);


			$excel->getActiveSheet()->getStyle('K6')->applyFromArray($style_row2);
			$excel->getActiveSheet()->getStyle('K9')->applyFromArray($style_row2);
			$excel->getActiveSheet()->getStyle('K12')->applyFromArray($style_row2);


			$excel->setActiveSheetIndex(0)->setCellValue('A1', "UJIAN		: CBT"); // Set kolom A1 dengan tulisan "DATA SISWA"

			$excel->setActiveSheetIndex(0)->setCellValue('A2', "PELAJARAN	: " .$ujian_list[0]->ujian_pelajaran);
			$excel->setActiveSheetIndex(0)->setCellValue('A3', "GURU		: " . $ujian_list[0]->ujian_guru );

			$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B5', "NAMA");
			$excel->setActiveSheetIndex(0)->setCellValue('C5', "JK");
			$excel->setActiveSheetIndex(0)->setCellValue('D5', "KELAS JURUSAN");
			$excel->setActiveSheetIndex(0)->setCellValue('E5', "BENAR");
			$excel->setActiveSheetIndex(0)->setCellValue('F5', "SALAH");
			$excel->setActiveSheetIndex(0)->setCellValue('G5', "JUMLAH SOAL");
			$excel->setActiveSheetIndex(0)->setCellValue('H5', "NILAI");
			$excel->setActiveSheetIndex(0)->setCellValue('I5', "NILAI BULAT");


			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14); // Set font size 15 untuk kolom A1

			$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); // Set font size 15 untuk kolom A1

			$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); // Set font size 15 untuk kolom A1

			$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('B5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('D5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('E5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('F5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('G5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('H5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('H5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('I5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('I5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


			$no = 1;
			$numrow = 6;
			foreach ($ujian as $row1){

				$jumlah = $row1->soal_jawab_jumlah_soal;
				$nilai = $row1->soal_jawab_nilai;
				$nilai_bulat = $nilai;
				if($row1->soal_jawab_jumlah_soal == 40){
					$nilai = ($row1->soal_jawab_benar*25)/10;
				}elseif($row1->soal_jawab_jumlah_soal == 30){
					$nilai = ($row1->soal_jawab_benar/3)*10;
				}elseif($row1->soal_jawab_jumlah_soal == 25){
					$nilai = $row1->soal_jawab_benar*4;
				}

				$nilai = round($nilai,2);
				$nilai_bulat = round($nilai);

				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row1->peserta_nama);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row1->peserta_jk);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row1->soal_jawab_kelas .' '.$row1->soal_jawab_jurusan .' '.$row1->soal_jawab_jurusan_ke);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row1->soal_jawab_benar);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row1->soal_jawab_salah);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $jumlah);
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $nilai);
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $nilai_bulat);

				// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
				$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row2);
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_col2);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row2);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_col2);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row2);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row2);
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row2);
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row2);
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row2);

				$no++;
				$numrow++;

				$item[ 'peserta_id' ] = strip_tags($row1->peserta_id);
				$item[ 'peserta_nama' ] = strip_tags($row1->peserta_nama);
				array_push($data, $row1);
			}


			$filename = 'Nilai_Kelas_'. $ujian_list[0]->ujian_kelas .'_'.  $ujian_list[0]->ujian_jurusan.'_'.$ujian_list[0]->ujian_pelajaran .'_'.$ujian_list[0]->ujian_guru .'_'. date('Y');
			//$filename = 'Nilai_';

			// Set width kolom
			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->setActiveSheetIndex(0);




			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'.$filename .'.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');

		}else{
			die("Tidak ada data!");
			exit();
		}

		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($data);

	}

	function ujian_jawaban() {

		$id = $this->input->get('id');

		$ujian_list = $this->db->get_where("ujian",array("ujian_id" => $id))->result();


		$ujian = $this->db->select(
			'soal_jawab.ujian_id,soal_jawab.siswa_id,soal_jawab.soal_jawab_jumlah_soal,,soal_jawab.soal_jawab_nilai,'.
			'soal_jawab.soal_jawab_kelas,soal_jawab.soal_jawab_jurusan,soal_jawab.soal_jawab_jurusan_ke,'.
			'soal_jawab.soal_jawab_benar,soal_jawab.soal_jawab_salah,soal_jawab.soal_jawab_jumlah_soal,'.
			'soal_jawab.soal_jawab_pelajaran,'.
			'soal_jawab.soal_jawab_list_opsi,'.
			'peserta.peserta_id,peserta.peserta_nama,peserta.peserta_jk'
		)
			->from('soal_jawab')
			->join('peserta', 'peserta.peserta_id = soal_jawab.siswa_id', 'LEFT');

		$ujian = $ujian->order_by('soal_jawab.soal_jawab_jurusan','asc');
		$ujian = $ujian->order_by('soal_jawab.soal_jawab_jurusan_ke','asc');
		$ujian = $ujian->order_by('soal_jawab.soal_jawab_kelas','asc');

		$ujian = $ujian->order_by('peserta.peserta_nama','asc');


		$ujian = $ujian->where('soal_jawab.ujian_id',$id);
		$ujian = $ujian->get()->result();


		//$data = array();
		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($ujian);





		$data = array();
		if(sizeof($ujian) > 0){


			include APPPATH.'third_party/PHPExcel/PHPExcel.php';

			$excel = new PHPExcel();


			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
			$style_col = array(
				'font' => array('bold' => true), // Set font nya jadi bold
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);
			$style_col2 = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);
			// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);
			$style_row2 = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);

			$style_row3 = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '54D09A')
				)
			);



			$excel->setActiveSheetIndex(0)->setCellValue('A1', "UJIAN		: CBT"); // Set kolom A1 dengan tulisan "DATA SISWA"

			$excel->setActiveSheetIndex(0)->setCellValue('A2', "PELAJARAN	: " .$ujian_list[0]->ujian_pelajaran);
			$excel->setActiveSheetIndex(0)->setCellValue('A3', "GURU		: " . $ujian_list[0]->ujian_guru );

			$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B5', "NAMA");
			$excel->setActiveSheetIndex(0)->setCellValue('C5', "JK");
			$excel->setActiveSheetIndex(0)->setCellValue('D5', "KELAS JURUSAN");



			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14); // Set font size 15 untuk kolom A1

			$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); // Set font size 15 untuk kolom A1

			$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); // Set font size 15 untuk kolom A1

			$excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('B5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			$excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('D5')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1



			$ujian_jumlah_soal = $ujian_list[0]->ujian_jumlah_soal;
			$ujian_jumlah_soal+=3;

			$chars = $this->_print_char(65,86,65);
			$noa = 1;
			$no_col = 5;
			for($i=4;$i<=$ujian_jumlah_soal;$i++){
				$excel->setActiveSheetIndex(0)->setCellValue($chars[$i].$no_col, $noa);

				$excel->getActiveSheet()->getStyle($chars[$i].$no_col)->getFont()->setBold(TRUE); // Set bold kolom A1
				$excel->getActiveSheet()->getStyle($chars[$i].$no_col)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
				$excel->getActiveSheet()->getStyle($chars[$i].$no_col)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


				$noa++;
			}

			$excel->setActiveSheetIndex(0)->setCellValue($chars[$ujian_jumlah_soal+1].$no_col, "JUMLAH");

			$excel->getActiveSheet()->getStyle($chars[$ujian_jumlah_soal+1].$no_col)->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle($chars[$ujian_jumlah_soal+1].$no_col)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle($chars[$ujian_jumlah_soal+1].$no_col)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1



			$excel->setActiveSheetIndex(0)->setCellValue('B6', "JAWABAN BENAR");




			$opsi2 = array("A","B","C","D","E");

			$ujian_jenis = $ujian_list[0]->ujian_jenis;

			if($ujian_jenis == "Urut"){

				$ambil_soal = $this->db->get_where('soal', array(
					'soal_kelas' => $ujian_list[0]->ujian_kelas,
					'soal_guru' => $ujian_list[0]->ujian_guru,
					'soal_pelajaran' => $ujian_list[0]->ujian_pelajaran,
					//'soal_untuk' => $ujian_list[0]->ujian_untuk
				))->result();

				$data_jwb = array();
				foreach ($ambil_soal as $soal) {
					$soal_text_jawab = json_decode($soal->soal_text_jawab);

					$jwb_nomor = 0;
					foreach ($soal_text_jawab as $soal_text_jawab_item) {
						if ( $soal_text_jawab_item[0] == 1 ){
							array_push($data_jwb, $jwb_nomor);
						}
						$jwb_nomor++;
					}

				}

				$nob = 0;
				for($i=4;$i<=$ujian_jumlah_soal;$i++){
					$jwb_benar = "xxx";

					$excel->setActiveSheetIndex(0)->setCellValue($chars[$i].($no_col+1), $opsi2[$data_jwb[$nob]]);
					$excel->getActiveSheet()->getStyle($chars[$i].($no_col+1))->applyFromArray($style_row2);

					$nob++;
				}

			}




			$no = 1;
			$numrow = 8;
			foreach ($ujian as $row1){
				$soal_jawab_list_opsi = json_decode( $row1->soal_jawab_list_opsi );





				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row1->peserta_nama);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row1->peserta_jk);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row1->soal_jawab_kelas .' '.$row1->soal_jawab_jurusan .' '.$row1->soal_jawab_jurusan_ke);

				// Set width kolom
				$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
				$excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$excel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
				$excel->getActiveSheet()->getColumnDimension('D')->setWidth(45);

				// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
				$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row2);
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_col2);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row2);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_col2);

				$no1 = 0;
				$y = 4;
				$jumlah_benar = 0;
				$jumlah_terjawab = 0;
				foreach ($soal_jawab_list_opsi as $soal_jawab_list_opsi_item) {
					$id_soal = $soal_jawab_list_opsi_item[0];
					$jenis = $soal_jawab_list_opsi_item[1];
					$ragu = $soal_jawab_list_opsi_item[2];
					$jawaban = $soal_jawab_list_opsi_item[3];

					if ($jenis == 'optional') {

						if( $jawaban != "-" ){

							$ambil_soal = $this->db->get_where('soal', array('soal_id' => $id_soal))->result();
							foreach ($ambil_soal as $soal) {
								$soal_text_jawab = json_decode($soal->soal_text_jawab);

								//samakan jawaban peserta dengan jawaban soal
								$nomor_jawaban = 0;
								foreach ($soal_text_jawab as $soal_text_jawab_item) {

									if ( $soal_text_jawab_item[0] == 1 && $jawaban == $nomor_jawaban) {
										$jumlah_benar++;


										$excel->getActiveSheet()->getStyle($chars[$y].$numrow)->applyFromArray($style_row3);

									}

									$nomor_jawaban++;
								}

							}

							$jawaban = $opsi2[$jawaban];
						}

						$excel->setActiveSheetIndex(0)->setCellValue($chars[$y].$numrow, $jawaban);
						$excel->getActiveSheet()->getColumnDimension($chars[$y])->setWidth(3);
						$excel->getActiveSheet()->getStyle($chars[$y].$numrow)->applyFromArray($style_row2);


						/**
						if( $jawaban != "-" ) {
							$jawaban_data = array();
							//cari jawaban pada soal dengan $id_soal
							$ambil_soal = $this->db->get_where('soal', array('soal_id' => $id_soal))->result();
							foreach ($ambil_soal as $soal) {
								$soal_text_jawab = json_decode($soal->soal_text_jawab);

								//samakan jawaban peserta dengan jawaban soal
								$nomor_jawaban = 0;
								foreach ($soal_text_jawab as $soal_text_jawab_item) {

									if ( $soal_text_jawab_item[0] == 1 && $jawaban == $nomor_jawaban) {
										$jumlah_benar++;


										$excel->getActiveSheet()->getStyle($chars[$y].$numrow)->applyFromArray($style_row3);

									}

									$nomor_jawaban++;
								}

							}

							$jumlah_terjawab++;
						}*/

						//}elseif ($jenis == 'checkbox' && $jawaban != "" && $jawaban != "-") {
						//}elseif ($jenis == 'essay' && $jawaban != "" && $jawaban != "-") {
					}

					$no1++;
					$y++;
				}

				$excel->setActiveSheetIndex(0)->setCellValue($chars[$y].($numrow), $jumlah_benar);

				$excel->getActiveSheet()->getStyle($chars[$y].($numrow))->getFont()->setBold(TRUE); // Set bold kolom A1
				$excel->getActiveSheet()->getStyle($chars[$y].($numrow))->getFont()->setSize(12); // Set font size 15 untuk kolom A1
				$excel->getActiveSheet()->getStyle($chars[$y].($numrow))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


				$no++;
				$numrow++;


			}

			$filename = 'Jawaban_Kelas_'. $ujian_list[0]->ujian_kelas .'_'.  $ujian_list[0]->ujian_jurusan.'_'.$ujian_list[0]->ujian_pelajaran .'_'.$ujian_list[0]->ujian_guru .'_'. date('Y');


			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->setActiveSheetIndex(0);




			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'.$filename .'.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');

		}else{
			die("Tidak ada data!");
			exit();
		}


	}













	function soal1() {

		$soal_untuk = $this->input->get('untuk');
		$soal_pelajaran = $this->input->get('pelajaran');
		$soal_guru = $this->input->get('guru');

		$soal_kelas = $this->input->get('kelas');
		$soal_jurusan = $this->input->get('jurusan');


		$soal = $this->db->select('*')->from('soal');

		if(!empty($soal_untuk)){
			$soal = $soal->where('soal_untuk',$soal_untuk);
		}
		if(!empty($soal_pelajaran)){
			$soal = $soal->where('soal_pelajaran',$soal_pelajaran);
		}
		if(!empty($soal_guru)){
			$soal = $soal->where('soal_guru',$soal_guru);
		}

		if(!empty($soal_kelas)){
			$soal = $soal->where('soal_kelas',$soal_kelas);
		}
		if(!empty($soal_jurusan)){
			$soal = $soal->where('soal_jurusan',$soal_jurusan);
		}

		$soal = $soal->order_by('soal_date','asc');
		//$soal = $soal->limit(90);
		$soal = $soal->get();


		$data = array();

		$html = '<ol>';

		$n = 1;
		foreach ($soal->result_array() as $row1){

			$a = $b = $c = $d = $e = 'myOwnStyle1';
			$x1 = $x2 = $x3 = $x4 = $x5 = '';

			if( $row1['soal_text_jawab'] == '1' ){ $a = 'myOwnStyle2'; $x1 = ' style="font-weight:bold;"';}
			elseif( $row1['soal_text_jawab'] == '2' ){ $b = 'myOwnStyle2'; $x2 = ' style="font-weight:bold;"';}
			elseif( $row1['soal_text_jawab'] == '3' ){ $c = 'myOwnStyle2'; $x3 = ' style="font-weight:bold;"';}
			elseif( $row1['soal_text_jawab'] == '4' ){ $d = 'myOwnStyle2'; $x4 = ' style="font-weight:bold;"';}
			elseif( $row1['soal_text_jawab'] == '5' ){ $e = 'myOwnStyle2'; $x5 = ' style="font-weight:bold;"';}

			$html.= '<li>' . $row1['soal_text'];

			$jawaban = '<div style="clear: both;"></div><ol type="A">';
			if( $row1['soal_jenis'] == 'opsional' ){


				$jawaban.= '<li'.$x1.'>'.$this->hapus_abcde($row1['soal_text_opsi1']).'</li>';
				$jawaban.= '<li'.$x2.'>'.$this->hapus_abcde($row1['soal_text_opsi2']).'</li>';
				$jawaban.= '<li'.$x3.'>'.$this->hapus_abcde($row1['soal_text_opsi3']).'</li>';
				$jawaban.= '<li'.$x4.'>'.$this->hapus_abcde($row1['soal_text_opsi4']).'</li>';
				$jawaban.= '<li'.$x5.'>'.$this->hapus_abcde($row1['soal_text_opsi5']).'</li>';

			}
			$jawaban.= '</ol>';

			$n++;


			$item[ 'soal_tanya' ] = strip_tags($row1['soal_text_judul']);
			array_push($data, $item);


			$html.= $jawaban.'</li>';
		}


		$html.= '</ol>';

		$data['title'] = "ARSIP SOAL  " .
			strtoupper( $soal_untuk ) .'<br/>' .
			strtoupper( $soal_kelas ) .' '.
			strtoupper( $soal_jurusan ) .' '.
			strtoupper( $soal_jurusan_ke ) .'<br/>'.
			strtoupper( $soal_pelajaran  ) .'<br/>'.
			strtoupper( $soal_guru  );

		$data['html'] = $html;


		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($html);
		$this->load->view('soal',$data);


		// Get output html
		$html = $this->output->get_output();

		// Load pdf library
		$this->load->library('pdf');

		// Load HTML content
		$this->pdf->loadHtml($html);

		// (Optional) Setup the paper size and orientation
		$this->pdf->setPaper('A4', 'landscape');

		// Render the HTML as PDF
		$this->pdf->render();

		// Output the generated PDF (1 = download and 0 = preview)
		$this->pdf->stream("soal.pdf", array("Attachment"=>0));

	}

	function ujian1() {

		$id = $this->input->get('id');
		$order = $this->input->get('order');


		$ujian = $this->db->select('soal_jawab.*,peserta.*')
			->from('soal_jawab')
			->join('peserta', 'peserta.peserta_id = soal_jawab.siswa_id', 'LEFT');

		/**
		if(!empty( $order ) ){
		if( $order == 'nama' ){
		$ujian = $ujian->order_by('siswa.siswa_nama','asc');
		}elseif( $order == 'az' ){
		$ujian = $ujian->order_by('soal_jawab.soal_jawab_nilai','asc');
		}elseif( $order == 'za' ){
		$ujian = $ujian->order_by('soal_jawab.soal_jawab_nilai','desc');
		}else{
		$ujian = $ujian->order_by('siswa.siswa_nama','asc');
		}
		}else{
		$ujian = $ujian->order_by('siswa.siswa_nama','asc');
		}*/

		$ujian = $ujian->order_by('soal_jawab.soal_jawab_jurusan','asc');
		$ujian = $ujian->order_by('soal_jawab.soal_jawab_jurusan_ke','asc');
		$ujian = $ujian->order_by('soal_jawab.soal_jawab_kelas','asc');

		$ujian = $ujian->order_by('peserta.peserta_nama','asc');


		$ujian = $ujian->where('soal_jawab.ujian_id',$id);
		$ujian = $ujian->get()->result();




		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$excel = new PHPExcel();


		$data = array();


		if(sizeof($ujian) > 0){
			$excel->setActiveSheetIndex(0)->setCellValue('A1', "UJIAN		: CBT"); // Set kolom A1 dengan tulisan "DATA SISWA"

			$excel->setActiveSheetIndex(0)->setCellValue('A2', "PELAJARAN	: " .$ujian[0]->soal_jawab_pelajaran);
			//$excel->setActiveSheetIndex(0)->setCellValue('A3', "KELAS		: " . strtoupper($ujian[0]->soal_jawab_kelas) .", ". strtoupper($ujian[0]->soal_jawab_jurusan) .", ". strtoupper($ujian[0]->soal_jawab_jurusan_ke) );

			$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B5', "NAMA");
			$excel->setActiveSheetIndex(0)->setCellValue('C5', "KELAS JURUSAN");
			$excel->setActiveSheetIndex(0)->setCellValue('D5', "BENAR");
			$excel->setActiveSheetIndex(0)->setCellValue('E5', "SALAH");
			$excel->setActiveSheetIndex(0)->setCellValue('F5', "NILAI");
			$excel->setActiveSheetIndex(0)->setCellValue('G5', "JUMLAH SOAL");


			$no = 1;
			$numrow = 6;
			foreach ($ujian as $row1){

				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row1->peserta_nama);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, strtoupper($row1->soal_jawab_kelas) .' '.strtoupper($row1->soal_jawab_jurusan) .' '.$row1->soal_jawab_jurusan_ke);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row1->soal_jawab_benar);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row1->soal_jawab_salah);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row1->soal_jawab_nilai);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row1->soal_jawab_jumlah_soal);

				$no++;
				$numrow++;

				$item[ 'peserta_id' ] = strip_tags($row1->peserta_id);
				$item[ 'peserta_nama' ] = strip_tags($row1->peserta_nama);
				array_push($data, $row1);
			}

			$filename = 'Nilai_'. strtoupper( $ujian[0]->soal_jawab_kelas ) .'.'. strtoupper( $ujian[0]->soal_jawab_jurusan ) .'.'. $ujian[0]->soal_jawab_jurusan_ke .'_'. $ujian[0]->soal_jawab_pelajaran .'_'. date('Y');


			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->setActiveSheetIndex(0);




			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'.$filename .'.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		}


		//$this->output->set_header('Content-Type: application/json; charset=utf-8');
		//echo json_encode($data);

	}

	function ujian2() {

		$id = $this->input->get('id');
		$order = $this->input->get('order');




		$ujian = $this->db->select('soal_jawab.*,siswa.*,ujian.*')
			->from('soal_jawab')
			->join('siswa', 'siswa.siswa_id = soal_jawab.siswa_id', 'LEFT')
			->join('ujian', 'ujian.ujian_id = '.$id.'', 'LEFT');

		if(!empty( $order ) ){
			if( $order == 'nama' ){
				$ujian = $ujian->order_by('siswa.siswa_nama','asc');
			}elseif( $order == 'az' ){
				$ujian = $ujian->order_by('soal_jawab.soal_jawab_nilai','asc');
			}elseif( $order == 'za' ){
				$ujian = $ujian->order_by('soal_jawab.soal_jawab_nilai','desc');
			}else{
				$ujian = $ujian->order_by('siswa.siswa_nama','asc');
			}
		}else{
			$ujian = $ujian->order_by('siswa.siswa_nama','asc');
		}
		$ujian = $ujian->limit(10)->get()->result();




		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$excel = new PHPExcel();


		$data = array();


		if(sizeof($ujian) > 0){
			$excel->setActiveSheetIndex(0)->setCellValue('A1', "UJIAN		: CBT"); // Set kolom A1 dengan tulisan "DATA SISWA"

			$excel->setActiveSheetIndex(0)->setCellValue('A2', "PELAJARAN	: " .$ujian[0]->ujian_pelajaran);
			$excel->setActiveSheetIndex(0)->setCellValue('A3', "KELAS		: " . strtoupper($ujian[0]->ujian_kelas) .", ". strtoupper($ujian[0]->ujian_jurusan) );

			$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B5', "NAMA");
			$excel->setActiveSheetIndex(0)->setCellValue('C5', "JURUSAN");
			$excel->setActiveSheetIndex(0)->setCellValue('D5', "BENAR");
			$excel->setActiveSheetIndex(0)->setCellValue('E5', "SALAH");
			$excel->setActiveSheetIndex(0)->setCellValue('F5', "NILAI");
			$excel->setActiveSheetIndex(0)->setCellValue('G5', "JUMLAH SOAL");


			$no = 1;
			$numrow = 6;
			foreach ($ujian as $row1){

				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row1->siswa_nama);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, strtoupper($row1->soal_jawab_kelas) .' '.strtoupper($row1->soal_jawab_jurusan) .' '.$row1->soal_jawab_jurusan_ke);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row1->soal_jawab_benar);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row1->soal_jawab_salah);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row1->soal_jawab_nilai);
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row1->soal_jawab_jumlah_soal);

				$no++;
				$numrow++;

				$item[ 'siswa_id' ] = strip_tags($row1->siswa_id);
				$item[ 'siswa_nama' ] = strip_tags($row1->siswa_nama);
				array_push($data, $item);
			}

			$filename = 'Nilai_'. strtoupper( $ujian[0]->soal_jawab_kelas ) .'.'. strtoupper( $ujian[0]->soal_jawab_jurusan ) .'.'. $ujian[0]->soal_jawab_jurusan_ke .'_'. $ujian[0]->soal_jawab_pelajaran .'_'. date('Y');


			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->setActiveSheetIndex(0);


			/**

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'.$filename .'.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');*/
		}


		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);

	}

	function hapus_abcde($sa){
		$sa = str_replace("&lt;!-- [if gte vml 1]>","",$sa);
		$sa = str_replace("&lt;!--[endif]--&gt;","",$sa);
		$sa = str_replace("&lt;![endif]--&gt;","",$sa);
		$sa = str_replace("&lt;!-- [if !vml]--&gt;","",$sa);
		$sa = str_replace("&lt;!-- [if !supportLists]--&gt;","",$sa);

		return $sa;
	}

	function _print_char($start_no=65, $end_no=90, $prefix_no=0){
		$vasant = array();
		if($prefix_no==0)
		{
			for($set=$start_no; $set<=$end_no; $set++)
			{
				array_push($vasant,(chr($prefix_no).chr($set)));
			}
		}
		else
		{
			for($set=$start_no; $set<=90; $set++)
			{
				array_push($vasant,chr($set));
			}
			for($pre_loop=65; $pre_loop<=$prefix_no; $pre_loop++)
			{
				for($set=$start_no; $set<=90; $set++)
				{
					if($set>=$end_no && $pre_loop==$prefix_no)
					{
						array_push($vasant,(chr($pre_loop).chr($set)));

						break;
					}
					else
					{
						array_push($vasant,(chr($pre_loop).chr($set)));
					}
				}
			}
		}
		return $vasant;
	}

	function tes(){
		$ambil_soal = $this->db->get_where('soal', array(
			'soal_kelas' => "12",
			'soal_guru' => "Eko Hendratno, S.Kom",
			'soal_pelajaran' => "Produktif C-3",
			//'soal_untuk' => $ujian_list[0]->ujian_untuk
		))->result();

		$data_jwb = array();
		foreach ($ambil_soal as $soal) {
			$soal_text_jawab = json_decode($soal->soal_text_jawab);

			$jwb_nomor = 0;
			foreach ($soal_text_jawab as $soal_text_jawab_item) {
				if ( $soal_text_jawab_item[0] == 1 ){
					array_push($data_jwb, $jwb_nomor);
				}
				$jwb_nomor++;
			}

		}

		$nob = 0;
		for($i=4;$i<=40;$i++){
			$jwb_benar = "xxx";



			$nob++;
		}

		print_r($data_jwb);
	}
}
?>
