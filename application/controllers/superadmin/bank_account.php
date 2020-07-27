<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bank_account extends MY_Controller {

    public function __Construct() {

        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->helper(array('form'));
        $this->load->model('superadmin/bank_account_model');
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

   
    /* find all values from AccountType table to list number of AccountType */

    public function page($page_no) {
        if ($this->input->post('submit'))
        $this->updateStatus('tbl_bank_account_details');
        $data['heading'] = 'Bank Account';
        $this->load->view('superadmin/header', $data);

        //search query start//
        $search['title'] = trim($this->input->get('title'));
        
        $data['search'] = $search;
       
        //serach query ends//
        $per_page = 50;
        $total_record = $this->bank_account_model->GetTotalRecord();

        $page_no = $_GET['per_page'];
        $config['base_url'] = site_url() . 'superadmin/sms_template/index?k=2';
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
        $array_records = $this->bank_account_model->GetRecords($offset, $per_page);
        //echo "<pre>"; print_r($array_records); die;
        $data['records'] = $array_records;
        $this->load->view('superadmin/bank_account_list', $data);
        $this->load->view('superadmin/footer');
    }

    /* Redirect to Add and Edit city form */

    public function addedit($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit Bank Account';
        } else {
            $data['heading'] = 'Add Bank Account';
        }
        if ($param) {
            $array_records = $this->bank_account_model->GetRecordById($param);
        } else {
            $array_records = array();
        }
        $array_org = $this->bank_account_model->get_organization();
       // echo "<pre>"; print_r($array_org); die;
        $data['organization'] = $array_org;
        $data['row'] = $array_records;
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-bank-account', $data);
        $this->load->view('superadmin/footer');
    }

    /* save and update city by this action */

    public function save($param) { 
        $bank_account_id = $this->input->post('bank_account_id');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<label class="error">', '</label>');
        $this->form_validation->set_rules('organization', 'Organization', 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_holder_name', 'Account holder name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_nick_name', 'Account nick name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_name', 'Bank name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|max_length[18]|xss_clean');
        $this->form_validation->set_rules('ifsc_code', 'IFSC code', 'trim|required|max_length[11]|max_length[11]|xss_clean');
      

        if ($this->form_validation->run() == FALSE) {
           
        } else {
            $save = $this->bank_account_model->save_data();
            
            if ($save) {
                if ($bank_account_id) {
                    $this->session->set_flashdata('message', 'Bank account is successfully updated.');
                } else {
                    $this->session->set_flashdata('message', 'Bank account is successfully created.');
                }
                redirect('superadmin/bank_account/index');
            }
        }
        
        if (is_numeric($param)) {
            $data['heading'] = 'Edit Bank Account Details';
        } else {
            $data['heading'] = 'Add Bank Account Details';
        }

        if ($param) {
            $array_records = $this->bank_account_model->GetRecordById($param);
        } else {
            $array_records = array();
        }
        $data['row'] = $array_records;
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-bank-account', $data);
        $this->load->view('superadmin/footer');
    }
    

}// End class Bank_account

?>
