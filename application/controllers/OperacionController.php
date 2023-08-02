<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OperacionController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->Model('OperacionModel');
		$this->load->Model('CiudadModel');
		$this->load->Model('UsuariosModel');
		$this->load->Model('ItemModel');
		$this->load->Model('AlmacenModel');
		$this->load->Model('CampaignModel');
	}



	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Operaciones';
			$data['ciudades'] = $this->CiudadModel->showAllRegistro();
			$data['supervisores'] = $this->UsuariosModel->showAllUsuariosSupervisores();
			$data['almacenitems'] = $this->AlmacenModel->listalmacenitemsforselect();
			$data['campaigns'] = $this->CampaignModel->showAllRegistro();
			$this->load->view('pages/operaciones',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

    public function showAllRegistro(){
		$result = $this->OperacionModel->showAllRegistro();
		echo json_encode($result);

	}

	public function buscarRegistro(){
		$output = array('error' => false);
        $querydata = $this->input->post("querydata");
		$resp = $this->OperacionModel->buscarRegistro($querydata);
		if($resp){
			$output = $resp;
		}else{
			$output['error'] = true;
			$output['message'] = 'El nombre que está buscando no se encuetra registrado.';
		}

 		echo json_encode($output); 

	}

	public function addRegistro(){
		$result = $this->OperacionModel->addRegistro();
		echo json_encode($result);
	}

	public function misOperacionesView(){
		if($this->session->userdata('user')){
			$data['page_title'] = 'Mis Operaciones';
			$data['ciudades'] = $this->CiudadModel->showAllRegistro();
			$data['afiliadores'] = $this->UsuariosModel->showAllUsuariosAfiliadores();
			$data['campaigns'] = $this->CampaignModel->showAllRegistro();
			$data['almacenitems'] = $this->OperacionModel->mostrarItemsMyAlmacenSelect();
			$this->load->view('pages/mis-operaciones',$data);
		}else{
			redirect(base_url(), 'refresh');
		}
	}

	public function mostrarItemsMyAlmacenSelect(){
		$result = $this->OperacionModel->mostrarItemsMyAlmacenSelect();
		echo json_encode($result);
	}

	public function misOperaciones(){
		$result = $this->OperacionModel->misOperaciones();
		echo json_encode($result);
	}

	public function buscarmisOperaciones(){
		$output = array('error' => false);
		$querydata = $this->input->post("querydata");
		$resp = $this->OperacionModel->buscarmisOperaciones($querydata);
		if($resp){
			$output = $resp;
		}else{
			$output['error'] = true;
			$output['message'] = 'El nombre que está buscando no se encuetra registrado.';
		}

 		echo json_encode($output); 

	}

	public function registrarMisOperaciones(){
		$result = $this->OperacionModel->registrarMisOperaciones();
		echo json_encode($result);
	}

	public function registrarMisOperacionesTransferencia(){
		$result = $this->OperacionModel->registrarMisOperacionesTransferencia();
		echo json_encode($result);
	}

	public function actualizarStockMyAlmacenItem(){
		$result = $this->OperacionModel->actualizarStockMyAlmacenItem('Retorno',7,2,4);
		echo json_encode($result);
	}

}

