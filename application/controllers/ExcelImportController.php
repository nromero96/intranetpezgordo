<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ExcelImportController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ExcelImportModel');
		$this->load->library('excel');
	}

	function index(){
		
	}
	

	function import(){
		if(isset($_FILES["file"]["name"])){
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++){
					$data_numero = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$data_estado = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$data[] = array(
						'numero'		=>	$data_numero,
						'estado'			=>	$data_estado
					);
				}
			}
            
            $result1 = $this->ExcelImportModel->limpiarlatrabla();
			$result2 = $this->ExcelImportModel->insert($data);
		    echo json_encode($result2);

		}	
	}
}

?>