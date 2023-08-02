<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class PagesController extends CI_Controller {



    public function __construct()
	{
		parent::__construct();
		
	}



	public function index(){
		$this->load->view('bienvenida');
	}


	public function verificarnumero(){

		// $output = array('error' => false);
        // $numero = $this->input->post("numero");
		// $resp = $this->ConsultasModel->verificarnumero($numero);
		// if($resp){
		// 	$output = $resp;
		// }

		// else{
		// 	$output['error'] = true;
		// 	$output['message'] = 'El número ingresado no se encuentra registrado.';
		// }
 		// echo json_encode($output); 
	}

}