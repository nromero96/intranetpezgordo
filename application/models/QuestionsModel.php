<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class QuestionsModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function viewdataregiter($slug){
		$this->db->select('id, nombresyapellidos, estadojuego');
    	$this->db->from('trivia1');
		$this->db->where('id',$slug);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}

    public function viewquestionsregiter(){
        $this->db->select('*');
        $this->db->from('preguntas');
        $this->db->order_by('id', 'random');
        $query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
    }

    public function viewrespuestaslist(){
        $this->db->select('*');
        $this->db->from('respuestas');
        $query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
    }

	public function validarespuestas($idpregunta1,$idpregunta2,$idpregunta3,$idpregunta4,$idpregunta5){
		$query = $this->db->query("SELECT (SELECT correcto FROM respuestas WHERE id={$idpregunta1}) as respuesta1, (SELECT correcto FROM respuestas WHERE id={$idpregunta2}) as respuesta2, (SELECT correcto FROM respuestas WHERE id={$idpregunta3}) as respuesta3, (SELECT correcto FROM respuestas WHERE id={$idpregunta4}) as respuesta4, (SELECT correcto FROM respuestas WHERE id={$idpregunta5}) as respuesta5");

		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}

	}


	function updateTrivia($estadojuego, $idregtrivia){
		$field = array(
			'estadojuego' => $estadojuego
		);
		$this->db->where('id',$idregtrivia);
		$this->db->update('trivia1',$field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}


}