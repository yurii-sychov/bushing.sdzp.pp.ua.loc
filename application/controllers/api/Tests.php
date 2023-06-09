<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Authorization');
	}

	public function index()
	{
		echo "api-tests";
	}

	public function get_tests($passport_id = NULL)
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('bushings/test_model');

		if ( !$passport_id) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
			return;
		}

		$tests = $this->test_model->get_tests($passport_id);

		foreach ($tests as $key => $value) {
			$tests[$key]->index = $key+1;
			$tests[$key]->delta_capacity1_pusk = NULL;
			$tests[$key]->delta_capacity1_expl = NULL;
			if ($value->type_test_id == 1) {
				$capacity1_zav = $value->capacity1;
			}
			elseif ($value->type_test_id == 5 OR $value->type_test_id == 2) {
				$capacity1_pusk = $value->capacity1;
				$tests[$key]->delta_capacity1_pusk = number_format($value->capacity1*100/$capacity1_zav-100, 2, '.', '');
			}
			else {
				$tests[$key]->delta_capacity1_expl = number_format($value->capacity1*100/$capacity1_pusk-100, 2, '.', '');  
			}
		}

		$result = $tests;

		if ($result) {
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}

	public function get_test($id = NULL)
	{
		$this->output->set_content_type('application/json', 'utf-8');

		$this->load->model('bushings/test_model');

		if ( ! $id) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
			return;
		}

		$result = $this->test_model->get_test($id);

		if ($result) {
			$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Данные получены!', 'data' => $result], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Данные отсутсвуют!'], JSON_UNESCAPED_UNICODE));
	}
}