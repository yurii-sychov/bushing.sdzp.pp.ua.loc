<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Passport_model extends CI_Model {

	public function get_passports($filial_id, $stantion_id, $disp_id)
	{
		$this->db->select('
			bushing_passports.id as id,
			bushing_passports.tip as tip,
            bushing_passports.phase_id as phase_id,
			bushing_phases.name as phase,
			bushing_types_bushings.name as type_bushing,
			DATE_FORMAT(bushing_passports.year_made, "%Y") as year_made,
			bushing_passports.number as number,
			bushing_passports.number_scheme as number_scheme,
			bushing_passports.weight as weight,
			bushing_passports.scan_passport as scan_passport,

		');
		$this->db->from('bushing_passports');
		$this->db->join('bushing_companies', 'bushing_companies.id = bushing_passports.company_id');
		$this->db->join('bushing_filials', 'bushing_filials.id = bushing_passports.filial_id');
		$this->db->join('bushing_stantions', 'bushing_stantions.id = bushing_passports.stantion_id');
		$this->db->join('bushing_disps', 'bushing_disps.id = bushing_passports.disp_id');
		$this->db->join('bushing_phases', 'bushing_phases.id = bushing_passports.phase_id');
		$this->db->join('bushing_types_bushings', 'bushing_types_bushings.id = bushing_passports.type_bushing_id');
		$this->db->where('bushing_passports.filial_id', $filial_id);
		$this->db->where('bushing_passports.stantion_id', $stantion_id);
		$this->db->where('bushing_passports.disp_id', $disp_id);
		$this->db->order_by('phase_id', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_passport($id)
	{
		$this->db->select('
			bushing_passports.*,
			bushing_filials.name as filial,
			bushing_stantions.name as stantion,
			bushing_disps.name as disp,
			bushing_phases.name as phase,
		');
		$this->db->join('bushing_filials', 'bushing_filials.id = bushing_passports.filial_id');
		$this->db->join('bushing_stantions', 'bushing_stantions.id = bushing_passports.stantion_id');
		$this->db->join('bushing_disps', 'bushing_disps.id = bushing_passports.disp_id');
		$this->db->join('bushing_phases', 'bushing_phases.id = bushing_passports.phase_id');
		$this->db->where('bushing_passports.id', $id);
		$query = $this->db->get('bushing_passports');
		return $query->row();
	}

	public function create($data)
	{
		$query = $this->db->insert('bushing_passports', $data);
		return $query;
	}

	public function update($data, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('bushing_passports', $data);
		return $query;
	}

	public function move($data, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('bushing_passports', $data);
		return $query;
	}

	public function get_value($field)
	{
		$this->db->select($field);
		$this->db->distinct();
		// $this->db->where('created_by', $this->session->user->id);
		$this->db->order_by($field);
		$query = $this->db->get('bushing_passports');
		return $query->result();
	}

	public function get_scan_passport($id)
	{
		$this->db->select('scan_passport');
		$this->db->where('bushing_passports.id', $id);
		$query = $this->db->get('bushing_passports');
		return $query->row('scan_passport');
	}

	public function get_count_passports()
	{
		return $this->db->count_all('bushing_passports');
	}

	public function get_count_passports_year()
	{
		$this->db->select('
			DATE_FORMAT(year_made, "%Y") as year_made_format,
			COUNT(year_made) as count
		');
		$this->db->order_by('year_made', 'asc');
		$this->db->group_by('year_made_format');
		$query = $this->db->get('bushing_passports');
		return $query->result();
	}

	public function get_count_passports_tip()
	{
		$this->db->select('
			tip,
			COUNT(tip) as count
		');
		$this->db->order_by('count', 'desc');
		$this->db->group_by('tip');
		$query = $this->db->get('bushing_passports');
		return $query->result();
	}
}