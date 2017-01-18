<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman Index Buku Aplikasi
 *
 * Controller Ini sudah dialihkan pada  ./../config/routes.php
 * @access http://example_root/buku
 * @package Apps - Class App_buku.php
 * @author https://facebook.com/muh.azzain
 **/
class App_buku extends CI_Controller {
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
		$this->load->library(array('session','upload','encrypt'));
		$this->load->model(array('m_apps','m_buku','mtrash'));
		$this->load->helper(array('form','url','html'));
	}
	public function index()
	{
		$data = array(
			'title' => 'Tambah Buku Tanah'.DEFAULT_TITLE,
			'lemari' => $this->m_apps->lemari(),
			'hakmilik' => $this->mbpn->jenis_hak()
		);
		$this->template->view('buku/add_buku', $data);
	}

	/**
	 * Menambahkan Buku Tanah dan Warkah
	 *
	 * @return string (Callback)
	 **/
	public function insert()
	{
		$data_user = $this->session->userdata('login');
		$query_id = $this->db->query("SELECT MAX(id_bukutanah) AS id_bukutanah FROM tb_buku_tanah")->row();
		$ambil_id = ++$query_id->id_bukutanah;
		$id_bukutanah = $ambil_id + $this->input->post('nohak'); 
		// data buku tanah
		$data_buku = array(
			'id_bukutanah' => $id_bukutanah,
			'id_hak' => $this->input->post('hak'),
			'no_hakbuku' => $this->input->post('nohak'),
			'tahun' => $this->input->post('tahun'),
			'luas' => $this->input->post('luas'),
			'id_kecamatan' => $this->input->post('kecamatan'),
			'id_desa' => $this->input->post('desa'),
			'no208' => $this->input->post('no208'),
			'status_buku' => $this->input->post('status'),
			'status_entry' => ($data_user['level_akses']=='admin' OR $data_user['level_akses']=='super_admin') ? 'Y' : 'N',
			'pemilik_awal' => $this->input->post('pemilik'),
			'catatan_buku' => $this->input->post('catatan')
		);
		// data warkah
		$data_warkah = array(
			'tahun' => $this->input->post('tahun'),
			'no208' => $this->input->post('no208'),
			'status_warkah' => 'Y',
			'status_entry' => ($data_user['level_akses']=='admin') ? 'Y' : 'N',
			'id_bukutanah' => $id_bukutanah,
			'catatan_warkah' => ''
		);
		// data penyimpanan buku
		$data_penyimpanan = array(
			'id_bukutanah' => $id_bukutanah,
			'no_lemari' => $this->input->post('lemari'),
			'no_rak' => $this->input->post('rak'),
			'no_album' => $this->input->post('album'),
			'no_halaman' => $this->input->post('no_halaman')
		);
		// data history
		$data_history = array(
			'nip' => $this->nip,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bukutanah' => $id_bukutanah,
			'deskripsi' => 'Menambahkan dokumen buku tanah'
		);
		$cek_data = $this->db->query("SELECT * FROM tb_buku_tanah WHERE id_hak = '{$data_buku['id_hak']}' AND no_hakbuku = '{$data_buku['no_hakbuku']}' AND id_desa = '{$data_buku['id_desa']}'")->num_rows();
		if(!$cek_data) :
			// Upload File Dokumen Buku
			$config['upload_path'] =  'assets/files/';
			$config['allowed_types'] = 'gif|jpg|png|pdf|PDF|JPG|PNG|GIF';
			$config['max_size']	= '10240';
			$config['max_width']  = '3000';
			$config['max_height']  = '3000';
			$config['remove_spaces'] = FALSE;
			$config['overwrite'] = FALSE;
			$config['encrypt_name'] = TRUE;
			$this->upload->initialize($config);
			$file = array();
	        if($this->upload->do_multi_upload("file")) :
	        	foreach( $this->upload->get_multi_upload_data() as $key => $item) :
	           	$file[] = array(
	           		'id_bukutanah' => $id_bukutanah,
	           		'nama_file' =>  $item['file_name'],
	           		'mime_type' => $item['file_type'],
	           		'file_ext' => $item['file_ext']
	           	);
	           endforeach;
	        $this->db->insert_batch('tb_file_buku', $file);
	        endif;
	        $this->db->insert('tb_buku_tanah', $data_buku);
	        $this->db->insert('tb_warkah', $data_warkah);
	        $this->db->insert('tb_simpan_buku', $data_penyimpanan);
	        $this->db->insert('tb_history', $data_history);
	        redirect('buku/create?bin=true');
	    else :
	    	redirect('buku/create?bin=tersedia');
	    endif;
	}

	/**
	 * Menerima Data Buku Tanah Masuk
	 *
	 * @param Integer no_hakbuku
	 * @return string (Callback)
	 **/
	public function approve($ID=0)
	{
		$row = $this->db->query("SELECT tb_buku_tanah.*, tb_warkah.* FROM tb_buku_tanah JOIN tb_warkah ON tb_buku_tanah.no208 = tb_warkah.no208 WHERE tb_buku_tanah.id_bukutanah = '{$ID}'")->row();
		$data_history = array(
			'nip' => $this->nip,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bukutanah' => $row->id_bukutanah,
		);
		switch ($this->input->get('method')) :
			case 'terima':
				$data_history['deskripsi'] = "Menerima entrian data.";
				$this->db->update('tb_buku_tanah', array('status_entry'=>'Y'), array('id_bukutanah'=> $ID));
				$this->db->update('tb_warkah', array('status_entry'=>'Y'), array('no208'=> $row->no208));
				$this->db->insert('tb_history', $data_history);
				redirect($this->input->get('ref'));
				break;
			case 'tolak':
				$data_history['deskripsi'] = "Menolak entrian data.";
				$this->db->delete('tb_warkah', array('no208' => $row->no208));
				$this->db->delete('tb_buku_tanah', array('id_bukutanah' => $ID));
				$this->db->delete('tb_simpan_buku', array('id_bukutanah' => $ID));
				$this->db->delete('tb_file_buku', array('id_bukutanah' => $ID));
				$this->db->insert('tb_history', $data_history);
				redirect($this->input->get('ref'));
				break;
			default:
				redirect($this->input->get('ref'));
				break;
		endswitch;
	}

	/**
	 * menampilkan Data Pencarian
	 *
	 * @return Query
	 **/
	public function search()
	{
		$data = array(
			'title' => 'Cari Buku Tanah'.DEFAULT_TITLE,
			'jenishak' => $this->mbpn->jenis_hak()
		);
		// object Pencarian
		$where = array(
			'hak' => (!$this->input->get('hak')) ? 0 : $this->input->get('hak'),
			'nohak' => $this->input->get('nohak'),
			'kecamatan' => (!$this->input->get('kecamatan')) ? 0 : $this->input->get('kecamatan'),
			'desa' => (!$this->input->get('desa')) ? 0 : $this->input->get('desa'),
			'thn' => $this->input->get('thn')
		);
		// Query Pencarian Data Buku Tanah
		if($where['hak']==5) :
			$query = $this->db->query("SELECT * FROM tb_buku_tanah WHERE id_hak = '{$where['hak']}' AND no_hakbuku = '{$where['nohak']}' AND tahun = '{$where['thn']}'");
		else :
			$query = $this->db->query("SELECT * FROM tb_buku_tanah WHERE id_hak = '{$where['hak']}' AND no_hakbuku = '{$where['nohak']}' AND id_desa = '{$where['desa']}'");
		endif;
		if(!$query) :
			$storage = false;
		else :
			$buku = (!$query->num_rows()) ? 0 : $query->row()->id_bukutanah;
			$storage = $this->db->query("SELECT * FROM tb_simpan_buku WHERE id_bukutanah = '{$buku}'")->row();
		endif;
		// Transfer Data Ke views
		$data['data'] = $query->row();
		$data['storage'] = $storage;
		// insert history
		if($query->num_rows() >= 1) :
			// Data History
			$data_history = array(
				'nip' => $this->nip,
				'tanggal' => date('Y-m-d'),
				'time' => date('Y-m-d H:i:s'),
				'bulan' => date('m'),
				'tahun' => date('Y'),
				'id_bukutanah' => $data['data']->id_bukutanah,
				'deskripsi' => "Mencari Dokumen Buku Tanah."
			);
			$this->db->insert('tb_history', $data_history);
		endif;
		$this->template->view('buku/search_buku', $data);
	}

	/**
	 * undocumented class variable
	 *
	 * @var string
	 **/
	public function get($ID=0)
	{
		$row = $this->db->query("SELECT * FROM tb_buku_tanah JOIN tb_simpan_buku ON tb_simpan_buku.id_bukutanah = tb_buku_tanah.id_bukutanah WHERE tb_buku_tanah.id_bukutanah = '{$ID}'")->row();

		$data = array(
			'title' => 'Edit Buku Tanah'.DEFAULT_TITLE,
			'lemari' => $this->m_apps->lemari(),
			'hakmilik' => $this->mbpn->jenis_hak(),
			'data' => $row,
			'file' => $this->m_buku->file(0, $row->id_bukutanah),
		);
		$this->template->view('buku/edit_buku', $data);
	}

	/**
	 * Mengubah Data Buku Tanah, penyimpanan buku tanah, data warkah
	 *
	 * @param Integer, (no_hakbuku, no208)
	 * @return string (Callback)
	 **/
	public function update($ID=0)
	{
		$row = $this->db->query("SELECT tb_buku_tanah.*, tb_warkah.* FROM tb_buku_tanah JOIN tb_warkah ON tb_buku_tanah.id_bukutanah = tb_warkah.id_bukutanah WHERE tb_buku_tanah.id_bukutanah = '{$ID}'")->row();
		// data buku tanah
		$data_buku = array(
			'id_hak' => $this->input->post('hak'),
			'no_hakbuku' => $this->input->post('nohak'),
			'tahun' => $this->input->post('tahun'),
			'luas' => $this->input->post('luas'),
			'id_kecamatan' => (!$this->input->post('kecamatan')) ? $this->input->post('no_kecamatan') : $this->input->post('kecamatan'),
			'id_desa' => (!$this->input->post('desa')) ? $this->input->post('no_desa') : $this->input->post('desa'),
			'no208' => $this->input->post('no208'),
			'status_buku' => $this->input->post('status'),
			'pemilik_awal' => $this->input->post('pemilik'),
			'catatan_buku' => $this->input->post('catatan')
		);
		// data history
		$data_history = array(
			'nip' => $this->nip,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bukutanah' => $ID,
			'deskripsi' => "Mengubah dokumen buku tanah.",
		);
		// data warkah
		$data_warkah = array(
			'tahun' => $this->input->post('tahun'),
			'no208' => $this->input->post('no208')
		);
		// data penyimpanan
		$simpan = $this->db->query("SELECT * FROM tb_simpan_buku WHERE id_bukutanah = '{$ID}'")->row();
		$data_penyimpanan = array(
			'no_lemari' => (!$this->input->post('lemari')) ? $simpan->no_lemari : $this->input->post('lemari'),
			'no_rak' => (!$this->input->post('rak')) ? $simpan->no_rak : $this->input->post('rak'),
			'no_album' => (!$this->input->post('album')) ? $simpan->no_album : $this->input->post('album'),
			'no_halaman' => (!$this->input->post('no_halaman')) ? $simpan->no_halaman : $this->input->post('no_halaman')
		);
		$this->db->update('tb_buku_tanah', $data_buku, array('id_bukutanah'=>$ID));
		$this->db->update('tb_warkah', $data_warkah, array('id_bukutanah'=> $ID));
		$this->db->update('tb_simpan_buku', $data_penyimpanan, array('id_bukutanah'=>$row->id_bukutanah));
		$this->db->insert('tb_history', $data_history);
		redirect("buku/document/{$row->id_bukutanah}");
	}

	/**
	 * Mengubah Data Penyimpanan Buku Tanah
	 *
	 * @return string ( Callback)
	 **/
	public function update_penyimpanan($ID=0, $nohak = 0)
	{
		$row = $this->db->query("SELECT * FROM tb_buku_tanah WHERE id_bukutanah = '{$ID}' AND no_hakbuku = '{$nohak}' ")->row();
		// data penyimpanan buku
		$simpan = $this->db->query("SELECT * FROM tb_simpan_buku WHERE id_bukutanah = '{$ID}'")->row();
		$data_penyimpanan = array(
			'no_lemari' => (!$this->input->post('lemari')) ? $simpan->no_lemari : $this->input->post('lemari'),
			'no_rak' => (!$this->input->post('rak')) ? $simpan->no_rak : $this->input->post('rak'),
			'no_album' => (!$this->input->post('album')) ? $simpan->no_album : $this->input->post('album'),
			'no_halaman' => (!$this->input->post('no_halaman')) ? $simpan->no_halaman : $this->input->post('no_halaman')
		);
		// data history
		$data_history = array(
			'nip' => $this->nip,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bukutanah' => $row->id_bukutanah,
			'deskripsi' => "Mengubah penyimpanan dokumen buku tanah.",
		);
		$this->db->update('tb_simpan_buku', $data_penyimpanan, array('id_bukutanah'=>$row->id_bukutanah));
		$this->db->insert('tb_history', $data_history);
		redirect("buku/document/{$ID}?t=file");
	}

	/**
	 * menghapus Semua Dokumen Buku Tanah da Warkah
	 *
	 * @return string (Callback)
	 **/
	public function delete_all($ID=0, $no208 = 0)
	{
		$row = $this->db->query("SELECT tb_buku_tanah.*, tb_warkah.* FROM tb_buku_tanah JOIN tb_warkah ON tb_buku_tanah.no208 = tb_warkah.no208 WHERE tb_buku_tanah.id_bukutanah = '{$ID}'")->row();
		// data history
		$data_history = array(
			'nip' => $this->nip,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bukutanah' => $ID,
			'deskripsi' => "Menghapus dokumen.",
		);
		$this->db->insert('tb_history', $data_history);
/*		// Hapus File Dokumen
		$data_file_buku = $this->db->query("SELECT * FROM tb_file_buku WHERE id_bukutanah = '{$ID}'")->result();
		foreach($data_file_buku as $row) :
			@unlink("./assets/files/{$row->nama_file}");
		endforeach;
		$data_file_warkah = $this->db->query("SELECT * FROM tb_file_warkah WHERE id_warkah = '{$row->id_warkah}'")->result();
		foreach($data_file_warkah as $row) :
			@unlink("./assets/files/{$row->nama_file}");
		endforeach;
		// Hapus Semua File
		$tables1 = array('tb_buku_tanah', 'tb_file_buku','tb_simpan_buku', 'tb_pinjam_buku','tb_history');
		$this->db->where('id_bukutanah', $ID);
		$this->db->delete($tables1);
		$tables2 = array('tb_warkah', 'tb_file_warkah','tb_simpan_warkah', 'tb_pinjam_warkah');
		$this->db->where('id_warkah', $row->id_warkah);
		$this->db->delete($tables2);
		redirect("buku/search");*/
		$this->trash->delete($ID,'all');
		
		$session = $this->session->userdata('login');
		if($session['level_akses']=='super_admin') 
		{		
			redirect("buku/search");
		} else {
			redirect("buku/search?hak={$row->id_hak}&nohak={$row->no_hakbuku}&desa={$row->id_desa}&thn={$row->tahun}");
		}
	}

	/**
	 * meminjam Buku Tanah
	 *
	 * @return string
	 **/
	public function pinjam_buku($ID=0)
	{
		$row = $this->db->query("SELECT * FROM tb_buku_tanah WHERE id_bukutanah = '{$ID}'")->row();
		// data history
		$data_history = array(
			'nip' => $this->nip,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'id_bukutanah' => $row->id_bukutanah,
			'deskripsi' => "Mengeluarkan dokumen buku tanah.",
		);
		// data pinjam
		$data_pinjam = array(
			'id_bukutanah' => $row->id_bukutanah,
			'tgl_peminjaman' => date('Y-m-d'),
			'tgl_kembali' => '0000-00-00',
			'kegiatan' => $this->input->post('kegiatan'),
			'peminjam' => $this->input->post('peminjam'),
			'nip' => $this->nip,
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'status_pinjam' => 'N'
		);
		$this->db->insert('tb_pinjam_buku', $data_pinjam);
		$this->db->insert('tb_history', $data_history);
		$data_print = $this->db->query("SELECT MAX(id_pinjam_buku) AS id_pinjam_buku FROM tb_pinjam_buku")->row();
		redirect("buku/search?hak={$row->id_hak}&nohak={$row->no_hakbuku}&desa={$row->id_desa}&thn={$row->tahun}&print=true&data_print={$data_print->id_pinjam_buku}");
	}

	/**
	 * Mengembalikan Buku yang keluar
	 *
	 * @return string
	 **/
	public function kembali_buku($ID=0)
	{
		$row = $this->db->query("SELECT * FROM tb_buku_tanah WHERE id_bukutanah = '{$ID}'")->row();
		// data history
		$data_history = array(
			'nip' => $this->nip,
			'tanggal' => date('Y-m-d'),
			'time' => date('Y-m-d H:i:s'),
			'bulan' => date('m'),
			'tahun' => date('Y'),
			'id_bukutanah' => $row->id_bukutanah,
			'deskripsi' => "Mengembalikan dokumen buku tanah.",
		);
		// data kembali
		$data_kembali = array(
			'tgl_kembali' => date('Y-m-d'),
			'status_pinjam' => 'Y'
		);
		$this->db->update('tb_pinjam_buku', $data_kembali, array('id_bukutanah'=>$ID, 'status_pinjam' => 'N'));
		$this->db->insert('tb_history', $data_history);
		redirect("buku/search?hak={$row->id_hak}&nohak={$row->no_hakbuku}&kecamatan={$row->id_kecamatan}&desa={$row->id_desa}&thn={$row->tahun}");
	}

	/**
	 * Menampilkan Halaman dari Informasi album Buku Tanah
	 *
	 * @return string
	 **/
	public function selipkan()
	{
		$obj = $this->db->query("SELECT tb_album.*, tb_lemari.*, tb_rak.* FROM tb_album JOIN tb_lemari ON tb_album.no_lemari = tb_lemari.no_lemari JOIN tb_rak ON tb_album.no_rak = tb_rak.no_rak WHERE tb_album.no_album = '{$this->input->get('no_album')}'")->row();
		$data = array(
			'title' => 'Tambah Buku Tanah'.DEFAULT_TITLE,
			'lemari' => $this->m_apps->lemari(),
			'hakmilik' => $this->mbpn->jenis_hak(),
			'data' => $obj
		);
		$this->template->view('buku/selipkan_buku', $data);
	}
}

/* End of file App_buku.php */
/* Location: ./application/modules/apps/controllers/App_buku.php */
