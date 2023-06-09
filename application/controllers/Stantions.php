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

		if ( ! $this->session->user) {
			redirect('/authentication/signin');
		}

		$this->load->model('stantion_model');
	}

	public function index()
	{

		$data['title'] = 'Підстанції';
		$data['content'] = 'aui/stantions/index';
		$data['page'] = 'stantions';
		$data['page_js'] = 'stantions';
		$data['menu'] = 'stantions';
		$data['title_heading'] = 'Підстанції';
		$data['title_subheading'] = 'В таблиці надана інформація по підстанціям';
		$data['button_create'] = TRUE;
		$data['button_create_href'] = '/stantions/create';
		$data['button_back_href'] = '/stantions';

		$data['stantions'] = $this->stantion_model->all();

		$this->load->view('aui/index', $data);
	}
}
