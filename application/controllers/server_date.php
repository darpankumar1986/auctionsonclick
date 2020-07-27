<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Server_date extends WS_Controller {

    public function __construct() {
        parent::__construct();
    }
    function index()
    {   
        $this->load->view('server_date',$data);	
    } 
	
}
