<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportesController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->Model('OperacionModel');
		$this->load->Model('CiudadModel');
		$this->load->Model('UsuariosModel');
		$this->load->Model('ItemModel');
		$this->load->Model('AlmacenModel');
		$this->load->Model('CampaignModel');

		$this->load->Model('ReportesModel');
	}



	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Operaciones';
			$this->load->view('pages/reportes',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

	public function exportar_operaciones_excel() {
		
		// Obtener las fechas de inicio y fin del filtro
		$fecha_inicio = $this->input->get('fecha_inicio_operacion');
		$fecha_fin = $this->input->get('fecha_fin_operacion');

		// Cargar el modelo y obtener los datos por rango de fechas
		$data = $this->ReportesModel->exportar_operaciones($fecha_inicio, $fecha_fin);
	
		// Crear el objeto de Spreadsheet
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
	
		// Estilo para los encabezados
		$headerStyle = [
			'font' => [
				'bold' => true,
				'color' => ['rgb' => 'FFFFFF'],
				'size' => 12,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['rgb' => '0070C0'],
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
		];
	
		// Agregar los encabezados a las celdas con el estilo de encabezado
		$sheet->setCellValue('A1', 'ID')->getStyle('A1')->applyFromArray($headerStyle);
		$sheet->setCellValue('B1', 'ADMIN')->getStyle('B1')->applyFromArray($headerStyle);
		$sheet->setCellValue('C1', 'CIUDAD')->getStyle('C1')->applyFromArray($headerStyle);
		$sheet->setCellValue('D1', 'TIPO')->getStyle('D1')->applyFromArray($headerStyle);
		$sheet->setCellValue('E1', 'SUPERVISOR')->getStyle('E1')->applyFromArray($headerStyle);
		$sheet->setCellValue('F1', 'ITEM')->getStyle('F1')->applyFromArray($headerStyle);
		$sheet->setCellValue('G1', 'CANTIDAD')->getStyle('G1')->applyFromArray($headerStyle);
		$sheet->setCellValue('H1', 'FECHA')->getStyle('H1')->applyFromArray($headerStyle);
	
		// Agregar los datos a las celdas
		$row = 2;
		foreach ($data as $operacion) {
			$sheet->setCellValue('A' . $row, $operacion->id);
			$sheet->setCellValue('B' . $row, $operacion->administrador);
			$sheet->setCellValue('C' . $row, $operacion->ciudad);
			$sheet->setCellValue('D' . $row, $operacion->tipo);
			$sheet->setCellValue('E' . $row, $operacion->supervisor);
			$sheet->setCellValue('F' . $row, $operacion->item);
			$sheet->setCellValue('G' . $row, $operacion->cantidad);
			$sheet->setCellValue('H' . $row, $operacion->fechahora);
			$row++;
		}
	
		// Crear el archivo Excel y guardarlo en la carpeta /uploads/export-files/
		$writer = new Xlsx($spreadsheet);
		$archivo_exportado = FCPATH . 'uploads/export-files/reporte-operaciones.xlsx'; // Ruta donde guardar el archivo exportado
		$writer->save($archivo_exportado);
	
		// Descargar el archivo Excel al navegador
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="reporte-operaciones.xlsx"');
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}
	



}

