<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AlmacenModel extends CI_Model{

	public function __construct()
	{

		parent::__construct();
		$this->load->database();
	}

    public function cantidadItemsAlmacen(){
        $this->db->from('almacen_items');
        return $this->db->count_all_results();
    }

	public function showAllRegistro() {
		$campaign_id = $this->input->get('campaign');

		$this->db->select('almacen_items.*, items.nombre as item, campaigns.nombre as campaign');
		$this->db->from('almacen_items');
		$this->db->join('items', 'items.id = almacen_items.id_item');
		$this->db->join('campaigns', 'campaigns.id = items.id_campaign', 'left');
		$this->db->order_by('almacen_items.id', 'desc');

		if (!empty($campaign_id)) {
			$this->db->where('items.id_campaign', $campaign_id);
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function buscarRegistro($querydata){
		//join tabla ciudad and ciudad name as ciudad
		$this->db->select('almacen_items.*,items.nombre as item');
		$this->db->from('almacen_items');
		$this->db->join('items', 'items.id = almacen_items.id_item');
		$this->db->like('items.nombre',$querydata);
		$this->db->order_by('almacen_items.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}


	public function addStockAlmacenItem(){
		//get id item
		$iditem = $this->input->post('id_item');
		//verificar si existe el item en el almacen
		$this->db->where('id_item',$iditem);
		$query = $this->db->get('almacen_items');
		if($query->num_rows() > 0){
			//get cantidad actual
			$cantidadactual = $query->row()->stock;
			//get cantidad a agregar
			$cantidadagregar = $this->input->post('cantidad');
			//sumar cantidad actual + cantidad a agregar
			$cantidadtotal = $cantidadactual + $cantidadagregar;
			//update cantidad
			$field = array(
				'stock' => $cantidadtotal,
			);
			$this->db->where('id_item',$iditem);
			$this->db->update('almacen_items',$field);
			if($this->db->affected_rows() > 0){
				//insertar registro en la tabla almacen_operaciones
				date_default_timezone_set('America/Lima');
				$field = array(
					'id_administrador' =>$this->session->userdata('idusuario'),
					'tipo' => 'Ingreso',
					'id_almaceitem' => $query->row()->id,
					'cantidad' => $cantidadagregar,
					'fecharegistro' =>date('Y-m-d H:i:s')
				);
				$this->db->insert('almacen_operaciones',$field);
				if ($this->db->affected_rows() > 0) {
					return true;
				}else{
					return false;
				}

			}else{
				return false;
			}
		}else{
			//si no existe el item en el almacen
			//insertar item en el almacen
			$field = array(
				'id_item' =>$this->input->post('id_item'),
				'stock' =>$this->input->post('cantidad')
			);
			$this->db->insert('almacen_items',$field);
			if ($this->db->affected_rows() > 0) {
				//insertar registro en la tabla almacen_operaciones
				date_default_timezone_set('America/Lima');
				$field = array(
					'id_administrador' =>$this->session->userdata('idusuario'),
					'tipo' => 'Ingreso',
					'id_almaceitem' => $this->db->insert_id(),
					'cantidad' =>	$this->input->post('cantidad'),
					'fecharegistro' =>date('Y-m-d H:i:s')
				);
				$this->db->insert('almacen_operaciones',$field);
				if ($this->db->affected_rows() > 0) {
					return true;
				}else{
					return false;
				}

			}else{
				return false;
			}
		}

	}

	public function verHistorialStock(){
		//get id item
		$idalmacenitem = $this->input->get('idalmacenitem');
		//select from table almacen_operaciones where id_almaceitem =	$idalmacenitem
		$this->db->select('almacen_operaciones.*,usuarios.nombreapellido as usuario');
		$this->db->from('almacen_operaciones');
		$this->db->join('usuarios', 'usuarios.idusuario = almacen_operaciones.id_administrador');
		$this->db->where('almacen_operaciones.id_almaceitem',$idalmacenitem);
		$this->db->order_by('almacen_operaciones.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			//return result
			return $query->result();
		}else{
			return false;
		}

	}

	public function listalmacenitemsforselect(){

		$campaign_id = $this->input->get('campaign');

		$this->db->select('almacen_items.*,items.nombre as item');
		$this->db->from('almacen_items');
		$this->db->join('items', 'items.id = almacen_items.id_item');
		
		if (!empty($campaign_id)) {
			$this->db->where('items.id_campaign', $campaign_id);
		}

		$this->db->order_by('almacen_items.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			//return result
			return $query->result();
		}else{
			return false;
		}
	}

}