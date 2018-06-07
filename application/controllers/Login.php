<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Login extends CI_Controller {
	
    function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->model('M_Login');
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
	}

	public function index() {
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('Id_user');
		$this->load->view('v_login');
	}

	function ingresar() {
		$data['error'] = EXIT_ERROR;
        $data['msj']   = null;
         try {
            $usuario  = $this->input->post('usuario');
            $password = $this->input->post('password');
            $username = $this->M_Login->verificaUsuario($usuario);
            if(count($username) != 0){
                if(strtolower($username[0]->usuario) == strtolower($usuario)){
                    if($password == $username[0]->pass){
                        $session = array('usuario' => $usuario,  
                                         'Id_user' => $username[0]->id_mayorista,
                                         'id_rol'  => $username[0]->id_rol);
                        $this->session->set_userdata($session);
                        $data['error'] = EXIT_SUCCESS;
                    }else {
                        $data['pass'] = 'Contraseña incorrecta';
                    }
                }
            }
            $data['rol'] = $username[0]->id_rol;
        }catch(Exception $e) {
           $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
	}

	function cerrarCesion(){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $this->session->unset_userdata('usuario');
            $this->session->unset_userdata('Id_user');
            $data['error'] = EXIT_SUCCESS;
        } catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
    }
}