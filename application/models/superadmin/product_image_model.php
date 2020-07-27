<?php
class Product_image_model extends CI_Model {
    
	private $path = 'public/uploads/property_images/';
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetRecords() {
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
	
	public function GetRecordById($id) {
        $this->db->where('id', $id);
		$query = $this->db->get("tbl_product_image_video");
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
				$this->db->where('status !=', 5);
				$this->db->where('type', 'images');
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
	
	public function save_article_image_data($image=null) {
		$id = $this->input->post('id');
		$product_id = $this->input->post('product_id');
		$title = $this->input->post('title');
		$is_banner = $this->input->post('is_banner');
		$priority = $this->input->post('priority');
		if(!$priority){
			$priority = SetPriority('tbl_product_image_video', "and product_id = $product_id");
		}
		
		$data = array('product_id'=>$product_id ,
					'title'=>(($title)?$title:''),
					'is_banner'=>$is_banner,
					'type'=>'images',
					'name'=>$image,
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
		return true;
	}
	
	
	function upload1($fieldname)
	{
	
		echo $config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = '5120';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
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