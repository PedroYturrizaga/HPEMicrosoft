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
			$option .= '<option value=" '.$key->id_mayorista.' ">'.$key->noMayorista.'</option>';
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
			$idMayorista 	= $this->input->post('idMayorista');
			$numFactura	  	= $this->input->post('numFactura');
			$monto		 	= floatval($this->input->post('monto'));
			$tipoDoc 	    = $this->input->post('tipoDoc');
			$pais			= ucwords(strtolower($this->input->post('pais')));
			$puntos 		= $this->input->post('puntos');

			$noProducto1	= $this->input->post('noProducto1');
			$noProducto2	= $this->input->post('noProducto2');
			$noProducto3	= $this->input->post('noProducto3');
			$noProducto4	= $this->input->post('noProducto4');
			$cantidadWSEE	= $this->input->post('cantidadWSEE');
			$cantidadWSSE	= $this->input->post('cantidadWSSE');
			$cantidadWSDE	= $this->input->post('cantidadWSDE');
			$cantidadCAL	= $this->input->post('cantidadCAL');

			$columnaFinal   = (($tipoDoc == 1 ) ? 'puntos_cotizados': 'puntos_cerrados') ;

			$arrayInsertCotizacion = array('no_vendedor'   => $nombreVendedor,
										   'email'		   => $email,
										   'fecha' 		   => $fecha,
										   'canal' 		   => $canal,
										   '_id_mayorista' => $idMayorista,
										   'tipo_documento'=> $tipoDoc,
										   'pais'		   => $pais,
										   'nu_cotizacion' => $numFactura,
										   'monto' 		   => $monto,
										   $columnaFinal   => $puntos
										   );
			
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
			// $idUser = $this->session->userdata($session->Id_user); ;
			$obtenerOrdenes = $this->M_Solicitud->getLastOrders(5);
			$html = null;
			$puntosEngage = 0;
			foreach ($obtenerOrdenes as $key) {
				$html .= '<tr>
						      <td class="text-center">'.$key->pais.'</td>
	                          <td class="text-center">'.$key->documento.'</td>
	                          <td class="text-center">'.$key->fecha.'</td>
	                          <td class="text-center"> '.$key->puntos_cotizados.' </td>
	                          <td class="text-center"> '.$key->puntos_facturados.' </td>
	                          <td class="text-center"> '.$key->puntos_total.' </td> 
	                      </tr>';
              	$puntosEngage += $key->puntos_total;
			}
			$data['html'] = $html;
			$data['puntosGeneral'] = $puntosEngage;
			$data['error'] = EXIT_SUCCESS;
		} catch (Exception $ex){
			$data['msj'] = $ex->getMessage();
		}
		echo json_encode($data);
	}
}