<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtrash extends CI_Model {

	// property session data
	private $nip;
	private $level_akses;

	public function __construct()
	{
		parent::__construct();
		$session = $this->session->userdata('login');

        // initialize session data 
		$session = $this->session->userdata('login');
		$this->nip = $session['nip'];
		$this->level_akses = $session['level_akses'];
	}

	/**
	 * Mengecek file buku tanah pada tong sampah
	 *
	 * @param Integer (id_bukutanah)
	 * @return Bolean 
	 **/
	public function cek($id = 0)
	{
		$query = $this->db->query("SELECT id_bukutanah FROM tb_tong_sampah WHERE id_bukutanah = '{$id}'");

		if( $query->num_rows() )
		{
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Menambahkan trash baru
	 * dan akan menjadi acuan notifikasi delete
	 *
	 * @return affected_rows
	 **/
	public function insert($id = 0, $delete = 'all')
	{
		if(	$this->cek($id) AND $this->level_akses == 'admin' )
		{
			$data = array(
				'id_bukutanah' => $id,
				'nip' => $this->nip,
				'jenis_delete' => $delete,
				'waktu_delete' => date('Y-m-d H:i:s')
			);

			$this->db->insert('tb_tong_sampah', $data);
		}

		return $this->db->affected_rows();
	}

	/**
	 * Menampilkan label pada icon notifikasi
	 *
	 * @return String
	 **/
	public function label()
	{
		$data = $this->db->count_all('tb_tong_sampah');

		if( $data !== 0)
			echo "<span class='label label-danger'>{$data}</span>";
	}

	/**
	 * Menampilkan data yang peru disetujui
	 *
	 * @return result
	 **/
	public function get_all()
	{
		$query = $this->db->query("SELECT tb_tong_sampah.*, tb_users.nama_lengkap, tb_users.foto FROM tb_tong_sampah JOIN tb_buku_tanah ON tb_tong_sampah.id_bukutanah = tb_buku_tanah.id_bukutanah JOIN tb_users ON tb_tong_sampah.nip = tb_users.nip ORDER BY tb_tong_sampah.waktu_delete DESC");
		return $query->result();
	}

	/**
	 * Menampilkan detail data persetujuan
	 *
	 * @return row
	 **/
	public function get($id = 0)
	{
		$query = $this->db->query("SELECT tb_tong_sampah.*, tb_users.nama_lengkap, tb_users.foto, tb_buku_tanah.* FROM tb_tong_sampah JOIN tb_buku_tanah ON tb_tong_sampah.id_bukutanah = tb_buku_tanah.id_bukutanah JOIN tb_users ON tb_tong_sampah.nip = tb_users.nip WHERE tb_tong_sampah.id_tong_sampah = '{$id}'");
		return $query->row();
	}

}

/* End of file mtrash.php */
/* Location: ./application/models/mtrash.php */