<?php

class Email_template_model extends CI_Model {

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
        $columns = array("u.email_template_id", "u.email_template_name", "u.subject", "u.msg");
        $columnCount = count($columns);

        // start from a basic query, which we will expand later
        $query = "SELECT count(*) as total FROM tblmst_email_template as u WHERE 1  ";

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
        $query .= "ORDER BY u.email_template_id DESC ";
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
        $columns = array("u.email_template_id", "u.email_template_name", "u.subject", "u.msg");
        $columnCount = count($columns);

        // start from a basic query, which we will expand later
        $query = "SELECT u.* FROM tblmst_email_template as u WHERE 1  ";

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

        $query .= "ORDER BY u.email_template_id DESC ";
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

    public function GetRecordById($id) {
        $this->db->where('email_template_id', $id);
        $query = $this->db->get("tblmst_email_template");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }

    public function save_data() { 
        $template_name    = $this->input->post('template_name');
        $subject    = $this->input->post('subject');
        $msg_body   = $this->input->post('msg_body'); 
        $email_template_id   = $this->input->post('email_template_id');

        $status     = $this->input->post('status');
        
        $data = array(
            'email_template_name' => $template_name,
            'subject' => $subject,
            'msg' => $msg_body,
            'status' => $status
        );

        if ($email_template_id) {
            $data['date_modified'] = date('Y-m-d H:i:s');
            $this->db->where('email_template_id', $email_template_id);
            $this->db->update('tblmst_email_template', $data);
            
        } else {
            $data['date_created'] = date('Y-m-d H:i:s');
            $this->db->insert('tblmst_email_template', $data);
        }
        //echo $this->db->last_query(); die;
        return true;
    }
}

?>
