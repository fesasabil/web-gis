<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('googlemaps','session'));
	}

	public function index()
	{
		$this->data['title'] = "SISTEM INFORMASI GIS";
		$config['center'] = '-6.2293867,106.6894315';
		$config['zoom'] = 'auto';
		$config['styles'] = array(
		  	array(
		  		"name"=>"No Businesses", 
		  		"definition"=> array(
		   			array(
		   				"featureType"=>"poi", 
		   				"elementType" => 
		   				"business", 
		   				"stylers"=> array(
		   					array(
		   						"visibility"=>"off"
		   					)
		   				)
		   			)
		  		)
		  	)
		);
		$this->googlemaps->initialize($config);
		foreach($this->searchQuery() as $key => $value) :
		$marker = array();
		$marker['position'] = "{$value->latitude}, {$value->longitude}";

		$marker['animation'] = 'DROP';
		$marker['infowindow_content'] = '<div class="media" style="width:400px;">';
		$marker['infowindow_content'] .= '<div class="media-left">';
		$marker['infowindow_content'] .= '<img src="'.base_url("assets/image/{$value->photo}").'" class="media-object" style="width:150px">';
		$marker['infowindow_content'] .= '</div>';
		$marker['infowindow_content'] .= '<div class="media-body">';
		$marker['infowindow_content'] .= '<h5 class="media-heading">'.$value->name.'</h5>';
		$marker['infowindow_content'] .= '<p>Location : '.$value->location.'</strong></p>';
		$marker['infowindow_content'] .= '<p>'.$value->description.'</p>';
		$marker['infowindow_content'] .= '</div>';
		$marker['infowindow_content'] .= '</div>';
		$marker['icon'] = base_url("assets/icon/lodging-2.png");
		$this->googlemaps->add_marker($marker);
		endforeach;

		$this->googlemaps->initialize($config);

		$this->data['map'] = $this->googlemaps->create_map();

		$this->load->view('main-index', $this->data);
	}

	public function searchQuery()
	{
		$this->db->select('hospital.*, categories.name as category');

		$this->db->join('hospitalCategories', 'hospital.id = hospitalCategories.category_id', 'left');

		$this->db->join('categories', 'hospitalCategories.category_id = categories.category_id', 'left');

		switch ($this->input->get('location')) 
		{
			case 'Jakarta Utara':
				$this->db->where('hospital.location =', 'Jakarta Utara');
				break;
			case 'Jakarta Barat':
				$this->db->where('hospital.location =', 'Jakarta Barat');
				break;
			case 'Jakarta Pusat':
				$this->db->where('hospital.location =', 'Jakarta Pusat');
				break;
			case 'Jakarta Selatan':
				$this->db->where('hospital.location =', 'Jakarta Selatan');
				break;
			case 'Jakarta Timur':
				$this->db->where('hospital.location =', 'Jakarta Timur');
				break;
		}

		if( is_array(@$this->input->post('categories')) )
			$this->db->where_in('hospitalCategories.category_id', $this->input->post('categories'));

		$this->db->group_by('hospital.id');

		if($this->input->get('q') != '')
			$this->db->like('hospital.name', $this->input->get('q'));

		$this->db->where('hospital.latitude !=', NULL)
				 ->where('hospital.longitude !=', NULL);

		return $this->db->get("hospital")->result();
	}
}
