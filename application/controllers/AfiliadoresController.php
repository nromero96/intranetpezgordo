<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AfiliadoresController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->Model('AlmacenModel');
		$this->load->Model('OperacionModel');
		$this->load->Model('CiudadModel');
		$this->load->Model('CategoriaModel');
		$this->load->Model('ItemModel');
		$this->load->Model('UsuariosModel');
	}



	public function index(){

	}

    public function miafiliadorAlmacenView(){
        //get userid from session
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='2'  ){
            $data['page_title'] = 'Mis Afiliadores';
            $data['misafiliadores'] = $this->UsuariosModel->showAllUsuariosAfiliadores();
			$this->load->view('pages/mis-afiliadores',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

    public function mostrarItemsAfiliadorAlmacen(){
        //get afiliador with post
        $idafiliador = $this->input->get('id_afiliador');
		$result = $this->OperacionModel->mostrarItemsAfiliadorAlmacen($idafiliador);
		echo json_encode($result);
	}


}

