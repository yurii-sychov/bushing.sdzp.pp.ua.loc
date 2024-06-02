<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Passports extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Authorization');
	}

	public function index()
	{
		echo "api-passports";
	}

	public function get_passports($filial_id = NULL, $stantion_id = NULL, $disp_id = NULL)
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('bushings/passport_model');

		if ( ! $filial_id AND ! $stantion_id AND ! $disp_id) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
			return;
		}

		$result = $this->passport_model->get_passports($filial_id, $stantion_id, $disp_id);

		if ($result) {
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}

	public function get_passport($passport_id = NULL)
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('bushings/passport_model');

		if ( ! $passport_id) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
			return;
		}

		$result = $this->passport_model->get_passport($passport_id);

		if ($result) {
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}
}