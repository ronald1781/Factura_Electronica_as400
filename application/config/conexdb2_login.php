<?php
    $usuario=strtoupper($usuario);//conexrgr,conexd
    $server='';
    $dserver=dato_hostas();
$server=$dserver['ipas'];
    $dsn ="DRIVER={iSeries Access ODBC Driver};SYSTEM=".$server.";";
    //$dsn ="DRIVER={iSeries Access ODBC Driver};SYSTEM=192.168.1.000;";
    $dbconect = odbc_connect($dsn, $usuario, $password);    
    if ($dbconect === false) {
       // $sqlerror = odbc_errormsg($dbconect);

        $result=0;
    }else{
        $result=1;
    }


    ?>

