<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_apps extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	function login($nip, $password)
	{
        $this->load->database();
        $this->db->select('id,nip,nama_lengkap,pass_login,foto,level_akses');
        $this->db->from('tb_users');
        $this->db->where('nip', $nip);
        $this->db->where('pass_login', $password);
        $this->db->where('status_user', 'valid');
        $this->db->limit(1);
      
        $query = $this->db->get();
      
        if($query->num_rows()==1) {
          $result = $query->result();
          return $result;
        }
        else {
          return false;
        }
	}

    function kecamatan()
    {
        $query = $this->db->get('tb_kecamatan'); 
        return $query->result(); 
    }
    function desa($id) 
    {
        $this->db->where('id_kecamatan', $id);
        $query = $this->db->get('tb_desa');
        return $query->result();
    }
    function lemari()
    {
        $query = $this->db->get('tb_lemari'); 
        return $query->result(); 
    }
    function getLemari($id)
    {
        $this->db->where('no_lemari', $id);
        $query = $this->db->get('tb_lemari'); 
        return $query->result(); 
    }
    function rak($id) 
    {
        $this->db->where('no_lemari', $id);
        $query = $this->db->get('tb_rak');
        return $query->result();
    }
    function getRak($id) 
    {
        $this->db->where('no_rak', $id);
        $query = $this->db->get('tb_rak');
        return $query->result();
    }
    function album($id) 
    {
        $this->db->where('no_rak', $id);
        $query = $this->db->get('tb_album');
        return $query->result();
    }
    function getAlbum($id) 
    {
        $this->db->where('no_album', $id);
        $query = $this->db->get('tb_album');
        return $query->result();
    }
    function laman($id) 
    {
        $this->db->where('no_album', $id);
        $query = $this->db->get('tb_halaman');
        return $query->result();
    }
    function halaman_tampil($id)
    {
        $this->db->where('tb_penyimpanan.no_album', $id);
        $query = $this->db->get('tb_halaman');
        return $query->result();
    }
    function cek_ketersediaan($id,$i) 
    {
        $this->db->where('no_album', $id);
        $this->db->where('no_halaman', $i);
        $query = $this->db->get('tb_penyimpanan');
        return $query->result();
    }
    function get_jenisHak($id) {
        $this->db->where('id_hak', $id);
        $query = $this->db->get('tb_hak_milik');
        return $query->result();
    }
    function get_kecamatan($id) {
        $this->db->where('id_kecamatan', $id);
        $query = $this->db->get('tb_kecamatan');
        return $query->result();
    }
    function get_desa($id) {
        $this->db->where('id_desa', $id);
        $query = $this->db->get('tb_desa');
        return $query->result();
    }
    function getbukuPending()
    {
        $this->db->where('status_entry', 'N');
        $query = $this->db->get('tb_buku_tanah');
        return $query->result();
    }
    function numbukuPending()
    {
        $this->db->where('status_entry', 'N');
        $query = $this->db->get('tb_buku_tanah');
        return $query->num_rows();
    }
    function getwarkahPending()
    {
        $this->db->where('status_entry', 'N');
        $query = $this->db->get('tb_warkah');
        return $query->result();
    }
    function numwarkahPending()
    {
        $this->db->where('status_entry', 'N');
        $query = $this->db->get('tb_warkah');
        return $query->num_rows();
    }
}

/* End of file m_dashboard.php */
/* Location: ./application/modules/dashboard/models/m_dashboard.php */