<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_rights extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if ( ! $this->session->user) {
			redirect('/authentication/signin');
		}
	}

	public function index()
	{
		$this->load->model('user_right_model');

		$data['title'] = 'Права користувачів';
		$data['content'] = 'aui/users_rights/index';
		$data['page'] = 'users_rights';
		$data['page_js'] = 'users_rights';
		$data['menu'] = 'users_rights';
		$data['title_heading'] = 'Права користувачів';
		$data['title_subheading'] = 'На сторінці надані дані по правам користувачів';
		$data['button_create'] = TRUE;
		$data['button_create_href'] = '/users_rights/create_user_rights';
		$data['user_rights'] = $this->rights->get_rights($data['page']);
		$data['users_rights'] = $this->user_right_model->all();

		$this->load->view('aui/index', $data);
	}
}