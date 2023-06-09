<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ($this->session->user->id != 1) {
			redirect('/authentication/signin');
		}
	}

	public function index()
	{
		show_404();
		return;
		
		$data['title'] = 'Імпорт даних';
		$data['content'] = 'aui/bushings/import';
		$data['page'] = 'import';
		$data['page_js'] = 'bushings_import';
		$data['menu'] = 'import';
		$data['title_heading'] = 'Імпорт даних';
		$data['title_subheading'] = 'Сторінка імпорту даних випробувань вводів';
		$data['button_create'] = FALSE;
		$data['tables'] = [
			'bushing_companies',
			'bushing_filials',
			'bushing_stantions',
			'bushing_disps',
			'bushing_passports',
			'bushing_tests',
			'bushing_phases',
			'bushing_types_bushings',
			'bushing_types_tests', 
		];

		

		$this->load->library('form_validation');

		$this->form_validation->set_rules('table', 'Таблица', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('aui/index', $data);
		}
		else
		{
			if ($this->input->post('table') === 'bushing_companies') {
				$fields = $this->get_set_fields_companies();
			}

			if ($this->input->post('table') === 'bushing_filials') {
				$fields = $this->get_set_fields_filials();
			}

			if ($this->input->post('table') === 'bushing_stantions') {
				$fields = $this->get_set_fields_stantions();
			}

			if ($this->input->post('table') === 'bushing_disps') {
				$fields = $this->get_set_fields_disps();
			}

			if ($this->input->post('table') === 'bushing_passports') {
				$fields = $this->get_set_fields_passports();
			}

			if ($this->input->post('table') === 'bushing_tests') {
				$fields = $this->get_set_fields_tests();
			}

			if ($this->input->post('table') === 'bushing_phases') {
				$fields = $this->get_set_fields_phases();
			}

			if ($this->input->post('table') === 'bushing_types_bushings') {
				$fields = $this->get_set_fields_types_bushings();
			}

			if ($this->input->post('table') === 'bushing_types_tests') {
				$fields = $this->get_set_fields_types_tests();
			}

			$this->load->dbforge();
			$this->dbforge->drop_table($this->input->post('table'));
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('company_id');
			$this->dbforge->add_key('filial_id');
			$this->dbforge->add_key('stantion_id');
			$this->dbforge->add_key('disp_id');
			$this->dbforge->add_key('phase_id');
			$this->dbforge->add_key('type_test_id');
			$this->dbforge->add_key('type_bushing_id');
			$this->dbforge->create_table($this->input->post('table'));

			if (file_exists($_FILES['file']['tmp_name'])) {
				$xml = simplexml_load_file($_FILES['file']['tmp_name']);

				foreach($xml as $k => $v) {

					if ($this->input->post('table') === 'bushing_companies') {
						$data = $this->get_set_data_companies($v);
						$this->db->insert('bushing_companies', $data);
					}

					if ($this->input->post('table') === 'bushing_filials') {
						$data = $this->get_set_data_filials($v);
						$this->db->insert('bushing_filials', $data);
					}

					if ($this->input->post('table') === 'bushing_stantions') {
						$data = $this->get_set_data_stantions($v);
						$this->db->insert('bushing_stantions', $data);
					}

					if ($this->input->post('table') === 'bushing_disps') {
						$data = $this->get_set_data_disps($v);
						$this->db->insert('bushing_disps', $data);
					}

					if ($this->input->post('table') === 'bushing_passports') {
						$data = $this->get_set_data_passports($v);
						$this->db->insert('bushing_passports', $data);
					}

					if ($this->input->post('table') === 'bushing_tests') {
						$data = $this->get_set_data_tests($v);
						$this->db->insert('bushing_tests', $data);
					}

					if ($this->input->post('table') === 'bushing_phases') {
						$data = $this->get_set_data_phases($v);
						$this->db->insert('bushing_phases', $data);
					}

					if ($this->input->post('table') === 'bushing_types_bushings') {
						$data = $this->get_set_data_types_bushings($v);
						$this->db->insert('bushing_types_bushings', $data);
					}

					if ($this->input->post('table') === 'bushing_types_tests') {
						$data = $this->get_set_data_types_tests($v);
						$this->db->insert('bushing_types_tests', $data);
					}
				}
				redirect('/import/index');        
			}
			else {
				exit('Что то пошло не так.');
			}
		}
	}

	private function get_set_fields_companies()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE,
			),
			'name' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'created_by' => array(
				'type' => 'INT',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
			'updated_by' => array(
				'type' => 'INT',
			),
		);
		return $fields;
	}

	private function get_set_data_companies($v)
	{
		$data['id'] = trim($v->ID_COMPANY);
		$data['name'] = trim($v->NAME_COMPANY);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = 1;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = 1;
		return $data;
	}

	private function get_set_fields_filials()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE,
			),
			'name' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'company_id' => array(
				'type' => 'INT',
				'INDEX' => TRUE
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'created_by' => array(
				'type' => 'INT',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
			'updated_by' => array(
				'type' => 'INT',
			),
		);
		return $fields;
	}

	private function get_set_data_filials($v)
	{
		$data['id'] = trim($v->ID_FILIAL);
		$data['name'] = trim($v->NAME_FILIAL);
		$data['company_id'] = trim($v->ID_COMPANY);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = 1;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = 1;
		return $data;
	}

	private function get_set_fields_stantions()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE,
			),
			'name' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'company_id' => array(
				'type' => 'INT',
				'INDEX' => TRUE
			),
			'filial_id' => array(
				'type' => 'INT',
				'INDEX' => TRUE
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'created_by' => array(
				'type' => 'INT',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
			'updated_by' => array(
				'type' => 'INT',
			),
		);
		return $fields;
	}

	private function get_set_data_stantions($v)
	{
		$data['id'] = trim($v->ID_STANTION);
		$data['name'] = trim($v->NAME_STANTION);
		$data['company_id'] = trim($v->ID_COMPANY);
		$data['filial_id'] = trim($v->ID_FILIAL);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = 1;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = 1;
		return $data;
	}

	private function get_set_fields_disps()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE,
			),
			'name' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'show' => array(
				'type' => 'INT',
			),
			'company_id' => array(
				'type' => 'INT',
				'INDEX' => TRUE
			),
			'filial_id' => array(
				'type' => 'INT',
				'INDEX' => TRUE
			),
			'stantion_id' => array(
				'type' => 'INT',
				'INDEX' => TRUE
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'created_by' => array(
				'type' => 'INT',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
			'updated_by' => array(
				'type' => 'INT',
			),
		);
		return $fields;
	}

	private function get_set_data_disps($v)
	{
		$data['id'] = trim($v->ID_DISP);
		$data['name'] = trim($v->NAME_DISP);
		$data['show'] = $v->NAME_OBORUD == 'vvod      ' ? 1 : 0;
		$data['company_id'] = trim($v->ID_COMPANY);
		$data['filial_id'] = trim($v->ID_FILIAL);
		$data['stantion_id'] = trim($v->ID_STANTION);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = 1;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = 1;
		return $data;
	}

	private function get_set_fields_passports()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE,
			),
			'tip' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'year_made' => array(
				'type' => 'DATE',
			),
			'number_scheme' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'number' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'company_id' => array(
				'type' => 'INT',
			),
			'filial_id' => array(
				'type' => 'INT',
			),
			'stantion_id' => array(
				'type' => 'INT',
			),
			'disp_id' => array(
				'type' => 'INT',
			),
			'phase_id' => array(
				'type' => 'INT',
			),
			'type_bushing_id' => array(
				'type' => 'INT',
			),
			'weight' => array(
				'type' => 'INT',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'created_by' => array(
				'type' => 'INT',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
			'updated_by' => array(
				'type' => 'INT',
			),
		);
		return $fields;
	}

	private function get_set_data_passports($v)
	{
		$data['id'] = trim($v->ID_PASPORT);
		$data['tip'] = trim($v->TIP);
		$data['year_made'] = trim($v->YEAR_MADE);
		$data['number_scheme'] = trim($v->NUMBER_SHEME);
		$data['number'] = trim($v->ZAV_NOMER);
		$data['company_id'] = trim($v->ID_COMPANY);
		$data['filial_id'] = trim($v->ID_FILIAL);
		$data['stantion_id'] = trim($v->ID_STANTION);
		$data['disp_id'] = trim($v->ID_DISP);
		$data['phase_id'] = trim($v->ID_FAZA);
		$data['type_bushing_id'] = trim($v->ID_VID_VVODA);
		$data['weight'] = trim($v->WEIGHT);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = 1;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = 1;
		return $data;
	}

	private function get_set_fields_tests()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE,
			),
			'passport_id' => array(
				'type' => 'INT',
			),
			'type_test_id' => array(
				'type' => 'INT',
			),
			'company_id' => array(
				'type' => 'INT',
				'index' => TRUE,
			),
			'filial_id' => array(
				'type' => 'INT',
			),
			'stantion_id' => array(
				'type' => 'INT',
			),
			'disp_id' => array(
				'type' => 'INT',
			),
			'phase_id' => array(
				'type' => 'INT',
			),
			'test_date' => array(
				'type' => 'DATE',
			),
			'protokol' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'tg1' => array(
				'type' => 'FLOAT',
				'constraint' => '7,4',
				'null' => TRUE,
			),
			'tg3' => array(
				'type' => 'FLOAT',
				'constraint' => '7,4',
				'null' => TRUE,
			),
			'capacity1' => array(
				'type' => 'FLOAT',
				'constraint' => '8,3',
				'null' => TRUE,
			),
			'capacity3' => array(
				'type' => 'FLOAT',
				'constraint' => '8,3',
				'null' => TRUE,
			),
			'r1' => array(
				'type' => 'INT',
				'null' => TRUE,
			),
			'r3' => array(
				'type' => 'INT',
				'null' => TRUE,
			),
			'more' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'device' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'tests_conducted' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'conclusion' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'weather' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			't_okr' => array(
				'type' => 'INT',
				'null' => TRUE,
			),
			't_bushing' => array(
				'type' => 'INT',
				'null' => TRUE,
			),
			't_vsm1' => array(
				'type' => 'INT',
				'null' => TRUE,
			),
			't_vsm2' => array(
				'type' => 'INT',
				'null' => TRUE,
			),
			'edit' => array(
				'type' => 'INT',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'created_by' => array(
				'type' => 'INT',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
			'updated_by' => array(
				'type' => 'INT',
			),
		);
		return $fields;
	}

	private function get_set_data_tests($v)
	{
		$data['passport_id'] = trim($v->ID_PASPORT);
		$data['type_test_id'] = trim($v->ID_VID_ISP);
		$data['company_id'] = trim($v->ID_COMPANY);
		$data['filial_id'] = trim($v->ID_FILIAL);
		$data['stantion_id'] = trim($v->ID_STANTION);
		$data['disp_id'] = trim($v->ID_DISP);
		$data['phase_id'] = trim($v->ID_FAZA);

		$data['test_date'] = trim($v->DATA_ISP);
		$data['protokol'] = trim($v->PROTOKOL);
		$data['tg1'] = $v->TG1 ? trim($v->TG1) : NULL;
		$data['tg3'] = $v->TG3 ? trim($v->TG3) : NULL;
		$data['capacity1'] = $v->C1 ? trim($v->C1) : NULL;
		$data['capacity3'] = $v->C3 ? trim($v->C3) : NULL;
		$data['r1'] = $v->R1 ? trim($v->R1) : NULL;
		$data['r3'] = $v->R3 ? trim($v->R3) : NULL;
		$data['more'] = trim($v->MORE);
		$data['device'] = trim($v->PRIBOR);
		$data['tests_conducted'] = trim($v->ISP_PROVEL);
		$data['conclusion'] = trim($v->VIVOD);
		$data['weather'] = trim($v->WEATHER);
		$data['t_okr'] = $v->T_OKR ? trim($v->T_OKR) : NULL;
		$data['t_bushing'] = $v->T_VVOD ? trim($v->T_VVOD) : NULL;
		$data['t_vsm1'] = $v->T_VSM1 ? trim($v->T_VSM1) : NULL;
		$data['t_vsm2'] = $v->T_VSM2 ? trim($v->T_VSM2) : NULL;
		$data['is_update'] = 0;

		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = 1;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = 1;
		return $data;
	}   

	private function get_set_fields_phases()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE,
			),
			'name' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'created_by' => array(
				'type' => 'INT',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
			'updated_by' => array(
				'type' => 'INT',
			),
		);
		return $fields;
	}

	private function get_set_data_phases($v)
	{
		$data['id'] = trim($v->ID_FAZA);
		$data['name'] = trim($v->NAME_FAZA);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = 1;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = 1;
		return $data;
	}

	private function get_set_fields_types_tests()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE,
			),
			'name' => array(
				'constraint' => '2',
				'type' => 'CHAR',
			),
			'description' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'more_description' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'sort' => array(
				'type' => 'INT',
				'INDEX' => TRUE
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'created_by' => array(
				'type' => 'INT',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
			'updated_by' => array(
				'type' => 'INT',
			),
		);
		return $fields;
	}

	private function get_set_data_types_tests($v)
	{
		$data['id'] = trim($v->ID_VID_ISP);
		$data['name'] = trim($v->VID_ISP);
		$data['description'] = trim($v->DESCRIPTION);
		$data['more_description'] = trim($v->MORE_DESCRIPTION);
		$data['sort'] = trim($v->SORT);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = 1;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = 1;
		return $data;
	}

	private function get_set_fields_types_bushings()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'auto_increment' => TRUE,
			),
			'name' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'short_name' => array(
				'constraint' => '255',
				'type' => 'VARCHAR',
			),
			'created_at' => array(
				'type' => 'DATETIME',
			),
			'created_by' => array(
				'type' => 'INT',
			),
			'updated_at' => array(
				'type' => 'DATETIME',
			),
			'updated_by' => array(
				'type' => 'INT',
			),
		);
		return $fields;
	}

	private function get_set_data_types_bushings($v)
	{
		$data['id'] = trim($v->ID_VID_VVODA);
		$data['name'] = trim($v->NAME_VID_VVODA);
		$data['short_name'] = trim($v->SHORT_DESC);
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = 1;
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = 1;
		return $data;
	}

}