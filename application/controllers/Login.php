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
                                         'Id_user' => $username[0]->id_vendedor,
                                         'id_rol'  => $username[0]->id_rol,
                                         'pais'    => $username[0]->pais);
                        $this->session->set_userdata($session);
                        $data['rol'] = $username[0]->id_rol;
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
            $this->session->unset_userdata('id_rol');
            $data['error'] = EXIT_SUCCESS;
        } catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
    }

//POR CONFIRMAR SI SE USARÁ
    // function registrarUsuario () {
    //     $data['error'] = EXIT_ERROR;
    //     $data['msj']   = null;
    //     try {
    //         $nombre    = $this->input->post('nombre');
    //         $apellidos = $this->input->post('apellidos');
    //         $canal     = $this->input->post('canal');
    //         $pais      = $this->input->post('pais');
    //         $email     = $this->input->post('email');
    //         $movil     = $this->input->post('movil');
    //         $pass      = $this->input->post('pass');

    //         $arrayInsert = array('no_vendedor'   => $nombreVendedor,
    //                              'email'         => $email,
    //                              'fecha'         => $fecha,
    //                              'canal'         => $canal,
    //                              '_id_mayorista' => $idMayorista,
    //                              'tipo_documento'=> $tipoDoc,
    //                              'pais'          => $pais,
    //                              'nu_cotizacion' => $numFactura,
    //                              'monto'         => $monto,
    //                              $columnaFinal   => $puntos );
    //     } catch (Exception $ex) {
    //         $data['msj'] = $ex->getMessage();
    //     }
    //     echo json_encode($data);
    // }

    function sendGmail(){
        $data['error'] = EXIT_ERROR;
        $data['msj']   = null;
        try {
            $usuario  = $this->input->post('user');
            $username = $this->M_Login->verificaUsuario($usuario);
            if(sizeof($username) == 0){
                $data['error'] = EXIT_ERROR;
                $data['msj']   = 'Usuario no registrado';
            }else{
                $this->load->library("email");
                $configGmail = array('protocol'  => 'smtp',
                                     'smtp_host' => 'smtpout.secureserver.net',
                                     'smtp_port' => 3535,
                                     'smtp_user' => 'info@marketinghpe.com',
                                     'smtp_pass' => 'hpEmSac$18',
                                     'mailtype'  => 'html',
                                     'charset'   => 'utf-8',
                                     'newline'   => "\r\n");
                $this->email->initialize($configGmail);
                $this->email->from('info@marketinghpe.com');
                $this->email->to($usuario);
                $this->email->subject('HPE Microsoft - recuperación de contraseña');
                $texto = '<!DOCTYPE html>
                            <html>
                                <body>
                                    <table width="500px" cellpadding="0" cellspacing="0" align="center" style="border: solid 1px #ccc;">
                                        <tr>
                                            <td>
                                                <table width="500" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #415564;padding: 10px 20px;">
                                                    <tr>
                                                        <td>
                                                            <table>
                                                                <tr>
                                                                    <td><img src="http://test.brainblue.com/HPE_promo_made_simple/public/img/logo/logo_header.png" width="120" alt="alternative text" border="0" style="display: block;"></td>
                                                                    <td></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table cellspacing="0" cellpadding="0" border="0" align="right">
                                                                <tr>
                                                                    <td><font style="font-family: arial;color: #FFFFFF;font-weight: 600;">http://test.brainblue.com/HPE_promo_made_simple/public/img/logo/microsoft-logo.png</font></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="400" cellspacing="0" cellpadding="0" border="0" align="center" style="padding: 30px 0">
                                                    <tr>
                                                        <td style="text-align: center;padding: 0;margin: 0;"><font style="font-family: arial;color: #000000;font-size: 18px;font-weight: 600">Recuperar contrase&ntilde;a</font></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 20px 0;">
                                                            <p>Sr(a) '.$username[0]->no_vendedor.':</p>
                                                            <p>Su contrase&ntilde;a es '.$username[0]->pass.'. </p>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;padding-bottom: 20px"><a href="http://localhost/HPEMicrosoft/Login" target="_blank" style="font-family: arial;color: #00B388;font-size: 14px; text-decoration: underline;font-weight: 600;">Regresar al portal</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><font style="font-family: arial;color: #D3D3D3;font-size: 12px;">&copy;2018 Hewlett Packard Enterprise Development LP</font></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </body>
                            </html>';
                $this->email->message($texto);
                $this->email->send();
                $data['error'] = EXIT_SUCCESS;
            }
        }catch (Exception $e){
            $data['msj'] = $e->getMessage();
        }
        echo json_encode($data);
    }
}