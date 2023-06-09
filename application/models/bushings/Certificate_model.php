<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_model extends CI_Model {

	public function get_certificate_for_protokol($date_test)
	{
		$this->db->select('*, DATE_FORMAT(date_from, "%d-%m-%Y р.") as date_from_format');
		$this->db->where('date_from <=', $date_test);
		$this->db->where('date_end >=', $date_test);
		$query = $this->db->get('bushing_certificates');
		return $query->row();
	}

	public function get_certificate($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('bushing_certificates');
		return $query->row();
	}

	public function get_certificates()
	{
		return $this->db->get('bushing_certificates')->result();
	}
}