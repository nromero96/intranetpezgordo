<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ConsumosController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->Model('ConsumosModel');

		$this->load->Model('UsuariosModel');
		$this->load->Model('CiudadModel');
	}

	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Consumos';
			$this->load->view('pages/consumos',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

    public function showAllConsumos(){
		$result = $this->ConsumosModel->showAllConsumos();
		echo json_encode($result);
	}

	public function view_page_inport()
    {
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Importar Consumos';
			$this->load->view('pages/importar-consumos',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
    }


    public function importar_consumos() {
        $response = array();
    
        if ($_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
            $ruta_temporal = $_FILES['archivo']['tmp_name'];
    
            // Cargar el archivo Excel usando PhpSpreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($ruta_temporal);
            $worksheet = $spreadsheet->getActiveSheet();
    
            // Iterar sobre las filas del archivo Excel
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // Incluye celdas vacías
    
                // Obtener los datos de cada columna en una fila
                $data = [];
                foreach ($cellIterator as $cell) {
                    $value = $cell->getValue();
                    // Verificar si la celda contiene un valor o está vacía
                    // Si está vacía, puedes asignar un valor predeterminado, como NULL o una cadena vacía ''
                    $data[] = ($value !== null) ? $value : ''; 
                }
    
                // Insertar un nuevo consumo
                $this->ConsumosModel->insertConsumoImport(array(
                    'Supervisor' => $data[0],
                    'Categoria' => $data[1],
                    'Campana' => $data[2],
                    'Afiliador' => $data[3],
                    'QR' => $data[4],
                    'F_Referencia' => $data[5], // Aquí está la fecha en formato 'YYYY-MM-DD' directamente desde el archivo Excel.
                ));
            }
    
            // Cuando la importación es exitosa
            $response['status'] = 'success';
            $response['message'] = 'Importación completa.';
        } else {
            // Cuando hay un error al subir el archivo
            $response['status'] = 'error';
            $response['message'] = 'Error al subir el archivo.';
        }
    
        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }


    public function exportar_datos() {
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin = $this->input->post('fecha_fin');
    
        // Cargar el modelo y obtener los datos por rango de fechas
        $data = $this->ConsumosModel->getConsumosPorRangoFechas($fecha_inicio, $fecha_fin);
    
        // Cargar PhpSpreadsheet
    
        // Crear el objeto de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Estilo para los encabezados
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Color del texto (blanco en este caso)
                'size' => 12, // Tamaño de fuente
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Rellenar con color sólido
                'startColor' => ['rgb' => '0070C0'], // Color de fondo (azul en este caso)
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Alinear horizontalmente al centro
            ],
        ];
    
        // Agregar los datos a las celdas con el estilo de encabezado
        $sheet->setCellValue('A1', 'Supervisor')->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->setCellValue('B1', 'Categoria')->getStyle('B1')->applyFromArray($headerStyle);
        $sheet->setCellValue('C1', 'Campana')->getStyle('C1')->applyFromArray($headerStyle);
        $sheet->setCellValue('D1', 'Afiliador')->getStyle('D1')->applyFromArray($headerStyle);
        $sheet->setCellValue('E1', 'QR')->getStyle('E1')->applyFromArray($headerStyle);
        $sheet->setCellValue('F1', 'F_Referencia')->getStyle('F1')->applyFromArray($headerStyle);
            
        $row = 2;
        foreach ($data as $consumo) {
            $sheet->setCellValue('A' . $row, $consumo->Supervisor);
            $sheet->setCellValue('B' . $row, $consumo->Categoria);
            $sheet->setCellValue('C' . $row, $consumo->Campana);
            $sheet->setCellValue('D' . $row, $consumo->Afiliador);
            $sheet->setCellValue('E' . $row, $consumo->QR);
            $sheet->setCellValue('F' . $row, $consumo->F_Referencia);
            $row++;
        }
    
        // Crear el archivo Excel y guardarlo en una ruta específica (puedes ajustar la ruta según tu preferencia)
        $writer = new Xlsx($spreadsheet);
        $archivo_exportado = 'uploads/export-files/exportacion-consumos.xlsx'; // Ruta donde guardar el archivo exportado
        $writer->save($archivo_exportado);
    
        // Descargar el archivo Excel al navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="exportacion-consumos.xlsx"');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
    }


}
