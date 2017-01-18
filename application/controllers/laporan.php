<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	private $name_user;
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
		$this->load->library(array('session','upload','encrypt','Excel/PHPExcel','PHPExcel/IOFactory'));
		$this->load->model(array('m_apps','m_laporan'));
		$this->load->helper(array('form','url','html'));
	}

	public function index()
	{
		$min_thn = (!$this->m_laporan->min_year()) ? date('Y') : $this->m_laporan->min_year();
        for($tahun = date('Y'); $tahun >= $min_thn;  $tahun--) :
        	$data_tahun['records'][] = array('tahun' => $tahun);
        endfor;
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $config = pagination_list();
        $config['base_url'] = site_url("laporan?load=thn");
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = count($data_tahun['records']);
        $this->pagination->initialize($config);

		$data = array(
			'title' => 'Edit Warkah Tanah'.DEFAULT_TITLE, 
			'hakmilik' => $this->mbpn->jenis_hak(),
			'tahun' => array_slice($data_tahun['records'],$page, $config['per_page'], $config['total_rows'])
		);
		$this->template->view('v_laporan', $data);
	}

	/**
	 * Mendownload Data Laporan
	 *
	 * @return string
	 **/
	public function unduh()
	{
        $objPHPExcel = new PHPExcel();
        //buat properties file
		$objPHPExcel->getProperties()
					->setCreator("BPN V.1.0.1")
					->setLastModifiedBy($this->name_user)
					->setTitle("Data Laporan")
					->setSubject("BACKAUP_SISTEM_BPN")
					->setDescription("Kanwil BPN Prop. Kep. Bangka Belitung")
					->setKeywords("Data Dokumen Buku Tanah")
					->setCategory("Export");
		// Create sheet DOKUMEN
		 $worksheet = $objPHPExcel->createSheet(0); // Sheet yang aktif
	    for ($cell='A'; $cell<='V'; $cell++) :
	        $worksheet->getStyle($cell.'1')->getFont()->setBold(true);
	        $worksheet->getStyle($cell.'2')->getFont()->setBold(true);
	    endfor;
		$worksheet->setCellValue('A1', "Tahun");
		$alphabet = 'A';
		foreach ($this->mbpn->jenis_hak() as $col => $val) :
		$worksheet->setCellValue(++$alphabet.'1', $val->jenis_hak)
				    ->setCellValue(++$alphabet.'1', '')
				    ->setCellValue(++$alphabet.'1', '');
		endforeach;
		$worksheet->setCellValue('B2', 'Aktif')
				   	->setCellValue('C2', 'Mati')
				   	->setCellValue('D2', 'Luas')
				   	->setCellValue('E2', 'Aktif')
				   	->setCellValue('F2', 'Mati')
				   	->setCellValue('G2', 'Luas')
				   	->setCellValue('H2', 'Aktif')
				   	->setCellValue('I2', 'Mati')
				   	->setCellValue('J2', 'Luas')
				   	->setCellValue('K2', 'Aktif')
				   	->setCellValue('L2', 'Mati')
				   	->setCellValue('M2', 'Luas')
				   	->setCellValue('N2', 'Aktif')
				   	->setCellValue('O2', 'Mati')
				   	->setCellValue('P2', 'Nilai')
				   	->setCellValue('Q2', 'Aktif')
				   	->setCellValue('R2', 'Mati')
				   	->setCellValue('S2', 'Luas')
				   	->setCellValue('T2', 'Aktif')
				   	->setCellValue('U2', 'Mati')
				   	->setCellValue('V2', 'Luas');

		$worksheet->mergeCells('A1:A2');
		$worksheet->mergeCells('B1:D1')
					->mergeCells('E1:G1')
					->mergeCells('H1:J1')
					->mergeCells('K1:M1')
					->mergeCells('N1:P1')
					->mergeCells('Q1:S1')
					->mergeCells('T1:V1')
					->mergeCells('W1:Y1');
		$cell = 3; 
		for($tahun = date('Y'); $tahun >= $this->m_laporan->min_year(); $tahun--) :
		$worksheet->setCellValue("A{$cell}", $tahun);
		$abjad = 'B';
		foreach ($this->mbpn->jenis_hak() as $col => $val) :
		$cell2 = $cell;
		$worksheet->setCellValue($abjad++."{$cell2}", $this->m_laporan->count_status('Y', $val->id_hak, $tahun))
				   	->setCellValue($abjad++."{$cell2}", $this->m_laporan->count_status('N', $val->id_hak, $tahun))
				   	->setCellValue($abjad++."{$cell2}", $this->m_laporan->count_luas($val->id_hak, $tahun));
		endforeach;
		$cell++;
		endfor;
		$worksheet->setTitle("Laporan Buku Tanah");
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

	public function tes($value='')
	{
		for($tahun = date('Y'); $tahun >= $this->m_laporan->min_year(); $tahun--) :
			echo $tahun."<br>";
			foreach ($this->mbpn->jenis_hak() as $col => $val) :
				echo "(".$this->m_laporan->count_luas($val->id_hak, $tahun).")<br>";
			endforeach;
		endfor;
	}
}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */