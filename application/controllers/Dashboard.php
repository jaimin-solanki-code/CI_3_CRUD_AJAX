<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
	}

	public function index()
	{ 
		$this->load->view('view_dashboard');
	}

	public function fetchdata_con() {
	$fetch_data = $this->Dashboard_model->fetchdata('*', 'user', array());
		$result = array();
		$button = '';
		$i = 1;
		foreach($fetch_data as $key => $value){
			$button = "<a href='#' class='btn btn-outline-info btn-sm' onclick = edit_data(". $value['id'] .")> EDIT </a>";
			$button .= "  <a href='#' class='btn btn-outline-dark btn-sm' onclick = delete_data(". $value['id'] .")> DELETE </a>";
			
			$result['data'][] = array(
				$i++,
				$value['name'],
				$button,
			);
		}
		echo json_encode($result);
	}

	public function add_data(){
		$post_data = $this->input->post();
		$model = $this->Dashboard_model->add_data_model($post_data);
		echo json_encode($model);
	}

	public function edit_data(){
		$id = $this->input->post();
		$model = $this->Dashboard_model->fetch_edit_data('*', 'user', array('id' => $id));
		echo json_encode($model);
	}

	public function update(){
		$post_data = $this->input->post();
		$model = $this->Dashboard_model->update_data_modal('user', $post_data, array('id' => $post_data['id']));
		echo json_encode($model);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		$model = $this->Dashboard_model->delete_data_modal('user', array('id' => $id));
		echo json_encode($model);
	}
}
?>
