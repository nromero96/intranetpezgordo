<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InicioController extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('user')){
			$data['page_title'] = 'Panel de Control';
			$this->load->view('pages/inicio', $data);
        }else{
			redirect(base_url('login'), 'refresh');
        }
	}
}
