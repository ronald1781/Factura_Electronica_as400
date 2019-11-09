<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_control extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('login_model', '', TRUE);
        $this->load->model('login_model_db2', '', TRUE);
        $this->load->model('model_db2', '', TRUE);
    }

    function index($msg = NULL) {

        $datos['msg'] = $msg;
        $datos['titulo'] = 'Facturacion';
        $this->load->view('login_view', $datos);
    }

    public function process() {
        $EUDSCCOR='';
        //$cia='10';
        $lstcia=array();
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $codcia = $this->security->xss_clean($this->input->post('seleccia'));       
        $resuse = $this->login_model_db2->validaLoguin($username, $password,$codcia);        
        if ($resuse == 0) {

            $msg = '<font color=red>Usuario y/o Password Incorrectos AS.</font><br />' . $result;
            $this->index($msg);
            $this->session->set_userdata('errorLogin', 'Usuario o Contraseña Incorrecto!! <font color=red>' . $username . ' ' . $resuse . '</font><br />');
            redirect('login');
        } else {

         $BMCODCIA = trim(odbc_result($resuse, 1));
         $BMCODPER = trim(odbc_result($resuse, 2));            
         $BMCODSUC = trim(odbc_result($resuse, 3));
         $BMUSERID = trim(odbc_result($resuse, 4));
         $BMPRAPLL = trim(odbc_result($resuse, 5));
         $BMPRNOMB = trim(odbc_result($resuse, 6));
         $BMTIPPER=trim(odbc_result($resuse, 7));
         $resuc = $this->model_db2->get_sucursal($BMCODSUC);
         if($resuc!=false){           
            $EUCODELE = trim(odbc_result($resuc, 1));
            $EUDSCCOR = trim(odbc_result($resuc, 2));
        }
        $rslstcia = $this->login_model_db2->listarCia($BMCODCIA);
        $EUCODELEC = trim(odbc_result($rslstcia, 1));
        $EUDSCABRC = trim(odbc_result($rslstcia, 2));
        $EUDSCLARC = trim(odbc_result($rslstcia, 3));
        $EUCODCLIE = trim(odbc_result($rslstcia, 4));
        $dusr['BMCODCIA']=$BMCODCIA;
        $dusr['BMCODPER']=$BMCODPER; 
        $dusr['BMUSERID']=$BMUSERID;
        $dusr['BMCODSUC']=$BMCODSUC;
        $dusr['EUDSCCOR']=$EUDSCCOR;
        $dusr['BMNOMPER']=$BMPRNOMB. ' '. $BMPRAPLL;
        $dusr['BMTIPPER']=$BMTIPPER;
        $dusr['EUDSCLARC']=$EUDSCLARC;
        $dusr['EUCODCLIE']=$EUCODCLIE;
        $rslstcli = $this->login_model_db2->get_cliente_ruc($EUCODCLIE);
        $IFNVORUC = trim(odbc_result($rslstcli, 3));
        $dusr['IFNVORUC']=$IFNVORUC;
        $result = $this->login_model->validate($dusr);
        $valid = $this->session->userdata('validated');

        if ($valid == true && $result==true) { 
            $mensaje='Acceso consedido a las '.gmdate("Y-m-d H:i:s", time() - 18000);
            $usuario=$username;
        $this->send_mail_acceso_autorizado($mensaje,$usuario);

           redirect('feprocesa');
           
       } else {           
        $msg = $result;                
        $this->session->set_userdata('errorLogin', '<font color=red>Usuario no Habilitado ' . $username .  '</font><br />');
        $this->index($msg); 
        
    }
    
}

}

