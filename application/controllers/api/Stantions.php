<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Stantions extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Authorization');
	}

	public function index()
	{
		echo "api-stantions";
	}

	public function get_stantions($filial_id = NULL)
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('bushings/stantion_model');

		if ( ! $filial_id) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
			return;
		}

		$result = $this->stantion_model->get_data($filial_id);

		if ($result) {
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}
}