<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AlmacenController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->Model('AlmacenModel');
		$this->load->Model('OperacionModel');
		$this->load->Model('CiudadModel');
		$this->load->Model('CampaignModel');
		$this->load->Model('CategoriaModel');
		$this->load->Model('ItemModel');
		$this->load->Model('UsuariosModel');
	}



	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Almacén Principal';
			$data['ciudades'] = $this->CiudadModel->showAllRegistro();
			//$data['supervisores'] = $this->UsuariosModel->showAllUsuariosSupervisores();
			$data['campaigns'] = $this->CampaignModel->showAllRegistro();
			$data['categorias'] = $this->CategoriaModel->listarCariasActivas();
			$data['listitems'] = $this->ItemModel->showItemsList();

			$this->load->view('pages/almacen',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

    public function showAllRegistro(){
		$result = $this->AlmacenModel->showAllRegistro();
		echo json_encode($result);
	}

	public function buscarRegistro(){
		$output = array('error' => false);
        $querydata = $this->input->post("querydata");
		$resp = $this->AlmacenModel->buscarRegistro($querydata);
		if($resp){
			$output = $resp;
		}else{
			$output['error'] = true;
			$output['message'] = 'El nombre que está buscando no se encuetra registrado.';
		}

 		echo json_encode($output);

	}


	public function addStockAlmacenItem(){
		$result = $this->AlmacenModel->addStockAlmacenItem();
		echo json_encode($result);
	}

    public function verHistorialStock(){
		$result = $this->AlmacenModel->verHistorialStock();
		echo json_encode($result);
	}


	public function listalmacenitemsforselect(){
		$result = $this->AlmacenModel->listalmacenitemsforselect();
		echo json_encode($result);
	}


	public function miAlmacenView(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='2'  ){
			$data['page_title'] = 'Mi Almacen';
			$data['campaigns'] = $this->CampaignModel->showAllRegistro();
			$this->load->view('pages/mialmacen',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}


	public function mostrarItemsMyAlmacen(){
		$result = $this->OperacionModel->mostrarItemsMyAlmacen();
		echo json_encode($result);
	}

	public function buscarItemsMyAlmacen(){
		$output = array('error' => false);
		$querydata = $this->input->post("querydata");
		$resp = $this->OperacionModel->buscarItemsMyAlmacen($querydata);
		if($resp){
			$output = $resp;
		}else{
			$output['error'] = true;
			$output['message'] = 'El nombre que está buscando no se encuetra registrado.';
		}

 		echo json_encode($output); 
	}

	

}

