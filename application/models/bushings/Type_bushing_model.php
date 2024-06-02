<?php

/**
* Developer: Yurii Sychov
* Site: http://sychov.pp.ua
* Email: yurii@sychov.pp.ua
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Type_bushing_model extends CI_Model {

	public function get_data($id = NULL)
	{
		$this->db->select('id, short_name as name');
		if ($id) {
			$this->db->where('id', $id);    
		}
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('bushing_types_bushings');
		return $query->result();
	}
}