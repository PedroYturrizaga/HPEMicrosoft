<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Champion extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
        $this->load->helper("url");//BORRAR CACHÉ DE LA PÁGINA
        $this->load->model('M_Solicitud');
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
	}

	public function index (){
		$data['nombre'] = '';
		$datos = $this->M_Solicitud->getCanalMasUsado();
        $datos2 = $this->M_Solicitud->getLastCotizaciones();
		$html  = ' ';
		$html2 = ' ';
		foreach ($datos as $key) {
			$html .= '<tr>
					      <td class="text-center">'.$key->no_canal.'</td>
                          <td class="text-center">'.$key->no_vendedor.'</td>
                          <td class="text-center">'.$key->pais.'</td>
                          <td class="text-center">'.$key->importe.'</td>
                      </tr>';
        }
        foreach ($datos2 as $key) {
        	$html2 .= '<tr>
        			       <td class="text-center">'.$key->canal.'</td>
        			       <td class="text-center">'.$key->no_vendedor.'</td>
        			       <td class="text-center">'.$key->pais.'</td>
        			       <td class="text-center">'.$key->fecha.'</td>
                           <td class="text-center">
                               <button class="mdl-button mdl-js-button mdl-button--icon" onclick="getDetails('.$key->id_cotizacion.')">
                                   <i class="mdi mdi-visibility"></i>
                               </button>
                           </td>
        			     </tr>';
        }
        $data['bodyCanales'] = $html;
        $data['bodyCotizaciones'] = $html2;
		$this->load->view('v_champion', $data);
	}

    function getDetalles() {
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $id    = $this->input->post("idCotizacion");
            // print_r('id1 :::: '.$this->input->post('idCotizacion'));
            // print_r('id2 :::: '.$id);
            $datos = $this->M_Solicitud->getDetallesCotizacion(33);
            $data['detalles'] = $datos;
        }
        catch (Exception $ex){
            $data['msj'] = $ex->getMessage();
        }
        $data['error'] = EXIT_SUCCESS;
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
}