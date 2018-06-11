<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud extends CI_Controller {

	function __construct() {
		parent::__construct();
        $this->load->helper("url");//BORRAR CACHÉ DE LA PÁGINA
        $this->load->model('M_Solicitud');
        $this->load->model('M_Login');
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
	}

	public function index (){
        if($this->session->userdata('usuario') == null){
            header("location: Login");
        } else {
        	$nombre = $this->M_Login->verificaUsuario( $this->session->userdata('usuario') );
			$data['nombre'] = $nombre[0]->no_vendedor;
			$pais   = $this->session->userdata('pais');
			$idUser = $this->session->userdata('Id_user');
	        $datos  = $this->M_Solicitud->getMayoristas($idUser);
			$option = ' ';
			foreach ($datos as $key) {
				$option .= '<option value="'.$key->mayorista.'">'.$key->mayorista.'</option>';
			}
			$data['option'] = $option;
			$obtenerOrdenes = $this->M_Solicitud->getLastOrders($idUser);
			$html = null;
			$puntosEngage = 0;
			foreach ($obtenerOrdenes as $key) {
				$html .= '<tr>
						      <td class="text-left">'.$key->pais.'</td>
	                          <td class="text-left">'.$key->documento.'</td>
	                          <td class="text-left">'.$key->fecha.'</td>
	                          <td class="text-center"> '.$key->puntos_cotizados.' </td>
	                          <td class="text-center"> '.$key->puntos_facturados.' </td>
	                          <td class="text-center"> '.$key->puntos_total.' </td> 
	                      </tr>';
	          	$puntosEngage += $key->puntos_total;
			}
			$data['html'] = $html;
			$data['pais'] = $pais;
			$data['puntosGeneral'] = $puntosEngage;
			$this->load->view('v_solicitud', $data);
        }
	}

	function registrar(){
		$data['error'] = EXIT_ERROR;
		$data['msj']   = null;
		try {
			$idVendedor     = $this->session->userdata('Id_user');
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
										   'mayorista'     => $idMayorista,
										   'tipo_documento'=> $tipoDoc,
										   'pais'		   => $pais,
										   'nu_cotizacion' => $numFactura,
										   'monto' 		   => $monto,
										   $columnaFinal   => $puntos,
										   '_id_vendedor'  => $idVendedor
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
			$this->session->set_userdata(array('id_cotizacion' => $datoInsertCotizacion['id_cotizacion'] ));
			$obtenerOrdenes = $this->M_Solicitud->getLastOrders($idVendedor);
			$html = null;
			$puntosEngage = 0;
			foreach ($obtenerOrdenes as $key) {
				$html .= '<tr>
						      <td class="text-left">'.$key->pais.'</td>
	                          <td class="text-left">'.$key->documento.'</td>
	                          <td class="text-left">'.$key->fecha.'</td>
	                          <td class="text-center"> '.$key->puntos_cotizados.' </td>
	                          <td class="text-center"> '.$key->puntos_facturados.' </td>
	                          <td class="text-center"> '.$key->puntos_total.' </td> 
	                      </tr>';
	          	$puntosEngage += $key->puntos_total;
			}

			$pais2  = $this->session->userdata('pais');
			$html2  = '';
			$htmlCanales = '';
			$datos  = $this->M_Solicitud->getCanalMasUsado($pais, $idVendedor);
			$datos2 = $this->M_Solicitud->getLastCotizaciones($pais2, $idVendedor);
			foreach ($datos2 as $key) {
        		$html2 .= '<tr>
        			           <td>'.$key->canal.'</td>
        			           <td>'.$key->no_vendedor.'</td>
        			           <td>'.$key->pais.'</td>
        			           <td>'.$key->fecha.'</td>
                               <td class="text-center">
                                   <button class="mdl-button mdl-js-button mdl-button--icon" onclick="getDetails('.$key->id_cotizacion.');">
                                       <i class="mdi mdi-visibility"> </i>
                                   </button>
                               </td>
        			       </tr>';
        	}

			foreach ($datos as $key) {
				$htmlCanales .= '<tr>
						      	     <td>'.$key->no_canal.'</td>
	                                 <td>'.$key->no_vendedor.'</td>
	                                 <td>'.$key->pais.'</td>
	                                 <td class="text-right">'.$key->importe.'</td>
	                             </tr>';
	        }
        	$data['bodyCanales'] = $htmlCanales;
        	$data['bodyCotizaciones'] = $html2;
			$data['html'] = $html;
			$data['puntosGeneral'] = $puntosEngage;
			$data['error'] = EXIT_SUCCESS;
		} 
		catch (Exception $e) {
			$data['msj'] = $e->getMessage();
		}
		echo json_encode($data);
	}

	function cargarFact(){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        if(count($_FILES) == 0){
            $respuesta->mensaje = 'Seleccione su factura';
        }else {
            $tipo = $_FILES['archivo']['type']; 
            $tamanio = $_FILES['archivo']['size']; 
            $archivotmp = $_FILES['archivo']['tmp_name'];
            $namearch = $_FILES['archivo']['name'];
            $nuevo = explode(".",$namearch);
            // print_r('tipo:::: '.$tipo);

            // print_r('archivotmp:::: '.$archivotmp);
            if($tamanio > '2000000'){
                $respuesta->mensaje = 'El tamaño de su pdf debe ser menor';
            }else {
                if($nuevo[1] == 'pdf' || $nuevo[1] == 'jpg'){
                    $target = getcwd().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'archivos'.DIRECTORY_SEPARATOR.'1'.basename($_FILES['archivo']['name']);
                    if(move_uploaded_file($archivotmp, $target) ){
                       $arrUpdt = array('documento' => $namearch);
                       $this->M_Solicitud->updateDatos($arrUpdt, $this->session->userdata('id_cotizacion'), 'tb_cotizacion');
                       $respuesta->mensaje = 'Su factura se subió correctamente';
                    } else {
                       $respuesta->mensaje = 'Hubo un problema en la subida de su factura';
                    }
                }else {
                    $respuesta->mensaje = 'El formato de la factura es incorrecto';
                }
            }
            echo json_encode($respuesta);
        }
    }
}