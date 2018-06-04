<?php

class M_Solicitud extends CI_Model {
	function __construct() {
		parent::__construct();
		$data['idCotizacion'] = '';
	}

	function insertarCotizacion($arrayInsert, $tabla) {
		$this->db->insert($tabla, $arrayInsert);
		$sql = $this->db->insert_id();
		$data['idCotizacion'] = $sql;
		if($this->db->affected_rows() != 1) {
            throw new Exception('Error al insertar');
            $data['error'] = EXIT_ERROR;
		}
		return array("error" => EXIT_SUCCESS, "msj"=> MSJ_INS, "Id"=> $sql);
	}

	function insertProducto($arrayInsert, $tabla) {
		$arrayInsert->array_push('_id_cotizacion', $data['idCotizacion']);
		print_r($arrayInsert);
		$this->db->insert_batch($tabla, $arrayInsert);
		$sql = $this->db->insert_id();
		
	}
}