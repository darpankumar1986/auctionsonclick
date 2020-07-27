<?php

class Tokens_model extends CI_Model {

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
        $columns = array("u.token_id", "u.token_name", "u.token_type");
        $columnCount = count($columns);

        // start from a basic query, which we will expand later
        $query = "SELECT count(*) as total FROM tbl_tokens as u WHERE 1  ";

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
        $query .= "ORDER BY u.token_id ASC ";
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
        $columns = array("u.token_id", "u.token_name", "u.token_type");
        $columnCount = count($columns);

        // start from a basic query, which we will expand later
        $query = "SELECT u.* FROM tbl_tokens as u WHERE 1  ";

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

        $query .= "ORDER BY u.token_id ASC ";
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
        $token_id          = $this->input->post('token_id');
        $token_name        = $this->input->post('token_name');
        $token_type        = $this->input->post('token_type');
        $status            = $this->input->post('status');
        
        
        $data = array(           
            'token_name'   => $token_name,
            'token_type'   => $token_type,            
            'status'       => $status
        );

        if ($token_id) {
            $data['modified_date'] = date('Y-m-d H:i:s');
            $this->db->where('token_id', $token_id);
            $this->db->update('tbl_tokens', $data);
            
            unset($data['modified_date']);
            $data['created_date']   = date('Y-m-d H:i:s');
            $data['token_id']    	= $token_id;
            $data['ip']             = $this->input->ip_address();
            $this->db->insert('tbl_log_tokens', $data);
            
        }
        else
        {
            $data['created_date'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_tokens', $data);
            
            $data['token_id']   = $this->db->insert_id();
            $data['ip']         = $this->input->ip_address();
            $this->db->insert('tbl_log_tokens', $data);
            
        }
        //echo $this->db->last_query(); die;
        return true;
    }
    
    
    public function GetRecordById($id) {
        $this->db->where('token_id', $id);
        $query = $this->db->get("tbl_tokens");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }    
    
    public function uniquetoken($name,$id) {
		$this->db->where('token_id !=', $id);
		$this->db->where('token_name', $name);
		$query = $this->db->get("tbl_tokens");
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {
				return "false";
		}
		return "true";
	}
    
}//End class Tokens_model

?>
