<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();

		if ( ! $this->session->user) {
			redirect('/authentication/signin');
		}

		$this->load->model('bushings/passport_model');
		$this->load->model('bushings/test_model');
		$this->load->model('bushings/type_test_model', 'type_test');
	}

	public function index($passport_id)
	{
		if ( ! is_numeric($passport_id)) {
			show_404();
		}

		$passport = $this->passport_model->get_passport($passport_id);

		if ( ! $passport) {
			show_404();
		}

		$data['title'] = 'Випробування вводів';
		$data['content'] = 'aui/bushings/tests';
		$data['page'] = 'tests';
		$data['page_js'] = 'bushings_tests';
		$data['menu'] = 'tests';
		$data['title_heading'] = 'Випробування вводів';
		$data['title_subheading'] = 'В таблиці надана інформація по високовольтним випробуванням вводів';
		$data['button_create'] = TRUE;
		$data['button_create_href'] = '/tests/create_test/'.$passport_id;
		$data['button_back'] = TRUE;
		$data['button_back_title'] = 'До паспортів';
		$data['button_back_href'] = '/passports/index/'.$passport->filial_id.'/'.$passport->stantion_id.'/'.$passport->disp_id;

		$data['filial'] = $passport->filial;
		$data['stantion'] = $passport->stantion;
		$data['disp'] = $passport->disp;
		$data['phase'] = $passport->phase;
		$data['number'] = $passport->number;

		$tests = $this->test_model->get_tests($passport_id);

		foreach ($tests as $key => $value) {
			$tests[$key]->index = $key+1;
			$tests[$key]->delta_capacity1_pusk = NULL;
			$tests[$key]->delta_capacity1_expl = NULL;
			if ($value->type_test_id == 1) {
				$capacity1_zav = $value->capacity1;
			}
			elseif ($value->type_test_id == 5 OR $value->type_test_id == 2) {
				$capacity1_pusk = $value->capacity1;
				$tests[$key]->delta_capacity1_pusk = number_format($value->capacity1*100/$capacity1_zav-100, 2, '.', '');
			}
			else {
				$tests[$key]->delta_capacity1_expl = number_format($value->capacity1*100/$capacity1_pusk-100, 2, '.', '');  
			}
		}

		$data['tests'] = $tests;

		$this->load->view('aui/index', $data);
	}

	public function create_test($passport_id)
	{
		if ( ! is_numeric($passport_id)) {
			show_404();
		}

		$passport = $this->passport_model->get_passport($passport_id);

		if ( ! $passport) {
			show_404();
		}

		$data['title'] = 'Створення випробування';
		$data['content'] = 'aui/bushings/form_test';
		$data['page'] = 'create_test';
		$data['page_js'] = 'bushings_create_test';
		$data['menu'] = 'tests';
		$data['title_heading'] = 'Створення випробування';
		$data['title_subheading'] = 'Форма для створення випробування';
		$data['button_create'] = FALSE;

		$data['passport'] = $passport;
		$data['types_tests'] = $this->type_test->get_data();
		$data['future_protokol'] = $this->test_model->get_future_protokol();

		$this->load->library('form_validation');

		$this->set_rules_test();

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('aui/index', $data);
		}
		else
		{
			$set_data = $this->set_data_test('create_test');
			$result = $this->test_model->create($set_data);

			if ($result) {
				$this->session->set_flashdata(['status' => 'success', 'message' => 'Дані успішно додані!']);
			}
			else {
				$this->session->set_flashdata(['status' => 'error', 'message' => 'Сталася помилка при додаванні даних!']);		
			}
			redirect('/tests/index/'.$this->input->post('passport_id'));
		}
	}

	public function update_test($id)
	{
		if ( ! is_numeric($id)) {
			show_404();
		}

		$data['title'] = 'Редагування випробування';
		$data['content'] = 'aui/bushings/form_test';
		$data['page'] = 'update_test';
		$data['page_js'] = 'bushings_update_test';
		$data['menu'] = 'tests';
		$data['title_heading'] = 'Створення випробування';
		$data['title_subheading'] = 'Форма для створення випробування';
		$data['button_create'] = FALSE;

		$test = $this->test_model->get_test($id);

		if ( ! $test) {
			show_404();
		}

		if ($test->created_by != $this->session->user->id OR $test->is_update == 0) {
			redirect('/tests/index/'.$test->passport_id);
		}

		$data['passport'] = $this->passport_model->get_passport($test->passport_id);
		$data['types_tests'] = $this->type_test->get_data();
		$data['test'] = $test;

		$this->load->library('form_validation');

		$this->set_rules_test();

		if ($this->form_validation->run() == FALSE)
		{
			if ($test->created_by == $this->session->user->id) {
				$this->load->view('aui/index', $data);
			}
			else {
				redirect('/tests/index/'.$test->passport_id);
			}
			
		}
		else
		{
			$set_data = $this->set_data_test('update_test');

			$result = $this->test_model->update($set_data, $id);

			if ($result) {
				$this->session->set_flashdata(['status' => 'success', 'message' => 'Дані успішно змінені!']);
			}
			else {
				$this->session->set_flashdata(['status' => 'error', 'message' => 'Сталася помилка при зміні даних!']);		
			}
			redirect('/tests/index/'.$this->input->post('passport_id'));
		}
	}

	public function delete_test($id)
	{
		if ( ! is_numeric($id)) {
			show_404();
		}

		$test = $this->test_model->get_test($id);

		if ( ! $test) {
			show_404();
		}

		$factory_test = $this->test_model->get_count_type_test($test->passport_id, 1);
		$reception_test = $this->test_model->get_count_type_test($test->passport_id, 2);
		$preventive_test = $this->test_model->get_count_type_test($test->passport_id, 3);
		$overhaul_test = $this->test_model->get_count_type_test($test->passport_id, 4);
		$launchers_test = $this->test_model->get_count_type_test($test->passport_id, 5);

		if ($test->type_test_id == 1) {
			echo "Заводские"; echo "<br/>";
			if ($reception_test OR $preventive_test OR $overhaul_test OR $launchers_test) {
				$this->session->set_flashdata(['status' => 'error', 'message' => 'Неможливо видалити ці дані!']);
				redirect('/tests/index/'.$test->passport_id);
			}
		}
		elseif ($test->type_test_id == 2) {
			echo "Приёмо-сдаточные";
			if ($preventive_test OR $overhaul_test OR $launchers_test) {
				$this->session->set_flashdata(['status' => 'error', 'message' => 'Неможливо видалити ці дані!']);
				redirect('/tests/index/'.$test->passport_id);
			}
		}
		elseif ($test->type_test_id == 3) {
			// "Профилактические";
		}
		elseif ($test->type_test_id == 4) {
			// "После капитального ремонта";
		}
		elseif ($test->type_test_id == 5) {
			echo "Пусковые";
			if ($preventive_test OR $overhaul_test) {
				$this->session->set_flashdata(['status' => 'error', 'message' => 'Неможливо видалити ці дані!']);
				redirect('/tests/index/'.$test->passport_id);
			}
		}

		if ($test->created_by != $this->session->user->id) {
			redirect('/authentication/signin');
		}

		if ( ! $test->is_update) {
			redirect('/authentication/signin');
		}

		$result = $this->test_model->delete($id);

		if ($result) {
			$this->session->set_flashdata(['status' => 'success', 'message' => 'Дані успішно видалені!']);
		}
		else {
			$this->session->set_flashdata(['status' => 'error', 'message' => 'Сталася помилка при видалені!']);		
		}

		redirect('/tests/index/'.$test->passport_id);
	}

	public function not_update_test($id)
	{
		if ( ! is_numeric($id)) {
			show_404();
		}

		$test = $this->test_model->get_test($id);

		if ( ! $test) {
			show_404();
		}

		$result = $this->test_model->update_field(0, 'is_update', $id);

		if ($result) {
			$this->session->set_flashdata(['status' => 'success', 'message' => 'Дані успішно оновлені!']);
		}
		else {
			$this->session->set_flashdata(['status' => 'error', 'message' => 'Сталася помилка при оновленні!']);		
		}

		redirect('/tests/index/'.$test->passport_id);
	}

	public function get_value($value = NULL)
	{
		if ( ! $value) {
			show_404();
		}
		$data['values'] = $this->test_model->get_value($value);
		$data['field'] = $value;
		$this->load->view('/aui/bushings/value', $data);
	}

	public function protokol_test($id)
	{
		if ( ! is_numeric($id)) {
			show_404();
		}

		$test = $this->test_model->get_test($id);

		if ( ! $test) {
			show_404();
		}

		$passport = $this->passport_model->get_passport($test->passport_id);
		
		if ($test->type_test_id == 1) {
			show_404();
		}

		if ($test->type_test_id == 2 OR $test->type_test_id == 5) {
			$capacity1_zav = $this->test_model->get_capacity1_zav($passport->id);
			$capacity3_zav = $this->test_model->get_capacity3_zav($passport->id);
		}
		else {
			$capacity1_pusk = $this->test_model->get_capacity1_pusk($passport->id);
			$capacity3_pusk = $this->test_model->get_capacity3_pusk($passport->id);
		}

		$this->load->model('bushings/certificate_model');
		$certificate = $this->certificate_model->get_certificate_for_protokol($test->test_date);
		if ( ! $certificate) {
			$certificate['date_from_format'] = '29.05.2020';
			$certificate['number'] = 'ПТ-163/20';
			$certificate['name'] = 'Сертифікат';
			$certificate = (object)$certificate;
		}
		
		require('./assets/lib/fpdf/fpdf.php');

		$pdf = new FPDF('P','mm','A3');
		$pdf->AddFont('TNRB', '','times-new-roman-gras.php');
		$pdf->AddFont('TNR', '','times-new-roman.php');
		$pdf->AddFont('TNRBI', '','times-new-roman-gras-italique.php');
		$pdf->AddFont('TNRI', '','times-new-roman-italique.php');
		$pdf->SetLeftMargin('20');
		$pdf->AddPage();


		// Шапка
		$pdf->SetFont('TNRB', '', 14);
		$pdf->SetTextColor(0, 0, 255);
		$pdf->Cell(100, 10, iconv('utf-8', 'windows-1251//IGNORE', 'ПрАТ "Кіровоградобленерго"'), 0, 1, 'L');

		$pdf->Cell($pdf->GetStringWidth(iconv('utf-8', 'windows-1251//IGNORE', 'ЕТЛ ')), 10, iconv('utf-8', 'windows-1251//IGNORE', 'ЕТЛ '), 0, 0, 'L');
		$pdf->SetFont('TNR', 'U', 14);
		$pdf->Write(10, iconv('utf-8', 'windows-1251//IGNORE', 'СДЗП'));
		$pdf->ln(10);

		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell($pdf->GetStringWidth(iconv('utf-8', 'windows-1251//IGNORE', $certificate->name.' № ')), 10, iconv('utf-8', 'windows-1251//IGNORE', $certificate->name.' № '), 0, 0, 'L');
		$pdf->SetFont('TNR', 'U', 14);
		$pdf->Write(10, iconv('utf-8', 'windows-1251//IGNORE', $certificate->number));
		$pdf->ln(10);

		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell($pdf->GetStringWidth(iconv('utf-8', 'windows-1251//IGNORE', 'від ')), 10, iconv('utf-8', 'windows-1251//IGNORE', 'від '), 0, 0, 'L');
		$pdf->SetFont('TNR', 'U', 14);
		$pdf->Write(10, iconv('utf-8', 'windows-1251//IGNORE', $certificate->date_from_format));
		$pdf->ln(10);

		$pdf->Image('./assets/images/logo_protokol.png', 257, 10, 30);
		$pdf->ln(10);
		// End Шапка

		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('TNRB', '', 26);
		$pdf->Cell(0, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Протокол № '.$test->protokol), 0, 1, 'C');
		$pdf->SetFont('TNRB', '', 20);
		$pdf->Cell(0, 15, iconv('utf-8', 'windows-1251//IGNORE', 'Місце розташування вводу під час генерування протоколу'), 0, 1, 'C');

		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(86, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Підрозділ'), 1, 0, 'C');
		$pdf->Cell(86, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Підстанція'), 1, 0, 'C');
		$pdf->Cell(65, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Дисп. найменування'), 1, 0, 'C');
		$pdf->Cell(30, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Фаза'), 1, 1, 'C');
		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(86, 10, iconv('utf-8', 'windows-1251//IGNORE', $passport->filial), 1, 0, 'C');
		$pdf->Cell(86, 10, iconv('utf-8', 'windows-1251//IGNORE', $passport->stantion), 1, 0, 'C');
		$pdf->Cell(65, 10, iconv('utf-8', 'windows-1251//IGNORE', $passport->disp), 1, 0, 'C');
		$pdf->Cell(30, 10, iconv('utf-8', 'windows-1251//IGNORE', $passport->phase), 1, 1, 'C');

		$pdf->SetFont('TNRB', '', 20);
		$pdf->Cell(0, 15, iconv('utf-8', 'windows-1251//IGNORE', 'Місце вимірювань вводу'), 0, 1, 'C');

		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(86, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Підрозділ'), 1, 0, 'C');
		$pdf->Cell(86, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Підстанція'), 1, 0, 'C');
		$pdf->Cell(65, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Дисп. найменування'), 1, 0, 'C');
		$pdf->Cell(30, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Фаза'), 1, 1, 'C');

		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(86, 10, iconv('utf-8', 'windows-1251//IGNORE', $test->filial), 1, 0, 'C');
		$pdf->Cell(86, 10, iconv('utf-8', 'windows-1251//IGNORE', $test->stantion), 1, 0, 'C');
		$pdf->Cell(65, 10, iconv('utf-8', 'windows-1251//IGNORE', $test->disp), 1, 0, 'C');
		$pdf->Cell(30, 10, iconv('utf-8', 'windows-1251//IGNORE', $test->phase), 1, 1, 'C');

		$pdf->SetFont('TNRB', '', 20);
		$pdf->Cell(0, 15, iconv('utf-8', 'windows-1251//IGNORE', 'Результати вимірювань'), 0, 1, 'C');

		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(67, 5, iconv('utf-8', 'windows-1251//IGNORE', 'Дата виконання вимірювань'), 0);
		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(66, 5, iconv('utf-8', 'windows-1251//IGNORE', $test->test_date_format), 'B', 0, 'C');
		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(44, 5, iconv('utf-8', 'windows-1251//IGNORE', 'Тип вимірювань'), 0, 0, 'R');
		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(90, 5, iconv('utf-8', 'windows-1251//IGNORE', $test->type_test), 'B', 0, 'C');

		$pdf->ln(10);

		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(22, 5, iconv('utf-8', 'windows-1251//IGNORE', 'Тпов., °C'), 0);
		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(37, 5, iconv('utf-8', 'windows-1251//IGNORE', ($test->t_okr != '') ? $test->t_okr : '-'), 'B', 0, 'C');
		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(33, 5, iconv('utf-8', 'windows-1251//IGNORE', 'Твшм1., °C'), 0, 0, 'R');
		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(37, 5, iconv('utf-8', 'windows-1251//IGNORE', ($test->t_vsm1 != '') ? $test->t_vsm1 : '-'), 'B', 0, 'C');
		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(33, 5, iconv('utf-8', 'windows-1251//IGNORE', 'Твшм2., °C'), 0, 0, 'R');
		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(37, 5, iconv('utf-8', 'windows-1251//IGNORE', ($test->t_vsm2 != '') ? $test->t_vsm2 : '-'), 'B', 0, 'C');
		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(31, 5, iconv('utf-8', 'windows-1251//IGNORE', 'Твводу., °C'), 0, 0, 'R');
		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(37, 5, iconv('utf-8', 'windows-1251//IGNORE', ($test->t_bushing != '') ? $test->t_bushing : ''), 'B', 0, 'C');

		$pdf->ln(10);

		if ($test->weather != '') {
			$pdf->SetFont('TNRB', '', 14);
			$pdf->Cell($pdf->GetStringWidth(iconv('utf-8', 'windows-1251//IGNORE', 'Погода ')), 5, iconv('utf-8', 'windows-1251//IGNORE', 'Погода '), 0);
			$pdf->SetFont('TNR', 'U', 14);
			$pdf->Write(5, iconv('utf-8', 'windows-1251//IGNORE', $test->weather));
			$pdf->ln(10);
		}

		if ($test->more != '') {
			$pdf->SetFont('TNRB', '', 14);
			$pdf->Cell($pdf->GetStringWidth(iconv('utf-8', 'windows-1251//IGNORE', 'Більше інформації про вимірювання ')), 5, iconv('utf-8', 'windows-1251//IGNORE', 'Більше інформації про вимірювання '), 0);
			$pdf->SetFont('TNR', 'U', 14);
			$pdf->Write(5, iconv('utf-8', 'windows-1251//IGNORE', $test->more));
			$pdf->ln(10);
		}

		$pdf->SetFont('TNRB', '', 20);
		$pdf->Cell(0, 15, iconv('utf-8', 'windows-1251//IGNORE', 'Результати вимірюваннь ділянки С1'), 0, 1, 'C');

		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', 'R1, МОм'), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Tg1, %'), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', 'C1, пФ'), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', ($test->type_test_id == 5 OR $test->type_test_id == 2) ? 'С1зав., пФ' : 'С1пуск., пФ'), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Відмінність C1, %'), 1, 1, 'C');
		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', $test->r1), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', number_format($test->tg1, '3', '.', '')), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', number_format($test->capacity1, '2', '.', '')), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', ($test->type_test_id == 5 OR $test->type_test_id == 2) ? number_format($capacity1_zav, '2', '.', '') : number_format($capacity1_pusk, '2', '.', '')), 1, 0, 'C');

		$delta_capacity1_pusk = isset($capacity1_zav) ? $test->capacity1*100/$capacity1_zav-100 : NULL;
		$delta_capacity1_expl = isset($capacity1_pusk) ? $test->capacity1*100/$capacity1_pusk-100 : NULL;

		if ($delta_capacity1_pusk > 5 OR $delta_capacity1_expl > 5) {
			$pdf->SetTextColor(255, 0, 0);
		}
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', ($test->type_test_id == 5 OR $test->type_test_id == 2) ? number_format($delta_capacity1_pusk, '2', '.', '') : number_format($delta_capacity1_expl, '2', '.', '')), 1, 1, 'C');
		$pdf->SetTextColor(0, 0, 0);

		$pdf->SetFont('TNRB', '', 20);
		$pdf->Cell(0, 15, iconv('utf-8', 'windows-1251//IGNORE', 'Результати вимірюваннь ділянки С3'), 0, 1, 'C');

		$pdf->SetFont('TNRB', '', 14);
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', 'R3, МОм'), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Tg3, %'), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', 'C3, пФ'), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', ($test->type_test_id == 5 OR $test->type_test_id == 2) ? 'С3зав., пФ' : 'С3пуск., пФ'), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', 'Відмінність C3, %'), 1, 1, 'C');
		$pdf->SetFont('TNR', '', 14);
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', $test->r3), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', number_format($test->tg3, '3', '.', '')), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', number_format($test->capacity3, '1', '.', '')), 1, 0, 'C');
		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', ($test->type_test_id == 5 OR $test->type_test_id == 2) ? number_format($capacity3_zav, '1', '.', '') : number_format($capacity3_pusk, '1', '.', '')), 1, 0, 'C');

		$delta_capacity3_pusk = isset($capacity3_zav) ? $test->capacity3*100/$capacity3_zav-100 : NULL;
		$delta_capacity3_expl = isset($capacity3_pusk) ? $test->capacity3*100/$capacity3_pusk-100 : NULL;

		$pdf->Cell(53.4, 10, iconv('utf-8', 'windows-1251//IGNORE', ($test->type_test_id == 5 OR $test->type_test_id == 2) ? number_format($delta_capacity3_pusk, '2', '.', '') : number_format($delta_capacity3_expl, '2', '.', '')), 1, 1, 'C');

		$pdf->ln(10);

		if ($test->device != '') {
			$pdf->SetFont('TNRB', '', 14);
			$pdf->Cell($pdf->GetStringWidth(iconv('utf-8', 'windows-1251//IGNORE', 'Прилади для вимірювання ')), 5, iconv('utf-8', 'windows-1251//IGNORE', 'Прилади для вимірювання '), 0);
			$pdf->SetFont('TNR','U', 14);
			$pdf->Write(5, iconv('utf-8', 'windows-1251//IGNORE', $test->device));
			$pdf->ln(10);
		}

		if ($test->conclusion != '') {
			$pdf->SetFont('TNRB', '', 14);
			$pdf->Cell($pdf->GetStringWidth(iconv('utf-8', 'windows-1251//IGNORE', 'Висновок ')), 5, iconv('utf-8', 'windows-1251//IGNORE', 'Висновок '), 0);
			$pdf->SetFont('TNR', 'U', 14);
			$pdf->Write(5, iconv('utf-8', 'windows-1251//IGNORE', $test->conclusion));
			$pdf->ln(10);
		}

		if ($test->tests_conducted != '') {
			$pdf->ln(30);
			$pdf->SetFont('TNRB', '', 14);
			$pdf->Cell($pdf->GetStringWidth(iconv('utf-8', 'windows-1251//IGNORE', 'Виконавець ____________________ ')), 5, iconv('utf-8', 'windows-1251//IGNORE', 'Виконавець ____________________ '), 0);
			$pdf->Write(5, iconv('utf-8', 'windows-1251//IGNORE', $test->tests_conducted));
		}

		$pdf->Output('I', str_replace('"', '', $test->stantion).'_'.str_replace('"', '', $test->disp).'_'.str_replace('"', '', $test->phase).'_Протокол № '.$test->protokol, TRUE);
	}

	public function tests_section_c1_ajax()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		// Якщо це не Ajax-запрос
		if ($this->input->is_ajax_request() === FALSE) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Це не Ajax-запрос!']));
			return;
		}

		$data = $this->test_model->get_tests_section_c1($this->input->post('passport_id'));

		$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Дані отримано!', 'data' => $data]));
		return;
	}

	public function test_ajax()
	{
		$this->output->set_content_type('application/json', 'utf-8');

		// Якщо це не Ajax-запрос
		if ($this->input->is_ajax_request() === FALSE) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Це не Ajax-запрос!']));
			return;
		}

		if ( ! $this->input->post('test_id')) {
			$this->output->set_output(json_encode(['status' => 'ERROR', 'message' => 'Не дійшов ідентифікатор вимірювання!']));
			return;
		}

		$data = $this->test_model->get_test($this->input->post('test_id'));

		$this->output->set_output(json_encode(['status' => 'SUCCESS', 'message' => 'Дані отримано!', 'data' => $data]));
		return;
	}

	private function set_rules_test()
	{
		$this->form_validation->set_rules('type_test', '<strong>Тип випробування</strong>', 'required|trim');
		$this->form_validation->set_rules('test_date', '<strong>Дата випробувань</strong>', 'required|trim');
		$this->form_validation->set_rules('protokol', '<strong>Протокол</strong>', 'required|trim');
		$this->form_validation->set_rules('weather', '<strong>Погода</strong>', 'trim');

		$this->form_validation->set_rules('t_okr', '<strong>Токр. &deg;C</strong>', 'trim|numeric');
		$this->form_validation->set_rules('t_vsm1', '<strong>ТС1. &deg;C</strong>', 'trim|numeric');
		$this->form_validation->set_rules('t_vsm2', '<strong>ТС2. &deg;C</strong>', 'trim|numeric');
		$this->form_validation->set_rules('t_bushing', '<strong>Твводу. &deg;C</strong>', 'required|trim|numeric');
		$this->form_validation->set_rules('more', '<strong>Додаткова інформація про вимірювання</strong>', 'trim');

		$this->form_validation->set_rules('r1', '<strong>R1, МОм</strong>', 'trim|numeric');
		$this->form_validation->set_rules('r3', '<strong>R3, МОм</strong>', 'trim|numeric');
		$this->form_validation->set_rules('tg1', '<strong>Tg&delta;1, %</strong>', 'required|trim|numeric|max_length[7]');
		$this->form_validation->set_rules('tg3', '<strong>Tg&delta;3, %</strong>', 'trim|numeric|max_length[7]');
		$this->form_validation->set_rules('capacity1', '<strong>C1, пФ</strong>', 'required|trim|numeric');
		$this->form_validation->set_rules('capacity3', '<strong>C3, пФ</strong>', 'trim|numeric');

		$this->form_validation->set_rules('device', '<strong>Прилади для вимірювань</strong>', 'trim');
		$this->form_validation->set_rules('tests_conducted', '<strong>Керівник робіт</strong>', 'trim');

		$this->form_validation->set_rules('conclusion', '<strong>Висновок</strong>', 'required|trim');
	}

	private function set_data_test($page)
	{
		$set_data['company_id'] = 1;
		$set_data['filial_id'] = $this->input->post('filial_id');
		$set_data['stantion_id'] = $this->input->post('stantion_id');
		$set_data['disp_id'] = $this->input->post('disp_id');
		$set_data['phase_id'] = $this->input->post('phase_id');
		$set_data['passport_id'] = $this->input->post('passport_id');
		$set_data['type_test_id'] = $this->input->post('type_test');
		$set_data['test_date'] = $this->input->post('test_date');
		$set_data['protokol'] = $this->input->post('protokol');
		$set_data['weather'] = $this->input->post('weather');
		$set_data['t_okr'] = $this->input->post('t_okr');
		$set_data['t_vsm1'] = $this->input->post('t_vsm1');
		$set_data['t_vsm2'] = $this->input->post('t_vsm2');
		$set_data['t_bushing'] = $this->input->post('t_bushing');
		$set_data['more'] = $this->input->post('more');
		$set_data['r1'] = $this->input->post('r1');
		$set_data['r3'] = $this->input->post('r3');
		$set_data['tg1'] = $this->input->post('tg1');
		$set_data['tg3'] = $this->input->post('tg3');
		$set_data['capacity1'] = $this->input->post('capacity1');
		$set_data['capacity3'] = $this->input->post('capacity3');
		$set_data['device'] = $this->input->post('device');
		$set_data['tests_conducted'] = $this->input->post('tests_conducted');
		$set_data['conclusion'] = $this->input->post('conclusion');
		$set_data['is_update'] = 1;
		if ($page === 'create_test') {
			$set_data['created_at'] = date('Y-m-d H:i:s');
			$set_data['created_by'] = $this->session->user->id;
		}
		else {
			$set_data['updated_at'] = date('Y-m-d H:i:s');
			$set_data['updated_by'] = $this->session->user->id;
		}
		return $set_data;
	}
}