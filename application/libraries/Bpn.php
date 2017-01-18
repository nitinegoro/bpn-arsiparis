<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Kumpulan Fungsi pda aplikasi Ini
 *
 * To Do Descriptcion
 * @package Apps All
 * @author https://facebook.com/muh.azzain
 **/
class Bpn
{
	protected $CI;

	public function __construct()
	{
        $this->CI =& get_instance();
	}
	public function ketersediaan_buku( $lemari = 0, $rak = 0, $album = 0, $laman = 0)
	{
		/**
		 * Lybarary Untuk menampilkan apakah tersedia Slot Kosong
		 *
		 * @param Integer
		 * @return Array
		 **/
		$penyimpanan = $this->CI->db->query("SELECT * FROM tb_simpan_buku WHERE no_lemari = '{$lemari}' AND no_rak = '{$rak}' AND no_album = '{$album}' AND no_halaman = '{$laman}'");
		if (!$penyimpanan->num_rows()) :
			$availability = true;
		else :
			$availability = false;
		endif;
		return $availability;
	}
	public function ketersediaan_warkah( $lemari = 0, $rak = 0, $album = 0, $laman = 0)
	{
		/**
		 * Lybarary Untuk menampilkan apakah tersedia Slot Kosong
		 *
		 * @param Integer
		 * @return Array
		 **/
		$penyimpanan = $this->CI->db->query("SELECT * FROM tb_simpan_warkah WHERE no_lemari = '{$lemari}' AND no_rak = '{$rak}' AND no_album = '{$album}' AND no_halaman = '{$laman}'");
		if (!$penyimpanan->num_rows()) :
			$availability = true;
		else :
			$availability = false;
		endif;
		return $availability;
	}
	
	/**
	 * Menampilkan Hak Milik yang tertera pda buku tanah
	 *
	 * @var string
	 **/
	public function hak($ID=0)
	{
		$query = $this->CI->db->query("SELECT * FROM tb_hak_milik WHERE id_hak = '{$ID}'")->row();
		return $query->jenis_hak;
	}

	/**
	 * Menampilkan Kecamatan
	 *
	 * @var string
	 **/
	public function kecamatan($ID=0)
	{
		$query = $this->CI->db->query("SELECT * FROM tb_kecamatan WHERE id_kecamatan = '{$ID}'")->row();
		return $query->nama_kecamatan;
	}

	/**
	 * Menampilkan Desa
	 *
	 * @var string
	 **/
	public function desa($ID=0)
	{
		$query = $this->CI->db->query("SELECT * FROM tb_desa WHERE id_desa = '{$ID}'")->row();
		return $query->nama_desa;
	}

	/**
	 * menampilkan Nama Rak
	 *
	 * @var string
	 **/
	public function rak($ID=0)
	{
		$query = $this->CI->db->query("SELECT * FROM tb_rak WHERE no_rak = '{$ID}'")->row();
		if(!$query) :
			$data = '-';
		else :
			$data = $query->nama_rak;
		endif;
		return $data;
	}

	/**
	 * menampilkan Nama Rak
	 *
	 * @var string
	 **/
	public function album($ID=0)
	{
		$query = $this->CI->db->query("SELECT * FROM tb_album WHERE no_album = '{$ID}'")->row();
		if(!$query) :
			$data = '-';
		else :
			$data = $query->nama_album;
		endif;
		return $data;
	}

	/**
	 * Menggenerate id_kecamatan lewat string
	 *
	 * @var string
	 **/
	public function generate_id_kecamatan($string='')
	{
		$query = $this->CI->db->query("SELECT * FROM tb_kecamatan WHERE slug_kecamatan = '{$string}'");
		if(!$query->num_rows()) :
			return false;
		else :
			$row = $query->row();
			return $row->id_kecamatan;
		endif;
	}

	/**
	 * Menggenerate id_desa lewat string
	 *
	 * @var string
	 **/
	public function generate_id_desa($string='')
	{
		$query = $this->CI->db->query("SELECT * FROM tb_desa WHERE slug_desa = '{$string}'");
		if(!$query->num_rows()) :
			return 0;
		else :
			$row = $query->row();
			return $row->id_desa;
		endif;
	}

	/**
	 * Menggenaerate id_hak lewat string
	 *
	 * @var string
	 **/
	public function generate_id_hak($string='')
	{
		$query = $this->CI->db->query("SELECT * FROM tb_hak_milik WHERE slug_jenis_hak = '{$string}'");
		if(!$query->num_rows()) :
			return 0;
		else :
			$row = $query->row();
			return $row->id_hak;
		endif;
	}

}

/* End of file Bpn.php */
/* Location: ./application/libraries/Bpn.php */
