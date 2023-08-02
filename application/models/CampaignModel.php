<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CampaignModel extends CI_Model{

	public function __construct()
	{

		parent::__construct();
		$this->load->database();
	}

    public function cantidadCategorias(){
        $this->db->from('campaigns');
        return $this->db->count_all_results();
    }

    public function showAllRegistro(){
		$this->db->select('*');
    	$this->db->from('campaigns');
        $this->db->where('estado', '1');
    	$this->db->order_by('id','desc');
    	$this->db->limit(20);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function buscarRegistro($querydata){
        $this->db->select('*');
    	$this->db->from('campaigns');
		$this->db->where('estado', '1');
    	$this->db->like('nombre',$querydata);
    	$this->db->order_by('id','desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }


	public function addRegistro(){
		$field = array(
			'nombre' =>$this->input->post('nombre'),
            'descripcion' =>$this->input->post('descripcion')
		);
		$this->db->insert('campaigns',$field);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

    public function getRegistroEdit(){
		$idr = $this->input->get('idr');
		$this->db->where('id', $idr);
		$query = $this->db->get('campaigns');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}

	}

	public function updateRegistro(){
		$idn = $this->input->post('idregist');
		$field = array(
			'nombre' =>$this->input->post('nombre'),
            'descripcion' =>$this->input->post('descripcion')
		);

		$this->db->where('id',$idn);
		$this->db->update('campaigns',$field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function deleteRegistro(){
		$idp = $this->input->get('idreg');
		$field = array(
			'estado' => "0",
		);
		$this->db->where('id', $idp);
		$this->db->update('campaigns',$field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function listarCariasActivas(){
		$this->db->select('*');
		$this->db->from('campaigns');
		$this->db->where('estado', '1');
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->result();
	}

}