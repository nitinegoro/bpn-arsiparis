<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
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
		$this->load->library(array('session','Excel/PHPExcel', 'upload'));
		$this->load->model(array('m_apps'));
		$this->load->helper(array('form','url','html'));
	}
	public function index($nip=0)
	{
		$data_user = $this->db->query("SELECT * FROM tb_users WHERE nip = '{$this->nip}'")->row();
		$page = ($this->input->get('page')) ? $this->input->get('page') : 0;

		$total_rows = $this->db->query("SELECT * FROM tb_history WHERE nip = '{$this->nip}'")->num_rows();

        $config = pagination_list();
        $config['base_url'] = site_url("setting/profile?data=history");
		$config['per_page'] = 10;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $total_rows;
        $this->pagination->initialize($config);

		$data_history = $this->db->query("SELECT tb_history.*, tb_buku_tanah.* FROM tb_history JOIN tb_buku_tanah ON tb_history.id_bukutanah = tb_buku_tanah.id_bukutanah WHERE tb_history.nip = '{$this->nip}' LIMIT {$config['per_page']} OFFSET {$page}")->result();
		$data = array(
			'title' => 'My Akun'.DEFAULT_TITLE, 
			'data' => $data_user,
			'data_history' => $data_history
		);

		$this->template->view('setting/my_akun', $data);
	}

	/**
	 * Mengubah Data profile
	 *
	 * @return string
	 **/
	public function update()
	{
		$data_user = $this->db->query("SELECT * FROM tb_users WHERE nip = '{$this->nip}'")->row();

		$data = array(
			'nama_lengkap' => $this->input->post('nama'),
			'nip' => $this->input->post('nip'), 
		);

		$config['upload_path'] = './assets/user/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10240';
		$config['max_width']  = '9000';
		$config['max_height']  = '8000';
		//$config['remove_spaces'] = FALSE;
		$config['overwrite'] = FALSE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('img')) :
			$data['foto'] = $this->input->post('no_file');
		else :
			$data['foto'] = $this->upload->file_name;
			//if($data_user->foto =! 'null')
				@unlink("./assets/user/{$data_user->foto}");
		endif;

		$this->db->update('tb_users', $data, array('nip'=> $this->nip));
		if($data['nip']==$data->nip) :
			redirect("login/profile?data=update");
		else :
			redirect('login/logout');
		endif;
	}

	/**
	 * Mengecek valid password
	 *
	 * @return string
	 **/
	public function cek_pass()
	{
		$data_user = $this->db->query("SELECT * FROM tb_users WHERE nip = '{$this->nip}'")->row();
		$output['valid'] = (password_verify($this->input->post('lama'), $data_user->pass_login)) ? true : false;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	/**
	 * Mengubah Password
	 *
	 * @var string
	 **/
	public function update_pass()
	{
		$data = array(
			'pass_login' => password_hash($this->input->get('password'), PASSWORD_DEFAULT), 
		);
		$this->db->update('tb_users', $data, array('nip'=> $this->nip));
		redirect("setting/profile?data=security");
	}
}

/* End of file Profile.php */
/* Location: ./application/modules/setting/controllers/Profile.php */