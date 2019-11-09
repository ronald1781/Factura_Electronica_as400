<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Procesar_facturas_control extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('facturacionsendws_db2_model', '', TRUE);
	}

	function index() {

	}

	function procesar_facturas_nuevas(){
		//$datos['contenido'] = 'procesar_factura_view'; 
		$datos['titulo'] = 'Procesar Factura Electronica';		   
		$this->load->view('front_end/procesar_factura_view', $datos);		
	}

	function get_verificar_existe_fact(){
		$listdfe =array();

		$lstdocfe = $this->facturacionsendws_db2_model->get_verificar_existe_fact();		
		$numdata=odbc_num_rows($lstdocfe);
		if(($lstdocfe!=false)||($numdata>0)){
			while (odbc_fetch_row($lstdocfe)) {
				$SCTEFEC = trim(odbc_result($lstdocfe, 1)); 
				$SCTECIAA = trim(odbc_result($lstdocfe, 2)); 
				$SCTEPDCA = trim(odbc_result($lstdocfe, 3)); 
				$SCTESERI = trim(odbc_result($lstdocfe, 4));
				$SCTECORR = trim(odbc_result($lstdocfe, 5));
				$listdfe[] = array('SCTEFEC'=>$SCTEFEC,"SCTECIAA"=>$SCTECIAA,'SCTEPDCA'=>$SCTEPDCA,"SCTESERI"=>$SCTESERI,"SCTECORR"=>$SCTECORR);
			}
			$result = [
				"datos"=>$listdfe,
				"proceso"=>true
			];	
		}else{
			$result = [
				"datos"=>$listdfe,
				"proceso"=>false
			];
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($result);
	}

}
?>