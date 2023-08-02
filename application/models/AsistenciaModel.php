<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AsistenciaModel extends CI_Model{

	public function __construct()
	{

		parent::__construct();
		$this->load->database();
	}



    public function cantidadUsuarios(){
        $this->db->from('registro_numero');
        $this->db->where('estado !=','0');
        return $this->db->count_all_results();
    }



    public function showAllRegistro(){
		$this->db->select('*');
    	$this->db->from('asistentes');
    	$this->db->order_by('id','desc');
    	$this->db->limit(20);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

    public function updateAsistencia(){
		$idp = $this->input->get('idu');
        $valchbx = $this->input->get('valchbx');

        //get date and time
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d H:i:s');
        //format date
        $date = date('d-m-Y H:i:s', strtotime($date));

		if($valchbx == 'no'){
			$field = array( 'ingreso' => "si", 'fechayhora' => $date,);
		}else{
			$field = array( 'ingreso' => "no", 'fechayhora' => '-',);
		}

		$this->db->where('id', $idp);
		$this->db->update('asistentes',$field);
		if($this->db->affected_rows() > 0){
            //return fechayhora this asistente
            $this->db->select('fechayhora');
            $this->db->from('asistentes');
            $this->db->where('id',$idp);
            $query = $this->db->get();
            //return single row
            return $query->row();
		}else{
			return false;
		}
	}

	public function buscarasistente($nombre){
        $this->db->select('*');
    	$this->db->from('asistentes');
    	$this->db->like('nombre',$nombre);
    	$this->db->order_by('id','desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }


	public function addAsistente(){
        $valingreso = $this->input->post('ingreso');

        //get date and time
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d H:i:s');

        if($valingreso == 'si'){
			$date = date('d-m-Y H:i:s', strtotime($date));
		}else{
			$date = '-';
		}

		$field = array(
			'nombre' =>$this->input->post('nombre'),
			'tipo' =>$this->input->post('tipo'),
			'ingreso' => $valingreso,
            'fechayhora' =>$date,
		);

		$this->db->insert('asistentes',$field);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}


    // public function getRegistroEdit(){

	// 	$idr = $this->input->get('idr');

	// 	$this->db->where('id', $idr);

	// 	$query = $this->db->get('registro_numero');

	// 	if($query->num_rows() > 0){

	// 		return $query->row();

	// 	}else{

	// 		return false;

	// 	}

	// }

	

	// public function updateNumero(){

	// 	$idn = $this->input->post('idnumero');

	// 	$field = array(

	// 		'numero' =>$this->input->post('numero'),

	// 		'estado' =>$this->input->post('estado')

	// 	);



	// 	$this->db->where('id',$idn);

	// 	$this->db->update('registro_numero',$field);

	// 	if($this->db->affected_rows() > 0){

	// 		return true;

	// 	}else{

	// 		return false;

	// 	}

	// }



}