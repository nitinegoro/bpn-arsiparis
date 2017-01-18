<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_presentation extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	// Dokumen
	function getDok_aktif()
	{
		$this->db->where('status_buku', 'Y');
		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}
	function getDok_mati()
	{
		$this->db->where('status_buku', 'N');
		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}
	function getDokBuku_keluar()
	{
		$this->db->where('status_pinjam', 'N');
		$query = $this->db->get('tb_pinjam_buku');
		return $query->num_rows();
	}
	function getDokWarkah_keluar()
	{
		$this->db->where('status_pinjam', 'N');
		$query = $this->db->get('tb_pinjam_warkah');
		return $query->num_rows();
	}
	// tahun Mundur
	function getDok_tahun($thn)
	{
		$this->db->where('tahun', $thn);
		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}
	function getDok_luas($id)
	{
		$this->db->where('id_kecamatan', $id);
		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}
	//jenis-hak
	function numJenishak($id)
	{
		$this->db->where('id_hak', $id);
		$query = $this->db->get('tb_buku_tanah');
		return $query->num_rows();
	}

	function tanggungan_tahun($thn)
	{
		$this->db->where('tahun', $thn);
		$this->db->where('id_hak', 5);
		$query = $this->db->get('tb_buku_tanah');
		$data = 0;
		foreach( $query->result() as $row) :
			$data += $row->luas;
		endforeach;
		return $data;
	}
}

/* End of file m_presentation.php */
/* Location: ./application/models/m_presentation.php */