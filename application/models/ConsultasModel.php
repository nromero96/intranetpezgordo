<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ConsultasModel extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    public function verificarnumero($numero){
        $this->db->where("numero",$numero);
        $result = $this->db->get("registro_numero");
        if($result->num_rows()>0){
            return $result->row();
        }else{
            return false;
        }
    }
  

}