function get_cia(){
   $json = array();
   $dato = array();
   $lstcia = array();

   $username = $this->security->xss_clean($this->input->post('username'));
   $password = $this->security->xss_clean($this->input->post('password'));

   $rescia = $this->login_model_db2->validanroCia($username,$password);       


   if($rescia!=0){

    while (odbc_fetch_row($rescia)) {
        $BMCODCIA = trim(odbc_result($rescia, 1));
        $BMCODPER = trim(odbc_result($rescia, 2));
        $rslstpgm = $this->login_model_db2->validapgmusr($username,$password,$BMCODPER);
       
        if(($rslstpgm>0)||($rslstpgm!=false)){
            $rslstcia = $this->login_model_db2->listarCia($BMCODCIA);
            $EUCODELE = trim(odbc_result($rslstcia, 1));
            $EUDSCABR = trim(odbc_result($rslstcia, 2));
            $EUDSCLAR = trim(odbc_result($rslstcia, 3));
            $lstcia[]=array('EUCODELE'=>$EUCODELE,'EUDSCABR'=>$EUDSCABR,'EUDSCLAR'=>$EUDSCLAR);
        }else{

        }
    }

    if(count($lstcia)>0){
        $num = count($lstcia);
        if ($num > 0) {
            for ($g = 0; $g < $num; $g++) {
                $cad = $lstcia[$g];
                $EUCODELE = $cad['EUCODELE'];
                $EUDSCABR = $cad['EUDSCABR'];
                $EUDSCCOR = $cad['EUDSCLAR'];
                $dato[] = $EUCODELE . '#$#' .$EUDSCABR . '#$#' . $EUDSCCOR;
            }
            $json['lista'] = implode("&&&", $dato);
        } else {
            $json['lista'] = 0;
        }
    }else{
$json['lista'] = 0;
    }
    
}else{
  $json['lista'] = 0;  
  
}

echo json_encode($json);
}

function home_principal() {    
 redirect('principal');
}

public function do_logout() {
    $this->session->sess_destroy();
    redirect('login_control');
}

public function sin_datos() {
    $username = $this->session->userdata('usuaper');      
    $datos['titulo'] = 'Error';
    $datos['contenido'] = 'error_sin_datos_view';
    $this->load->view('/includes/plantillaerror', $datos);
}

function send_mail_intento_acceso(){
                    $result='';
                     $usuario = $this->security->xss_clean($this->input->post('usuario'));
   $mensaje = $this->security->xss_clean($this->input->post('mensaje'));
        $f= gmdate("d-m-Y", time() - 18000);
        $hh= gmdate("H-i-s", time() - 18000);
         $destino='rramos@mym.com.pe'; //helpdesk
         $nomuser='Ronald MYM';
         $cuerpohtml=' El usuario '.strtoupper($usuario).' '.$mensaje;
         $htmle='';
         $this->load->library('My_PHPMailer_5');
         $mail = new PHPMailer;
         $mail->isSMTP(); 
         $mail->Host = 'smtp.office365.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'facturacion@mym.com.pe';
         $mail->Password = 'Abc123xyz';
         $mail->SMTPSecure = 'tls';
         $mail->Port = 587;
         $mail->setFrom('facturacion@mym.com.pe', 'Facturacion mym');
         $mail->AddAddress($destino,$nomuser);
         $mail->isHTML(true); 
         $mail->Subject = 'Alerta Acceso No Autorizado'.$f.' '.$hh; 
         $htmle=$cuerpohtml;
         $mail->Body = $htmle; 
         $mail->AltBody = "Cuerpo en texto plano";             
         if(!$mail->send()) {
            $result= 'El mensaje no pudo ser enviado.';
            $result.='Error en el envío: ' . $mail->ErrorInfo;
         } else {
            $result= "¡Mensaje enviado correctamente! a ".$destino;

         }
         return $result;
        }
function send_mail_acceso_autorizado($mensaje,$usuario){
                    $result='';
                     $usuario = $this->security->xss_clean($usuario);
   $mensaje = $this->security->xss_clean($mensaje);
        $f= gmdate("d-m-Y", time() - 18000);
        $hh= gmdate("H-i-s", time() - 18000);
         $destino='rramos@mym.com.pe'; //helpdesk
         $nomuser='Ronald MYM';
         $cuerpohtml=' El usuario '.strtoupper($usuario).' '.$mensaje;
         $htmle='';
         $this->load->library('My_PHPMailer_5');
         $mail = new PHPMailer;
         $mail->isSMTP(); 
         $mail->Host = 'smtp.office365.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'facturacion@mym.com.pe';
         $mail->Password = 'Abc123xyz';
         $mail->SMTPSecure = 'tls';
         $mail->Port = 587;
         $mail->setFrom('facturacion@mym.com.pe', 'Facturacion mym');
         $mail->AddAddress($destino,$nomuser);
         $mail->isHTML(true); 
         $mail->Subject = 'Alerta Acceso Autorizado'.$f.' '.$hh; 
         $htmle=$cuerpohtml;
         $mail->Body = $htmle; 
         $mail->AltBody = "Cuerpo en texto plano";             
         if(!$mail->send()) {
            $result= 'El mensaje no pudo ser enviado.';
            $result.='Error en el envío: ' . $mail->ErrorInfo;
         } else {
            $result= "¡Mensaje enviado correctamente! a ".$destino;

         }
         return $result;
        }

}

?>