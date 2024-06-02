<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistic extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Authorization');
	}

	public function index()
	{
		echo "api-statistic";
	}

	public function get_count_passports()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		// $post = json_decode(file_get_contents('php://input'), true);
		// if ($post['key'] !== 'qwerty0910QWERTY0910') {
		// 	$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'У вас не прав!'], JSON_UNESCAPED_UNICODE));
		// 	return;
		// }

		$this->load->model('/bushings/passport_model');

		$result = $this->passport_model->get_count_passports();

		if ($result) {
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}

	public function get_count_tests()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('/bushings/test_model');

		$result = $this->test_model->get_count_tests();

		if ($result) {
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}

	public function get_count_tests_conducted()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('/bushings/test_model');

		$result = $this->test_model->get_count_tests_conducted();

		if ($result) {
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}

	public function get_count_passports_year()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('bushings/passport_model');

		$result = $this->passport_model->get_count_passports_year();

		if ($result) {
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}

	public function get_count_passports_tip()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('bushings/passport_model');

		$result = $this->passport_model->get_count_passports_tip();

		if ($result) {
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}

	public function get_tests_current_year()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('/bushings/test_model');

		$result = $this->test_model->get_tests_current_year();

		if ($result) {
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}

	public function get_how_many_tests_conducted()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('/bushings/test_model');

		$result = $this->test_model->get_how_many_tests_conducted();

		if ($result) {
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}

	public function get_count_tests_current_year_month()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('/bushings/test_model');

		$result = $this->test_model->get_count_tests_current_year_month();

		if ($result) {
			$this->output->set_status_header(200);
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}


}