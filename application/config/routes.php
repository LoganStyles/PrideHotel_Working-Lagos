<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['404_override'] = 'app/page404';
$route['default_controller'] = 'app';
$route['app/housekeeping'] = 'app/showHousekeeping/housekeeping';
$route['app/terminals'] = 'app/showTerminals/terminals';
$route['app/prices'] = 'app/showPrice/price';
$route['app/processRoomtype'] = 'app/processRoomtype';
$route['app/processAccountSale'] = 'app/processAccountSale';
$route['app/processAccountPayment'] = 'app/processAccountPayment';
$route['app/processAccountPlu'] = 'app/processAccountPlu';
$route['app/processRole'] = 'app/processRole';
$route['app/processUser'] = 'app/processUser';
$route['app/processRoom'] = 'app/processRoom';
$route['app/processDelete'] = 'app/processDelete';
$route['app/logout'] = 'app/logout';
$route['app/process/(:any)'] = 'app/processTypeclass/$1';
$route['app/(:any)'] = 'app/showTypeclass/$1';

$route['resv/guest'] = 'resv/showReservation/guest';
$route['resv/client'] = 'resv/showClients/person';
$route['resv/(:any)'] = 'resv/viewLists/$1';
