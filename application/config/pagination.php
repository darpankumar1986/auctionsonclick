<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['per_page'] = 1;
		
$config["uri_segment"] = 2;

$config['use_page_numbers'] = TRUE;
$config['display_pages'] = TRUE;
$config['first_link'] = '<<';
$config['last_link'] = '>>';

$config['prev_link'] = TRUE;
$config['next_link'] = TRUE;

$config['prev_link'] = 'Prev';	
$config['next_link'] = 'Next';

$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
$config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
 
$config['cur_tag_open'] = '<li class="current">';
$config['cur_tag_close'] = '</li>';


// $config['use_page_numbers'] = TRUE;

/* End of file pagination.php */
/* Location: ./application/config/pagination.php */