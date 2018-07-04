<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Champion extends CI_Controller{
	
	function __construct(){
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
            $pais   = $this->session->userdata('pais');
            $idUser = $this->session->userdata('Id_user');
            $data['nombre'] = $nombre[0]->no_vendedor;
            $datos  = $this->M_Solicitud->getCanalMasUsado($pais, $idUser);
            $datos2 = $this->M_Solicitud->getLastCotizaciones($pais, $idUser);
            $datos3 = $this->M_Solicitud->getDatosReporte();
            $html   = ' ';
            $html2  = ' ';
            $html3  = ' '; 
            $producto= '';
            foreach ($datos as $key) {
                $importe = round($key->importe * 100) / 100;
                $html .= '<tr>
                              <td>'.$key->no_canal.'</td>
                              <td>'.$key->no_vendedor.'</td>
                              <td>'.$key->pais.'</td>
                              <td class="text-right">'.$importe.'</td>
                          </tr>';
            }
            foreach ($datos2 as $key) {
                $html2 .= '<tr>
                               <td>'.$key->canal.'</td>
                               <td>'.$key->no_vendedor.'</td>
                               <td>'.$key->pais.'</td>
                               <td>'.(($key->tipo_documento == 1) ? 'Cotización' : 'Facturazión' ).'</td>
                               <td>'.$key->fecha.'</td>
                               <td class="text-center">
                                   <button class="mdl-button mdl-js-button mdl-button--icon" onclick="getDetails('.$key->id_cotizacion.');">
                                       <i class="mdi mdi-visibility"> </i>
                                   </button>
                                   <button class="mdl-button mdl-js-button mdl-button--icon" onclick="openModalDocuemento('.$key->id_cotizacion.')">
                                       <i class="mdi mdi-collections"> </i>
                                   </button>
                               </td>
                             </tr>';
            }
            foreach ($datos3 as $key) {
                $productos = $this->M_Solicitud->getProductosById($key->id_cotizacion);
                $producto  = '';
                foreach ($productos as $value) {
                    if ($value->cantidad != 0){
                        $producto .= $value->cantidad.' '.$value->no_producto.', ';
                    };
                }
                $producto =substr($producto, 0, -2);
                $producto .= '.';

                $html3 .= '<tr>
                               <td>'.$key->canal.'</td>
                               <td>'.$key->no_vendedor.'</td>
                               <td>'.$key->email.'</td>
                               <td>'.$key->pais.'</td>
                               <td>'.(($key->tipo_documento == 1) ? 'Cotización' : 'Facturazión' ).'</td>
                               <td>'.$key->fecha2.'</td>
                               <td>'.$producto.'</td>
                               <td>'.RUTA_ARCHIVOS.$key->documento.'</td>
                             </tr>';
            }
            $data['bodyCanales'] = $html;
            $data['bodyCotizaciones'] = $html2;
            $data['bodyReporte'] = $html3;
            $data['pais'] = $pais;
            $this->load->view('v_champion', $data);
        }
	}

    function getDetalles() {
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $id     = $this->input->post('cotizacion');
            $datos  = $this->M_Solicitud->getDetallesCotizacion($id);
            $data['detalles'] = $datos;
            $idVendedor = $this->session->userdata('Id_user');
            $datos2 = $this->M_Solicitud->getMayoristas($idVendedor);
            $option = ' ';
            foreach ($datos2 as $key) {
                if($datos[0]->mayorista == $key->mayorista) {
                    $option = '<option value="'.$key->mayorista.'" class="selected">'.$key->mayorista.'</option>';
                }
            }
            $data['option'] = $option;
            $data['error'] = EXIT_SUCCESS;
        }
        catch (Exception $ex){
            $data['msj'] = $ex->getMessage();
        }
        echo json_encode($data);
    }

    function comboMayoristas(){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $pais = $this->session->userdata('pais');
            $idVendedor = $this->session->userdata('Id_user');
            $datos2 = $this->M_Solicitud->getMayoristas($idVendedor);
            $option = ' ';
            foreach ($datos2 as $key) {
                $option .= '<option value="'.$key->mayorista.'">'.$key->mayorista.'</option>';
            }
            $data['option'] = $option;
            $data['pais']   = $pais;
            $data['error']  = EXIT_SUCCESS;
        } catch (Exception $ex){
            $data['msj'] = $ex->getMessage();
        }
        
        echo json_encode($data);
    }

    public function getDatosGraficosCanales() {
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $datos = $this->M_Solicitud->getDatosGraficosCanales();
            $array = [];
            foreach ($datos as $key) {
                array_push($array, [$key->pais, intval($key->importe) ]);
            }
            $data['datos'] = json_encode($array);
        }
        catch (Exception $ex){
            $data['msj'] = $ex->getMessage();
        }
        echo json_encode($data);
    }

    public function getDatosGraficoCotiza() {
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $datos = $this->M_Solicitud->getDatosGraficoCotiza();
            $array = [];
            foreach ($datos as $key) {
                array_push($array, [$key->pais, intval($key->puntos_entregados) ]);
            }
            $data['datos'] = json_encode($array);
        }
        catch (Exception $ex){
            $data['msj'] = $ex->getMessage();
        }
        echo json_encode($data);
    }

    function muestraDocumento() {
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $id  = $this->input->post('id');
            $img = $this->M_Solicitud->getDocumento($id);
            if($img[0]->documento != null) {
                $data['imagen'] = RUTA_ARCHIVOS.$img[0]->documento;
            } else {   
                $data['imagen'] = "";
            }
            
            // $data['imagen'] = $this->M_Solicitud->getDocumento($id);
            $data['error'] = EXIT_SUCCESS;
        }
        catch (Exception $ex){
            $data['msj'] = $ex->getMessage();
        }
        echo json_encode($data);
    }
}