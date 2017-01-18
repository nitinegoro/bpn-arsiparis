<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('pagination_list') ) {
	function pagination_list()
	{
		$config['full_tag_open'] = '<ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="">';
		$config['num_tag_close'] = '</li>';	
		return $config;
	}
}

if ( ! function_exists('set_permalink'))
{
	/**
	* @param String $content
	* @return Clean Url
	*/
	function set_permalink($content) {
		$karakter 				= array ('{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','-','/','\\',',','.','#',':',';','\'','"','[',']');
		$hapus_karakter_aneh 	= strtolower(str_replace($karakter,"",$content));
		$tambah_strip 			= strtolower(str_replace(' ', '-', $hapus_karakter_aneh));
		$link_akhir 			= $tambah_strip;
		return $link_akhir;
	}
}


if ( ! function_exists('file_name')) {
	function file_name($angka)
	{
		switch ($angka) {
			case 1:
				$data = 'Buku Tanah';
				break;
			case 2:
				$data = 'Surat Ukur';
				break;
			case 3:
				$data = 'Catatan Buku Tanah';
				break;
			default:
				$data = 'Catatan Buku Tanah';
				break;
		}
		return strtoupper($data);
	}
}


/*  Trash Helper */
if ( ! function_exists('trash') ) 
{
	function trash($jenis_delete)
	{
		switch ($jenis_delete) {
			case 'all':
				$data = 'Buku Tanah';
				break;
			case 'tb_pinjam_buku':
				$data = 'Peminjaman Buku Tanah';
				break;
			case 'tb_pinjam_warkah':
				$data = 'Peminjaman Warkah';
				break;
			default:
				$data = '';
				break;
		}
		return $data;
	}
}

/* Menu active helpers */
if ( ! function_exists('active_link_controller'))
{
    function active_link_controller($controller)
    {
        $CI    =& get_instance();
        $class = $CI->router->fetch_class();

        return ($class == $controller) ? 'active' : NULL;
    }
}


if ( ! function_exists('active_link_function'))
{
    function active_link_function($controller)
    {
        $CI    =& get_instance();
        $class = $CI->router->fetch_method();

        return ($class == $controller) ? 'active' : NULL;
    }
}


if( ! function_exists('level_akses') )
{
	function level_akses($level) 
	{
		switch ($level) {
			case 'operator':
				echo "Operator";
				break;
			case 'admin':
				echo "Administrator";
				break;
			case 'viewer':
				echo "Loket";
				break;
			case 'super_admin':
				echo "Super Administrator";
				break;
			default:
				echo "-";
				break;
		}
	}
}