<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slug extends MY_Controller {
	
	public function __Construct()
	{
	   	parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/slug_model');
	   	
	}	
	
	public function index($title)
	{
		$this->validateslug($title);
	}	
	public function validateslug($title,$table){
		$title = urldecode($title);
		$title = trim($title);
		$title = preg_replace('/[^A-Za-z0-9\- ]/', '', $title); // Removes special chars.
		$title = strtolower($title);
		$title = str_replace(" ","-",$title);
		
		$title = $this->slug_model->verify_slug($title,$table);
		//echo $title;
		echo str_replace("--","-",$title);
	}
	
	
}
?>
