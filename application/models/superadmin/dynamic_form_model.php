<?php
class Dynamic_form_model extends CI_Model {
    private $path = 'public/uploads/property_images/';
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function GetTotalRecord() {	
		$this->db->select('count(p.id) as total');	
		//search query start//
	$title 	= trim($this->input->post('title')); 
		$status	= $this->input->post('status1');
		$posted_by 	= $this->input->post('posted_by');
		$product_type = $this->input->post('product_type');
		$type	= $this->input->post('type');
		
		if($status != '')
		$this->db->where('p.status ', $status);
		if($title != '')
		$this->db->like('p.name', $title);
		if($type != '')
		$this->db->like('p.product_type_val', $type);
		if($posted_by != '')
		{
			($posted_by)?$this->db->where('p.sell_rent !=', is_null):$this->db->where('p.sell_rent', is_null);
		}
		if($product_type != '')
		$this->db->like('p.is_auction', $product_type);
		//serach query ends//
		$this->db->from("tbl_product as p");
		$this->db->join("tbl_auction as a", 'p.id=a.productID','left');
		$this->db->where('a.auction_type','1');
		$this->db->where('p.status !=', 5);
		 $query = $this->db->get();	
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords($start=0, $limit=10) {
		
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= $this->input->post('status1');
		$posted_by 	= $this->input->post('posted_by');
		$product_type = $this->input->post('product_type');
		$type	= $this->input->post('type');
		$this->db->select('p.id,p.name,p.product_type_val,p.status,p.indate');	
	
		
		if($status != '')
		$this->db->where('p.status ', $status);
		if($title != '')
		$this->db->like('p.name', $title);
		if($type != '')
		$this->db->like('p.product_type_val', $type);
		if($posted_by != '')
		{
			($posted_by)?$this->db->where('p.sell_rent !=', is_null):$this->db->where('p.sell_rent', is_null);
		}
		if($product_type != '')
		$this->db->like('p.is_auction', $product_type);
		//serach query ends//
		$this->db->from("tbl_product as p");
		$this->db->join("tbl_auction as a", 'p.id=a.productID','left');
		$this->db->where('a.auction_type','1');		
		$this->db->where('p.status !=', 5);		
		$this->db->limit($limit,$start);
		$this->db->order_by("p.id", "desc");
        $query = $this->db->get();	
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
	public function GetProductDetail($product_id) {
		
		$this->db->where('id ', $product_id);		
        $query = $this->db->get("tbl_product");	
		//echo $this->db->last_query();
		
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
							$data = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetProductPreview($product_id) {
		
		$this->db->where('id ', $product_id);		
        $query = $this->db->get("tbl_product");	
		//echo $this->db->last_query();
		
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				if($row->is_auction)
				{
						$this->db->where('productId ', $product_id);		
						$query = $this->db->get("tbl_auction");
						if ($query->num_rows() > 0) {
						foreach ($query->result() as $row_auction) {}
						$row->auction=$row_auction;
						}

				}
							$data = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetAttributeValue($product_id) {
		$this->db->select('attribute_id ,values');
		$this->db->where('product_id ', $product_id);		
		$this->db->where('status', 0);		
        $query = $this->db->get("tbl_product_attribute_value");	
		//echo $this->db->last_query();
		
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
							$data[$row->attribute_id] = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetImageValue($product_id) {
		$this->db->where('product_id ', $product_id);
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
	public function GetRecordByCategory($category_id,$is_auction='',$is_bank='',$is_sell='') {
	
		$this->db->select('a.* , ag.name as group_name, ag.id as group_id, ag.is_display');		
		$this->db->from("tbl_attribute_group as ag");
		$this->db->join('tbl_attribute as a', 'a.group_id = ag.id and a.status=1', 'left');
		$this->db->where("FIND_IN_SET('$category_id',ag.category_id) !=", 0);
		$this->db->where("ag.status",1);
		if($is_auction)
		{
		$this->db->where("(a.is_auction='$is_auction' OR a.is_auction='both')");
		}
		if($is_bank)
		{
		$this->db->where("(a.is_bank='$is_bank' OR a.is_bank='both')");
		}
		if($is_sell)
		{
		$this->db->where("(a.is_sell='$is_sell' OR a.is_sell='both')");
		}
		$this->db->order_by("a.priorty", "asc");
		$this->db->order_by("ag.priority", "asc");
		$query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->group_id][] = $row;
            }
            return $data;
        }
        return false;
    }
	public function save_data($image=null) {
		$type = $this->input->post('type');
		$records=$this->GetRecordByCategory($type,$is_auction='auction',$is_bank='bank',$is_sell='sell');
		// Insert basic info
		$id = $this->input->post('id');
		$product_for = $this->input->post('product_for');
		$name = $this->input->post('name');
		$description = $this->input->post('description');
		$price = $this->input->post('price');
		$is_auction = $this->input->post('is_auction');
		$Address1 = $this->input->post('address');
		$Street = $this->input->post('street');
		$Country = $this->input->post('country');
		$State = $this->input->post('state');
		$City = $this->input->post('city');
		$Zip = $this->input->post('zip');
		$phone = $this->input->post('phone');
		$fax = $this->input->post('fax');
		$category = $this->input->post('category');
		$subproduct_type_val=GetTitleByField('tbl_category', "id=".$type."", 'name');
		$product_type_val=GetTitleByField('tbl_category', "id=".$category."", 'name');
		$data = array(
							'name'=>$name,
							'product_description'=>$description,
							'price'=>$price,
							'sell_rent'=>$product_for,
							'user_id'=>$user_id,
							'is_auction'=>$is_auction,
							'product_subtype_id'=>$type,
							'product_type'=>$category,
							'product_type_val'=>$product_type_val,
							'product_subtype_val'=>$subproduct_type_val,
							'address1'=>$Address1,
							'street'=>$Street,
							'country'=>$Country,
							'state'=>$State,
							'city'=>$City,
							'zip'=>$Zip,
							'phone'=>$phone,
							'fax'=>$fax
							
						);
				
				if($id)			
				{
					/*if(!preg_match("/^[_a-z0-9-]+-[0-9]+$/", $data['slug'])) {
					  $data['slug'] = GetSlug($title, $id);
					}*/
					$data['updated_date']=date('Y-m-d H:i:s');
					$this->db->where('id', $id);
					$this->db->update('tbl_product', $data); 
					$product_id =$id;
				}
				else
				{			
					$data['status']=0;			
					$data['indate']=date('Y-m-d H:i:s');			
					$this->db->insert('tbl_product',$data); 
					$product_id = $this->db->insert_id();

				}
				 //$this->db->last_query();
				
		// End Insert basic info
		 $files = $_FILES;
         $count = count($_FILES['image']['name']);
		
            for($i=0; $i<$count; $i++)
            {
				if($files['image']['name'][$i])
				{
					$_FILES['file_upload']['name']= $files['image']['name'][$i];
					$_FILES['file_upload']['type']= $files['image']['type'][$i];
					$_FILES['file_upload']['tmp_name']= $files['image']['tmp_name'][$i];
					$_FILES['file_upload']['error']= $files['image']['error'][$i];
					$_FILES['file_upload']['size']= $files['image']['size'][$i];
					$image=$this->upload1('file_upload');
			    }
				else
				{
					$file_upload = $this->input->post('image_old');
					$image=$file_upload[$i];
				}
			   if($image){
			   $priority = SetPriority('tbl_product_image_video', "and product_id = $product_id");
				$data = array(
							'product_id'=>$product_id,
							'type'=>'images',
							'name'=>$image,
							'priority'=>$priority,
							'status'=>0
							
						);
					$data['indate']=date('Y-m-d H:i:s');			
					$this->db->insert('tbl_product_image_video',$data);
				}

            }
			//video 
			if($_FILES['video']['name'])
			{
			$video=$this->upload1('video');
			}
			else
			$video = $this->input->post('video_url');
			if($video)
			{
				$video_type = $this->input->post('video_type');
				$priority = SetPriority('tbl_product_image_video', "and product_id = $product_id");
				$data = array(
					'product_id'=>$product_id,
					'name'=>$video,
					'type'=>$video_type,
					'priority'=>$priority,
					'status'=>0
					);
					$data['indate']=date('Y-m-d H:i:s');			
					$this->db->insert('tbl_product_image_video',$data);
			}
			//End video
		
		
		///Delete previous Records from tbl_product_attribute_values on edit
			if($id)			
			{
					$this->db->where('product_id', $product_id);
					$this->db->update('tbl_product_attribute_value', array('status'=>5,'updated_date'=>date('Y-m-d H:i:s'))); 
			}
					
		//End Delete previous Records from tbl_product_attribute_values on edit
		foreach($records as $group_records)		
		{
			foreach($group_records as $data)		
			{
				$values = $this->input->post('form_field_'.$data->id);
				if(is_array($values))
					$values=implode(',',$values);
				
				
				$data = array(
							'attribute_id'=>$data->id,
							'group_id'=>$group_records[0]->group_id,
							'user_id'=>$user_id,
							'product_id'=>$product_id,
							'attr_name'=>$data->name,
							'values'=>$values,
							'status'=>0
							
						);
					$data['indate']=date('Y-m-d H:i:s');			
					$this->db->insert('tbl_product_attribute_value',$data); 
					//$id = $this->db->insert_id();
			}
		}
		return $product_id;
	}
	
	
	function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = false;
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
//print_r($error);die;		
	}
	public function GettotalImages($product_id) {
        $this->db->where('product_id', $product_id);
		$this->db->where('status !=', 5);
		$this->db->where('type', 'images');
		$query = $this->db->get("tbl_product_image_video");
		$this->db->last_query();
		if ($query->num_rows() > 0) {
         $totalrecords=$query->num_rows();
        }else{
		 $totalrecords=0;	
		}
		return $totalrecords;
    }
	
}