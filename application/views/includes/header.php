<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1"></meta>
    <?php date_default_timezone_set('America/Lima'); ?>
    <base href="<?php echo base_url(); ?>">
    <title><?php echo $titulo ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/imagen/fe.ico" />
    <!--<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"></link>-->

    <link  rel="stylesheet" type="text/css" href="assest/css/bootstrap.css"></link> 
    <link  rel="stylesheet" type="text/css" href="assest/css/jquery-ui.min.css"></link> 
    <link  rel="stylesheet" type="text/css" href="assest/css/chosen.min.css"></link> 
    <link  rel="stylesheet" type="text/css" href="assest/css/bootstrap-multiselect.css"></link> 

    <link  rel="stylesheet" type="text/css" href="assest/css/rrgstilos.css"></link> 
    <script src="assest/js/bootstrap.js"></script> 
    <script src="assest/js/jquery.min.js"></script> 
    <script src="assest/js/alertify.js"></script>  
    <script src="assest/js/jquery-ui.min.js"></script> 
    <script src="assest/js/bootstrap.min.js"></script> 
    <script src="assest/js/jquery.validate.js"></script> 

    <script src="assest/js/chosen.jquery.min.js"></script>
    <script src="assest/js/chosen.proto.min.js"></script>
    <script src="assest/js/bootstrap-filestyle.min.js"></script>                
    <script src="assest/js/jquery.dataTables.min.js"></script> 
    <script src="assest/js/dataTables.bootstrap.js"></script>
    <script src="assest/js/ajaxfileupload.js"></script>
    <script src="assest/js/jquery.ajax-progress.min.js"></script>
    <script src="assest/js/bootstrap-multiselect.js"></script>
    <script src="assest/js/generales_js.js"></script>     
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="assest/js/push.js"></script> 
    <script src="assest/js/sw.js"></script>

    <script>

      $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);

</script>
<style>
    .dropdown-submenu{position:relative;}
    .dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
    .dropdown-submenu:hover>.dropdown-menu{display:block;}
    .dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
    .dropdown-submenu:hover>a:after{border-left-color:#ffffff;}
    .dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}


    .modal-header,  .close {
        background-color: #1E90FF;
        color:white !important;
        text-align: center;
        font-size: 30px;
    }
    .modal-footer {
        background-color: #f9f9f9;
    }
</style>
</head>
<body> 
    <?PHP 

    $codper = $this->session->userdata('codper');
    $usuaper = strtoupper($this->session->userdata('usuaper'));
    $nomsuc = strtoupper($this->session->userdata('nomsuc'));
    $nomcia = strtoupper($this->session->userdata('nomcia'));
    $codcia = strtoupper($this->session->userdata('codcia'));
    $nomuser = strtoupper($this->session->userdata('nomperusr'));
    $pflucfg = $this->session->userdata('prfusr');
    $nomsvr = $this->session->userdata('nomsvr');
    if($nomsvr=='PRODUCCION'){$serveras='<span class="label label-success">PRD</span>';}elseif ($nomsvr=='CALIDAD') {
        $serveras='<span class="label label-warning">CAL</span>';
    }else{
      $serveras='<span class="label label-danger">DES</span>';  
  }
  ?>
  <nav>
    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
        </div>
        <a class="navbar-brand"><img src="./assest/imagen/<?php echo $codcia.'.';?>png" style="height: 30px; margin-top: -5px;" ></img></a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="inicio"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                <li><a href="inicio" class="dropdown-toggle" data-toggle="dropdown">Electronica<b class="caret"></b></a>
                    <ul class="dropdown-menu">                        
                        <li><a href="<?php echo base_url('feprocesa') ?>">Documentos</a></li> 
                        <li><a href="<?php echo base_url('principal') ?>">Dashboard</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a title="Usuario Sucursal"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span>  <?php echo $usuaper; ?>
                <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span><?php echo $nomcia; ?> 
            </b>
        </a>                       
    </li>                   

    <li>
<!--
                <a href="#" title="Configuracion" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span><b class="caret"></b></a> 
                    <ul class="dropdown-menu"> 
                     <?php if($pflucfg==0){?>
                        <li> <a href="config_server" title="Configuracion Servdior"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Configuracion Servdior</a></li> 
                        <li> <a href="modulouser" title="Modulo Usuario"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> Modulo Usuario</a></li> 
                        <?php }?>

                        <li> <a data-toggle="modal" data-target="#myModalusr" title="Dato Usuario"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Dato Usuario</a></li>
                                                                   
                    </ul> 

                -->
            </li>
            <li><a href="loginin" title="Salir"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a>
            </li>
            <li><a href="<?php echo base_url('feprocesarfe') ?>" title="Proceso Envio F.E." target="_blank"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a></li> 
            <li><a href="inicio" title="<?php echo 'AMBIENTE: '.$nomsvr;?>"> <?php echo $serveras; ?></a></li> 
        </ul>
    </div>
</div>
</nav>

<section class="container">

  <!-- Modal -->
  <div class="modal fade in" id="myModalusr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-width="760">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="savecfg" id="form" class="form-horizontal" method="post">  
                <input type="hidden" name="codiperus" value="<?php echo $codper;?>" id="codiperus">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Datos del Usuario</h4>
                </div>                          
                <div class="modal-body">                      
                 <div class="form-group">                      
                   <label for="Producto">Nombres</label>
                   <input type="text"  class="form-control" name="txtnomusr" value="<?php echo $nompercfg; ?>" id="txtnomusr" placeholder="Nombres" maxlength="35" readonly=""> 
                   <label for="Producto">Apellidos</label>
                   <input type="text"  class="form-control" name="txtapeusr" value="<?php echo $apepercfg; ?>" id="txtapeusr" placeholder="Apellidos" maxlength="45" readonly="">
                   <label for="Producto">Usuario</label>
                   <input type="text"  class="form-control" name="txtuserusr" id="txtuserusr" value="<?php echo $usuaper; ?>" placeholder="Usuario" maxlength="10" readonly="">
                   <label for="Producto">Contraseña</label>
                   <span>*</span>                            
                   <input type="password" class="form-control" name="txtpassusr" id="txtpassusr" value="" placeholder="Puede Cambiar la Contraseña" maxlength="11">                        
               </div>
           </div>
           <div class="modal-footer">                    
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
      </form>         

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal-Fade in -->

