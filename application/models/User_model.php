<?php

/**
* Developer: Yurii Sychov
* Site: http://sychov.pp.ua
* Email: yurii@sychov.pp.ua
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function all()
	{
		return $this->db->get('bushing_users')->result();
	}

	public function one($id)
	{

		return $this->db->where('id', $id)->get('bushing_users')->row();
	}
}