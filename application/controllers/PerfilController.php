<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PerfilController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		// $this->load->Model('PerfilModel');
	}

	public function index(){

		if($this->session->userdata('user')){
			$data['page_title'] = 'Perfil';
			$this->load->view('pages/perfil', $data);
        }else{
			redirect(base_url(), 'refresh');
        }
    }
    
    // public function getPerfilEdit(){
	// 	$result = $this->PerfilModel->getClienteEdit();
	// 	echo json_encode($result);
	// }
	
	// public function updatePerfil(){
	// 	$result = $this->PerfilModel->updateCliente();
	// 	echo json_encode($result);
	// }
	
}
