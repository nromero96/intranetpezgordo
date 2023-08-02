<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class UsuariosController extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		
		$this->load->Model('UsuariosModel');
		$this->load->Model('CiudadModel');
	}

	public function index(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Usuarios';
			$data['ciudades'] = $this->CiudadModel->showAllRegistro();
			$data['supervisores'] = $this->UsuariosModel->showAllUsuariosSupervisores();
			$this->load->view('pages/usuarios',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}

	public function usuariosEliminadosView(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Usuarios Eliminados';
			$data['ciudades'] = $this->CiudadModel->showAllRegistro();
			$data['supervisores'] = $this->UsuariosModel->showAllUsuariosSupervisores();
			$this->load->view('pages/usuarios-eliminados',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}
    
    public function showAllUsuarios(){
		$result = $this->UsuariosModel->showAllUsuarios();
		echo json_encode($result);
	}

	public function showAllUsuariosEliminados(){
		$result = $this->UsuariosModel->showAllUsuariosEliminados();
		echo json_encode($result);
	}

	public function addUsuario(){
		$result = $this->UsuariosModel->addUsuario();
		echo json_encode($result);
	}
    
    public function getUsuarioEdit(){
		$result = $this->UsuariosModel->getUsuarioEdit();
		echo json_encode($result);
	}
	
	public function updateUsuario(){
		$result = $this->UsuariosModel->updateUsuario();
		echo json_encode($result);
	}

	public function updatePerfil(){
		$idu = $this->session->userdata('idusuario');
		$result = $this->UsuariosModel->updatePerfil($idu);
		echo json_encode($result);
	}
	
	public function deleteUsuario(){
		$result = $this->UsuariosModel->deleteUsuario();
		$msg['success'] = false;
		$msg['type'] = 'deleted';
		if($result){
			$msg['success']=true;
		}
		echo json_encode($msg);
	}

	public function restaurarUsuario(){
		$result = $this->UsuariosModel->restaurarUsuario();
		$msg['success'] = false;
		$msg['type'] = 'restaurado';
		if($result){
			$msg['success']=true;
		}
		echo json_encode($msg);
	}

	public function updateEstadoUsuario(){
		$result = $this->UsuariosModel->updateEstadoUsuario();
		echo json_encode($result);
	}

	public function vistaHistorialLogin(){
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Historial de Login';
			$this->load->view('pages/historial-login', $data);
        }else{
			redirect(base_url(), 'refresh');
        }
	}
	
	public function showHistorialLogin(){
		$result = $this->UsuariosModel->showHistorialLogin();
		echo json_encode($result);
	}
	
	public function showCantidadLogin(){
		$result = $this->UsuariosModel->showCantidadLogin();
		echo json_encode($result);
    }

	//verificar Email
	public function verificarEmail(){
		$result = $this->UsuariosModel->verificarEmail();
		echo json_encode($result);
	}


	public function view_page_inport_afiliadores()
    {
		if($this->session->userdata('user') && $this->session->userdata('idrol') =='1'){
			$data['page_title'] = 'Usuarios';
			$this->load->view('pages/importar_usuarios',$data);
        }else{
			redirect(base_url(), 'refresh');
        }
    }



    public function importar_usuarios_afiliadores() {
		$response = array();

		if ($_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
            $ruta_temporal = $_FILES['archivo']['tmp_name'];

            // Cargar el archivo Excel usando PhpSpreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($ruta_temporal);
            $worksheet = $spreadsheet->getActiveSheet();

            // Iterar sobre las filas del archivo Excel
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // Incluye celdas vacías

                // Obtener los datos de cada columna en una fila
                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }

                // Verificar si el email ya existe en la tabla
                $email = $data[1]; // Suponiendo que el email está en la tercera columna (0-indexado)
                $existing_user = $this->UsuariosModel->getUsuarioByEmailImportAfiliadores($email);

                if ($existing_user) {
                    // Actualizar los datos del usuario existente
                    $this->UsuariosModel->updateUsuarioImportAfiliadores($existing_user->idusuario, array(
                        'nombreapellido' => $data[0],
                        'telefono' => $data[2],
                        'id_ciudad' => $data[3],
                        'fecha_ingreso' => date('Y-m-d', strtotime($data[4])),
                        'fecha_ultimabaja' => date('Y-m-d', strtotime($data[5])),
                        'registradopor' => $data[6],
                        'estado' => $data[7],
                    ));
                } else {
                    // Insertar un nuevo usuario
                    $this->UsuariosModel->insertUsuarioImportAfiliadores(array(
                        'nombreapellido' => $data[0],
                        'email' => $data[1],
                        'telefono' => $data[2],
                        'id_ciudad' => $data[3],
                        'fecha_ingreso' => date('Y-m-d', strtotime($data[4])),
                        'fecha_ultimabaja' => date('Y-m-d', strtotime($data[5])),
                        'password' =>	'e10adc3949ba59abbe56e057f20f883e', //md5('12345678')
                        'token' => '',
                        'expiratoken' => date('Y-m-d H:i:s', strtotime('0000-00-00 00:00:00')),
                        'idrol' => '3',//rol afiliador
                        'registradopor' => $data[6],
						'fecharegistro' => date('Y-m-d H:i:s'),
                        'estado' => $data[7],
                        'bfverificado' => '',
                    ));
                }
            }

            // Cuando la importación es exitosa
        	$response['status'] = 'success';
        	$response['message'] = 'Importación completa.';

        } else {
            // Cuando hay un error al subir el archivo
        	$response['status'] = 'error';
        	$response['message'] = 'Error al subir el archivo.';
        }
	// Devolver la respuesta en formato JSON
	header('Content-Type: application/json');
	echo json_encode($response);

    }


}
