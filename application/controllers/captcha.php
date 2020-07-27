<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Captcha extends CI_Controller {
/* Initialize the controller by calling the necessary helpers and libraries */
  public function __construct()
  {
    parent::__construct();
    /* Load the libraries and helpers */
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->helper(array('form', 'url', 'captcha'));
  }
  
  /* The default function that gets called when visiting the page */
	public function index() {
		$word=random_string('numeric',6);
		$captcha=$this->captcha_image($word);
//		echo $captcha['word'];
		$this->session->set_userdata('captchaWord', $captcha['word']);
		echo  $captcha['image'];
		//$this->load->view('captcha_view',$captcha);
	}
	public function refresh_captcha()
	{
		$word=random_string('numeric',6);
		$captcha=$this->captcha_image($word);
		$this->session->set_userdata('captchaWord', $captcha['word']);
		 echo  $captcha['image'];
	}
	public function captcha_image($word='')
	{
		$vals = array(
			'img_path'  => './public/uploads/images/',
			'img_url'  => base_url().'public/uploads/images/',
			'word' => $word,
			'img_width' => 150,
			'img_height' => '50',
			'expiration' => 7200
			);
		$cap = create_captcha($vals);
		return $cap;
	}
	
}
