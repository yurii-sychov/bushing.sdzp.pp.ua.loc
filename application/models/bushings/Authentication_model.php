<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_user($login, $password)
	{
		$this->db->where('login', $login);
		$this->db->where('password', sha1($password));
		$this->db->where('active', 1);
		$query = $this->db->get('bushing_users');
		return $query->row();
	}

	public function create_user($data)
	{
		$query = $this->db->insert('bushing_users', $data);
		return $query;
	}

	public function is_email($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('bushing_users');
		return $query->row('email');
	}

	public function is_login($login)
	{
		$this->db->where('login', $login);
		$query = $this->db->get('bushing_users');
		return $query->row('login');
	}
}