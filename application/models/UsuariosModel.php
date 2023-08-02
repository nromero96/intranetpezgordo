<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosModel extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    public function cantidadUsuarios(){
        $this->db->from('usuarios');
        $this->db->where('estado !=','0');
        return $this->db->count_all_results();
    }

    public function showAllUsuarios(){
		$this->db->select('u.idusuario, u.nombreapellido, u.email, u.telefono, r.nombre as nombrerol, u.estado, u.bfverificado');
    	$this->db->from('usuarios u');
		$this->db->join('roles r', 'u.idrol = r.idrol');
		$this->db->where('u.estado !=','0');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function showAllUsuariosEliminados(){
		$this->db->select('u.idusuario, u.nombreapellido, u.email, u.telefono, r.nombre as nombrerol, u.estado, u.bfverificado');
    	$this->db->from('usuarios u');
		$this->db->join('roles r', 'u.idrol = r.idrol');
		$this->db->where('u.estado','0');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function showAllUsuariosSupervisores(){
		//show users by rol 2
		$this->db->select('u.idusuario, u.nombreapellido, u.email');
		$this->db->from('usuarios u');
		$this->db->join('roles r', 'u.idrol = r.idrol');
		$this->db->where('u.idrol','2');
		$this->db->where('u.estado !=','0');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function showAllUsuariosAfiliadores(){
		//get user login id
		$idu = $this->session->userdata('idusuario');
		//show users by rol 3
		$this->db->select('u.idusuario, u.nombreapellido, u.email');
		$this->db->from('usuarios u');
		$this->db->join('roles r', 'u.idrol = r.idrol');
		$this->db->where('u.idrol','3');
		$this->db->where('u.registradopor',$idu);
		$this->db->where('u.estado !=','0');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function addUsuario(){

		//get user login id
		$idu = $this->session->userdata('idusuario');
		$registradopor = $this->input->post('registradopor');
		if($registradopor == ''){
			$registradopor = $idu;
		}else{
			$registradopor = $registradopor;
		}

		$field = array(
			'nombreapellido' =>$this->input->post('nombreyapellido'),
			'email' =>$this->input->post('email'),
			'telefono' =>$this->input->post('numero'),
			'id_ciudad' =>$this->input->post('id_ciudad'),
			'fecha_ingreso' =>$this->input->post('fecha_ingreso'),
			'idrol' =>$this->input->post('rolusuario'),
			'registradopor' => $registradopor,
			'password' =>sha1($this->input->post('password'))
		);

		$this->db->insert('usuarios',$field);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}
    
    public function getUsuarioEdit(){
		$idu = $this->input->get('idu');
		$this->db->where('idusuario', $idu);
		$query = $this->db->get('usuarios');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}
	
	public function updateUsuario(){

		//get user login id
		$idulogin = $this->session->userdata('idusuario');
		$registradopor = $this->input->post('registradopor');
		if($registradopor == ''){
			$registradopor = $idulogin;
		}else{
			$registradopor = $registradopor;
		}

		$idu = $this->input->post('idusuario');

		$datos1 = array(
			'nombreapellido' =>$this->input->post('nombreyapellido'),
			'telefono' =>$this->input->post('numero'),
			'id_ciudad' =>$this->input->post('id_ciudad'),
			'fecha_ingreso' =>$this->input->post('fecha_ingreso'),
			'idrol' =>$this->input->post('rolusuario'),
			'registradopor' => $registradopor
		);

		$datos2 = array(
			'nombreapellido' =>$this->input->post('nombreyapellido'),
			'telefono' =>$this->input->post('numero'),
			'id_ciudad' =>$this->input->post('id_ciudad'),
			'fecha_ingreso' =>$this->input->post('fecha_ingreso'),
			'idrol' =>$this->input->post('rolusuario'),
			'registradopor' => $registradopor,
			'password' => sha1($this->input->post('password'))
		);

		if($this->input->post('password') == ''){
			$field = $datos1;
		}else{
			$field = $datos2;
		}

		$this->db->where('idusuario',$idu);
		$this->db->update('usuarios',$field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}


	public function updatePerfil($idu){
		$datos1 = array(
			'nombreapellido' =>$this->input->post('nombreyapellido'),
			'telefono' =>$this->input->post('numero')
		);

		$datos2 = array(
			'nombreapellido' =>$this->input->post('nombreyapellido'),
			'telefono' =>$this->input->post('numero'),
			'password' => sha1($this->input->post('password'))
		);

		if($this->input->post('password') == ''){
			$field = $datos1;
		}else{
			$field = $datos2;
		}

		$this->db->where('idusuario',$idu);
		$this->db->update('usuarios',$field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function deleteUsuario(){
		$idp = $this->input->get('idu');
		$field = array(
			'estado' => "0",
		);
		$this->db->where('idusuario', $idp);
		$this->db->update('usuarios',$field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function restaurarUsuario(){
		$idp = $this->input->get('idu');
		$field = array(
			'estado' => "1",
		);
		$this->db->where('idusuario', $idp);
		$this->db->update('usuarios',$field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}


	public function updateEstadoUsuario(){
		$idp = $this->input->get('idu');
        $valchbx = $this->input->get('valchbx');

		if($valchbx == '99'){
			$field = array( 'estado' => "1", );
		}else{
			$field = array( 'estado' => "99", );
		}

		$this->db->where('idusuario', $idp);
		$this->db->update('usuarios',$field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}



	public function showHistorialLogin(){
		$this->db->select('u.nombreapellido, u.email, h.ip, h.fechahora');
    	$this->db->from('historial_login h');
		$this->db->join('usuarios u', 'h.idusuario = u.idusuario');
		$this->db->order_by('h.idhl', 'DESC');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function showCantidadLogin(){
		
		$query= $this->db->query('SELECT u.idusuario, u.nombreapellido, u.email, count(*) AS cantidadlogin FROM historial_login h INNER JOIN usuarios u ON h.idusuario = u.idusuario GROUP BY h.idusuario');
		if($query->num_rows() > 0){
		 	return $query->result();
		 }else{
			return false;
	 	}
	}

	//verificar Email
	public function verificarEmail(){
		$email = $this->input->post('email');
		$this->db->where('email', $email);
		$query = $this->db->get('usuarios');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	//Impotar ususarios afiliadores
	public function getUsuarioByEmailImportAfiliadores($email) {
        return $this->db->get_where('usuarios', array('email' => $email))->row();
    }

    public function insertUsuarioImportAfiliadores($data) {
        $this->db->insert('usuarios', $data);
    }

    public function updateUsuarioImportAfiliadores($idusuario, $data) {
        $this->db->where('idusuario', $idusuario)->update('usuarios', $data);
    }

}