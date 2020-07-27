<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tokens extends MY_Controller {

    public function __Construct() {

        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->helper(array('form'));
        $this->load->model('superadmin/tokens_model');
        $this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
        $this->output->set_header('Pragma: no-cache');
        $this->check_isvalidated();
    }

    /* execute page action to show the list of Bank in table format */

    public function index($page_no) {
        $this->page($page_no);
    }

    /* check session if not loged in then redirect to login page */

    private function check_isvalidated() {
        if (!$this->session->userdata('validated') || $this->session->userdata('arole') != '1') {
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }
    
    function uniquetoken() {
		$name = trim($this->input->post('token_name'));
		$id = $this->input->post('token_id');
		echo $this->tokens_model->uniquetoken($name,$id);
	}	

   
    /* find all values from AccountType table to list number of AccountType */

    public function page($page_no) {
        if ($this->input->post('submit'))
        $this->updateStatus('tbl_tokens');
        $data['heading'] = 'Tokens';
        $this->load->view('superadmin/header', $data);

        //search query start//
        $search['title'] = trim($this->input->get('title'));
        
        $data['search'] = $search;
       
        //serach query ends//
        $per_page = 50;
        $total_record = $this->tokens_model->GetTotalRecord();

        $page_no = $_GET['per_page'];
        $config['base_url'] = site_url() . 'superadmin/token/index?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;
        $array_records = $this->tokens_model->GetRecords($offset, $per_page);
        //echo "<pre>"; print_r($array_records); die;
        $data['records'] = $array_records;
        $this->load->view('superadmin/token_list', $data);
        $this->load->view('superadmin/footer');
    }

    /* Redirect to Add and Edit city form */

    public function addedit($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit Tokens';
        } else {
            $data['heading'] = 'Add Tokens';
        }
        if ($param) {
            $array_records = $this->tokens_model->GetRecordById($param);
        } else {
            $array_records = array();
        }
        
        $data['row'] = $array_records;
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-tokens', $data);
        $this->load->view('superadmin/footer');
    }

    /* save and update city by this action */

    public function save($param) { 
        $bank_account_id = $this->input->post('token_id');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<label class="error">', '</label>');        
        $this->form_validation->set_rules('token_name', 'Token Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('token_type', 'Token Type', 'trim|required|xss_clean');
      

        if ($this->form_validation->run() == FALSE) {
           
        } else {
            $save = $this->tokens_model->save_data();
            
            if ($save) {
                if ($token_id) {
                    $this->session->set_flashdata('message', 'Token is successfully updated.');
                } else {
                    $this->session->set_flashdata('message', 'Token is successfully created.');
                }
                redirect('superadmin/tokens/index');
            }
        }
        
        if (is_numeric($param)) {
            $data['heading'] = 'Edit Tokens';
        } else {
            $data['heading'] = 'Add Tokens';
        }

        if ($param) {
            $array_records = $this->bank_account_model->GetRecordById($param);
        } else {
            $array_records = array();
        }
        $data['row'] = $array_records;
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-tokens', $data);
        $this->load->view('superadmin/footer');
    }
    

}// End class tokens

?>
