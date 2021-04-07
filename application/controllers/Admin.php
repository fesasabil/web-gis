<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{
	public $page;

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('googlemaps','session','form_validation','pagination'));

		$this->load->helper(array('menus','text','url'));

		if($this->session->has_userdata('admin_login')==FALSE) 
			redirect(site_url());

		$this->load->model('madmin');

		$this->page = $this->input->get('page');
	}

	public function addhospital()
	{	
		$this->data['title'] = "Add Hospital";

		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('location', 'Location', 'trim|required');
		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{
			$this->madmin->createHospital();

			redirect(current_url());
		}

		$config['map_div_id'] = "map-add";
		$config['map_height'] = "250px";
		$config['center'] = '-6.2293867,106.6894315';
		$config['zoom'] = '12';
		$config['map_height'] = '300px;';
		$this->googlemaps->initialize($config);

		$marker = array();
		$marker['position'] = '-6.2293867,106.6894315';
		$marker['draggable'] = true;
		$marker['ondragend'] = 'setMapToForm(event.latLng.lat(), event.latLng.lng());';
		$this->googlemaps->add_marker($marker);
		$this->data['map'] = $this->googlemaps->create_map();

		$this->load->view('add-hospital', $this->data);
	}

	public function hospital()
	{
		$config['base_url'] = site_url("admin/hospital?per_page={$this->input->get('per_page')}&query={$this->input->get('q')}");

		$config['per_page'] = 10;
		$config['total_rows'] = $this->madmin->getAllHospital(null, null, 'num');
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = "&larr; Pertama";
        $config['first_tag_open'] = '<li class="">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = "Terakhir &raquo";
        $config['last_tag_open'] = '<li class="">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = "Selanjutnya &rarr;";
        $config['next_tag_open'] = '<li class="">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = "&larr; Sebelumnya"; 
        $config['prev_tag_open'] = '<li class="">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="">';
        $config['num_tag_close'] = '</li>'; 
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
		
		$this->pagination->initialize($config);
		
		
		$this->data = array(
			'title' => "Data Hospital",
			'hospital' => $this->madmin->getAllHospital($config['per_page'], $this->input->get('page'), 'result')
		);

		$this->load->view('data-hospital', $this->data);
	}

	public function updatehospital($param = 0)
	{
		$this->data['title'] = "Update Hospital";

		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('location', 'Location', 'trim|required');
		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
		$this->form_validation->set_rules('description', 'Deskripsi', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{
			$this->madmin->updateHospital($param);

			redirect(current_url());
		}

		$this->data['hospital'] = $this->madmin->getHospital($param);

		$config['map_div_id'] = "map-add";
		$config['map_height'] = "250px";
		$config['center'] = $this->data['hospital']->latitude.','.$this->data['hospital']->longitude;
		$config['zoom'] = '14';
		$config['map_height'] = '300px;';
		$this->googlemaps->initialize($config);

		$marker = array();
		$marker['position'] = $this->data['hospital']->latitude.','.$this->data['hospital']->longitude;
		$marker['draggable'] = true;
		$marker['ondragend'] = 'setMapToForm(event.latLng.lat(), event.latLng.lng());';
		$this->googlemaps->add_marker($marker);
		$this->data['map'] = $this->googlemaps->create_map();

		$this->load->view('update-hospital', $this->data);
	}

	public function deletehospital($param = 0)
	{
		$this->madmin->deleteHospital($param);

		redirect('admin/hospital');
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */