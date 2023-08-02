<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ItemController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->Model('ItemModel');
		$this->load->Model('CampaignModel');
		$this->load->Model('CategoriaModel');
	}



	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Items';
			$data['campaigns'] = $this->CampaignModel->listarCariasActivas();
			$data['categorias'] = $this->CategoriaModel->listarCariasActivas();
			$this->load->view('pages/items', $data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

    public function showAllRegistro(){
		$result = $this->ItemModel->showAllRegistro();
		echo json_encode($result);

	}

    public function updateAsistencia(){
		$result = $this->ItemModel->updateAsistencia();
		echo json_encode($result);
	}

	public function buscarRegistro(){
		$output = array('error' => false);
        $querydata = $this->input->post("querydata");
		$resp = $this->ItemModel->buscarRegistro($querydata);
		if($resp){
			$output = $resp;
		}else{
			$output['error'] = true;
			$output['message'] = 'El nombre que está buscando no se encuetra registrado.';
		}

 		echo json_encode($output); 

	}



	public function addRegistro(){
		$result = $this->ItemModel->addRegistro();
		echo json_encode($result);
	}

    

    public function getRegistroEdit(){
		$result = $this->ItemModel->getRegistroEdit();
		echo json_encode($result);

	}

	public function updateRegistro(){
		$result = $this->ItemModel->updateRegistro();
		echo json_encode($result);
	}

	public function deleteRegistro(){
		$result = $this->ItemModel->deleteRegistro();
		$msg['success'] = false;
		$msg['type'] = 'deleted';
		if($result){
			$msg['success']=true;
		}
		echo json_encode($msg);
	}

	public function showItemsList(){
		$result = $this->ItemModel->showItemsList();
		echo json_encode($result);
	}

}

