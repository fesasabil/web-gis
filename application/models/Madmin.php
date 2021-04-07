<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Madmin extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('upload','session'));
	}
	
	public function createHospital()
	{
		$config['upload_path'] = './assets/image/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_width']  = 1024*3;
		$config['max_height']  = 768*3;
		
		$this->upload->initialize($config);

		if ( ! $this->upload->do_upload('photo'))
		{
			$photo = ""; 
			$this->session->set_flashdata('message', $this->upload->display_errors());
		} else{
			$photo = $this->upload->file_name;
		}

		$object = array(
			'name' => $this->input->post('name'),
			'location' => $this->input->post('location'),
			'latitude' => $this->input->post('latitude'),
			'longitude' => $this->input->post('longitude'),
			'address' => $this->input->post('alamat'),
			'photo' => $photo,
			'description' => $this->input->post('description')
		);

		$this->db->insert('hospital', $object);

		$IDHospital = $this->db->insert_id();

		if( is_array($this->input->post('categories')) )
		{
			$this->db->where('hospital_id', $IDHospital)
					 ->where_not_in('category_id', $this->input->post('categories'))
					 ->delete('hospitalcategories');
			foreach ($this->input->post('categories') as $key => $value) 
			{
				$this->db->insert('hospitalcategories', array(
					'hospital_id' => $IDHospital,
					'category_id' => $value
				));
			}
		}

		$this->session->set_flashdata('message', "Data Hospital berhasil ditambahkan");
	}

	public function getHospital($param = 0)
	{
		return $this->db->get_where('hospital', array('id' => $param) )->row();
	}

	public function categoryHospital($hospital = 0, $category = 0)
	{
		return $this->db->get_where('hospitalcategories', array('hospital_id' => $hospital, 'category_id' => $category) )->row();
	}

	public function updateHospital($param = 0)
	{
		$hospital = $this->getHospital($param);

		$config['upload_path'] = './assets/image/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_width']  = 1024*3;
		$config['max_height']  = 768*3;
		
		$this->upload->initialize($config);

		if ( ! $this->upload->do_upload('photo'))
		{
			$photo = $hospital->photo; 
			$this->session->set_flashdata('message', $this->upload->display_errors());
		} else{
			$photo = $this->upload->file_name;
		}

		$object = array(
			'name' => $this->input->post('name'),
			'location' => $this->input->post('location'),
			'latitude' => $this->input->post('latitude'),
			'longitude' => $this->input->post('longitude'),
			'address' => $this->input->post('alamat'),
			'photo' => $photo,
			'description' => $this->input->post('description')
		);

		$this->db->update('hospital', $object, array('id' => $param));

		if( is_array($this->input->post('categories')) )
		{
			$this->db->where('hospital_id', $param)
					 ->where_not_in('category_id', $this->input->post('categories'))
					 ->delete('hospitalcategories');
			foreach ($this->input->post('categories') as $key => $value) 
			{
				$this->db->insert('hospitalcategories', array(
					'hospital_id' => $param,
					'category_id' => $value
				));
			}
		} else {
			$this->db->where('hospital_id', $param)
					 ->where_not_in('category_id', $this->input->post('categories'))
					 ->delete('hospitalcategories');
		}

		$this->session->set_flashdata('message', "Perubahan berhasil disimpan");
	}

	public function getAllHospital($limit = 10, $offset = 0, $type = 'result')
	{
		if( $this->input->get('q') != '')
			$this->db->like('name', $this->input->get('q'));

		$this->db->order_by('id', 'desc');

		if($type == 'num')
		{
			return $this->db->get('hospital')->num_rows();
		} else {
			return $this->db->get('hospital', $limit, $offset)->result();
		}
	}

	public function deleteHospital($param = 0)
	{
		$hospital = $this->getHospital($param);

		if( $hospital->photo != '')
			@unlink(".assets/image/{$hospital->photo}");

		$this->db->delete('hospital', array('id' => $param));
		$this->db->delete('hospitalcategories', array('hospital_id' => $param));

		$this->session->set_flashdata('message', "Data Hospital berhasil dihapus");
	}
}

/* End of file Madmin.php */
/* Location: ./application/models/Madmin.php */