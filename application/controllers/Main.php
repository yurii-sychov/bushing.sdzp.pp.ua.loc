<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if ( ! $this->session->user) {
			redirect('/authentication/signin');
		}
	}

	public function index()
	{
		
		$data = [];
		$data['title'] = 'Головна';
		$data['content'] = 'aui/bushings/main';
		$data['page'] = 'main';
		$data['page_js'] = 'bushings_main';
		$data['menu'] = 'main';
		$data['title_heading'] = 'Статистика по вводам';
		$data['title_subheading'] = 'На сторінці надані дані по високольтним вводам';
		$data['button_create'] = FALSE;
		$data['user_rights'] = $this->rights->get_rights($data['page']);

		$this->load->model('/bushings/passport_model');
		$this->load->model('/bushings/test_model');
		$this->load->model('/bushings/news_model');

		$data['news'] = $this->news_model->get_all_news();

		$data['count_passports'] = $this->passport_model->get_count_passports();
		$data['count_tests'] = $this->test_model->get_count_tests();
		$data['count_tests_conducted'] = $this->test_model->get_count_tests_conducted();

		$data['tests_current_year'] = $this->test_model->get_tests_current_year();

		$data['how_many_tests_conducted'] = $this->test_model->get_how_many_tests_conducted();
		$data['count_tests_current_year_month'] = $this->test_model->get_count_tests_current_year_month();

		$this->load->view('aui/index', $data);
	}

	public function not_update_test($id)
	{
		if ( ! is_numeric($id)) {
			show_404();
		}

		$this->load->model('bushings/test_model');

		$test = $this->test_model->get_test($id);

		if ( ! $test) {
			show_404();
		}

		$result = $this->test_model->update_field(0, 'is_update', $id);

		if ($result) {
			$this->session->set_flashdata(['status' => 'success', 'message' => 'Дані успішно оновлені!']);
		}
		else {
			$this->session->set_flashdata(['status' => 'error', 'message' => 'Сталася помилка при оновленні!']);		
		}

		redirect('');
	}

	public function submit_message_ajax()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		// Якщо це не Ajax-запрос
		if ($this->input->is_ajax_request() === FALSE) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Это не Ajax-запрос!']));
			return;
		}

		$error = [];

		if ( ! $this->input->post('name')) {
			array_push($error, ['message' => 'Будь ласка введіть ім`я.']);
		}

		if ( ! $this->input->post('subject')) {
			array_push($error, ['message' => 'Будь ласка введіть тему.']);
		}

		if ( ! $this->input->post('message')) {
			array_push($error, ['message' => 'Будь ласка введіть повідомлення.']);
		}

		if ($error) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => $error]));
			return;
		}

		$this->submit_message($this->input->post());
		$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Ok!']));
	}

	private function submit_message($data)
	{
		$this->load->library('email');

		$this->email->from('mail@bushing.sdzp.pp.ua', $data['name']);
		$this->email->to('yurii@sychov.pp.ua');

		$this->email->subject($data['subject']);
		$this->email->message($data['message']);

		$this->email->send();
	}
}