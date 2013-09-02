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

$route['default_controller'] = "install";
// $route['default_controller'] = "welcome";
$route['404_override'] = '';

$route['admin'] = "admin/admin";
$route['login'] = "admin/admin/connexion";
$route['logout'] = "admin/admin/logout";
$route['install/admin-user'] = "install/adminUser";
$route['install/setup-administrator'] = "install/setupAdministrator";
// $route['configuration'] = 'configuration/listStations';
$route['configuration/stations'] = 'configuration/index';
$route['configuration/list-stations'] = 'configuration/listStations';
$route['configuration/add-station'] = "configuration/addStation";
$route['configuration/do/add-station'] = "cmd/makeNewStation";
$route['configuration/remove-station'] = "configuration/removeStation";
$route['configuration/remove-station/(:any)'] = "configuration/removeStation/$1";
$route['configuration/update-station'] = "configuration/updateStation";
$route['configuration/update-station/(:any)'] = "configuration/updateStation/$1";
// $route['viewer/(:any)/(:any)/(:any)'] = "viewer/index/$1?station=$2&sensor=$3";

$route['dashboard'] = "viewer";
$route['list-viewer'] = "viewer";
$route['viewer/(:any)'] = "viewer/index/$1";
$route['dashboard/(:any)'] = "viewer/index/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
