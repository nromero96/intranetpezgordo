<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AsistenciaController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->Model('AsistenciaModel');
	}



	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$this->load->view('pages/asistencia');
        }else{
			redirect(base_url(), 'refresh');
        }
	}

    public function showAllRegistro(){
		$result = $this->AsistenciaModel->showAllRegistro();
		echo json_encode($result);

	}

    public function updateAsistencia(){
		$result = $this->AsistenciaModel->updateAsistencia();
		echo json_encode($result);
	}

	public function buscarAsistente(){
		$output = array('error' => false);
        $nombre = $this->input->post("searchname");
		$resp = $this->AsistenciaModel->buscarasistente($nombre);
		if($resp){
			$output = $resp;
		}else{
			$output['error'] = true;
			$output['message'] = 'El nombre que está buscando no se encuetra registrado.';
		}

 		echo json_encode($output); 

	}



	public function addAsistente(){
		$result = $this->AsistenciaModel->addAsistente();
		echo json_encode($result);
	}

    

    // public function getRegistroEdit(){

	// 	$result = $this->RegistroModel->getRegistroEdit();

	// 	echo json_encode($result);

	// }

	

	// public function updateNumero(){

	// 	$result = $this->RegistroModel->updateNumero();

	// 	echo json_encode($result);

	// }

	

}

