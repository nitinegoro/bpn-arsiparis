<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_history extends CI_Controller {

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
		$this->load->library(array('session','upload','encrypt','Excel/PHPExcel'));
		$this->load->model(array('m_apps','m_laporan'));
		$this->load->helper(array('form','url','html'));
	}

	public function index()
	{
		$where = array(
			'id_hak' => $this->input->get('jenishak'), 
			'no_hakbuku' => $this->input->get('nohak'),
			'id_desa' => $this->input->get('desa'),
			'no208' => $this->input->get('no208'),
			'bln' => $this->input->get('bln'),
			'thn_warkah' => $this->input->get('thn_warkah'),
			'thn_history' => $this->input->get('thn_history')
		);

        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $config = pagination_list();
        $config['base_url'] = site_url("laporan_history?jenishak={$where['id_hak']}&no208={$where['no208']}&nohak={$where['no_hakbuku']}&thn_warkah={$where['thn_warkah']}&desa={$where['id_desa']}&thn_history={$where['thn_history']}&bln={$where['bln']}");
		$config['per_page'] = 50;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->count($where);
        $this->pagination->initialize($config);

		$data = array(
			'title' => 'Laporan History'.DEFAULT_TITLE, 
			'hakmilik' => $this->mbpn->jenis_hak(),
			'data_history' => $this->filtered($where, $config['per_page'], $page)
		);
		$this->template->view('v_laporan_history', $data);
	}

	/**
	 * Query Where data history
	 *
	 * @return string
	 **/
	public function filtered(Array $data, $limit = 50, $offset = 0)
	{
		$this->db->join('tb_buku_tanah', 'tb_history.id_bukutanah = tb_buku_tanah.id_bukutanah');
		
		$this->db->join('tb_users', 'tb_history.nip = tb_users.nip');
		//$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');

		if ($data['id_hak'] != '') $this->db->where('tb_buku_tanah.id_hak', $data['id_hak']);
		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_buku_tanah.id_desa', $data['id_desa']);
		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn_warkah'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn_warkah']);
		if ($data['bln'] != '') $this->db->where('tb_history.bulan', $data['bln']);
		if ($data['thn_history'] != '') $this->db->where('tb_history.tahun', $data['thn_history']);
		$this->db->order_by('tb_history.time', 'desc');
		$query = $this->db->get('tb_history', $limit, $offset);
		return $query->result();
	}

	/**
	 * Menghitung Query Where data history
	 *
	 * @return string
	 **/
	public function count(Array $data)
	{
		$this->db->join('tb_buku_tanah', 'tb_history.id_bukutanah = tb_buku_tanah.id_bukutanah');
		
		$this->db->join('tb_users', 'tb_history.nip = tb_users.nip');
		//$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');

		if ($data['id_hak'] != '') $this->db->where('tb_buku_tanah.id_hak', $data['id_hak']);
		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_buku_tanah.id_desa', $data['id_desa']);
		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn_warkah'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn_warkah']);
		if ($data['bln'] != '') $this->db->where('tb_history.bulan', $data['bln']);
		if ($data['thn_history'] != '') $this->db->where('tb_history.tahun', $data['thn_history']);

		$query = $this->db->get('tb_history');
		return $query->num_rows();
	}


	/**
	 * Menampilkan Cetak Data History
	 *
	 * @return pages print
	 **/
	public function cetak()
	{
		$data = array(
			'id_hak' => $this->input->get('jenishak'), 
			'no_hakbuku' => $this->input->get('nohak'),
			'id_desa' => $this->input->get('desa'),
			'no208' => $this->input->get('no208'),
			'bln' => $this->input->get('bln'),
			'thn_warkah' => $this->input->get('thn_warkah'),
			'thn_history' => $this->input->get('thn_history')
		);

		$this->db->join('tb_buku_tanah', 'tb_history.id_bukutanah = tb_buku_tanah.id_bukutanah');
		
		$this->db->join('tb_users', 'tb_history.nip = tb_users.nip');
		$this->db->join('tb_desa', 'tb_buku_tanah.id_desa = tb_desa.id_desa');
		$this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');

		if ($data['id_hak'] != '') $this->db->where('tb_buku_tanah.id_hak', $data['id_hak']);
		if ($data['no_hakbuku'] != '') $this->db->where('tb_buku_tanah.no_hakbuku', $data['no_hakbuku']);
		if ($data['id_desa'] != '') $this->db->where('tb_buku_tanah.id_desa', $data['id_desa']);
		if ($data['no208'] != '') $this->db->where('tb_buku_tanah.no208', $data['no208']);
		if ($data['thn_warkah'] != '') $this->db->where('tb_buku_tanah.tahun', $data['thn_warkah']);
		if ($data['bln'] != '') $this->db->where('tb_history.bulan', $data['bln']);
		if ($data['thn_history'] != '') $this->db->where('tb_history.tahun', $data['thn_history']);

		$query = $this->db->get('tb_history');

		$data_history = array(
			'data_loop' => $query->result() , 
		);

		$this->load->view('app-html/cetak_history', $data_history);
	}

}

/* End of file Laporan_history.php */
/* Location: ./application/controllers/Laporan_history.php */