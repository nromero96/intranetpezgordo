<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CiudadController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->Model('CiudadModel');
	}



	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Ciudades';
			$this->load->view('pages/ciudades',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

    public function showAllRegistro(){
		$result = $this->CiudadModel->showAllRegistro();
		echo json_encode($result);

	}

    public function updateAsistencia(){
		$result = $this->CiudadModel->updateAsistencia();
		echo json_encode($result);
	}

	public function buscarRegistro(){
		$output = array('error' => false);
        $querydata = $this->input->post("querydata");
		$resp = $this->CiudadModel->buscarRegistro($querydata);
		if($resp){
			$output = $resp;
		}else{
			$output['error'] = true;
			$output['message'] = 'El nombre que está buscando no se encuetra registrado.';
		}

 		echo json_encode($output); 

	}



	public function addRegistro(){
		$result = $this->CiudadModel->addRegistro();
		echo json_encode($result);
	}

    

    public function getRegistroEdit(){
		$result = $this->CiudadModel->getRegistroEdit();
		echo json_encode($result);

	}

	public function updateRegistro(){
		$result = $this->CiudadModel->updateRegistro();
		echo json_encode($result);
	}

	public function deleteRegistro(){
		$result = $this->CiudadModel->deleteRegistro();
		$msg['success'] = false;
		$msg['type'] = 'deleted';
		if($result){
			$msg['success']=true;
		}
		echo json_encode($msg);
	}

	

}

