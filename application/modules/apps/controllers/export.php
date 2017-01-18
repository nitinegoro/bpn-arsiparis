<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Index Ecport Dokumen Aplikasi
 *
 * Controller Ini sudah dialihkan pada  ./../config/routes.php
 * @access http://example_root/buku
 * @package Apps - Class Ecport.php
 * @author https://facebook.com/muh.azzain
 **/
class Export extends CI_Controller {
	// generate name user
	private $name_user;
	// generate nip user
	private $nip;

	public function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('login') ) :
			redirect(site_url('login'));
			return;
		endif;
		$data_session = $this->session->userdata('login');
		$this->name_user = $data_session['nama_lengkap'];
		$this->nip = $data_session['nip'];
		$this->load->library(array('session','upload','encrypt','Excel/PHPExcel','PHPExcel/IOFactory','user_agent'));
		$this->load->model(array('m_apps','m_buku','m_warkah','m_backup','m_laporan'));
		$this->load->helper(array('form','url','html'));
		$this->load->dbutil();
	}

	public function index()
	{
	    $where = array(
	      'id_hak' => $this->input->get('jenishak'), 
	      'id_desa' => $this->input->get('desa'),
	      'no_hakbuku' => $this->input->get('nohak'),
	      'no208' => $this->input->get('no208'),
	      'thn' => $this->input->get('thn'),
	      'bln' => $this->input->get('bln')
	    );

        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $config = pagination_list();
        $config['base_url'] = site_url("apps/export?jenishak={$where['id_hak']}&no208={$where['no208']}&nohak={$where['no_hakbuku']}&thn={$where['thn']}&desa={$where['id_desa']}&bln={$where['bln']}");
		$config['per_page'] = 50;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->count($where);
        $this->pagination->initialize($config);
        
		$data = array(
			'title' => 'Export Buku Tanah'.DEFAULT_TITLE, 
			'data' => $this->filtered($where, $config['per_page'], $page),
			'per_page' => $config['per_page'],
			'total_page' => $config['total_rows']
		);
		$this->template->view('v_export', $data);
	}

	/**
	 * Mengeprint Data Belum tersimpan berdasarkan FIltered Data
	 *
	 * @return Print Page
	 **/
	public function cetak()
	{
	    $where = array(
	      'id_hak' => $this->input->get('jenishak'), 
	      'id_desa' => $this->input->get('desa'),
	      'no_hakbuku' => $this->input->get('nohak'),
	      'no208' => $this->input->get('no208'),
	      'thn' => $this->input->get('thn'),
	    );		

		$data = array('data' => $this->filtered($where, $this->count($where), 0), );
		$this->load->view('app-html/v_print_export', $data, FALSE);
	}

	/**
	 * Menghitung Jumlah Data Yang akan ditampilkan
	 *
	 * @return Integer
	 **/
	private function count( Array $data)
	{

		$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
		$this->db->join('tb_kecamatan', 'tb_buku_tanah.id_kecamatan = tb_kecamatan.id_kecamatan');

		if ($data['id_hak'] != '') $this->db->where('tb_buku_tanah.id_hak', $data['id_hak']);
		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_buku_tanah.id_desa', $data['id_desa']);
		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn']);

		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}

	/**
	 * Menampilkan Data Dokumen Yang akan dittampilkan
	 *
	 * @return Query Result
	 **/
	public function filtered( Array $data, $limit = 50, $offset = 0) 
	{

		$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
		$this->db->join('tb_kecamatan', 'tb_buku_tanah.id_kecamatan = tb_kecamatan.id_kecamatan');

		if ($data['id_hak'] != '') $this->db->where('tb_buku_tanah.id_hak', $data['id_hak']);
		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_buku_tanah.id_desa', $data['id_desa']);
		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn']);

		$this->db->order_by('tb_buku_tanah.id_bukutanah', 'desc');
		$query = $this->db->get('tb_buku_tanah', $limit, $offset);
		return $query->result();
	}

	/**
	 * Mengimport Database Dataabse Baru
	 *
	 * @see http://stackoverflow.com/questions/25147099/how-i-can-execute-a-sql-script-with-codeigniter-and-pass-data-to-it
	 * @return Repair (Import Database)
	 **/
	public function import_database()
	{
		$data = array(
			'title' => 'Import Database'.DEFAULT_TITLE, 
		);
		$this->template->view('v_import_database', $data);
	}

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	public function insert_database()
	{
/*		if($this->agent->platform() == 'linux')
			chmod("/opt/lampp/htdocs/assets", 777); */
		$media = $this->upload->data('file');
        $fileName = $media['file_name'];
        $config['upload_path'] = './assets/backup_db/'; 
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'sql|SQL';

        $this->upload->initialize($config);
        if( ! $this->upload->do_upload('file') ) :
			echo json_encode(array('status'=>false, 'error' => 'Mengaploud File'));
        endif;
        // read derectory and file name
        $inputFileName = './assets/backup_db/'.$this->upload->file_name;
        // loaded file
		$file_restore = $this->load->file($inputFileName, true);
		$file_array = explode(';', $file_restore);

		$sqls = explode(';', $file_restore);
		array_pop($sqls);

		foreach($sqls as $statement) :
		    $statment = $statement . ";";
		    $this->db->query($statement);   
		endforeach;
		@unlink($inputFileName);
		echo json_encode(array('status'=>true), JSON_PRETTY_PRINT);
		//$this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>true), JSON_PRETTY_PRINT));
	}

	/**
	 * force_download file Backup
	 *
	 * @return Zip.file
	 **/
	public function backup()
	{
        $prefs = array(     
                'format'      => 'zip',             
                'filename'    => 'database_sim_bpn.sql'
              );
        $backup =& $this->dbutil->backup($prefs); 

        $db_name = 'BACKAUP_SISTEM_BPN-'. date("Y-m-d-H-i-s") .'.zip';

        $this->load->helper('download');
        force_download($db_name, $backup); 
	}

	/**
	 * Mengeksport Semua Data ke Excel
	 *
	 * @return php excel Output
	 **/
	public function excel()
	{
	    $where = array(
	      'id_hak' => $this->input->get('jenishak'), 
	      'id_desa' => $this->input->get('desa'),
	      'no_hakbuku' => $this->input->get('nohak'),
	      'no208' => $this->input->get('no208'),
	      'thn' => $this->input->get('thn'),
	      'bln' => $this->input->get('bln'),
	      'thn_pinjam' => $this->input->get('thn_pinjam')
	    );

        $objPHPExcel = new PHPExcel();
        //buat properties file
		$objPHPExcel->getProperties()
					->setCreator("BPN V.1.0.1")
					->setLastModifiedBy($this->name_user)
					->setTitle("Backup")
					->setSubject("BACKAUP_SISTEM_BPN")
					->setDescription("Kanwil BPN Prop. Kep. Bangka Belitung")
					->setKeywords("Data Dokumen Buku Tanah")
					->setCategory("Export");
		// Create sheet DOKUMEN
		 $worksheet = $objPHPExcel->createSheet(0); // Sheet yang aktif
		// set bold header
	    for ($cell1='A'; $cell1<='I'; $cell1++) :
	        $worksheet->getStyle($cell1.'1')->getFont()->setBold(true);
	    endfor;
		// Header dokumen
		 $worksheet->setCellValue('A1', 'NO.')
				   ->setCellValue('B1', 'JENIS HAK')
				   ->setCellValue('C1', 'NOMOR HAK')
				   ->setCellValue('D1', 'KECAMATAN')
				   ->setCellValue('E1', 'DESA')
				   ->setCellValue('F1', 'LUAS')
				   ->setCellValue('G1', 'NOMOR 208')
				   ->setCellValue('H1', 'TAHUN')
				   ->setCellValue('I1', 'STATUS');
		// DATA dokumen
		$row_cell = 2; $no = 1;
		foreach($this->filtered($where, $this->count($where), 0) as $row) :
		 $worksheet->setCellValue('A'.$row_cell, $no)
				   ->setCellValue('B'.$row_cell, $row->jenis_hak)
				   ->setCellValue('C'.$row_cell, $row->no_hakbuku)
				   ->setCellValue('D'.$row_cell, $row->nama_kecamatan)
				   ->setCellValue('E'.$row_cell, $row->nama_desa)
				   ->setCellValue('F'.$row_cell, $row->luas)
				   ->setCellValue('G'.$row_cell, $row->no208)
				   ->setCellValue('H'.$row_cell, $row->tahun)
				   ->setCellValue('I'.$row_cell, ($row->status_buku=='Y') ? 'Aktif' : 'Mati');
		$no++; $row_cell++;
		endforeach;
		// Create Sheet DOKEMEN
		 $worksheet->setTitle("DOKUMEN");


		// Add new sheet BUKU KELUAR
		 $worksheet = $objPHPExcel->createSheet(1); // Sheet yang aktif
		// set bold header
	    for ($cell2='A'; $cell2<='I'; $cell2++) :
	        $worksheet->getStyle($cell2.'1')->getFont()->setBold(true);
	    endfor;
		// Header buku keluar
		 $worksheet->setCellValue('A1', 'NO.')
				   ->setCellValue('B1', 'JENIS HAK')
				   ->setCellValue('C1', 'NOMOR HAK')
				   ->setCellValue('D1', 'KELUAR')
				   ->setCellValue('E1', 'KEMBALI')
				   ->setCellValue('F1', 'PETUGAS')
				   ->setCellValue('G1', 'PEMINJAM')
				   ->setCellValue('H1', 'KEGIATAN')
				   ->setCellValue('I1', 'STATUS');
		// DATA BUKU KELUAR
		$row_cell2 = 2; $no = 1;
		foreach($this->m_backup->buku_keluar($where) as $row) :
		 $worksheet->setCellValue('A'.$row_cell2, $no)
				   ->setCellValue('B'.$row_cell2, $row->jenis_hak)
				   ->setCellValue('C'.$row_cell2, $row->no_hakbuku)
				   ->setCellValue('D'.$row_cell2, tgl_indo($row->tgl_peminjaman))
				   ->setCellValue('E'.$row_cell2, tgl_indo($row->tgl_kembali))
				   ->setCellValue('F'.$row_cell2, $row->nama_lengkap)
				   ->setCellValue('G'.$row_cell2, $row->peminjam)
				   ->setCellValue('H'.$row_cell2, $row->kegiatan)
				   ->setCellValue('I'.$row_cell2, ($row->status_pinjam=='Y') ? 'KEMBALI' : 'KELUAR');
		$row_cell2++; $no++; 
		endforeach;
		// Create Sheet BUKU KELUAR
		$worksheet->setTitle("BUKU KELUAR");



		// Add new sheet WARKAH KELUAR
		 $worksheet = $objPHPExcel->createSheet(2); // Sheet yang aktif
		// set bold header
	    for ($cell3='A'; $cell3<='I'; $cell3++) :
	        $worksheet->getStyle($cell3.'1')->getFont()->setBold(true);
	    endfor;
		// Header warkah keluar
		 $worksheet->setCellValue('A1', 'NO.')
				   ->setCellValue('B1', 'NOMOR 208')
				   ->setCellValue('C1', 'TAHUN')
				   ->setCellValue('D1', 'KELUAR')
				   ->setCellValue('E1', 'KEMBALI')
				   ->setCellValue('F1', 'PETUGAS')
				   ->setCellValue('G1', 'PEMINJAM')
				   ->setCellValue('H1', 'KEGIATAN')
				   ->setCellValue('I1', 'STATUS');
		// DATA WARKAH KELUAR
		$row_cell3 = 2; $no = 1;
		foreach($this->m_backup->warkah_keluar($where) as $row) :
		 $worksheet->setCellValue('A'.$row_cell3, $no)
				   ->setCellValue('B'.$row_cell3, $row->no208)
				   ->setCellValue('C'.$row_cell3, $row->tahun)
				   ->setCellValue('D'.$row_cell3, tgl_indo($row->tgl_peminjaman))
				   ->setCellValue('E'.$row_cell3, tgl_indo($row->tgl_kembali))
				   ->setCellValue('F'.$row_cell3, $row->nama_lengkap)
				   ->setCellValue('G'.$row_cell3, $row->peminjam)
				   ->setCellValue('H'.$row_cell3, $row->kegiatan)
				   ->setCellValue('I'.$row_cell3, ($row->status_pinjam=='Y') ? 'KEMBALI' : 'KELUAR');
		$row_cell3++; $no++;
		endforeach;
		// Create Sheet WARKAH KELUAR
		$worksheet->setTitle("WARKAH KELUAR");


		$objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');\
        header('Content-Disposition: attachment;filename="BACKAUP_SISTEM_BPN_EXCEL.xlsx"');
        $objWriter->save("php://output");
	}


	public function test()
	{
		foreach($this->m_backup->warkah_keluar() as $row) :
			echo $row->nama_lengkap;
		endforeach;
	}
}

/* End of file Export.php */
/* Location: ./application/modules/apps/controllers/Export.php */