<?php

class Home_page_slider_model extends CI_Model {

    private $path = 'public/uploads/home_page_slider/';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function GetSubRecords($start = 0, $limit = 0) {

        $this->db->from("tbl_home_page_slider");
        $this->db->order_by('id','asc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
            echo "<pre>";
            print_r($data);
            die;
        }
        return false;
    }

    public function GetParentRecordsControl() {
        $this->db->where('parent_id', 0);
        $this->db->where('status', 1);
		$this->db->order_by('id','asc');
        $query = $this->db->get("tbl_home_page_slider");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecordById($id) {
        $this->db->where('id', $id);
 
        $query = $this->db->get("tbl_home_page_slider");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }

    public function imageName($id){
        $this->db->select('image');
        $this->db->where('id', $id);
        $query = $this->db->get("tbl_home_page_slider");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function deleteRecord($id, $image_name) {

        /*$file = base_url() . 'public/uploads/home_page_slider/' . $image_name;
        if (!unlink($file)) {
            echo ("Error deleting $file");
        } else {
            echo ("Deleted $file");
        }*/
        $this->db->where('id', $id);
        $this->db->delete('tbl_home_page_slider');
        //echo $this->db->last_query();die;
        return true;
    }

    public function save_slider_data($image = null) {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $priority = $this->input->post('priority');
        $status = $this->input->post('status');
        $url = $this->input->post('url');
        $indate = date('Y-m-d H:i:s');

        $data = array(
            'title' => $title,
            'image' => $image,
            'description' => $description,
            'priority' => $priority,
            'status' => $status,
            'indate' => $indate,
            'url' => $url
        );
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('tbl_home_page_slider', $data);
        } else {
            $this->db->insert('tbl_home_page_slider', $data);
            $id = $this->db->insert_id();
        }
        return true;
    }

    function upload1($fieldname) {
        $config['upload_path'] = $this->path;
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777);
        }
        $config['allowed_types'] = 'jpg|png|jpeg|gif|JPG|JPEG|GIF|PNG';
        $config['max_size'] = '2000';
        $config['remove_spaces'] = true;
        $config['overwrite'] = false;
        $config['encrypt_name'] = true;
        $config['max_width'] = '';
        $config['max_height'] = '';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($fieldname)) {
            $error = array('error' => $this->upload->display_errors());
			$error=$error['error'];
			$returndata['error']=$error;
        } else {
            $upload_data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $upload_data['full_path'];
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 890;
            $config['height'] = 489;
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()){
                    $this->session->set_flashdata('message', $this->image_lib->display_errors());
		}
			$returndata['imagename']=$upload_data['file_name'];
        }
		return $returndata;
    }
}
