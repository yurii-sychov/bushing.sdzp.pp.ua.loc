<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if ( ! $this->session->user) {
			redirect('/authentication/signin');
		}
	}

	public function index()
	{
		$this->load->model('user_model');

		$data['title'] = 'Користувачі';
		$data['content'] = 'aui/users/index';
		$data['page'] = 'users';
		$data['page_js'] = 'users';
		$data['menu'] = 'users';
		$data['title_heading'] = 'Користувачі';
		$data['title_subheading'] = 'На сторінці надані дані по користувачам';
		$data['button_create'] = TRUE;
		$data['button_create_href'] = '/users/create_user';
		$data['user_rights'] = $this->rights->get_rights($data['page']);
		$data['users'] = $this->user_model->all();

		$this->load->view('aui/index', $data);
	}
}