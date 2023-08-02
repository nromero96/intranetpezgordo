<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ConsumosModel extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    public function showAllConsumos(){
        $this->db->select('consumo.*');
        $this->db->from('consumo');
        $this->db->order_by('id', 'desc'); // Suponiendo que el campo que representa el orden es 'id', cámbialo si es otro.
        $this->db->limit(100);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }
    

	//Impotar ususarios afiliadores

    public function insertConsumoImport($data) {
        $this->db->insert('consumo', $data);
    }


    public function getConsumosPorRangoFechas($fecha_inicio, $fecha_fin) {
        // Realiza la consulta para obtener los consumos dentro del rango de fechas
        // Ajusta el nombre de la tabla 'consumo' y los nombres de las columnas según tu estructura de base de datos
        $this->db->select('Supervisor, Categoria, Campana, Afiliador, QR, F_Referencia');
        $this->db->from('consumo');
        $this->db->where('F_Referencia >=', $fecha_inicio);
        $this->db->where('F_Referencia <=', $fecha_fin);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array(); // Devuelve un arreglo vacío si no hay resultados
        }
    }


}