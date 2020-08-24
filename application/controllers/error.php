<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Error extends MY_Controller
{

    public function __Construct()
    {
        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('log4php');
        log_error('my_error');
        log_info('my_info');
        log_debug('my_debug');
        //error_reporting(0);
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('Datatables');
        $this->load->library('table');
        //$this->load->model('property_model');
        //$this->load->model('product_detail_model');
        $this->load->model('home_model');
        $this->load->model('admin/news_model');
        //$this->load->model('property_model');
    }

    public function index()
    {
        $data['error'] = 1;
        $this->load->view('front_view/header',$data);
        //$this->load->view('front_view/home',$data);
        $this->load->view('front_view/error_404');
        $this->load->view('front_view/footer');
    }
}
?>
