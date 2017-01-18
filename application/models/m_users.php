<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    /**
    * @author    : Vicky Nitinegoro
    * @link      : http://www.teitramega.com
    * @copyright : BPN App - TeitraMega Team 2016
    */
class M_users extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
    function getMyakun($nip) {
        $this->db->where('nip',$nip);
        $query = $this->db->get('tb_users');
        return $query->result();
    }
    function getHistory($nip) {
        $this->db->where('nip',$nip);
        $this->db->order_by('time','desc');
        $query = $this->db->get('tb_history',20);
        return $query->result();
    }
    function getHistorylimit($nip) {

        $this->db->join('tb_buku_tanah', 'tb_history.id_bukutanah = tb_buku_tanah.id_bukutanah');
        $this->db->join('tb_hak_milik', 'tb_buku_tanah.id_hak = tb_hak_milik.id_hak');
        $this->db->join('tb_users', 'tb_history.nip = tb_users.nip');
        $this->db->where('tb_history.nip', $nip);
        $this->db->order_by('tb_history.id', 'desc');
        $query = $this->db->get('tb_history', 5);
        return $query->result();
    }
    function cek_user($id)
    {
        $this->db->where('nip', $id);
        $query = $this->db->get('tb_users');
        return $query->num_rows();
    }
    function getMyakun_id($id) {
        $this->db->where('id',$id);
        $query = $this->db->get('tb_users');
        return $query->result();
    }
    function getAllExcel($bln, $thn)
    {
        $this->db->join('tb_users', 'tb_users.nip = tb_history.nip', 'left');
        $this->db->where('tb_history.bulan', $bln);   
        $this->db->where('tb_history.tahun', $thn);
        $query = $this->db->get('tb_history');
        return $query->result();
    }
    function getIDExcel($nip)
    {
        $this->db->join('tb_users', 'tb_users.nip = tb_history.nip', 'left'); 
        $this->db->where('tb_history.nip', $nip);  
        $query = $this->db->get('tb_history');
        return $query->result();
    }
}

/* End of file m_users.php */
/* Location: ./application/modules/m_users.php */