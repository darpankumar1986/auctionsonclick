<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_page_slider extends MY_Controller {

    public function __Construct() {
        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->helper(array('form'));
        $this->load->model('superadmin/home_page_slider_model');
        $this->check_isvalidated();
    }

    public function index($page_no) {
        $this->page($page_no);
    }

    private function check_isvalidated() {
        if (!$this->session->userdata('validated')) {
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }

    public function page($page_no) {
        $data['heading'] = 'Home Page Slider';
        $this->load->view('superadmin/header', $data);
        $this->load->view('superadmin/sidebar');

        if ($this->input->post('submit'))
            $this->updateStatus('tbl_home_page_slider');
        //search query start//
        $search['title'] = $this->input->post('title');
        $search['status'] = $this->input->post('status1');
        $data['search'] = $search;
        //serach query ends//
        $per_page = 50;
        //$total_record	= $this->home_page_slider_model->GetSubTotalRecord();		
        $config['base_url'] = site_url() . 'superadmin/home_page_slider/index';
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

        $array_records = $this->home_page_slider_model->GetSubRecords($offset, $per_page);

		
		
        $data['records'] = $array_records;
        $this->load->view('superadmin/home_page_slider', $data);
        $this->load->view('superadmin/footer');
    }

    public function addedit($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit Slider Info';
            $slider_id = $param;
        } else {
            $data['heading'] = 'Add Slider Info';
        }
        if ($slider_id) {
            $array_records = $this->home_page_slider_model->GetRecordById($slider_id);
        } else {
            $array_records = array();
        }
        $data['row'] = $array_records;

        $data['category'] = $category;
        $this->load->view('superadmin/header', $data);
        $this->load->view('superadmin/sidebar');
        $this->load->view('superadmin/add-edit-home-page-slider', $data);
        $this->load->view('superadmin/footer');
    }

    function delete($id) {
        $id = $_REQUEST["id"];
        //$image = $this->home_page_slider_model->imageName($id);
        //$image_name = $image[0]->image;
        //echo $this->home_page_slider_model->deleteRecord($id,$image_name);
        echo $this->home_page_slider_model->deleteRecord($id);
    }

    public function save() {
		
		$this->load->library('form_validation');
		$id=$this->input->post('id');
		$this->form_validation->set_rules('title', 'title name', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message','Please enter required fields also unique title name');
			redirect('superadmin/home_page_slider/addedit');
		}else{

				if ($_FILES['image']['name'] != "") {
					$image = $this->home_page_slider_model->upload1('image');
					if($image['error']!='')
					{
						$this->session->set_flashdata('message',$image['error']);
						redirect('superadmin/home_page_slider/addedit/'.$id);	
					}else{
					$fimage=$image['imagename']	;
					}
				} else {
					$fimage = $this->input->post('image_old');
				}
				
				//echo $image;
				
				
				
				$save = $this->home_page_slider_model->save_slider_data($fimage);
				if ($save) {
						
						if($id>0)
						{
						$this->session->set_flashdata('message','Home page slider Image is Updated successfully');
						}else{
						$this->session->set_flashdata('message','Home page slider Image is uploaded successfully');
						}
					
					redirect('superadmin/home_page_slider/index');
				} 
		
		}
    }

}

?>
