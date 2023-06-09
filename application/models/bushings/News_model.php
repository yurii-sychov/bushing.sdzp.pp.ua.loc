<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {

	public function get_all_news()
	{
		$this->db->select('*, DATE_FORMAT(created_at, "%d-%m-%Y") as created_at_format,');
		$this->db->order_by('created_at', 'desc');
		$query = $this->db->get('bushing_news');
		return $query->result();
	}
}