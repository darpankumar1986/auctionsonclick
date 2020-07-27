<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_Image extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/product_image_model');
		$this->check_isvalidated();
	}	
	
	public function index($product_id)
	{
		$this->page($product_id);
	}	
	
public function updateimageVideoStatus()
	{
		$id=$this->input->post('id');
		if($id){
			$returnval=$this->product_image_model->updateimageVideoStatus();
			if($returnval==1)
			{
				echo "Stauts is updated successfully!";
			}else{
				echo "Stauts is not updated!";
			}
		}
	}
	
public function DeleteimageVideoStatus()
	{
		$id=$this->input->post('id');
		if($id){
			$returnval=$this->product_image_model->DeleteimageVideoStatus();
			if($returnval==1)
			{
				echo "Stauts is updated successfully!";
			}else{
				echo "Stauts is not updated!";
			}
		}
	}
	
	private function check_isvalidated(){
        $sess = $this->input->post('sess');
				if($sess && $sess = $this->session->userdata('session_id'))
				{
				
				}
				else if(! $this->session->userdata('validated')){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
	


	
	public function page($product_id)
	{
		$data['heading']='Product Gallery'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');
		
		$array_records = $this->product_image_model->GetRecordByArticleId($product_id);
		
		$data['records'] = $array_records; 
		
		$this->load->view('superadmin/article_image', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function page_popup($product_id)
	{
		$data['heading']='Product Images'; 
		$this->load->view('superadmin/header-popup', $data);
		$array_records = $this->product_image_model->GetRecordByArticleId($product_id);
		$data['product_id'] = $product_id;
		$data['records'] = $array_records; 
		$this->load->view('superadmin/product-image', $data);
	}

	public function add_popup($product_id)
	{
		$data['heading']='Add Product Image';
		$data['product_id'] = $product_id;
		$this->load->view('superadmin/header-popup', $data);		
		$this->load->view('superadmin/add-edit-product-image', $data);
	}
	
	public function add_multiple_popup($product_id)
	{
		$data['heading']='Add Product Images';
		$product_id = $product_id;
		
		$data['product_id'] = $product_id;
		$this->load->view('superadmin/header-popup', $data);		
		$this->load->view('superadmin/add-multiple-product-image', $data);
	}
	
	public function edit_popup($id)
	{
		$data['heading']='Edit Product Image';
		$id = $id;
		
		$data['row'] = $this->product_image_model->GetRecordById($id);
		$data['product_id'] = $data['row']->product_id;
		$this->load->view('superadmin/header-popup', $data);		
		$this->load->view('superadmin/add-edit-product-image', $data);
	}
	
	function save_multiple()
    {

            $this->load->library('upload');
            $files = $_FILES;
             $count = count($_FILES['file_upload']['name']);
		
            for($i=0; $i<$count; $i++)
            {
                $_FILES['file_upload']['name']= $files['file_upload']['name'][$i];
                $_FILES['file_upload']['type']= $files['file_upload']['type'][$i];
                $_FILES['file_upload']['tmp_name']= $files['file_upload']['tmp_name'][$i];
                $_FILES['file_upload']['error']= $files['file_upload']['error'][$i];
                $_FILES['file_upload']['size']= $files['file_upload']['size'][$i];
               $image=$this->product_image_model->upload1('file_upload');	
                $save = $this->product_image_model->save_article_image_data($image);

            }
			redirect('superadmin/product_image/page_popup/'.$this->input->post('product_id'));

    }
    public function save()
	{
		{
			if($_FILES['image']['name']!= ""){
				$image=$this->product_image_model->upload1('image');	
			}else{
				$image=$this->input->post('image_old');
			}
			
			$save = $this->product_image_model->save_article_image_data($image);
			
			if($save){
				redirect('superadmin/product_image/page_popup/'.$this->input->post('product_id'));
			}else{
				
			}
		}	
	}	
}
?>
