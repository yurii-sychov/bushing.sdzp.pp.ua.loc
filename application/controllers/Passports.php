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

		if ( ! $this->session->user) {
			redirect('/authentication/signin');
		}
		$this->load->model('bushings/filial_model');
		$this->load->model('bushings/stantion_model');
		$this->load->model('bushings/disp_model');
		$this->load->model('bushings/phase_model');
		$this->load->model('bushings/type_bushing_model');

		$this->load->model('bushings/passport_model');
	}

	public function index($filial_id = NULL, $stantion_id = NULL, $disp_id = NULL)
	{
		if ( ( ! is_numeric($filial_id) && $filial_id) OR ( ! is_numeric($stantion_id) && $stantion_id ) OR ( ! is_numeric($disp_id) && $disp_id) ) {
			show_404();
		}

		$data['title'] = 'Паспорти вводів';
		$data['content'] = 'aui/bushings/passports';
		$data['page'] = 'passports';
		$data['page_js'] = 'bushings_passports';
		$data['menu'] = 'passports';
		$data['title_heading'] = 'Паспорти вводів';
		$data['title_subheading'] = 'В таблиці буде надана інформація по паспортним даним вводів';
		$data['button_create'] = ($filial_id AND $stantion_id AND $disp_id) ? TRUE : FALSE;
		$data['button_create_href'] = '/passports/create_passport';

		$data['filials'] = $this->filial_model->get_data();
		$data['stantions'] = [];
		$data['disps'] = [];

		if ($filial_id) {
			
			$data['stantions'] = $this->stantion_model->get_data($filial_id);

			if ( ! $data['stantions']) {
				show_404();
			}

			$data['filial'] = $this->filial_model->get_name($filial_id);
		}

		if ($stantion_id) {
			$data['disps'] = $this->disp_model->get_data($stantion_id);

			if ( ! $data['disps']) {
				show_404();
			}

			$data['stantion'] = $this->stantion_model->get_name($stantion_id);
		}

		if ($filial_id AND $stantion_id AND $disp_id) {

			$data['passports'] = $this->passport_model->get_passports($filial_id, $stantion_id, $disp_id);

			// if ( ! $data['passports']) {
			// 	show_404();
			// }

			$data['title_subheading'] = 'В таблиці надана інформація по паспортним даним вводів';

			$data['disp'] = $this->disp_model->get_name($disp_id);

			$this->session->set_userdata('current_passport_page', 'passports/index/'.$filial_id.'/'.$stantion_id.'/'.$disp_id);
			// $this->session->set_userdata('filial_id', $filial_id);
			// $this->session->set_userdata('stantion_id', $stantion_id);
			// $this->session->set_userdata('disp_id', $disp_id);	
		}
		else {
			$this->session->unset_userdata('current_passport_page');
		}

		

		$this->load->view('aui/index', $data);
	}

	public function create_passport($filial_id = NULL, $stantion_id = NULL, $disp_id = NULL)
	{
		$data['title'] = 'Створення паспорту';
		$data['content'] = 'aui/bushings/form_passport';
		$data['page'] = 'create_passport';
		$data['page_js'] = 'bushings_create_passport';
		$data['menu'] = 'passports';
		$data['title_heading'] = 'Створення паспорту';
		$data['title_subheading'] = 'Форма для створення паспорту';
		
		$data['filials'] = $this->filial_model->get_data();
		$data['stantions'] = [];
		$data['disps'] = [];
		$data['types_bushing'] = $this->type_bushing_model->get_data();

		if ($filial_id) {
			
			$data['stantions'] = $this->stantion_model->get_data($filial_id);

			if ( ! $data['stantions']) {
				show_404();
			}

			$data['filial'] = $this->filial_model->get_name($filial_id);
		}

		if ($stantion_id) {
			$data['disps'] = $this->disp_model->get_data($stantion_id);

			if ( ! $data['disps']) {
				show_404();
			}

			$data['stantion'] = $this->stantion_model->get_name($stantion_id);
		}

		if ($filial_id AND $stantion_id AND $disp_id) {
			$data['phases'] = $this->phase_model->get_data();
		}
		
		$this->load->library('form_validation');

		$this->set_rules_passport('create_passport');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('aui/index', $data);
		}
		else
		{
			$set_data = $this->set_data_passport('create_passport');

			$result = $this->passport_model->create($set_data);

			if ($result) {
				$this->session->set_flashdata(['status' => 'success', 'message' => 'Дані успішно додані!']);
			}
			else {
				$this->session->set_flashdata(['status' => 'error', 'message' => 'Сталася помилка при додаванні даних!']);		
			}
			redirect('/passports/index/'.$set_data['filial_id'].'/'.$set_data['stantion_id'].'/'.$set_data['disp_id']);
		}
	}

	public function update_passport($id)
	{
		if ( ! is_numeric($id)) {
			show_404();
		}

		if ($this->session->user->id != 1) {
			redirect('/authentication/signin');
		}

		$data['title'] = 'Редагування паспорту';
		$data['content'] = 'aui/bushings/form_passport';
		$data['page'] = 'update_passport';
		$data['page_js'] = 'bushings_update_passport';
		$data['menu'] = 'passports';
		$data['title_heading'] = 'Редагування паспорту';
		$data['title_subheading'] = 'Форма для редагування паспорту';

		$data['passport'] = $this->passport_model->get_passport($id);
		$data['filials'] = $this->filial_model->get_data_one($data['passport']->filial_id);
		$data['stantions'] = $this->stantion_model->get_data_one($data['passport']->stantion_id);
		$data['disps'] = $this->disp_model->get_data_one($data['passport']->disp_id);
		$data['phases'] = $this->phase_model->get_data_one($data['passport']->phase_id);
		$data['types_bushing'] = $this->type_bushing_model->get_data();

		if ( ! $data['passport']) {
			show_404();
		}
		$this->load->library('form_validation');

		$this->set_rules_passport('update_passport');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('aui/index', $data);
		}
		else
		{
			$set_data = $this->set_data_passport('update_passport');
			
			$result = $this->passport_model->update($set_data, $id);

			if ($result) {
				$this->session->set_flashdata(['status' => 'success', 'message' => 'Дані успішно змінені!']);
			}
			else {
				$this->session->set_flashdata(['status' => 'error', 'message' => 'Сталася помилка при зміні даних!']);		
			}
			redirect('/passports/index/'.$data['passport']->filial_id.'/'.$data['passport']->stantion_id.'/'.$data['passport']->disp_id);
		}
	}

	public function delete_passport($id)
	{
		if ( ! is_numeric($id)) {
			show_404();
		}

		if ($this->session->user->id != 1) {
			redirect('/authentication/signin');
		}

		echo "delete_passport";
	}

	public function move_passport($id, $filial_id = NULL, $stantion_id = NULL, $disp_id = NULL)
	{
		
		if ( ! is_numeric($id)) {
			show_404();
		}

		if ($this->session->user->id != 1) {
			redirect('/authentication/signin');
		}

		$data['title'] = 'Переміщення паспорту';
		$data['content'] = 'aui/bushings/form_passport';
		$data['page'] = 'move_passport';
		$data['page_js'] = 'bushings_move_passport';
		$data['menu'] = 'passports';
		$data['title_heading'] = 'Переміщення паспорту';
		$data['title_subheading'] = 'Форма для переміщення паспорту';

		$data['passport'] = $this->passport_model->get_passport($id);
		$data['filials'] = $this->filial_model->get_data();
		$data['stantions'] = [];
		$data['disps'] = [];
		$data['types_bushing'] = $this->type_bushing_model->get_data();

		if ($filial_id) {
			
			$data['stantions'] = $this->stantion_model->get_data($filial_id);

			if ( ! $data['stantions']) {
				show_404();
			}

			$data['filial'] = $this->filial_model->get_name($filial_id);
		}

		if ($stantion_id) {
			$data['disps'] = $this->disp_model->get_data($stantion_id);

			if ( ! $data['disps']) {
				show_404();
			}

			$data['stantion'] = $this->stantion_model->get_name($stantion_id);
		}

		if ($filial_id AND $stantion_id AND $disp_id) {
			$data['phases'] = $this->phase_model->get_data();
		}

		$this->load->library('form_validation');

		$this->set_rules_passport('move_passport');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('aui/index', $data);
		}
		else
		{
			$set_data = $this->set_data_passport('move_passport');

			$result = $this->passport_model->move($set_data, $id);

			if ($result) {
				$this->session->set_flashdata(['status' => 'success', 'message' => 'Дані успішно змінені!']);
			}
			else {
				$this->session->set_flashdata(['status' => 'error', 'message' => 'Сталася помилка при зміні даних!']);		
			}
			redirect('/passports/index/'.$set_data['filial_id'].'/'.$set_data['stantion_id'].'/'.$set_data['disp_id']);
		}
	}

	public function upload_scan_passport()
	{
		echo '<pre style="margin: 80px 0 0 300px">';
		print_r($_FILES);
		print_r($_POST);
		echo '</pre>';

		$config['upload_path']          = './uploads/passports/';
		$config['allowed_types']        = 'pdf';
		$config['overwrite']			= TRUE;
		$config['encrypt_name']			= TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('scan_passport')) {
			$error = array('error' => $this->upload->display_errors('', ''));

			$this->session->set_flashdata(['status' => 'error', 'message' => $error['error']]);

			redirect('/passports/index/'.$this->input->post('filial_id').'/'.$this->input->post('stantion_id').'/'.$this->input->post('disp_id'));
		}
		else {
			$data = array('upload_data' => $this->upload->data());

			$scan_passport_old = $this->passport_model->get_scan_passport($this->input->post('id'));

			if (file_exists('./uploads/passports/'.$scan_passport_old)) {
				unlink('./uploads/passports/'.$scan_passport_old);
			}

			$result = $this->passport_model->update(['scan_passport' => $data['upload_data']['file_name']], $this->input->post('id'));

			$this->session->set_flashdata(['status' => 'success', 'message' => 'Скан паспорту успішно завантажено!']);

			redirect('/passports/index/'.$this->input->post('filial_id').'/'.$this->input->post('stantion_id').'/'.$this->input->post('disp_id'));
		}
	}

	public function document($id)
	{
		if ( ! is_numeric($id)) {
			show_404();
		}

		echo "document";
	}

	private function set_rules_passport($page)
	{
		if ($page === 'create_passport' || $page === 'move_passport') {
			$this->form_validation->set_rules('filial_id', '<strong>Підрозділ</strong>', 'required');
			$this->form_validation->set_rules('stantion_id', '<strong>Підстанція</strong>', 'required');
			$this->form_validation->set_rules('disp_id', '<strong>Диспетчерське найменування</strong>', 'required');
			$this->form_validation->set_rules('phase_id', '<strong>Фаза (місце)</strong>', 'required');
		}
		if ($page === 'create_passport' || $page === 'update_passport') {
			$this->form_validation->set_rules('tip', '<strong>Тип вводу</strong>', 'required|trim');
			$this->form_validation->set_rules('year_made', '<strong>Рік випуску</strong>', 'required|trim');
			$this->form_validation->set_rules('type_bushing_id', '<strong>Признак вводу</strong>', 'required');
			$this->form_validation->set_rules('number', '<strong>Номер вводу</strong>', 'required|trim');
			$this->form_validation->set_rules('number_scheme', '<strong>№ креслення</strong>', 'required|trim');
		}
	}

	private function set_data_passport($page)
	{
		$filial_id = explode('/', $this->input->post('filial_id'));
		$stantion_id = explode('/', $this->input->post('stantion_id'));
		$disp_id = explode('/', $this->input->post('disp_id'));

		$set_data['company_id'] = 1;
		if ($page === 'create_passport' || $page === 'move_passport') {
			$set_data['filial_id'] = end($filial_id);
			$set_data['stantion_id'] = end($stantion_id);
			$set_data['disp_id'] = end($disp_id);
			$set_data['phase_id'] = $this->input->post('phase_id');
		}
		if ($page === 'create_passport' || $page === 'update_passport') {
			$set_data['tip'] = $this->input->post('tip');
			$set_data['year_made'] = $this->input->post('year_made');
			$set_data['number'] = $this->input->post('number');
			$set_data['number_scheme'] = $this->input->post('number_scheme');
			$set_data['type_bushing_id'] = $this->input->post('type_bushing_id') ? $this->input->post('type_bushing_id') : 1;
			$set_data['weight'] = $this->input->post('weight');
		}
		if ($page === 'create_passport') {
			$set_data['created_at'] = date('Y-m-d H:i:s');
			$set_data['created_by'] = 2;
		}
		else {
			$set_data['updated_at'] = date('Y-m-d H:i:s');
			$set_data['updated_by'] = 2;
		}
		return $set_data;
	}

	public function get_count_passports_year_ajax()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		// Якщо це не Ajax-запрос
		if ($this->input->is_ajax_request() === FALSE) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Це не Ajax-запрос!']));
			return;
		}

		$data = $this->passport_model->get_count_passports_year();

		$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Дані отримано!', 'data' => $data]));
		return;
	}

	public function get_count_passports_tip_ajax()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		// Якщо це не Ajax-запрос
		if ($this->input->is_ajax_request() === FALSE) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Це не Ajax-запрос!']));
			return;
		}

		$data = $this->passport_model->get_count_passports_tip();

		$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Дані отримано!', 'data' => $data]));
		return;
	}

	public function get_count_passports_ajax()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		// Якщо це не Ajax-запрос
		if ($this->input->is_ajax_request() === FALSE) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Це не Ajax-запрос!']));
			return;
		}

		$data = $this->passport_model->get_count_passports();

		$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Дані отримано!', 'data' => $data]));
		return;
	}

	public function get_value($value = NULL)
	{
		if ( ! $value) {
			show_404();
		}
		$data['values'] = $this->passport_model->get_value($value);
		$data['field'] = $value;
		$this->load->view('/aui/bushings/value', $data);
	}
}