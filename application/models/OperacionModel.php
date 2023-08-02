<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OperacionModel extends CI_Model{

	public function __construct()
	{

		parent::__construct();
		$this->load->database();
	}

	public function showAllRegistro(){
		$campaign_id = $this->input->get('campaign');
		//join tabla usuarios, ciudades items and ciudades name as ciudad
		$this->db->select('operaciones.*,ciudades.nombre as ciudad, uspr.nombreapellido as supervisor, uadmin.nombreapellido as administrador, items.nombre as item');
		$this->db->from('operaciones');
		$this->db->join('ciudades', 'ciudades.id = operaciones.id_ciudad');
		$this->db->join('usuarios uadmin', 'uadmin.idusuario = operaciones.id_administrador');
		$this->db->join('usuarios uspr', 'uspr.idusuario = operaciones.id_supervisor');
		$this->db->join('almacen_items ai', 'ai.id = operaciones.id_almaceitem');
		$this->db->join('items', 'items.id = ai.id_item');

		if(!empty($campaign_id)){
			$this->db->where('items.id_campaign', $campaign_id);
		}

		$this->db->where('operaciones.tipo', 'Entrega');
		$this->db->order_by('operaciones.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}


	public function buscarRegistro($querydata){
		//join tabla ciudad and ciudad name as ciudad
		$this->db->select('operaciones.*,ciudades.nombre as ciudad, uspr.nombreapellido as supervisor, uadmin.nombreapellido as administrador, items.nombre as item');
		$this->db->from('operaciones');
		$this->db->join('ciudades', 'ciudades.id = operaciones.id_ciudad');
		$this->db->join('usuarios uadmin', 'uadmin.idusuario = operaciones.id_administrador');
		$this->db->join('usuarios uspr', 'uspr.idusuario = operaciones.id_supervisor');
		$this->db->join('almacen_items ai', 'ai.id = operaciones.id_almaceitem');
		$this->db->join('items', 'items.id = ai.id_item');
		$this->db->where('operaciones.tipo', 'Entrega');
		$this->db->like('items.nombre',$querydata);
		$this->db->or_like('uadmin.nombreapellido',$querydata);
		$this->db->or_like('uspr.nombreapellido',$querydata);
		$this->db->order_by('operaciones.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function addRegistro(){
		//esta funcion es solo para que el administrador entregue stock a los supervisores
		$idusuario = $this->session->userdata('idusuario');
		$field = array(
			'tipo' =>$this->input->post('tipo'),
			'id_administrador' => $idusuario,
			'id_supervisor'	=> $this->input->post('id_supervisor'),
			'id_ciudad' =>$this->input->post('id_ciudad'),
			'id_almaceitem' =>$this->input->post('id_almaceitem'),
			'cantidad' =>$this->input->post('cantidad')
		);
		$this->db->insert('operaciones',$field);
		if ($this->db->affected_rows() > 0) {
			//update stock almacen_items
			$this->db->set('stock', 'stock-'.$this->input->post('cantidad'), FALSE);
			$this->db->where('id', $this->input->post('id_almaceitem'));
			$this->db->update('almacen_items');
			if ($this->db->affected_rows() > 0) {
				//insertar en la tabla almacen_operaciones el id_administrador, tipo, id_almaceitem y cantidad
				$field = array(
					'id_administrador' => $idusuario,
					'tipo' => 'Entrega',
					'id_almaceitem' => $this->input->post('id_almaceitem'),
					'cantidad' => $this->input->post('cantidad')
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
			return false;
		}
	}

	public function mostrarItemsMyAlmacen(){
		$campaign_id = $this->input->get('campaign');
		//select from almacen_items with table operaciones by id_supervisor
		$idusuario = $this->session->userdata('idusuario');
		$this->db->select('ai.id, ai.id_item, ai.stock, items.nombre as item, categorias.nombre as categoria, campaigns.nombre as campaign');
		$this->db->from('almacen_items ai');
		$this->db->join('items', 'items.id = ai.id_item');
		$this->db->join('operaciones', 'operaciones.id_almaceitem = ai.id');

		//join con tabla categorias y tambin tabla campaigns con tabla items
		$this->db->join('categorias', 'categorias.id = items.id_categoria', 'left');
		$this->db->join('campaigns', 'campaigns.id = items.id_campaign', 'left');

		$this->db->where('operaciones.id_supervisor', $idusuario);

		if(!empty($campaign_id)){
			$this->db->where('items.id_campaign', $campaign_id);
		}

		$this->db->group_by('ai.id_item');
		$this->db->order_by('ai.id_item','asc');
		$query = $this->db->get();
		
		//en stock suma cantidad del tipo = Entrega y tipo = Retorno y resta cantidad del tipo = Salida y mostar stock
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$this->db->select('SUM(cantidad) as total');
				$this->db->from('operaciones');
				$this->db->where('id_almaceitem', $row->id);
				$this->db->where('tipo', 'Entrega');
				$this->db->where('id_supervisor', $idusuario);
				$query1 = $this->db->get();
				$row1 = $query1->row();
				$entrega = $row1->total;

				$this->db->select('SUM(cantidad) as total');
				$this->db->from('operaciones');
				$this->db->where('id_almaceitem', $row->id);
				$this->db->where('tipo', 'Retorno');
				$this->db->where('id_supervisor', $idusuario);
				$query2 = $this->db->get();
				$row2 = $query2->row();
				$retorno = $row2->total;

				$this->db->select('SUM(cantidad) as total');
				$this->db->from('operaciones');
				$this->db->where('id_almaceitem', $row->id);
				$this->db->where('id_supervisor', $idusuario);
				$this->db->where('tipo', 'Salida');
				$query3 = $this->db->get();
				$row3 = $query3->row();
				$salida = $row3->total;

				$stock = $entrega + $retorno - $salida;
				$data[] = array(
					'id' => $row->id,
					'id_item' => $row->id_item,
					'stock' => $stock,
					'item' => $row->item,
					'categoria' => $row->categoria,
					'campaign' => $row->campaign
				);
			}
			return $data;
		}else{
			return false;
		}
	}


	public function buscarItemsMyAlmacen($querydata){
		$idusuario = $this->session->userdata('idusuario');
		$this->db->select('ai.id, ai.id_item, ai.stock, items.nombre as item, categorias.nombre as categoria, campaigns.nombre as campaign');
		$this->db->from('almacen_items ai');
		$this->db->join('items', 'items.id = ai.id_item');
		$this->db->join('operaciones', 'operaciones.id_almaceitem = ai.id');
		
		//join con tabla categorias y tambin tabla campaigns con tabla items
		$this->db->join('categorias', 'categorias.id = items.id_categoria', 'left');
		$this->db->join('campaigns', 'campaigns.id = items.id_campaign', 'left');

		$this->db->where('operaciones.id_supervisor', $idusuario);
		$this->db->like('items.nombre', $querydata);
		$this->db->group_by('ai.id_item');
		$this->db->order_by('ai.id_item','asc');
		$query = $this->db->get();
		
		//en stock suma cantidad del tipo = Entrega y tipo = Retorno y resta cantidad del tipo = Salida y mostar stock
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$this->db->select('SUM(cantidad) as total');
				$this->db->from('operaciones');
				$this->db->where('id_almaceitem', $row->id);
				$this->db->where('tipo', 'Entrega');
				$this->db->where('id_supervisor', $idusuario);
				$query1 = $this->db->get();
				$row1 = $query1->row();
				$entrega = $row1->total;

				$this->db->select('SUM(cantidad) as total');
				$this->db->from('operaciones');
				$this->db->where('id_almaceitem', $row->id);
				$this->db->where('tipo', 'Retorno');
				$this->db->where('id_supervisor', $idusuario);
				$query2 = $this->db->get();
				$row2 = $query2->row();
				$retorno = $row2->total;

				$this->db->select('SUM(cantidad) as total');
				$this->db->from('operaciones');
				$this->db->where('id_almaceitem', $row->id);
				$this->db->where('id_supervisor', $idusuario);
				$this->db->where('tipo', 'Salida');
				$query3 = $this->db->get();
				$row3 = $query3->row();
				$salida = $row3->total;

				$stock = $entrega + $retorno - $salida;
				$data[] = array(
					'id' => $row->id,
					'id_item' => $row->id_item,
					'stock' => $stock,
					'item' => $row->item,
					'categoria' => $row->categoria,
					'campaign' => $row->campaign
				);
			}
			return $data;
		}else{
			return false;
		}
	}

	public function mostrarItemsMyAlmacenSelect(){

		$campaign_id = $this->input->get('campaign');

		//select from almacen_items with table operaciones by id_supervisor
		$idusuario = $this->session->userdata('idusuario');
		$this->db->select('ai.id, ai.id_item, ai.stock, items.nombre as item');
		$this->db->from('almacen_items ai');
		$this->db->join('items', 'items.id = ai.id_item');
		$this->db->join('operaciones', 'operaciones.id_almaceitem = ai.id');
		$this->db->where('operaciones.id_supervisor', $idusuario);
		
		if (!empty($campaign_id)) {
			$this->db->where('items.id_campaign', $campaign_id);
		}
		
		$this->db->group_by('ai.id_item');
		$this->db->order_by('ai.id_item','asc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}


	public function mostrarItemsAfiliadorAlmacen($idafiliador){
		//select from almacen_items with table operaciones by $idafiliador
		$this->db->select('ai.id, ai.id_item, ai.stock, items.nombre as item');
		$this->db->from('almacen_items ai');
		$this->db->join('items', 'items.id = ai.id_item');
		$this->db->join('operaciones', 'operaciones.id_almaceitem = ai.id');
		$this->db->where('operaciones.id_afiliador', $idafiliador);
		$this->db->group_by('ai.id_item');
		$this->db->order_by('ai.id_item','asc');
		$query = $this->db->get();
		
		//en stock suma cantidad del tipo = Entrega y tipo = Retorno y resta cantidad del tipo = Salida y mostar stock
		if($query->num_rows() > 0){
			foreach ($query->result() as $row) {
				$this->db->select('SUM(cantidad) as total');
				$this->db->from('operaciones');
				$this->db->where('id_almaceitem', $row->id);
				$this->db->where('tipo', 'Retorno');
				$this->db->where('id_afiliador', $idafiliador);
				$query2 = $this->db->get();
				$row2 = $query2->row();
				$retorno = $row2->total;

				$this->db->select('SUM(cantidad) as total');
				$this->db->from('operaciones');
				$this->db->where('id_almaceitem', $row->id);
				$this->db->where('id_afiliador', $idafiliador);
				$this->db->where('tipo', 'Salida');
				$query3 = $this->db->get();
				$row3 = $query3->row();
				$salida = $row3->total;

				$stock = $salida - $retorno;
				$data[] = array(
					'id' => $row->id,
					'id_item' => $row->id_item,
					'stock' => $stock,
					'item' => $row->item
				);
			}
			return $data;
		}else{
			return false;
		}
	}


	public function misOperaciones(){

		$campaign_id = $this->input->get('campaign');

		//get idusuario from loged user
		$idusuario = $this->session->userdata('idusuario');

		$this->db->select('operaciones.*,ciudades.nombre as ciudad, uspr.nombreapellido as supervisor, uafl.nombreapellido as afiliador, items.nombre as item');
		$this->db->from('operaciones');
		$this->db->join('ciudades', 'ciudades.id = operaciones.id_ciudad');
		$this->db->join('usuarios uspr', 'uspr.idusuario = operaciones.id_supervisor');
		$this->db->join('usuarios uafl', 'uafl.idusuario = operaciones.id_afiliador', 'left');
		$this->db->join('almacen_items ai', 'ai.id = operaciones.id_almaceitem');
		$this->db->join('items', 'items.id = ai.id_item');

		if(!empty($campaign_id)){
			$this->db->where('items.id_campaign', $campaign_id);
		}

		$this->db->where('operaciones.id_supervisor', $idusuario);
		$this->db->order_by('operaciones.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function buscarmisOperaciones($querydata){
		//get idusuario from loged user
		$idusuario = $this->session->userdata('idusuario');

		$this->db->select('operaciones.*,ciudades.nombre as ciudad, uspr.nombreapellido as supervisor, uafl.nombreapellido as afiliador, items.nombre as item');
		$this->db->from('operaciones');
		$this->db->join('ciudades', 'ciudades.id = operaciones.id_ciudad');
		$this->db->join('usuarios uspr', 'uspr.idusuario = operaciones.id_supervisor');
		$this->db->join('usuarios uafl', 'uafl.idusuario = operaciones.id_afiliador', 'left');
		$this->db->join('almacen_items ai', 'ai.id = operaciones.id_almaceitem');
		$this->db->join('items', 'items.id = ai.id_item');
		$this->db->where('operaciones.id_supervisor', $idusuario);
		$this->db->like('ciudades.nombre', $querydata);
		$this->db->or_like('uspr.nombreapellido', $querydata);
		$this->db->or_like('uafl.nombreapellido', $querydata);
		$this->db->or_like('items.nombre', $querydata);
		$this->db->order_by('operaciones.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function registrarMisOperaciones(){
		//get idusuario from loged user
		$idusuario = $this->session->userdata('idusuario');

		$tipo = $this->input->post('tipo');
		$id_almaceitem = $this->input->post('id_almaceitem');
		$cantidad = $this->input->post('cantidad');

		$field = array(
			'tipo' =>$tipo,
			'id_supervisor'	=> $idusuario,
			'id_ciudad' =>$this->input->post('id_ciudad'),
			'id_afiliador' =>$this->input->post('id_afiliador'),
			'id_almaceitem' =>$id_almaceitem,
			'cantidad' =>$cantidad
		);
		$this->db->insert('operaciones',$field);

		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}


	public function registrarMisOperacionesTransferencia(){
		// Obtener idusuario del usuario logueado
		$idusuario = $this->session->userdata('idusuario');
	
		// Datos de origen
		$tipo_origen = 'Retorno';
		$id_ciudad_origen = $this->input->post('id_ciudad_origen');
		$id_afiliador_origen = $this->input->post('id_afiliador_origen');
		$id_almaceitem_origen = $this->input->post('id_almaceitem_origen');
		$cantidad_origen = $this->input->post('cantidad_origen');
	
		// Datos para destino
		$tipo_destino = 'Salida';
		$id_ciudad_destino = $this->input->post('id_ciudad_destino');
		$id_afiliador_destino = $this->input->post('id_afiliador_destino');
		$id_almaceitem_destino = $id_almaceitem_origen;
		$cantidad_destino = $cantidad_origen;
	
		// Validación de entrada (ejemplo simplificado, agrega la validación adecuada según tus requisitos de datos)
		if (!($id_ciudad_origen && $id_afiliador_origen && $id_almaceitem_origen && $cantidad_origen &&
			  $id_ciudad_destino && $id_afiliador_destino && $cantidad_destino)) {
			return false; // Los datos de entrada no están completos, maneja esto según la lógica de tu aplicación
		}
	
		// Iniciar transacción
		$this->db->trans_start();
	
		$field_origen = array(
			'tipo' => $tipo_origen,
			'id_supervisor' => $idusuario,
			'id_ciudad' => $id_ciudad_origen,
			'id_afiliador' => $id_afiliador_origen,
			'id_almaceitem' => $id_almaceitem_origen,
			'cantidad' => $cantidad_origen
		);
	
		$field_destino = array(
			'tipo' => $tipo_destino,
			'id_supervisor' => $idusuario,
			'id_ciudad' => $id_ciudad_destino,
			'id_afiliador' => $id_afiliador_destino,
			'id_almaceitem' => $id_almaceitem_destino,
			'cantidad' => $cantidad_destino
		);
	
		$this->db->insert('operaciones', $field_origen);
		$this->db->insert('operaciones', $field_destino);
	
		// Completar transacción
		$this->db->trans_complete();
	
		if ($this->db->trans_status() === FALSE) {
			// La transacción falló, maneja el error o devuelve false
			return false;
		}
	
		return true;
	}
	


}