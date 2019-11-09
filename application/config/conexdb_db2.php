<?php
$usuario='WEBUSERMYM';
$password='xxxxx';
$server='';
$fp = fopen("./server.txt", "r");

$server = fgets($fp);

fclose($fp);

$dsn ="DRIVER={iSeries Access ODBC Driver};SYSTEM=".$server.";";
    $usuario=strtoupper($usuario);//conexrgr,conexd
    $dbconect = odbc_connect($dsn, $usuario, $password);    
    if ($dbconect === false) { 
               $result=0;
    }else{
        $result=1;
    }
?>
