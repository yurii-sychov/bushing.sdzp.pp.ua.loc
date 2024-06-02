<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Test_model extends CI_Model {

	public function get_count_type_test($passport_id, $type_test_id)
	{
		$this->db->where('passport_id', $passport_id);
		$this->db->where('type_test_id', $type_test_id);
		$query = $this->db->from('bushing_tests');
		return $query->count_all_results();
	}

	public function get_tests($passport_id)
	{
		$this->db->select('
			bushing_tests.*,
			DATE_FORMAT(bushing_tests.test_date, "%d-%m-%Y") as test_data,
			bushing_phases.name as phase,
			bushing_types_tests.name as type_test,
			bushing_types_tests.description as type_test_description,
			bushing_filials.name as name_filial,
			bushing_stantions.name as name_stantion,
			bushing_disps.name as name_disp
		');
		$this->db->order_by('test_date', 'asc');
		$this->db->order_by('protokol', 'asc');
		$this->db->from('bushing_tests');
		// $this->db->join('bushing_companies', 'bushing_companies.id = bushing_tests.company_id');
		$this->db->join('bushing_filials', 'bushing_filials.id = bushing_tests.filial_id');
		$this->db->join('bushing_stantions', 'bushing_stantions.id = bushing_tests.stantion_id');
		$this->db->join('bushing_disps', 'bushing_disps.id = bushing_tests.disp_id');
		$this->db->join('bushing_phases', 'bushing_phases.id = bushing_tests.phase_id');
		$this->db->join('bushing_types_tests', 'bushing_types_tests.id = bushing_tests.type_test_id');


		$this->db->order_by('bushing_tests.test_date', 'asc');
		$this->db->where('passport_id', $passport_id);    
		$query = $this->db->get();
		return $query->result();
	}

	public function create($data)
	{
		$query = $this->db->insert('bushing_tests', $data);
		return $query;
	}

	public function update($data, $id)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('bushing_tests', $data);
		return $query;
	}

	public function update_field($value, $field, $id)
	{
		$this->db->set($field, $value);
		$this->db->where('id', $id);
		$query = $this->db->update('bushing_tests');
		return $query;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete('bushing_tests');
		return $query;
	}

	public function get_value($field)
	{
		$this->db->select($field);
		$this->db->distinct();
		// $this->db->where('created_by', $this->session->user->id);
		$this->db->order_by($field);
		$query = $this->db->get('bushing_tests');
		return $query->result();
	}

	public function get_tests_section_c1($passport_id)
	{
		$this->db->select('
			test_date,
			DATE_FORMAT(bushing_tests.test_date, "%d-%m-%Y") as test_date_format,
			tg1,	
			capacity1,
		');
		$this->db->order_by('test_date', 'asc');
		$this->db->where('passport_id', $passport_id);    
		$query = $this->db->get('bushing_tests');
		return $query->result();
	}

	public function get_test($id)
	{
		$this->db->select('
			bushing_tests.*,
			DATE_FORMAT(bushing_tests.test_date, "%d-%m-%Y року") as test_date_format,
			bushing_filials.name as filial,
			bushing_stantions.name as stantion,
			bushing_disps.name as disp,
			bushing_phases.name as phase,
			bushing_types_tests.description as type_test,
		');
		$this->db->join('bushing_filials', 'bushing_filials.id = bushing_tests.filial_id');
		$this->db->join('bushing_stantions', 'bushing_stantions.id = bushing_tests.stantion_id');
		$this->db->join('bushing_disps', 'bushing_disps.id = bushing_tests.disp_id');
		$this->db->join('bushing_phases', 'bushing_phases.id = bushing_tests.phase_id');
		$this->db->join('bushing_types_tests', 'bushing_types_tests.id = bushing_tests.type_test_id');
		$this->db->where('bushing_tests.id', $id);
		$query = $this->db->get('bushing_tests');
		return $query->row();
	}

	public function get_capacity1_zav($passport_id)
	{
		$this->db->select('capacity1');
		$this->db->where('bushing_tests.passport_id', $passport_id);
		$this->db->where('bushing_tests.type_test_id', 1);
		$query = $this->db->get('bushing_tests');
		return $query->row('capacity1');
	}

	public function get_capacity1_pusk($passport_id)
	{
		$this->db->select('capacity1');
		$this->db->where('bushing_tests.passport_id', $passport_id);
		$this->db->where('bushing_tests.type_test_id', 5);
		$query = $this->db->get('bushing_tests');
		return $query->row('capacity1');
	}

	public function get_capacity3_zav($passport_id)
	{
		$this->db->select('capacity3');
		$this->db->where('bushing_tests.passport_id', $passport_id);
		$this->db->where('bushing_tests.type_test_id', 1);
		$query = $this->db->get('bushing_tests');
		return $query->row('capacity3');
	}

	public function get_capacity3_pusk($passport_id)
	{
		$this->db->select('capacity3');
		$this->db->where('bushing_tests.passport_id', $passport_id);
		$this->db->where('bushing_tests.type_test_id', 5);
		$query = $this->db->get('bushing_tests');
		return $query->row('capacity3');
	}

	public function get_count_tests()
	{
		return $this->db->count_all('bushing_tests');
	}

	public function get_count_tests_conducted()
	{
		$this->db->select('tests_conducted');
		$this->db->group_by('tests_conducted');
		$query = $this->db->get('bushing_tests');
		return $query->num_rows();
	}

	public function get_future_protokol()
	{
		return $this->db->count_all('bushing_tests')+1;
	}

	public function get_how_many_tests_conducted()
	{
		$this->db->select('
			tests_conducted,
			COUNT(tests_conducted) as count
		');
		$this->db->order_by('count', 'desc');
		$this->db->order_by('tests_conducted', 'asc');
		$this->db->group_by('tests_conducted');
		$query = $this->db->get('bushing_tests');
		return $query->result();
	}

	public function get_count_tests_current_year_month()
	{
		$this->db->select('
			DATE_FORMAT(bushing_tests.test_date, "%M") as test_date_format,
			COUNT(bushing_tests.test_date) as count

		');
		$this->db->where('bushing_tests.test_date>=', date('Y-01-01'));
		$this->db->order_by('test_date_format', 'asc');
		$this->db->group_by('test_date_format');
		$query = $this->db->get('bushing_tests');
		return $query->result();
	}

	public function get_tests_current_year()
	{
		$this->db->select('
			bushing_tests.id,
			bushing_tests.passport_id,
			DATE_FORMAT(bushing_tests.test_date, "%d-%m-%Y") as test_date_format,
			bushing_tests.protokol,
			bushing_tests.tests_conducted,
			bushing_tests.phase_id,
			bushing_tests.is_update,
			bushing_stantions.name as stantion,
			bushing_disps.name as disp,
			bushing_phases.name as phase,
		');
		$this->db->join('bushing_stantions', 'bushing_stantions.id = bushing_tests.stantion_id');
		$this->db->join('bushing_disps', 'bushing_disps.id = bushing_tests.disp_id');
		$this->db->join('bushing_phases', 'bushing_phases.id = bushing_tests.phase_id');
		$this->db->where('bushing_tests.test_date>=', date('Y-01-01'));
		$this->db->order_by('bushing_tests.test_date', 'desc');
		$this->db->order_by('bushing_tests.protokol', 'desc');
		$query = $this->db->get('bushing_tests');
		return $query->result();
	}
}	