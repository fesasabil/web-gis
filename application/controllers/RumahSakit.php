<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RumahSakit extends CI_Controller 
{
	public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->model('M_rumahsakit', 'rumahsakit');
    }

	public function index()
	{
		$this->load->view('rumahsakit');
	}

	public function rumahsakit_json()
	{
		$data =  $this->db->get('rumahsakit')->result();
        // print_r($data);
		// $data = $this->M_rumahsakit->getData();
		echo json_encode($data);
	}

	public function detail($id)
	{
		$data = $this->rumahsakit->get_by_id($id);
		echo json_encode($data);
		// print_r($data);
	}

	public function list()
	{
		$list = $this->rumahsakit->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $rumahsakit) {
			$no++;
			$row = array();
			$row[] = $rumahsakit->rumahsakit_nama;
			$row[] = $rumahsakit->rumahsakit_lat;
			$row[] = $rumahsakit->rumahsakit_long;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Maps" onclick="rumahsakit_map('."'".$rumahsakit->id."'".')"><i class="glyphicon glyphicon-globe"></i> Maps</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rumahsakit->count_all(),
						"recordsFiltered" => $this->rumahsakit->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	/**
	 * admin
	 */
	public function admin()
	{
		$this->load->view('rumahsakitadmin');
	}

	public function ajax_list()
	{
		$list = $this->rumahsakit->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $rumahsakit) {
			$no++;
			$row = array();
			$row[] = $rumahsakit->rumahsakit_nama;
			$row[] = $rumahsakit->rumahsakit_lat;
			$row[] = $rumahsakit->rumahsakit_long;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_rumahsakit('."'".$rumahsakit->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_rumahsakit('."'".$rumahsakit->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->rumahsakit->count_all(),
						"recordsFiltered" => $this->rumahsakit->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->rumahsakit->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'rumahsakit_nama' => $this->input->post('rumahsakit_nama'),
				'rumahsakit_lat' => $this->input->post('rumahsakit_lat'),
				'rumahsakit_long' => $this->input->post('rumahsakit_long'),
			);
		$insert = $this->rumahsakit->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'rumahsakit_nama' => $this->input->post('rumahsakit_nama'),
				'rumahsakit_lat' => $this->input->post('rumahsakit_lat'),
				'rumahsakit_long' => $this->input->post('rumahsakit_long'),
			);
		$this->rumahsakit->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->rumahsakit->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
}
