<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Performance_report extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("Umb_model");
		$this->load->model("Karyawans_model");
		$this->load->model("Performance_report_model");
	}
	
	public function output($Return=array()){
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		
		exit(json_encode($Return));
	}
	
	public function index() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('kpi_report').' | '.$this->Umb_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('kpi_report');
		$data['path_url'] = 'performance_report';
		$role_resources_ids = $this->Umb_model->user_role_resource();
		if(in_array('373',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/performance/performance_report", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); 		
		} else {
			redirect('admin/dashboard');
		}
	}

	public function download_kpi () {

		$quarter = $this->input->post('kpi_quarter_name');
		$year = $this->input->post('kpi_year');

		if ($quarter == 'All') {
			$this->download_all_kpi($year);
			die();
		}

		$all_karyawans = $this->Umb_model->all_active_karyawans();    	
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Legend');
		$sheet->setCellValue('A1', 'Status Legend:');
		$sheet->setCellValue('A2', '1 - Ongoing');
		$sheet->setCellValue('A3', '2 - Improvement');
		$sheet->setCellValue('A4', '3 - Achieved');
		$sheet->setCellValue('A5', '4 - Excellent');

		$highestRow = $sheet->getHighestRow();
		
		foreach ($all_karyawans as $key => $value) {

			$worksheet = $spreadsheet->createSheet();
			$worksheet->setTitle("$value->first_name $value->last_name");
			$worksheet->setCellValue('A1', 'VARIABLE');
			$worksheet->setCellValue('A2', 'KPI');
			$worksheet->setCellValue('B2', 'TARGETED DATE');
			$worksheet->setCellValue('C2', 'RESULT');
			$worksheet->setCellValue('D2', 'STATUS');
			$worksheet->setCellValue('E2', 'FEEDBACK');
			$worksheet->setCellValue('F2', 'LAST UPDATED');

			$variable = $this->Performance_report_model->get_variable_statistic($value->user_id, $quarter, $year);

			foreach ($variable->result() as $k => $v) {
				$worksheet->setCellValueByColumnAndRow(1, $k+3, $v->variable_kpi);
				$worksheet->setCellValueByColumnAndRow(2, $k+3, $v->targeted_date);
				$worksheet->setCellValueByColumnAndRow(3, $k+3, $v->result);
				$worksheet->setCellValueByColumnAndRow(4, $k+3, $v->status);
				$worksheet->setCellValueByColumnAndRow(5, $k+3, $v->feedback);
				$worksheet->setCellValueByColumnAndRow(6, $k+3, $this->Umb_model->set_date_time_format($v->updated_at));
			}

			$hr1 = $highestRow + 4;
			$hr2 = $highestRow + 5;
			$hr3 = $highestRow + 3;
			$worksheet->setCellValue("A$hr1", 'INCIDENTAL');
			$worksheet->setCellValue("A$hr2", 'KPI');
			$worksheet->setCellValue("B$hr2", 'TARGETED DATE');
			$worksheet->setCellValue("C$hr2", 'RESULT');
			$worksheet->setCellValue("D$hr2", 'STATUS');
			$worksheet->setCellValue("E$hr2", 'FEEDBACK');
			$worksheet->setCellValue("F$hr2", 'LAST UPDATED');

			$incidental = $this->Performance_report_model->get_incidental_statistic($value->user_id, $quarter, $year);

			foreach ($incidental->result() as $k => $v) {
				$worksheet->setCellValueByColumnAndRow(1, $hr3+$k+3, $v->incidental_kpi);
				$worksheet->setCellValueByColumnAndRow(2, $hr3+$k+3, $v->targeted_date);
				$worksheet->setCellValueByColumnAndRow(3, $hr3+$k+3, $v->result);
				$worksheet->setCellValueByColumnAndRow(4, $hr3+$k+3, $v->status);
				$worksheet->setCellValueByColumnAndRow(5, $hr3+$k+3, $v->feedback);
				$worksheet->setCellValueByColumnAndRow(6, $hr3+$k+3, $this->Umb_model->set_date_time_format($v->updated_at));
			}

		}

		$writer = new Xlsx($spreadsheet);
		$filename = "Performance_report($quarter".'_'."$year)";
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		ob_start();
		$writer->save('php://output');
		ob_end_flush();
	}

	public function download_all_kpi ($year)
	{
		$all_karyawans = $this->Umb_model->all_active_karyawans();    	
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Legend');
		$sheet->setCellValue('A1', 'Status Legend:');
		$sheet->setCellValue('A2', '1 - Ongoing');
		$sheet->setCellValue('A3', '2 - Improvement');
		$sheet->setCellValue('A4', '3 - Achieved');
		$sheet->setCellValue('A5', '4 - Excellent');

		$highestRow = $sheet->getHighestRow();
		
		foreach ($all_karyawans as $key => $value) {

			$worksheet = $spreadsheet->createSheet();
			$worksheet->setTitle("$value->first_name $value->last_name");
			$worksheet->setCellValue('A1', 'VARIABLE');
			$worksheet->setCellValue('A2', 'KPI');
			$worksheet->setCellValue('B2', 'TARGETED DATE');
			$worksheet->setCellValue('C2', 'RESULT');
			$worksheet->setCellValue('D2', 'STATUS');
			$worksheet->setCellValue('E2', 'FEEDBACK');
			$worksheet->setCellValue('F2', 'LAST UPDATED');

			$variable = $this->Performance_report_model->get_all_variable($value->user_id, $year);

			foreach ($variable->result() as $k => $v) {
				$worksheet->setCellValueByColumnAndRow(1, $k+3, $v->variable_kpi);
				$worksheet->setCellValueByColumnAndRow(2, $k+3, $v->targeted_date);
				$worksheet->setCellValueByColumnAndRow(3, $k+3, $v->result);
				$worksheet->setCellValueByColumnAndRow(4, $k+3, $v->status);
				$worksheet->setCellValueByColumnAndRow(5, $k+3, $v->feedback);
				$worksheet->setCellValueByColumnAndRow(6, $k+3, $this->Umb_model->set_date_time_format($v->updated_at));
			}

			$hr1 = $highestRow + 4;
			$hr2 = $highestRow + 5;
			$hr3 = $highestRow + 3;
			$worksheet->setCellValue("A$hr1", 'INCIDENTAL');
			$worksheet->setCellValue("A$hr2", 'KPI');
			$worksheet->setCellValue("B$hr2", 'TARGETED DATE');
			$worksheet->setCellValue("C$hr2", 'RESULT');
			$worksheet->setCellValue("D$hr2", 'STATUS');
			$worksheet->setCellValue("E$hr2", 'FEEDBACK');
			$worksheet->setCellValue("F$hr2", 'LAST UPDATED');

			$incidental = $this->Performance_report_model->get_all_incidental($value->user_id, $year);

			foreach ($incidental->result() as $k => $v) {
				$worksheet->setCellValueByColumnAndRow(1, $hr3+$k+3, $v->incidental_kpi);
				$worksheet->setCellValueByColumnAndRow(2, $hr3+$k+3, $v->targeted_date);
				$worksheet->setCellValueByColumnAndRow(3, $hr3+$k+3, $v->result);
				$worksheet->setCellValueByColumnAndRow(4, $hr3+$k+3, $v->status);
				$worksheet->setCellValueByColumnAndRow(5, $hr3+$k+3, $v->feedback);
				$worksheet->setCellValueByColumnAndRow(6, $hr3+$k+3, $this->Umb_model->set_date_time_format($v->updated_at));
			}

		}

		$writer = new Xlsx($spreadsheet);
		$filename = "Performance_report(All)";
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');
	}
}
