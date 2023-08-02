<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('user_agent');
		$this->load->Model('AuthModel');
	}

	public function index(){
        if($this->session->userdata('user')){
			redirect(base_url('panel'), 'refresh');
        }else{
			$this->load->view('login');
        }
    }



    public function ingresar(){
		$output = array('error' => false);
        $email = $this->input->post("email");
        $password = sha1($this->input->post("password"));
		$resp = $this->AuthModel->login($email, $password);
		if($resp){
			$data = array(
				'idusuario' => $resp->idusuario,
				'nombreapellido' => $resp->nombreapellido,
				'email' => $resp->email,
				'id_ciudad' => $resp->id_ciudad,
				'telefono' => $resp->telefono,
				'idrol' => $resp->idrol,
				'estado' => $resp->estado,
				'bfverificado' => $resp->bfverificado,
				'user' => TRUE,
			);
			$this->session->set_userdata($data);
			$output['message'] = 'Iniciando sesión. Espere ...';

			$idu = $this->session->userdata('idusuario');
			$result = $this->AuthModel->registrarhistorial($idu);

		}else{
			$output['error'] = true;
			$output['message'] = 'Login Inválido. Usuario no encontrado';
		}
 		echo json_encode($output); 
	}
	
	public function salir(){
		$this->load->library('session');
		$this->session->unset_userdata('user');
		redirect(base_url('login'), 'refresh');
	}

}
