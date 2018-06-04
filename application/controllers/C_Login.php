<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class C_Login extends CI_Controller {
	
	function __construct() {
		parent::__contructor();
		$this->load->model(M_Login);
		$this->load->helper('url'); 
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
            $username = $this->M_login->verificarUsuario($usuario);
            if(count($username) != 0){
                if(strtolower($username[0]->usuario) == strtolower($usuario)){
                    if($password == $username[0]->pass){
                        $session = array('usuario'   => $usuario,  
                                         'Id_user'   => $username[0]->Id);
                        $this->session->set_userdata($session);
                        $data['error'] = EXIT_SUCCESS;
                    }else {
                        $data['pass'] = 'Contraseña incorrecta';
                    }
                }
            }
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