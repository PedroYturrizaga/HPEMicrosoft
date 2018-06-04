<?php

class M_Solicitud extends CI_Model {
	function __construct() {
		parent::__construct();
		$data['idCotizacion'] = '';
	}

	function insertarCotizacion($arrayInsert, $tabla, $arrayInsertProducto, $tabla2) {
		$this->db->insert($tabla, $arrayInsert);
		$sql = $this->db->insert_id();
		$data['idCotizacion'] = $sql;
		if($this->db->affected_rows() != 1) {
            throw new Exception('Error al insertar');
            $data['error'] = EXIT_ERROR;
		}

		$arrayIdCotizacion = array('_id_cotizacion' => $data['idCotizacion']);
		$arrayInsertProducto->array_push($arrayInsertProducto, $arrayIdCotizacion);
		print_r($arrayInsertProducto);
		$this->db->insert_batch($tabla2, $arrayInsertProducto);

		return array("error" => EXIT_SUCCESS, "msj"=> MSJ_INS, "Id"=> $sql);
	}

	function getLastOrders($idUser) {
		$sql="SELECT *
				FROM `tb_cotizacion` 
			   WHERE _id_mayorista = ".$idUser."
			ORDER BY id_cotizacion 
		  DESC LIMIT 4 ";
	  	$result = $this->db->query($sql);
		return $result->result();
	}
/*
	function insertProducto($arrayInsert, $tabla) {
		print_r($data['idCotizacion']);
		$arrayIdCotizacion = array('_id_cotizacion' => $data['idCotizacion']);
		$arrayInsert->array_push($arrayInsert, $arrayIdCotizacion);
		print_r($arrayInsert);
		$this->db->insert_batch($tabla, $arrayInsert);
		$sql = $this->db->insert_id();
		
	}
*/

	/**
	QUERY PARA OBTENER LAS 5 ULTIMAS COTIZACIONES
	SELECT * FROM `tb_cotizacion` ORDER BY id_cotizacion DESC LIMIT 5 

	QUERY PARA OBTENER EL DETALLE DE CADA COTIZACION
	SELECT * FROM `tb_producto` WHERE _id_cotizacion = 5 AND cantidad <> 0

	QUERY PARA OBTENER EL CANAL Y LAS VECES QUE SE REALIZO UNA SOLICITUD POR ESE CANAL
	SELECT COUNT(canal) as cantidad_canal, canal FROM `tb_cotizacion`


	**/

}