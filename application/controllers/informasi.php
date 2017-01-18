<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informasi extends CI_Controller {

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
		$this->load->library(array('session'));
		$this->load->model(array('m_apps'));
		$this->load->helper(array('form','url','html'));
	}

	public function index()
	{
	    $where = array(
	      'id_hak' => $this->input->get('jenishak'), 
	      'id_desa' => $this->input->get('desa'),
	      'no_hakbuku' => $this->input->get('nohak'),
	      'no208' => $this->input->get('no208'),
	      'thn' => $this->input->get('thn'),
	      'storage' => $this->input->get('storage'),
	      'pemilik' => $this->input->get('pemilik'),
	      'status' => $this->input->get('status')
	    );

        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $config = pagination_list();
        $config['base_url'] = site_url("informasi?jenishak={$where['id_hak']}&no208={$where['no208']}&nohak={$where['no_hakbuku']}&thn={$where['thn']}&desa={$where['id_desa']}&storage={$where['storage']}&pemilik={$where['pemilik']}&status={$where['status']}");
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->count($where);
        $this->pagination->initialize($config);
        
		$data = array(
			'title' => 'Informasi Buku Tanah Belum Tersimpan'.DEFAULT_TITLE, 
			'data' => $this->filtered($where, $config['per_page'], $page),
			'per_page' => $config['per_page'],
			'total_page' => $config['total_rows']
		);
		$this->template->view('v_informasi', $data);
	}

	/**
	 * Menghitung Jumlah Data Yang belo tersimpan
	 *
	 * @return Integer
	 **/
	private function count( Array $data)
	{

	//	$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
		$this->db->join('tb_simpan_buku', 'tb_buku_tanah.id_bukutanah = tb_simpan_buku.id_bukutanah');

		if($data['storage']=='belum') :
			$this->db->where('tb_simpan_buku.no_lemari', 0);	
			$this->db->where('tb_simpan_buku.no_rak', 0);	
			$this->db->where('tb_simpan_buku.no_album', 0);	
			$this->db->where('tb_simpan_buku.no_halaman', 0);
		elseif($data['storage']=='sudah') :
			$this->db->where('tb_simpan_buku.no_lemari !=', 0);	
			$this->db->where('tb_simpan_buku.no_rak !=', 0);	
			$this->db->where('tb_simpan_buku.no_album !=', 0);	
			$this->db->where('tb_simpan_buku.no_halaman !=', 0);
		endif;

		if ($data['id_hak'] != '') $this->db->where('tb_buku_tanah.id_hak', $data['id_hak']);
		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_buku_tanah.id_desa', $data['id_desa']);
		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn']);
		if ($data['pemilik'] != '') $this->db->like('tb_buku_tanah.pemilik_awal', $data['pemilik']);
		if ($data['status'] != '') $this->db->where('tb_buku_tanah.status_buku', $data['status']);

		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}


	/**
	 * Menampilkan Data Dokumen Yang belum tersimpan
	 *
	 * @return Query Result
	 **/
	public function filtered( Array $data, $limit = 50, $offset = 0) 
	{

		//$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
		$this->db->join('tb_simpan_buku', 'tb_buku_tanah.id_bukutanah = tb_simpan_buku.id_bukutanah');

		if($data['storage']=='belum') :
			$this->db->where('tb_simpan_buku.no_lemari', 0);	
			$this->db->where('tb_simpan_buku.no_rak', 0);	
			$this->db->where('tb_simpan_buku.no_album', 0);	
			$this->db->where('tb_simpan_buku.no_halaman', 0);
		elseif($data['storage']=='sudah') :
			$this->db->where('tb_simpan_buku.no_lemari !=', 0);	
			$this->db->where('tb_simpan_buku.no_rak !=', 0);	
			$this->db->where('tb_simpan_buku.no_album !=', 0);	
			$this->db->where('tb_simpan_buku.no_halaman !=', 0);
		endif;

		if ($data['id_hak'] != '') $this->db->where('tb_buku_tanah.id_hak', $data['id_hak']);
		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_buku_tanah.id_desa', $data['id_desa']);
		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn']);
		if ($data['pemilik'] != '') $this->db->like('tb_buku_tanah.pemilik_awal', $data['pemilik']);
		if ($data['status'] != '') $this->db->where('tb_buku_tanah.status_buku', $data['status']);

		$this->db->order_by('tb_buku_tanah.id_bukutanah', 'desc');
		$query = $this->db->get('tb_buku_tanah', $limit, $offset);
		return $query->result();
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
	      'storage' =>$this->input->get('storage'),
	      'pemilik' => $this->input->get('pemilik'),
	      'status' => $this->input->get('status')
	    );		

		$data = array('data' => $this->filtered($where, $this->count($where), 0), );
		$this->load->view('app-html/v_print_informasi', $data, FALSE);
	}


}

/* End of file Belum_tersimpan.php */
/* Location: ./application/controllers/Belum_tersimpan.php */