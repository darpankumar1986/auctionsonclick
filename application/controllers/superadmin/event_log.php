<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_log extends MY_Controller {

    public function __Construct() {
        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
        $this->load->library("pagination");
        $this->load->helper(array('form'));
        $this->load->model('sales_coordinator_model');
        $this->load->model('helpdesk_model');
        $this->load->model('superadmin/bank_model');
        $this->load->model('superadmin/event_creation_model');
        $this->load->model('superadmin/user_model');
        $this->load->model('superadmin/bank_model');
        $this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
		$this->output->set_header('Pragma: no-cache');
        $this->check_isvalidated();
    }

    public function index($page_no) {
        $this->event_log_report($page_no);
    }

    private function check_isvalidated() {
        if (!$this->session->userdata('validated')) {
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }

    public function event_log_report($page_no) {
        $data = array();
        if ($this->input->get('submit')) {
            $submit = $this->input->get('submit');
        if (isset($submit) and ! empty($submit)){
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auctionId'] = $this->input->get('auctionId');
                

                if ($submit == 'Download') {

                    $reportData = $this->event_creation_model->log_event_report_model();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Event_log_list.csv');
                        //echo "Log_ID,Event_ID,Auction_ID,Client_Address,Date,Event_Logged_By,Organization". PHP_EOL;
                        
                        /*echo "Event Logged Id,Auction ID,IP Address,Date,Event Logged By,Organization Name". PHP_EOL;
                        foreach ($reportData as $row) {
                            //echo $row->id . ',' . $row->event_log_id . ',' . $row->auction_id . ',' . $row->ip . ',' . date('m-d-y_h:i:s', strtotime($row->indate)) . ',' . $row->created_by_first_name . ',' .str_replace(' ', '_',$row->bname)  . PHP_EOL;
                            echo $row->event_log_id . ',' . $row->auction_id . ',' . $row->ip . ',' . date('m-d-y_h:i:s', strtotime($row->indate)) . ',' . $row->created_by_first_name . ',' .str_replace(' ', '_',$row->bname)  . PHP_EOL;
                        }
                        */
                        
                        echo "Auction ID,IP Address,Date,Scheme Code,Approved/Reject Status,Comments,Auction Modified By". PHP_EOL;
                        foreach ($reportData as $row) {
							
                            if($row->approvalStatus==0) 
                            { $status = 'Saved';}
                            else if($row->approvalStatus==1) 
                            {$status = 'Pending For Approval';} 
                            else if($row->approvalStatus==2 && $row->status==0) 
                            {$status = 'Approved';} 
                            else if($row->approvalStatus==3) 
                            {$status = 'Review';}
                            else if($row->approvalStatus==4) 
                            {$status = 'Rejected';}
                            else if($row->approvalStatus==2 && $row->status==1) 
                            {$status = 'Approved';}
                            
                            echo $row->auction_id . ',' . $row->ip . ',' . date('m-d-y_h:i:s', strtotime($row->indate)) . ',' . $row->reference_no . ',' . $status .',' . $row->approverComments . ',' . $row->email_id . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Event Log User';
        $this->load->view('superadmin/header', $data);
        $per_page = 10;
        $total_record = $this->event_creation_model->log_event_count_model();
        $config['base_url'] = site_url() . 'superadmin/event_log/event_log_report?k=2&';        
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
        

        $array_records = $this->event_creation_model->log_event_records_model($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/event-creation', $data);
        $this->load->view('superadmin/footer');
    }

    public function assign_event_report($page_no) {
        $data = array();
        if ($this->input->post('submit')) {
            $submit = $this->input->post('submit');

            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->post('from_date');
                $data['to_date'] = $this->input->post('to_date');
                $data['auctionId'] = $this->input->post('auctionId');
                $data['eventId'] = $this->input->post('eventId');
                $data['createdby'] = $this->input->post('createdby');
                $data['Change_status'] = $this->input->post('Change_status');

                if ($submit == 'Download') {
                     $reportData = $this->event_creation_model->event_assign_report_model();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=misreport.csv');
                        echo "Log_ID,Auction_ID,IP_Address,Date,Event_Assigned_From,Event_Assigned_to,Bank_Name". PHP_EOL;
                        foreach ($reportData as $row) {
                            echo $row->id . ',' . $row->auction_id . ',' . $row->ip . ',' .date('m-d-y_h:i:s', strtotime($row->indate)) . ',' . $row->from_first_name . ',' . $row->to_first_name . ',' . str_replace(' ', '_',$row->bname) . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Event Assign/Reassign List';
        $this->load->view('superadmin/header', $data);
        $per_page = 10;
        $total_record = $this->event_creation_model->event_assign_count_model();
        $config['base_url'] = site_url() . 'superadmin/event_log/assign_event_report';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;

        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->event_creation_model->event_assign_records_model($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/event-assign', $data);
        $this->load->view('superadmin/footer');
    }

    public function select_bankuser($page_no) {
        $data = array();
        if ($this->input->post('submit')) {
            $submit = $this->input->post('submit');

            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->post('from_date');
                $data['to_date'] = $this->input->post('to_date');
                $data['auctionId'] = $this->input->post('auctionId');
                $data['eventId'] = $this->input->post('eventId');
                $data['createdby'] = $this->input->post('createdby');
                $data['Change_status'] = $this->input->post('Change_status');

                if ($submit == 'Download') {

                    $reportData = $this->event_creation_model->event_selectbankuser_report_model();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=misreport.csv');
                        echo "Log_ID,Event_ID,Auction_ID,Client_Address,Date,Bank_User_Id".PHP_EOL;
                        foreach ($reportData as $row) {
                            echo $row->id . ',' . $row->event_id . ',' . $row->auction_id . ',' . $row->ip . ',' . date('m-d-y_h:i:s', strtotime($row->indate)) . ',' . $row->email . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Event Selected Bank User';
        $this->load->view('superadmin/header', $data);
        $per_page = 10;
        $total_record = $this->event_creation_model->event_selectbankuser_count_model();
        $config['base_url'] = site_url() . 'superadmin/event_log/assign_event_report';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;

        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->event_creation_model->event_selectbankuser_records_model($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/select-bank-user', $data);
        $this->load->view('superadmin/footer');
    }

    public function upload_docimg($page_no) {
        $data = array();
        if ($this->input->post('submit')) {
            $submit = $this->input->post('submit');

            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->post('from_date');
                $data['to_date'] = $this->input->post('to_date');
                $data['auctionId'] = $this->input->post('auctionId');
                $data['eventId'] = $this->input->post('eventId');
                $data['createdby'] = $this->input->post('createdby');
                $data['Change_status'] = $this->input->post('Change_status');

                if ($submit == 'Download') {

                    $reportData = $this->event_creation_model->event_uploaddocimg_report_model();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=misreport.csv');
                        echo "Log_ID,Event_ID,Auction_ID,Client_Address,Date,Bank_User_Id". PHP_EOL;
                        foreach ($reportData as $row) {
                            echo $row->id . ',' . $row->event_id . ',' . $row->auction_id . ',' . $row->ip . ',' . date('m-d-y_h:i:s', strtotime($row->indate)) . ',' . $row->email . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }
        $data['heading'] = 'Event Upload Document / Image';
        $this->load->view('superadmin/header', $data);
        $per_page = 10;
        $total_record = $this->event_creation_model->event_uploaddocimg_count_model();
        $config['base_url'] = site_url() . 'superadmin/event_log/assign_event_report';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;

        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->event_creation_model->event_uploaddocimg_records_model($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/upload-doc-img', $data);
        $this->load->view('superadmin/footer');
    }

    public function second_opener($page_no) {
        $data = array();
        if ($this->input->post('submit')) {
            $submit = $this->input->post('submit');

            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->post('from_date');
                $data['to_date'] = $this->input->post('to_date');
                $data['auctionId'] = $this->input->post('auctionId');
                $data['eventId'] = $this->input->post('eventId');
                $data['createdby'] = $this->input->post('createdby');
                $data['Change_status'] = $this->input->post('Change_status');

                if ($submit == 'Download') {

                    $reportData = $this->event_creation_model->event_secondopener_report_model();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=misreport.csv');
                        echo "Log_ID,Event_ID,Auction_ID,Client_Address,Date,Bank_User_Id,Second_Opener_Id". PHP_EOL;
                        foreach ($reportData as $row) {
                            echo $row->id . ',' . $row->event_id . ',' . $row->auction_id . ',' . $row->ip . ',' . date('m-d-y_h:i:s', strtotime($row->indate)) . ',' . $row->email . ',' . $row->semail . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Event Upload Document / Image';
        $this->load->view('superadmin/header', $data);
        $per_page = 10;
        $total_record = $this->event_creation_model->event_secondopener_count_model();
        $config['base_url'] = site_url() . 'superadmin/event_log/assign_event_report';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;

        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->event_creation_model->event_secondopener_records_model($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/second-opener', $data);
        $this->load->view('superadmin/footer');
    }

    public function ajaxCorrigndumrender() {
        print_r($this->input->request);
        exit();
    }

    public function replaceComma($field) {
        return str_replace(',', ' ', $field);
    }

    public function doc_to_be_submit($page_no) {
        $data = array();
        if ($this->input->post('submit')) {
            $submit = $this->input->post('submit');

            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->post('from_date');
                $data['to_date'] = $this->input->post('to_date');
                $data['auctionId'] = $this->input->post('auctionId');
                $data['eventId'] = $this->input->post('eventId');
                $data['createdby'] = $this->input->post('createdby');
                $data['Change_status'] = $this->input->post('Change_status');

                if ($submit == 'Download') {

                    $reportData = $this->event_creation_model->event_dctbs_report_model();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=misreport.csv');
                        echo "Log_ID,Event_ID,Auction_ID,Client_Address,Date,Document_to_be_submitted". PHP_EOL;
                        foreach ($reportData as $row) {
                            echo $row->id . ',' . $row->event_id . ',' . $row->auction_id . ',' . $row->ip . ',' . date('m-d-y_h:i:s', strtotime($row->indate)) . ',' . str_replace(',', 'and',$row->document_to_be_submitted) . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Event Document to be submitted';
        $this->load->view('superadmin/header', $data);
        $per_page = 10;
        $total_record = $this->event_creation_model->event_dctbs_count_model();
        $config['base_url'] = site_url() . 'superadmin/event_log/assign_event_report';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;

        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->event_creation_model->event_dctbs_records_model($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/document-tobe-submitted', $data);
        $this->load->view('superadmin/footer');
    }

}

?>
