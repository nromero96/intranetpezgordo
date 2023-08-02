<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CampaignController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->Model('CampaignModel');
	}



	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Campañas';
			$this->load->view('pages/campaign',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

    public function showAllRegistro(){
		$result = $this->CampaignModel->showAllRegistro();
		echo json_encode($result);

	}

    public function updateAsistencia(){
		$result = $this->CampaignModel->updateAsistencia();
		echo json_encode($result);
	}

	public function buscarRegistro(){
		$output = array('error' => false);
        $querydata = $this->input->post("querydata");
		$resp = $this->CampaignModel->buscarRegistro($querydata);
		if($resp){
			$output = $resp;
		}else{
			$output['error'] = true;
			$output['message'] = 'El nombre que está buscando no se encuetra registrado.';
		}

 		echo json_encode($output); 

	}



	public function addRegistro(){
		$result = $this->CampaignModel->addRegistro();
		echo json_encode($result);
	}

    

    public function getRegistroEdit(){
		$result = $this->CampaignModel->getRegistroEdit();
		echo json_encode($result);

	}

	public function updateRegistro(){
		$result = $this->CampaignModel->updateRegistro();
		echo json_encode($result);
	}

	public function deleteRegistro(){
		$result = $this->CampaignModel->deleteRegistro();
		$msg['success'] = false;
		$msg['type'] = 'deleted';
		if($result){
			$msg['success']=true;
		}
		echo json_encode($msg);
	}

	

}

