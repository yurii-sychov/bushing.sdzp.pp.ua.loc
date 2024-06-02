<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Disp_model extends CI_Model {

	public function get_data($id = NULL)
	{
		$this->db->select('id, name');
		$this->db->where('show', 1);
		if ($id) {
			$this->db->where('stantion_id', $id);    
		}
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('bushing_disps');
		return $query->result();
	}

	public function get_name($id)
	{
		$this->db->select('id, name');
		$this->db->where('id', $id);    
		$query = $this->db->get('bushing_disps');
		return $query->row('name');
	}

	public function get_data_one($id = NULL)
	{
		$this->db->select('id, name');
		$this->db->where('id', $id);    
		$query = $this->db->get('bushing_disps');
		return $query->result();
	}
}