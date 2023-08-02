<?php
class ExcelImportModel extends CI_Model{

	function insert($data){
		$this->db->insert_batch('registro_demo', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

    function limpiarlatrabla(){
        $this->db->truncate('registro_demo');
    }

}
