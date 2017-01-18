<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Index Data Hak Bangka Tengah
 *
 * Controller Ini sudah dialihkan pada  ./../config/routes.php
 * @access http://example_root/setting/chak
 * @package Apps - Class chak.php
 * @author https://facebook.com/muh.azzain
 **/
class Chak extends CI_Controller {
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
		$page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("setting/chak?data=hak");
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->db->count_all('tb_hak_milik');
        $this->pagination->initialize($config);

		$data = array(
			'title' => 'Manajemen Jenis Hak'.DEFAULT_TITLE, 
			'data_hak' => $this->db->get('tb_hak_milik',$config['per_page'], $page)->result()
		);

		$this->template->view('setting/v_hak', $data);
	}

	/**
	 * Menambahkah Jenis Hak Baru
	 *
	 * @return string
	 **/
	public function add()
	{
		$data_hak = array(
			'jenis_hak' =>$this->input->post('hak'), 
			'slug_jenis_hak' => set_permalink( $this->input->post('hak') )
		);
		$this->db->insert('tb_hak_milik', $data_hak);
		redirect('setting/chak');
	}

	/**
	 * Mengubah Jenis Hak Baru
	 *
	 * @return string
	 **/
	public function update($ID=0)
	{
		$data_hak = array(
			'jenis_hak' =>$this->input->post('hak'), 
			'slug_jenis_hak' => set_permalink( $this->input->post('hak') )
		);
		$this->db->update('tb_hak_milik', $data_hak, array('id_hak'=>$ID));
		redirect('setting/chak');
	}

	/**
	 * Menampilkan Data Jenias Hak JSON
	 *
	 * @return string
	 **/
	public function get($ID=0)
	{
		$data = $this->db->get_where('tb_hak_milik', array('id_hak'=>$ID));
		$output = array(
			'status' => (!$data->num_rows()) ? false : true,
			'result' =>  $data->result()
		);
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	/**
	 * Menghapus Data Jenis Hak dan dokumen berkaitan
	 *
	 * @return string
	 **/
	public function delete($ID=0)
	{
		$this->db->delete('tb_hak_milik', array('id_hak'=>$ID));
		// delete dokumen berkaitan dengan kecamatan
		$data_buku = $this->db->get_where('tb_buku_tanah', array('id_hak'=>$ID));
		foreach($data_buku->result() as $row) :
			$data_file_buku = $this->db->get_where('tb_file_tanah', array('no_hakbuku'=>$row->no_hakbuku));
			// buku tanah
			$this->db->delete('tb_simpan_buku', array('no_hakbuku' => $row->no_hakbuku));
			$this->db->delete('tb_pinjam_buku', array('no_hakbuku' => $row->no_hakbuku));
			foreach($data_file_buku->result() as $file) :
				@unlink("./assets/files/{$file->nama_file}");
			endforeach;
			// warkah tanah
			$this->db->delete('tb_simpan_warkah', array('no208' => $row->no208));
			$this->db->delete('tb_pinjam_warkah', array('no208' => $row->no208));
			$data_file_warkah = $this->db->get_where('tb_file_warkah', array('no208'=>$row->no208));
			foreach($data_file_warkah->result() as $file) :
				@unlink("./assets/files/{$file->nama_file}");
			endforeach;
			$this->db->delete('tb_file_warkah', array('no208' => $row->no208));
		endforeach;
		$this->db->delete('tb_buku_tanah', array('id_hak'=>$ID));
		redirect('setting/chak');
	}

}

/* End of file Chak.php */
/* Location: ./application/modules/setting/controllers/Chak.php */