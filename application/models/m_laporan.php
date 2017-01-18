<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model {

	/**
	 * mengambil Thun terendah dari dokumen
	 *
	 * @return Integer
	 **/
	public function min_year()
	{
		$query = $this->db->query("SELECT MIN(tahun) AS tahun FROM tb_buku_tanah WHERE tahun NOT IN('0')")->row();
		return $query->tahun;
	}

	/**
	 * menghitung status dokumen
	 *
	 * @return Integer
	 **/
	public function count_status($status ='Y', $id_hak=0, $tahun=0)
	{
		if(!$tahun) :
			$query = $this->db->query("SELECT * FROM tb_buku_tanah WHERE status_buku = '{$status}' AND id_hak = '{$id_hak}'");
		else :
			$query = $this->db->query("SELECT * FROM tb_buku_tanah WHERE status_buku = '{$status}' AND id_hak = '{$id_hak}' AND tahun = '{$tahun}'");
		endif;
		return (!$query->num_rows()) ? '-' : $query->num_rows();
	}

	/**
	 * menghitung Luas Dokumen
	 *
	 * @return Integer
	 **/
	public function count_luas($id_hak=0, $tahun=0)
	{
		if($id_hak == 5) :
			$query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_buku_tanah WHERE id_hak = '{$id_hak}' AND tahun = '{$tahun}'")->row();
			//$query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_buku_tanah WHERE id_hak = '{$id_hak}' AND tahun = '{$tahun}'")->row();
		elseif(!$tahun) :
			// tinggalkan jenis hak
			$query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_buku_tanah WHERE id_hak = '{$id_hak}' AND status_buku NOT IN ('N')")->row();
		else :
			$query = $this->db->query("SELECT SUM(luas) AS luas FROM tb_buku_tanah WHERE id_hak = '{$id_hak}' AND tahun = '{$tahun}' AND status_buku NOT IN ('N')")->row();
		endif;
		return (!$query->luas) ? '-' : number_format($query->luas);
	}
}

/* End of file M_laporan.php */
/* Location: ./application/models/M_laporan.php */