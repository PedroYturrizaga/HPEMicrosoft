<?php

class M_Solicitud extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function insertarCotizacion($arrayInsert, $tabla, $arrayInsertProducto, $tabla2) {
		$this->db->insert($tabla, $arrayInsert);
		$sql = $this->db->insert_id();
		if($this->db->affected_rows() != 1) {
            throw new Exception('Error al insertar');
            $data['error'] = EXIT_ERROR;
		}

		$i = 0;
		$array1 = array();
		for ($i ; $i < sizeof($arrayInsertProducto['no_producto']); $i ++)  {
			array_push($array1, array('no_producto' => $arrayInsertProducto['no_producto'][$i],
									  'cantidad'    => $arrayInsertProducto['cantidad'][$i],
									  '_id_cotizacion'=> $sql,
									   ));
		}
		$this->db->insert_batch($tabla2, $array1);
		if($this->db->affected_rows() != $i) {
            throw new Exception('Error al insertar');
            $data['error'] = EXIT_ERROR;
		}

		return array("error" => EXIT_SUCCESS, "msj"=> MSJ_INS, "id_cotizacion"=> $sql);
	}

	function getMayoristas() {
		$sql = "SELECT * 
				  FROM tb_mayorista
			  ORDER BY noMayorista ASC";
		$result = $this->db->query($sql);
		return $result->result();
	}

	function getLastOrders($idUser) {
		$sql="SELECT *
				FROM tb_cotizacion 
			   WHERE _id_mayorista = ".$idUser."
			ORDER BY id_cotizacion 
		  DESC LIMIT 4 ";
	  	$result = $this->db->query($sql);
		return $result->result();
	}

	function getDetallesCotizacion($idCotizacion) {
		$sql = "SELECT * 
				  FROM tb_producto
				 WHERE _id_cotizacion = ".$idCotizacion."
				   AND cantidad <> 0";
	   	$result = $this->db->query($sql);
	   	return $result->result();
	}

// 	PARA EL CHAMPION
	function getCanalMasUsado () {
		$sql = "SELECT COUNT(canal) AS cantidad_canal,
					   LOWER(canal)
				  FROM tb_cotizacion
			  GROUP BY LOWER(canal)";
	}

	/**
	QUERY PARA OBTENER EL CANAL Y LAS VECES QUE SE REALIZO UNA SOLICITUD POR ESE CANAL
	SELECT COUNT(canal) as cantidad_canal, canal FROM `tb_cotizacion`
	**/

}