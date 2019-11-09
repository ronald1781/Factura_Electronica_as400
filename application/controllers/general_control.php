<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class General_control extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('general_model', '', true);
    $this->load->model('graficofe_model', '', true);
    $this->load->library("nusoap_lib");
  }


  function index() {
    $valid = $this->session->userdata('validated');

    if ($valid == true) {      
     $lstanio = $this->graficofe_model->listaanio();
     $json = array();
     $dato = array();
     $lisanio = array();
     while (odbc_fetch_row($lstanio)) {  
      $anio = trim(odbc_result($lstanio, 1));  
      $lisanio[] = array('anio'=>$anio);
    }
    $lstmes = $this->graficofe_model->listames();
    $json = array();
    $dato = array();
    $lismes = array();
    while (odbc_fetch_row($lstmes)) {
      $mes = trim(odbc_result($lstmes, 1));
      $dscmes=mes_letra($mes);  
      $lismes[] = array('mes'=>$mes,'dscmes'=>$dscmes);
    }

    $datos['lstmes'] = $lismes;
    $datos['lstanio'] = $lisanio;
    $datos['titulo'] = 'Factura Electronica';
    $datos['contenido'] = 'principal_view';
    
    $this->load->view('includes/plantilla', $datos);

  } else {           
   redirect('loginin');
 }
}


function demo_xml_bajadocumentos(){

  $client = new nusoap_client('http://ecomprobantes-test.com/wssCargaBajas/cargaBajas.asmx?WSDL', true);
  $proxy = $client->getProxyClassCode();                                               
  $client->soap_defencoding = 'UTF-8';
  $client->decode_utf8 = false;
   $client->useHTTPPersistentConnection(); // Uses http 1.1 instead of 1.0
   $soapaction = "http://ecomprobantes-test.com/wssCargaBajas";
   
   $request_xml ="<soap:Envelope 
   xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' 
   xmlns:xsd='http://www.w3.org/2001/XMLSchema' 
   xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>                   
   <soap:Body>
   <cargaBajas xmlns='http://www.dbnet.cl'>
   <RUC>20101266819</RUC>
   <ArchivoBajas>
   <bajas>
   <Tipo_Docu>1</Tipo_Docu>
   <Serie_Inte>F100</Serie_Inte>
   <Foli_Inte>34000</Foli_Inte>
   <Fech_Emis>2014-12-12</Fech_Emis>
   <Motiv_Anul>MAL EMITIDA</Motiv_Anul>
   </bajas>
   <bajas>
   <Tipo_Docu>1</Tipo_Docu>
   <Serie_Inte>F100</Serie_Inte>
   <Foli_Inte>34010</Foli_Inte>
   <Fech_Emis>2014-15-12</Fech_Emis>
   <Motiv_Anul>MAL EMITIDA</Motiv_Anul>
   </bajas>
   </ArchivoBajas>
   </cargaBajas>
   </soap:Body>
   </soap:Envelope>";
   //die($request_xml);
   $msg = $client->serializeEnvelope($request_xml);
   $client->use_curl = TRUE;
   $response = $client->send($request_xml, $soapaction);

   //pre($response['CustomerExtendedID']);
   if (isset($response['CustomerExtendedID'])) {
     $result = 1;
   }
   return $result;
    /*
    try {

      $soapclie= new SoapClie($url);
      $numdata=$soapclie->__getTypes();
    } catch ($e){
      echo $e;
    }
*/
    
    $resul='';
   /*
      $client= new nusoap_client($url);
      var_dump($client->__getFunctions());
    //$response=$client->__getFunctions()  nusoap_client*/

      $bajas=array(
       'Tipo_Docu'=>'01',
       'Serie_Inte'=>'F001',
       'Foli_Inte'=>'235',
       'Fech_Emis'=>'2018-05-02',
       'Motiv_Anul'=>'ERROR CLIENTE',
       'Tipo_REEM'=>'',
       'Serie_REEM'=>'',
       'Foli_REEM'=>'');

  //var_dump($client->Call('cargaBajas',array('RUC'=>'20101759688'),array('ArchivoBajas'=>array('bajas'=>$bajas)))->cargaBajasResponse);
      
/*
$response = '';

$client = new SoapClient($wsdl);
$result = $client->cargaBajas(array('RUC' => '20101759688', 'ArchivoBajas' => $bajas))->cargaBajasResponse;        
echo $result;*/


$datos['dsoap']='';
$datos['titulo'] = 'Anulacion factura electronica';
$datos['contenido'] = 'principal_view';
$this->load->view('includes/plantilla', $datos);
}

}
?>