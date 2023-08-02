<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ItemModel extends CI_Model{

	public function __construct()
	{

		parent::__construct();
		$this->load->database();
	}

    public function cantidadUsuarios(){
        $this->db->from('items');
        return $this->db->count_all_results();
    }

    public function showAllRegistro(){

		$id_campaign = $this->input->get('campaign');

		//join table categorias by id_categoria
		$this->db->select('items.*, campaigns.nombre as campaign, categorias.nombre as categoria');
		$this->db->from('items');
		$this->db->join('campaigns', 'campaigns.id = items.id_campaign', 'left');
		$this->db->join('categorias', 'categorias.id = items.id_categoria');
		
		if (!empty($id_campaign)) {
			$this->db->where('items.id_campaign', $id_campaign);
		}

		$this->db->order_by('items.id','desc');
		//$this->db->limit(20);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}

    public function listitemsforselect(){
        $this->db->select('*');
        $this->db->from('items');
        $this->db->order_by('nombre','asc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

	public function buscarRegistro($querydata){

		//join table categorias by id_categoria
		$this->db->select('items.*, campaigns.nombre as campaign, categorias.nombre as categoria');
		$this->db->from('items');
		$this->db->join('campaigns', 'campaigns.id = items.id_campaign', 'left');
		$this->db->join('categorias', 'categorias.id = items.id_categoria');
		$this->db->like('items.nombre',$querydata);
		$this->db->order_by('items.id','desc');
		//$this->db->limit(20);
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
			'id_campaign' =>$this->input->post('id_campaign'),
			'id_categoria' =>$this->input->post('id_categoria'),
            'estado' => $this->input->post('estado')
		);
		$this->db->insert('items',$field);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

    public function getRegistroEdit(){
		$idr = $this->input->get('idr');
		$this->db->where('id', $idr);
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}

	}

	public function updateRegistro(){

        //horario lima
        date_default_timezone_set('America/Lima');


		$idn = $this->input->post('idregist');
		$field = array(
			'nombre' =>$this->input->post('nombre'),
			'id_campaign' =>$this->input->post('id_campaign'),
			'id_categoria' =>$this->input->post('id_categoria'),
            'estado' => $this->input->post('estado'),
            'fechaultimaactualizacion' => date('Y-m-d H:i:s')
		);

		$this->db->where('id',$idn);
		$this->db->update('items',$field);
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
		$this->db->update('items',$field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function showItemsList(){
		// Obtener la campaña enviada por Ajax
		$idcampaign = $this->input->get('campaign');
	
		$this->db->select('*');
		$this->db->from('items');
	
		// Agregar la condición WHERE si $idcampaign no está vacío
		if(!empty($idcampaign)){
			$this->db->where('id_campaign', $idcampaign);
		}
	
		$this->db->order_by('nombre', 'asc');
		$query = $this->db->get();
	
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
	}
	

	public function listitemsforselectporalmacen($idusuario){
		//get id almacen by idusuario
		$this->db->select('id');
		$this->db->from('almacenes');
		$this->db->where('id_usuario',$idusuario);
		$query = $this->db->get();
		$idalmacen = $query->row()->id;

		//get almacenes_items by idalmacen
		$this->db->select('almacenes_items.id, items.nombre as nombreitem, almacenes_items.stock');
		$this->db->from('almacenes_items');
		$this->db->join('items', 'items.id = almacenes_items.id_item');
		$this->db->where('almacenes_items.id_almacen',$idalmacen);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}


	}

}