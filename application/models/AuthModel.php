<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    public function login($email, $password){
        $this->db->where("email",$email);
        $this->db->where("password",$password);
        $this->db->where("estado","1");
        $result = $this->db->get("usuarios");
        if($result->num_rows()>0){
            return $result->row();
        }else{
            return false;
        }
    }

    public function registrarhistorial($idu){
        $currentDateTime = date('Y-m-d H:i:s');
        $gtipuser = $_SERVER['REMOTE_ADDR'];

        $field = array(
			'fechahora' => $currentDateTime,
			'ip' => $gtipuser,
			'idusuario' => $idu
		);

		$this->db->insert('historial_login',$field);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		} 
    }
  

}