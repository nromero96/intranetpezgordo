<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ReportesModel extends CI_Model{

	public function __construct()
	{

		parent::__construct();
		$this->load->database();
	}

	public function exportar_operaciones($fecha_inicio, $fecha_fin) {
		$this->db->select('operaciones.*, ciudades.nombre as ciudad, uspr.nombreapellido as supervisor, uadmin.nombreapellido as administrador, items.nombre as item');
		$this->db->from('operaciones');
		$this->db->join('ciudades', 'ciudades.id = operaciones.id_ciudad');
		$this->db->join('usuarios uadmin', 'uadmin.idusuario = operaciones.id_administrador');
		$this->db->join('usuarios uspr', 'uspr.idusuario = operaciones.id_supervisor');
		$this->db->join('almacen_items ai', 'ai.id = operaciones.id_almaceitem');
		$this->db->join('items', 'items.id = ai.id_item');
	
		if (!empty($fecha_inicio) && !empty($fecha_fin)) {
			$this->db->where('operaciones.fechahora >=', $fecha_inicio);
			$this->db->where('operaciones.fechahora <=', $fecha_fin);
		}
	
		//$this->db->where('operaciones.tipo', 'Entrega');
		$this->db->order_by('operaciones.id', 'desc');
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array(); // Devuelve un arreglo vacío si no hay resultados
		}
	}
	

}