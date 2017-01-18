<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbpn extends CI_Model {

	/**
	 * tb_jenis_hak
	 *
	 * @return Query
	 **/
	public function jenis_hak($ID=0)
	{
		if (!$ID) :
			$query = $this->db->query("SELECT * FROM tb_hak_milik")->result();
		else : 
			$query = $this->db->query("SELECT + FROM tb_hak_milik WHERE id_hak = '{$ID}'")->row();
		endif;
		return $query;
	}
	

	/**
	 * tb_kecamatan
	 *
	 * @return Query
	 **/
	public function kecamatan($ID=0)
	{
		if(!$ID) :
			$query = $this->db->query("SELECT * FROM tb_kecamatan")->result();
		else :
			$query = $this->db->query("SELECT * FROM tb_kecamatan WHERE id_kecamatan = '{$ID}'")->row();
		endif;
		return $query;
	}

	/**
	 * tb_desa
	 *
	 * @return Query
	 **/
	public function desa($ID=0)
	{
		if(!$ID) :
			$query = $this->db->query("SELECT * FROM tb_desa")->result();
		else :
			$query = $this->db->query("SELECT * FROM tb_desa WHERE id_desa = '{$ID}'")->row();
		endif;
		return $query;
	}

	/**
	 * undocumented class variable
	 *
	 * @return string TRUE/BOOLEAN
	 **/
	public function ketersediaan_buku($ID=0)
	{
		$query = $this->db->query("SELECT * FROM tb_simpan_buku WHERE no_hakbuku = '{$ID}'");
		return $query->row();
	}


	/**
	 * tb_user
	 *
	 * @return Query
	 **/
	public function user($ID=0)
	{
		if(!$ID) :
			$query = $this->db->query("SELECT * FROM tb_users")->result();
		else :
			$query = $this->db->query("SELECT * FROM tb_users WHERE nip = '{$ID}'")->row();
		endif;
		return $query;
	}

	/**
	 * tb_lemari
	 *
	 * @return Query
	 **/
	public function lemari($ID=0)
	{
		$query = $this->db->query("SELECT * FROM tb_lemari WHERE no_lemari = '{$ID}'");
		return (!$query->num_rows()) ? '-' : $query->row()->nama_lemari;
	}
}

/* End of file mbpn.php */
/* Location: ./application/models/mbpn.php */