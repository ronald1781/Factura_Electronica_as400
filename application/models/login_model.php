<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function validate($dusr) {
        $msg = '';
        $datossvr=dato_hostas();
        $nomhost=$datossvr['nomhost'];         
        if (isset($dusr)) {            
            $data = array(    
                'codcia'=>$dusr['BMCODCIA'], 
                'nomcia'=>$dusr['EUDSCLARC'],           
                'codclie'=>$dusr['EUCODCLIE'],
                'ruccia'=>$dusr['IFNVORUC'],
                'codper'=>$dusr['BMCODPER'],                
                'usuaper' => $dusr['BMUSERID'], 
                'nomperusr'=>$dusr['BMNOMPER'], 
                'nomsuc'=>$dusr['EUDSCCOR'],
                'codsuc'=>$dusr['BMCODSUC'],
                'tipper'=>$dusr['BMTIPPER'],                
                'validated' => TRUE,
                'nomsvr'=>$nomhost,
            );
            $this->session->set_userdata($data);
            $msg = TRUE; 

        } else {
            $msg = " <font color=red>Invalido Usuario o Password.</font><br /><br />";
        }
        return $msg;
    }




}

?>