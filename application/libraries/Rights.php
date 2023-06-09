<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Rights {

	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->CI->load->database();
	}
	
	public function get_rights($page)
	{
		$this->CI->db->select('*');
		$this->CI->db->where('user_id', $this->CI->session->user->id);
		$this->CI->db->where('page', $page);
		$this->CI->db->limit(1);
		$query = $this->CI->db->get('bushing_users_rights');
		return $query->row();
		
	}
}