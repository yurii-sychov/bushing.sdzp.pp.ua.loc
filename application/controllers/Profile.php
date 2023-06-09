<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
		$this->load->model('user_right_model');

		$data['title'] = 'Кабінет користувача';
		$data['content'] = 'aui/profile/index';
		$data['page'] = 'profile';
		$data['page_js'] = 'profile';
		$data['menu'] = 'profile';
		$data['title_heading'] = 'Кабінет користувача';
		$data['title_subheading'] = 'Кабінет користувача';
		$data['user_rights'] = $this->rights->get_rights($data['page']);
		$data['user'] = $this->user_model->one($this->session->user->id);
		$data['rights'] = $this->user_right_model->all_for_user($this->session->user->id);

		$this->load->view('aui/index', $data);
	}
}