<?php

/**
* Developer: Yurii Sychov
* Site: http://sychov.pp.ua
* Email: yurii@sychov.pp.ua
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class User_right_model extends CI_Model {

	public function all()
	{
		$this->db->select('
			bushing_users_rights.id,
			bushing_users_rights.right_create,
			bushing_users_rights.right_read,
			bushing_users_rights.right_update,
			bushing_users_rights.right_delete,
			bushing_users_rights.page,
			bushing_users.surname,
			bushing_users.name,
			bushing_users.patronymic
		');
		$this->db->join('bushing_users', 'bushing_users.id = bushing_users_rights.user_id');
		$query = $this->db->get('bushing_users_rights');
		return $query->result();
	}

	public function all_for_user($user_id)
	{
		$this->db->select('
			bushing_users_rights.id,
			bushing_users_rights.right_create,
			bushing_users_rights.right_read,
			bushing_users_rights.right_update,
			bushing_users_rights.right_delete,
			bushing_users_rights.page,
			bushing_users.surname,
			bushing_users.name,
			bushing_users.patronymic
		');
		$this->db->where('user_id', $user_id);
		$this->db->join('bushing_users', 'bushing_users.id = bushing_users_rights.user_id');
		$query = $this->db->get('bushing_users_rights');
		return $query->result();
	}
}