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

	function getMayoristas($idRol) {
		if($idRol == 1) {
			$sql = "SELECT * 
					  FROM tb_mayorista
					 WHERE id_rol <> 0
				  ORDER BY noMayorista ASC";
		} else if ($idRol == 0) {
			$sql = "SELECT * 
					  FROM tb_mayorista
				  ORDER BY noMayorista ASC";
		}
		$result = $this->db->query($sql);
		return $result->result();
	}

	function getLastOrders($idUser) {
		$sql="SELECT id_cotizacion, 
	   				 pais,
	   				 CASE WHEN(tipo_documento = 1) THEN 'Cotización' else 'Factura' end AS documento,
	   				 fecha,
			       	 SUM(puntos_cotizados) AS puntos_cotizados,
			       	 SUM(puntos_cerrados) AS puntos_facturados,
			       	 SUM(puntos_cerrados + puntos_cotizados) AS puntos_total
			   	FROM tb_cotizacion 
			   WHERE _id_mayorista = ".$idUser."
 			GROUP BY id_cotizacion
			ORDER BY id_cotizacion DESC
			   LIMIT 4";
	  	$result = $this->db->query($sql);
		return $result->result();
	}

// 	PARA EL CHAMPION
	function getDetallesCotizacion($idCotizacion) {
		$sql = "SELECT c.email, 
					   c.no_vendedor, 
					   c.pais, 
					   c.canal, 
					   c.tipo_documento, 
					   c.nu_cotizacion, 
					   c.fecha, 
					   c.monto, 
					   m.noMayorista, 
					   p.no_producto, 
					   p.cantidad 
				  FROM tb_producto p, 
				       tb_cotizacion c, 
				       tb_mayorista m 
				 WHERE c.id_cotizacion = ".$idCotizacion." 
				   AND c.id_cotizacion = p._id_cotizacion 
				   AND p.cantidad <> 0 
				   AND c._id_mayorista = m.id_mayorista";
	   	$result = $this->db->query($sql);
	   	return $result->result();
	}

	function getCanalMasUsado () {
		$sql = "SELECT COUNT(canal) AS cantidad_canal,
					   canal AS no_canal, 
					   no_vendedor, 
					   pais, 
					   SUM(monto) AS importe
				  FROM tb_cotizacion
			  GROUP BY LOWER(canal)
			  ORDER BY cantidad_canal DESC, importe DESC
			  	 LIMIT 3";
		$result = $this->db->query($sql);
		return $result->result();
	}

	function getLastCotizaciones() {
		$sql = "SELECT id_cotizacion,
					   email,
				       no_vendedor,
				       canal,
				       pais,
				       fecha
				  FROM tb_cotizacion
			  ORDER BY id_cotizacion DESC
				 LIMIT 10";
		$result = $this->db->query($sql);
		return $result->result();
	}

	function getDatosGraficosCanales(){
		$sql = "SELECT pais, 
					   SUM(monto) AS importe
				  FROM tb_cotizacion
			  GROUP BY pais
			  ORDER BY importe DESC";
		$result = $this->db->query($sql);
		return $result->result();
	}

	function getDatosGraficoCotiza() {
		$sql = "SELECT pais, 
					   SUM(puntos_cotizados+puntos_cerrados) AS puntos_entregados 
				  FROM tb_cotizacion 
			  GROUP BY pais 
			  ORDER BY puntos_entregados DESC";
		$result = $this->db->query($sql);
		return $result->result();
	}

}