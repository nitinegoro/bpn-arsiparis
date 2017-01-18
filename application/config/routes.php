<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'utama';
$route['404_override'] = '';
// Custom module route apps/app_buku
$route['buku/create'] = 'apps/app_buku';
$route['buku/selipkan'] = 'apps/app_buku/selipkan';
$route['buku/search'] = 'apps/app_buku/search';
$route['buku/document/(\d+)'] = 'apps/app_buku/get/$1';
// Custome module apps/pinjma_buku
$route['buku/keluar'] = 'apps/pinjam_buku';
// Custome module apps/pinjma_warkah
$route['warkah/keluar'] = 'apps/pinjam_warkah';
// Custom Routes apps/app_warkah
$route['warkah/search'] = 'apps/app_warkah';
$route['warkah/document/(\d+)'] = 'apps/app_warkah/get/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */