<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud extends CI_Controller {

	function __construct() {
		parent::__construct();
        $this->load->helper("url");//BORRAR CACHÉ DE LA PÁGINA
        $this->load->model('M_Solicitud');
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
	}

	public function index (){
		$data['nombre']='';
		$datos = $this->M_Solicitud->getMayoristas();
		$option = ' ';
		foreach ($datos as $key) {
			$option .= '<option value=" '.$key->noMayorista.' ">'.$key->noMayorista.'</option>';
		}
		$data['option'] = $option;
		$this->load->view('v_solicitud', $data);
	}

	function registrar(){
		$data['error'] = EXIT_ERROR;
		$data['msj']   = null;
		try {
			$nombreVendedor = ucwords(strtolower($this->input->post('Nombre')));
			$email			= $this->input->post('email');
			$fecha		 	= $this->input->post('fecha');
			$canal		 	= ucwords(strtolower($this->input->post('canal')));
			$nomMayorista 	= $this->input->post('noMayorista');
			$numFactura	  	= $this->input->post('numFactura');
			$monto		 	= floatval($this->input->post('monto'));
			$tipoDoc 	    = $this->input->post('tipoDoc');
			$pais			= ucwords(strtolower($this->input->post('pais')));

			$noProducto1	= $this->input->post('noProducto1');
			$noProducto2	= $this->input->post('noProducto2');
			$noProducto3	= $this->input->post('noProducto3');
			$noProducto4	= $this->input->post('noProducto4');
			$cantidadWSEE	= $this->input->post('cantidadWSEE');
			$cantidadWSSE	= $this->input->post('cantidadWSSE');
			$cantidadWSDE	= $this->input->post('cantidadWSDE');
			$cantidadCAL	= $this->input->post('cantidadCAL');

			$arrayInsertCotizacion = array('no_vendedor'   => $nombreVendedor,
										   'email'		   => $email,
										   'fecha' 		   => $fecha,
										   'canal' 		   => $canal,
										   'mayorista' 	   => $nomMayorista,
										   'tipo_documento'=> $tipoDoc,
										   'pais'		   => $pais,
										   'nu_cotizacion' => $numFactura,
										   'monto' 		   => $monto);
			
			$arrayInsertProducto = array('no_producto' => array 
														   ($noProducto1,
															$noProducto2,
															$noProducto3,
															$noProducto4),
										 'cantidad'    => array 
										 				   ($cantidadWSEE,
															$cantidadWSSE,
															$cantidadWSDE,
															$cantidadCAL) );
			$datoInsertCotizacion = $this->M_Solicitud->insertarCotizacion($arrayInsertCotizacion, 'tb_cotizacion', $arrayInsertProducto, 'tb_producto');
			$data['error'] = EXIT_SUCCESS;
		} 
		catch (Exception $e) {
			$data['msj'] = $e->getMessage();
		}
		echo json_encode($data);
	} 

	function getLastOrders() {
		$data['error'] = EXIT_ERROR;
		$data['msj'] = null;
		try {
			$idUser = $this->session->userdata($session->Id_user); ;
			$obtenerOrdenes = $this->M_Solicitud->getLastOrders($idUser);
			$data['error'] = EXIT_SUCCESS;
		} catch (Exception $ex){
			$data['msj'] = $ex->getMessage();
			$data['pais'] = null;
		}
		echo json_encode($data);

	}
}