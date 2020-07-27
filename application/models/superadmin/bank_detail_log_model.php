<?php

class Bank_detail_log_model extends CI_Model {

    private $path = 'public/uploads/';

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('superadmin/role_model');
    }
    
     function complete_bank_account_log_data() {
        //search query start//
        $from_date  = trim($this->input->get('from_date'));
        $to_date    = trim($this->input->get('to_date'));
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(created_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
       
        $this->db->select('ba.id, ba.bank_account_id , ba.account_nick_name , ba.account_holder_name , ba.bank_name , ba.ifsc_code ,ba.account_number ,ba.ip ,ba.status ,ba.created_date, u.first_name, u.last_name, b.name');
        $this->db->from('tbl_log_bank_account_details AS ba');
        $this->db->join('tbl_user as u', 'u.id=ba.user_id', 'left');
        $this->db->join('tbl_bank as b', 'b.id=ba.organization_id', 'left');
        $this->db->order_by('ba.id ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function get_total_bank_account_log() 
    {
        $from_date  = trim($this->input->get('from_date'));
        $to_date    = trim($this->input->get('to_date'));
        $bank_account_id = trim($this->input->get('bank_account_id'));
       
        $this->db->select('count(*) as total');
       
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(created_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if ($bank_account_id != '') {
            $this->db->where("bank_account_id", $bank_account_id);
        }
        $query = $this->db->get("tbl_log_bank_account_details");
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }

   
    public function bank_account_log($start = 0, $limit = 10)
    {
        $from_date          = trim($_GET['from_date']);
        $to_date            = trim($_GET['to_date']);
        $bank_account_id    = trim($_GET['bank_account_id']);

        $this->db->select('ba.id, ba.bank_account_id , ba.account_nick_name , ba.account_holder_name , ba.bank_name , ba.ifsc_code ,ba.account_number ,ba.ip ,ba.status ,ba.created_date, u.first_name, u.last_name, b.name');
        $this->db->from(' tbl_log_bank_account_details AS ba');
        $this->db->join('tbl_user as u', 'u.id=ba.user_id', 'left');
        $this->db->join('tbl_bank as b', 'b.id=ba.organization_id', 'left');
        $this->db->order_by('ba.id DESC');
        $this->db->limit($limit, $start);
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where('(ba.created_date BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        if($bank_account_id !='') 
        {
            $this->db->where("bank_account_id", $bank_account_id);
        }
       
        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        
        return false;
    }
    
 /*
    public function GettotalPaymentlogs()
    {
        
        $from_date      = trim($this->input->get('from_date'));
        $to_date        = trim($this->input->get('to_date'));
        $auction_id     = trim($this->input->get('auction_id'));
        $ref_number     = trim($this->input->get('ref_number'));
        $email_id       = trim($this->input->get('email_id'));
       
        $this->db->select('count(*) as total');
        
        if ($from_date != '' && $to_date != '') 
        {
            $this->db->where('(indate BETWEEN ' . "'" . $from_date . "'  AND '" . $to_date . "')");
        }
        
        if ($auction_id != '') 
        {
            $this->db->where("auction_id",$auction_id);
        }
        
        if ($ref_number != '') 
        {
           $this->db->like("payment_response",$ref_number);
        }
        
        if ($email_id != '') 
        {
           $this->db->like("payment_request",$email_id);
        }
        
        $query = $this->db->get("tbl_jda_payment_log");
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    }
    
   
    
    public function GettotalNotawardedlogs() {
        $this->db->select('count(*) as total');
        
        $this->db->select('A.auctionID,D.reference_no,CONCAT(B.first_name , " ",  B.last_name) AS bidder_name,A.awardedStatus,CONCAT(C.first_name , " ",  C.last_name) AS awarded_by_name,A.awarded_date,A.awarded_ip',false);
        $this->db->from('tbl_log_auction_participate AS A');
        $this->db->join('tbl_auction as D', 'D.id=A.auctionID', 'left');
        $this->db->join('tbl_user as C', 'C.id=A.awarded_by', 'left');
        $this->db->join('tbl_user_registration as B', 'B.id=A.bidderID', 'left');
        $this->db->where('A.awardedStatus',2);
        
        
       $reference_no = trim($this->input->get('reference_no'));
        $query = $this->db->get();
        
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        } else {
            return 0;
        }
    } */

   } //End of class Bank_detail_log_model
  

?>
