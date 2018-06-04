<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Solicitud extends CI_Controller {

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
		$this->load->view('v_solicitud', $data);
	}

	function registrar(){
		$data['error'] = EXIT_ERROR;
		$data['msj']   = null;
		try {
			$nombreVendedor = $this->input->post('Nombre');
			$email			= $this->input->post('email');
			$fecha		 	= $this->input->post('fecha');
			$canal		 	= $this->input->post('canal');
			$nomMayorista 	= $this->input->post('noMayorista');
			$numFactura	  	= $this->input->post('numFactura');
			$monto		 	= floatval($this->input->post('monto'));

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
										   'nu_cotizacion' => $numFactura,
										   'monto' 		   => $monto);
			
			$arrayInsertProducto = array('nu_producto' => [	$noProducto1,
															$noProducto2,
															$noProducto3,
															$noProducto4],
										 'cantidad'    => [	$cantidadWSEE,
															$cantidadWSSE,
															$cantidadWSDE,
															$cantidadCAL] );
			$datoInsertCotizacion = $this->M_Solicitud->insertarCotizacion($arrayInsertCotizacion, 'tb_cotizacion', $arrayInsertProducto, 'tb_producto');
			// $datosInsertProducto = $this->M_Solicitud->insertProducto($arrayInsertProducto, 'tb_producto');
			$data['error'] = EXIT_SUCCESS; 
		} catch (Exception $e) {
			$data['msj'] = $e->getMessage();
		}
		echo json_encode(array_map('utf8_encode', $data));
	} 

	function getLastOrders() {
		$data['error'] = EXIT_ERROR;
		$data['msj'] = null;
		try {
			$idUser = $this->session->get_userdata($session->Id_user); ;
			$obtenerOrdenes = $this->M_Solicitud->getLastOrders($idUser);
			$data['error'] = EXIT_SUCCESS;
		} catch (Exception $ex){
			$data['msj'] = $ex->getMessage();
		}
		echo json_encode(array_map('utf8_encode', $data));

	}
}