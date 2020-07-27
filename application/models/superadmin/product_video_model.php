<?php
class Product_video_model extends CI_Model {
    
	private $path = 'public/uploads/videos/';
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetRecords($product_id) {
		$this->db->where('status !=', 5);
		//$this->db->where('type', 'url');
		$this->db->where('product_id', $product_id);
		$type = array('url', 'video');
		$this->db->where_in('type', $type);
        $query = $this->db->get("tbl_product_image_video");
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
        $this->db->where('id', $id);
		$query = $this->db->get("tbl_product_image_video");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetRecordByArticleId($product_id) {
        $this->db->where('product_id', $product_id);
		$query = $this->db->get("tbl_product_image_video");
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_article_video_data($image=null) {
		$id = $this->input->post('id');
		$product_id = $this->input->post('product_id');
		$type = $this->input->post('type');
		$youtubeurl = $this->input->post('youtubeurl');
		$title = $this->input->post('title');
		$priority = $this->input->post('priority');
		
		if($type=='url')
		{
			$name=	$youtubeurl;
		}else{
			$name=	$image;
		}

		$data = array('product_id'=>$product_id ,
					'title'=>(($title)?$title:''),
					'type'=>$type,
					'name'=>$name,
					'priority'=>$priority,
					'status'=>(($status)?$status:'1'),
					);
		if($id)			
		{
			$data['update_date']=date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			$this->db->update('tbl_product_image_video', $data); 
		}
		else
		{
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_product_image_video',$data); 
		}
		//echo $this->db->last_query();
		//die;
		return true;
	}
	
	
	function upload1($fieldname)
	{
	
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'avi|flv|wmv|mpeg|mp3|mp4';
		//$config['max_size'] = '1202400';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());

		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}	
	}
	
	function updateimageVideoStatus(){
		$type	=	$this->input->post('type');
		$id		=	$this->input->post('id');
		$stval	=	$this->input->post('stval');
		$data = array('status'=>$stval,'update_date'=>date('Y-m-d H:i:s'));
		$this->db->where('id', $id);
		if($this->db->update('tbl_product_image_video', $data))
		{
			return true;
		}else{
			return false;
		}
	}
	
		function DeleteimageVideoStatus(){
		$type	=	$this->input->post('type');
		$id		=	$this->input->post('id');
		$stval	=	$this->input->post('stval');
		$data = array('status'=>5,'update_date'=>date('Y-m-d H:i:s'));
		$this->db->where('id', $id);
		if($this->db->update('tbl_product_image_video', $data))
		{
			return true;
		}else{
			return false;
		}
	
	}
}