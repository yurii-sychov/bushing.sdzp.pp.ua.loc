<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Stantion_model extends CI_Model {

	public function all()
	{
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('bushing_stantions');
		return $query->result();
	}
}