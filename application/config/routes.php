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

$route['default_controller'] = "home";
$route['admin'] = 'admin/home';


$route['registration/signup'] = 'registration/signup';
$route['property/detail/([0-9]+)'] = "property/detail/$1";
$route['property/admindetail/([0-9]+)'] = "property/admindetail/$1";

$route['property/ratingReview/([0-9]+)'] = "property/ratingReview/$1";
$route['property/subscribe'] = "property/subscribe";
$route['property/savefavourite'] = "property/savefavourite";
$route['property/searchcity'] = "property/searchcity";
$route['property/(:any)'] = "property/index/$1";
$route['contact-us'] = 'home/contact_us';
$route['about-us'] = 'home/about_us';
$route['faq'] = 'home/faq';
$route['privacy-policy'] = 'home/privacy_policy';
$route['terms-conditions'] = 'home/terms_of_use';
$route['sitemap'] = 'home/sitemap';
$route['how-it-works'] = '/how_it_works';
$route['page/(:any)'] = "home/page/$1";
$route['auction-calender'] = '/auction_calender';


$route['extlogin'] = 'home/externallogin/$1';

$route['news-listing'] = '/news_listing';
$route['news-listing/detail/([0-9]+)'] = '/news_listing/detail/$1';
$route['404_override'] = 'error';
//new added by amit
$route['registration/login'] = 'home/index';
$route['registration/banker_login'] = 'home/index';

$route['sitemap\.xml'] = "admin/news/generatesitemap";
$route['robots\.txt'] = "admin/news/getRobots";
$route['propertylisting'] = 'home/propertylisting';

