<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoriaController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->Model('CategoriaModel');
	}



	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Categorías';
			$this->load->view('pages/categorias',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

    public function showAllRegistro(){
		$result = $this->CategoriaModel->showAllRegistro();
		echo json_encode($result);

	}

    public function updateAsistencia(){
		$result = $this->CategoriaModel->updateAsistencia();
		echo json_encode($result);
	}

	public function buscarRegistro(){
		$output = array('error' => false);
        $querydata = $this->input->post("querydata");
		$resp = $this->CategoriaModel->buscarRegistro($querydata);
		if($resp){
			$output = $resp;
		}else{
			$output['error'] = true;
			$output['message'] = 'El nombre que está buscando no se encuetra registrado.';
		}

 		echo json_encode($output); 

	}



	public function addRegistro(){
		$result = $this->CategoriaModel->addRegistro();
		echo json_encode($result);
	}

    

    public function getRegistroEdit(){
		$result = $this->CategoriaModel->getRegistroEdit();
		echo json_encode($result);

	}

	public function updateRegistro(){
		$result = $this->CategoriaModel->updateRegistro();
		echo json_encode($result);
	}

	public function deleteRegistro(){
		$result = $this->CategoriaModel->deleteRegistro();
		$msg['success'] = false;
		$msg['type'] = 'deleted';
		if($result){
			$msg['success']=true;
		}
		echo json_encode($msg);
	}

	

}

