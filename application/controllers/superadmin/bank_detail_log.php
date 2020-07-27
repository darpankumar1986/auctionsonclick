<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bank_detail_log extends MY_Controller {

    public function __Construct() {
        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->helper(array('form'));
        $this->load->model('superadmin/bank_detail_log_model');
        $this->load->model('superadmin/bank_model');
        $this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
	$this->output->set_header('Pragma: no-cache');
        $this->check_isvalidated();
    }

    public function index($page_no) {
        $this->page($page_no);
    }

    private function check_isvalidated() {
        if (!$this->session->userdata('validated') || $this->session->userdata('arole')!='1'){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }

 
   
    public function replaceComma($field) {
        return str_replace(',', ' ', $field);
    }

    public function bank_account_log($page_no) 
    {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date']      = $this->input->get('from_date');
                $data['to_date']        = $this->input->get('to_date');
                $data['bank_account_id'] = $this->input->get('bank_account_id');
            
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->bank_detail_log_model->complete_bank_account_log_data();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=bank_account_log.csv');
                        echo "Log Id, Bank Account Id, Modified By, Organization name,Account holder name, Bank name, Account number, IFSC Code, Account nick name, IP Address, Modified Date, Status" . PHP_EOL;
                        foreach ($reportData as $row) {
                            echo $row->id . ',' . $row->bank_account_id . ',' . $row->first_name ." ". $row->last_name. ',' . $row->name . ','. $row->account_holder_name . ',' . $row->bank_name . ',' . $row->account_number . ',' . $row->ifsc_code . ','.$row->account_nick_name . ',' .$row->ip . ','. date('d-m-Y_h:i:s', strtotime($row->created_date)) . ',' . (($row->status == 1)? "Active":"Inactive") . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->bank_detail_log_model->get_total_bank_account_log();
        
        $config['base_url'] = site_url() . 'superadmin/bank_detail_log/bank_account_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->bank_detail_log_model->bank_account_log($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/bank_account_log', $data);
        $this->load->view('superadmin/footer');
    }
    
 
    /*
    public function bank_account_log1($page_no) {
     if ($this->input->get('submit')) 
        { 
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['reference_no'] = $this->input->get('reference_no');
   
                if ($submit == 'Download') 
                { 
                    // if($this->input->post('from_date') && $this->input->post('to_date')){
					
                    $reportData = $this->user_model->completeAwardedListLogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Awarded_logList.csv');
                        echo "S.No,Ref No.,H1 Bidder,Status,Awarded By,Date,IP Address" . PHP_EOL;
                        foreach ($reportData as $row) {
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                           $dateMiliArr = explode('.',$row->modified_date);
                           $mDate = date('d-m-Y_h:i:s', strtotime($dateMiliArr[0])).'.'.$dateMiliArr[1];
                             echo $row->auctionID . ',' . $row->reference_no . ',' . $row->bidder_name . ',' . $row->awardedStatus . ',' . $row->awarded_by_name . ',' . date('d-m-Y_h:i:s', strtotime($row->awarded_date)) . ',' . $row->awarded_ip . ',' .  PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }
        
         

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->Gettotalawardedlogs();
        
        
        
        
        
        $config['base_url'] = site_url() . 'superadmin/user/awardedList_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetAwardedListlogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/awarded_list_log', $data);
        $this->load->view('superadmin/footer');
    }
   */

}

?>
