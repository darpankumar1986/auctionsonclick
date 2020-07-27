<?php

class Bank_account_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('superadmin/role_model');
    }

    public function GetTotalRecord() {
        //search query start//
        $title = trim($this->input->get('title'));

        $searchq = $title;
        $words = explode(" ", $searchq);
        $wordCount = count($words);

        // declare which columns should be searched
        $columns = array("u.bank_account_id", "u.account_nick_name", "u.account_holder_name", "u.bank_name", "u.ifsc_code", "u.account_number");
        $columnCount = count($columns);

        // start from a basic query, which we will expand later
        $query = "SELECT count(*) as total FROM tbl_bank_account_details as u WHERE 1  ";

        // all words should be used
        // that's why we are adding them with the 'AND' operator.
        if ($title != '') {
            $query .= " AND ";
            for ($i = 0; $i < $wordCount; $i++) {
                $word = mysql_escape_string($words[$i]);

                if ($i > 0)
                    $query .= " AND ";

                // build the condition
                $condition = " (";
                for ($j = 0; $j < $columnCount; $j++) {
                    // but each word can match any column, doesn't matter which one.
                    // that's why we are using the 'OR' operator here. 
                    if ($j > 0)
                        $condition .= " OR ";
                    $column = $columns[$j];

                    if (strtolower($word) == 'active') {
                        $status = 1;
                        $condition .= " u.status like '%{$status}%' ";
                    }
                    if (strtolower($word) == 'inactive') {
                        $status = 0;
                        $condition .= " u.status like '%{$status}%' ";
                    }
                    if (strtolower($word) != 'active' && strtolower($word) != 'inactive') {
                        $condition .= " {$column} like '%{$word}%' ";
                    }
                }
                $condition .= ") ";
                $query .= $condition;
            }
        }

        //$query .= " AND u.status != 5  ";
        $query .= "ORDER BY u.bank_account_id ASC ";
        $query = $this->db->query($query);

        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data[0]->total;
        }
        return 0;
    }

    public function GetRecords($start = 0, $limit = 10) {
        //search query start//
        $title = trim($this->input->get('title'));

        $searchq = $title;
        $words = explode(" ", $searchq);
        $wordCount = count($words);

        // declare which columns should be searched
        $columns = array("u.bank_account_id", "u.account_nick_name", "u.account_holder_name", "u.bank_name", "u.ifsc_code", "u.account_number");
        $columnCount = count($columns);

        // start from a basic query, which we will expand later
        $query = "SELECT u.* FROM tbl_bank_account_details as u WHERE 1  ";

        // all words should be used
        // that's why we are adding them with the 'AND' operator.
        if ($title != '') {
            $query .= " AND ";
            for ($i = 0; $i < $wordCount; $i++) {
                $word = mysql_escape_string($words[$i]);

                if ($i > 0)
                    $query .= " AND ";

                // build the condition
                $condition = " (";
                for ($j = 0; $j < $columnCount; $j++) {
                    // but each word can match any column, doesn't matter which one.
                    // that's why we are using the 'OR' operator here. 
                    if ($j > 0)
                        $condition .= " OR ";
                    $column = $columns[$j];

                    if (strtolower($word) == 'active') {
                        $status = 1;
                        $condition .= " u.status like '%{$status}%' ";
                    }
                    if (strtolower($word) == 'inactive') {
                        $status = 0;
                        $condition .= " u.status like '%{$status}%' ";
                    }
                    if (strtolower($word) != 'active' && strtolower($word) != 'inactive') {
                        $condition .= " {$column} like '%{$word}%' ";
                    }
                }
                $condition .= ") ";
                $query .= $condition;
            }
        }

        $query .= "ORDER BY u.bank_account_id ASC ";
        $query .= " LIMIT " . $start . ", " . $limit . "";
        $query = $this->db->query($query);

        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function save_data() { 
        
        $organization_id        = $this->input->post('organization');
        $bank_account_id        = $this->input->post('bank_account_id');
        $account_holder_name    = $this->input->post('account_holder_name'); 
        $account_nick_name      = $this->input->post('account_nick_name');
        $bank_name              = $this->input->post('bank_name');
        $account_number         = $this->input->post('account_number');
        $ifsc_code              = $this->input->post('ifsc_code');
        $status                 = $this->input->post('status');
        
        
        $data = array(
            'organization_id'       => $organization_id,
            'user_id'               => $this->session->userdata('id'),
            'account_nick_name'     => $account_nick_name,
            'account_holder_name'   => $account_holder_name,
            'bank_name'             => $bank_name,
            'ifsc_code'             => $ifsc_code,
            'account_number'        => $account_number,
            'status'                => $status
        );

        if ($bank_account_id) {
            $data['modified_date'] = date('Y-m-d H:i:s');
            $this->db->where('bank_account_id', $bank_account_id);
            $this->db->update('tbl_bank_account_details', $data);
            
            unset($data['modified_date']);
            $data['created_date']       = date('Y-m-d H:i:s');
            $data['bank_account_id']    = $bank_account_id;
            $data['ip']                 = $this->input->ip_address();
            $this->db->insert('tbl_log_bank_account_details', $data);
            
        }
        else
        {
            $data['created_date'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_bank_account_details', $data);
            
            $data['bank_account_id']   = $this->db->insert_id();
            $data['ip']                = $this->input->ip_address();
            $this->db->insert('tbl_log_bank_account_details', $data);
            
        }
        //echo $this->db->last_query(); die;
        return true;
    }
    
    
    public function GetRecordById($id) {
        $this->db->where('bank_account_id', $id);
        $query = $this->db->get("tbl_bank_account_details");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function get_organization() {
        $this->db->select('id, name');
        $this->db->where('status', 1);
        $query = $this->db->get("tbl_bank");
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function get_all_remitter_account() {
        $this->db->select('bank_account_id, account_nick_name, account_holder_name, bank_name, ifsc_code, account_number');
        $this->db->where('status', 1);
        $query = $this->db->get("tbl_bank_account_details");
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function get_remitter_account_by_id() {
        $bank_account_id    = $this->input->post("id");
        $this->db->select('account_holder_name, bank_name, ifsc_code, account_number');
        $this->db->where('bank_account_id', $bank_account_id);
        $this->db->where('status', 1);
        $query = $this->db->get("tbl_bank_account_details");
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
}//End class Bank_account_model

?>
