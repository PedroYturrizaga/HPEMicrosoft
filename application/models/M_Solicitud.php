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

	function updateDatos($arrayData, $id, $tabla){
        $this->db->where('id_cotizacion'  , $id);
        $this->db->update($tabla, $arrayData);
        if ($this->db->trans_status() == false) {
            throw new Exception('No se pudo actualizar los datos');
        }
        return array('error' => EXIT_SUCCESS,'msj' => MSJ_UPT);
    }

	function getMayoristas($idVendedor) {
		$sql = "SELECT v.id_vendedor,
					   m.mayorista
				  FROM tb_mayorista m, tb_vendedores v
				 WHERE v.id_vendedor = ".$idVendedor."
                  AND m.id_mayorista = v._id_mayorista
			  GROUP BY mayorista
			  ORDER BY mayorista ASC";
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
			   WHERE _id_vendedor = ".$idUser."
 			GROUP BY id_cotizacion
			ORDER BY id_cotizacion DESC
			   LIMIT 4";
	  	$result = $this->db->query($sql);
		return $result->result();
	}

	function eliminaRegistro($id, $tabla1, $tabla2) {
		$this->db->where('id_cotizacion'  , $id);
        $this->db->delete($tabla1);

        $this->db->where('_id_cotizacion'  , $id);
        $this->db->delete($tabla2);

        return array('error' => EXIT_SUCCESS,'msj' => MSJ_DEL);
	}

// 	PARA EL CHAMPION
	function getDetallesCotizacion($idCotizacion) {
		$sql = "SELECT c.email, 
					   c.no_vendedor, 
					   c.pais, 
					   c.canal, 
					   c.tipo_documento, 
					   c.nu_cotizacion, 
					   date_format(c.fecha, '%d/%m/%Y') AS fecha, 
					   c.monto, 
					   m.mayorista, 
					   p.no_producto, 
					   p.cantidad, 
					   c.documento
				  FROM tb_producto p, 
				       tb_cotizacion c, 
				       tb_vendedores v, 
                       tb_mayorista m
				 WHERE c.id_cotizacion = ".$idCotizacion." 
				   AND c.id_cotizacion = p._id_cotizacion 
				   AND p.cantidad <> 0 
				   AND trim(c.mayorista) = trim(m.mayorista)
                   GROUP BY p.no_producto";
	   	$result = $this->db->query($sql);
	   	return $result->result();
	}

	function getCanalMasUsado ($pais, $idUser) {	
		if($pais == '') {
			$sql = "SELECT COUNT(canal) AS cantidad_canal,
						   canal AS no_canal, 
						   no_vendedor, 
						   pais, 
						   SUM(monto) AS importe
					  FROM tb_cotizacion
				  GROUP BY LOWER(canal)
				  ORDER BY cantidad_canal DESC, importe DESC
				  	 LIMIT 3";
		} else {
			$sql = "SELECT COUNT(canal) AS cantidad_canal,
						   canal AS no_canal, 
						   no_vendedor, 
						   pais, 
						   SUM(monto) AS importe
					  FROM tb_cotizacion
					 WHERE pais LIKE '".$pais."'
					   AND mayorista LIKE (SELECT m.mayorista 
	                                         FROM tb_mayorista m, tb_vendedores v 
	                                        WHERE v.id_vendedor = ".$idUser."
	                                          AND v._id_mayorista = m.id_mayorista)
				  GROUP BY LOWER(canal)
				  ORDER BY cantidad_canal DESC, importe DESC
				  	 LIMIT 3";
		}
		$result = $this->db->query($sql);
		return $result->result();
	}

	function getLastCotizaciones($pais, $idUser) {
		if($pais == '') {
			$sql = "SELECT id_cotizacion,
						   email,
					       no_vendedor,
					       canal,
					       pais,
					       date_format(fecha, '%d/%m/%Y') AS fecha,
					       fecha as fecha2,
					       documento,
					       tipo_documento
					  FROM tb_cotizacion
				  ORDER BY fecha2 DESC
					 LIMIT 10";
		} else {
			$sql = "SELECT id_cotizacion,
						   email,
					       no_vendedor,
					       canal,
					       pais,
					       date_format(fecha, '%d/%m/%Y') AS fecha
					  FROM tb_cotizacion
					 WHERE pais LIKE '".$pais."'
					   AND tipo_documento = 1
					   AND mayorista LIKE (SELECT m.mayorista 
	                                          FROM tb_mayorista m, tb_vendedores v 
	                                         WHERE v.id_vendedor = ".$idUser."
	                                           AND v._id_mayorista = m.id_mayorista) 
				  ORDER BY id_cotizacion DESC
					 LIMIT 10";
		}
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

	function getDocumento($id){
		$sql    = "SELECT documento 
					 FROM tb_cotizacion
					WHERE id_cotizacion = ".$id."";
		$result = $this->db->query($sql);
		return $result->result();
	}
	function getProductosById($id){
		$sql    = "SELECT * 
					 FROM tb_producto
					WHERE _id_cotizacion = ".$id."";
		$result = $this->db->query($sql);
		return $result->result();
	}
	function getDatosReporte(){
		$sql = "SELECT id_cotizacion,
					   email,
				       no_vendedor,
				       canal,
				       pais,
				       date_format(fecha, '%d/%m/%Y') AS fecha,
				       fecha as fecha2,
				       documento,
				       tipo_documento
				  FROM tb_cotizacion
			  ORDER BY fecha2 DESC";
		$result = $this->db->query($sql);
		return $result->result();
	}
}