<?php
  session_start();
  if($_SESSION['logged']!=1){
    header("Location:login.php");
    exit(1);
  }
  else{
    $cliente = $_SESSION['cliente'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Argus FROZEN - Monitor de sistemas de refrigeración</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="/lib/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="/lib/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/lib/dist/css/skins/_all-skins.min.css">

  <!-- APP JS -->
  <?php
    include "./js/main_script.php";
  ?>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMSHh2fi5o7oWEKLKXLrGHTIWlKw_fRiQ&callback=initialize"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="main.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>FZ</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Argus</b>FROZEN</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

        <span class="sr-only">Toggle navigation</span>
         
      </a>
      <!-- Navbar Right Menu -->
      <h4 class="navbar-text"><font color=white><?php echo "$cliente[razon_social]" ?></font></h4>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Alertas y notificaciones</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-plug text-red"></i> Fallos en el fluido eléctrico
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-heartbeat text-yellow"></i> Temperaturas fuera de umbral
                    </a>
                  </li>
                   <li>
                    <a href="#">
                      <i class="fa fa-dashboard text-red "></i> Fallos en el dispositivo monitor
                    </a>
                  </li>
                  
                </ul>
              </li>
              <li class="footer"><a href="#">Ver todo</a></li>
            </ul>
          </li>
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src=<?php echo "\"$cliente[foto]\"" ?> class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo "$cliente[nombres] $cliente[apellidos]" ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src=<?php echo "\"$cliente[foto]\"" ?> class="img-circle" alt="User Image">

                <p>
                  <?php echo "$cliente[nombres] $cliente[apellidos]" ?>
                  <small><?php echo "$cliente[razon_social]" ?></small>
                  <small><?php echo "$cliente[direccion] - Cel: $cliente[telefono]" ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Administrar perfil</a>
                </div>
                <div class="pull-right">
                  <a href="login.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src=<?php echo "\"$cliente[foto]\"" ?> class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo "$cliente[nombres] $cliente[apellidos]" ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
        </div>
      </div>
      <!-- BARRA LATERAL -->
      <ul class="sidebar-menu">
        <li class="header">Menú principal</li>
        <li class="active treeview">
          <a href="main.php">
            <i class="fa fa-th"></i> <span>Tablero principal</span>
          </a>
        </li>
        
        <li class="treeview">
          <a id="statsLink" href="#">
            <i class="fa fa-area-chart"></i>
            <span>Estadísticas</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#" onclick="drawStatistics(); return false;"><i class="fa fa-bar-chart text-aqua"></i> Historial</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-line-chart text-red"></i> Tiempo real</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-map-marker"></i>
            <span>Sensores</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o text-yellow"></i> Detalles</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o text-aqua"></i> Ajustes</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list-ul"></i>
            <span>Variables</span>
          </a>
          <ul class="treeview-menu">
            <?php
              for($i=0;$i<5;$i++){
                echo "\t\t\t<li><a href=\"pages/layout/top-nav.html\"><i class=\"fa fa-circle-o text-yellow\"></i> Variable $i</a></li>\n";
              }
            ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-sun-o"></i>
            <span>Refrigeradores</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o text-yellow"></i> Detalles</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o text-aqua"></i> Mantenimiento</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text-o"></i> <span>Contrato</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-user-secret"></i> <span>Acerca de...</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- ÁREA PRINCIPAL DE CONTENIDO-->
  <div class="content-wrapper">
    <section class="content">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12"><p> </div>
    </div>
      <!-- BOTONES DE LA BARRA SUPERIOR -->
      <div class="row">
        <div class="col-md-2 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-olive"><i class="fa fa-hourglass-o"></i></span>
            
            <div class="info-box-content">
              <span class="info-box-text">Actualizado</span>
              <span class="info-box-number"><font color=black><label id="last_update"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></label></font></span>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
          <div class="info-box">
            <span id="temp_box" class="info-box-icon bg-aqua"><i class="ion ion-ios-snowy"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Temperatura</span>
              <span class="info-box-number" id="device_temperature"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
          <div class="info-box">
            <span id="pwr_box" class="info-box-icon bg-yellow"><i class="ion ion-ios-bolt"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Red eléctrica</span>
              <span class="info-box-number"><font color=green><label id="device_pwr"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></label></font></span>
              <text id="pwr_info"></text>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
          <div class="info-box">
            <span id="com_box" class="info-box-icon bg-blue"><i class="ion-ios-cog"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Canal Internet</span>
              <span class="info-box-number"><font color=green><label id="device_com"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></label></font></span>
              <text id="rtt_info"></text>
            </div>
          </div>
        </div>
        <div class="col-md-4">
        <div class="col-md-12 col-sm-6 col-xs-12">
          <div class="info-box">
            <span id="dev_box" class="info-box-icon bg-teal"><i class="ion ion-ios-location-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Sensor</span>
              <span class="info-box-number"><font color=green><label id="device_status"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></label></font></span>
              <text id="seldev"></text>
            </div>
          </div>
        </div>
        </div>
      </div>
      <!-- FIN BOTONES BARRA SUPERIOR -->

      <!-- FILA PRINCIPAL -->
      <div class="row">
        <div class="col-md-8">
          <!-- PANEL MAPA -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title" id="main_container_title">Georeferenciación de sensores</h3>
              <div class="box-tools pull-right" id="main-container-menu">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <div class="row">
                <div class="col-md-12 col-sm-8">
                  <div class="pad">
                    <div id="main_container" style="width: 100%; height:800px"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- *************************** -->
        </div> 

        <div class="col-md-4">
        <!-- ZONA PARA GRÁFICO DE CICLOS DEL COMPRESOR -->
          <div class="col-md-12">
           <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Voltaje en las fases R,S,T</h3>
              </div>
              <div class="box-body">
                <br>
                <center><div id="compressor_timeline" style="width:100%; height: 140px;"></div></center>
              </div>
            </div>
          </div>
          <!-- ******************************************** -->
          
           <!-- ZONA PARA HISTORIAL DE TEMPERATURA -->
           <div class="col-md-12">
           <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Temperatura</h3>
                
              </div>
              <div class="box-body">
                <center><div id="temperature_log" style="height: 150px;"></div></center>
              </div>
            </div>
          </div>
          
           <!--******************************************** -->
             <!-- ZONA PARA INFORMACIÒN -->
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Detalles del sensor</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <table class="table table-condensed table-hover">
                <tr>
                  <td>ID</td><td><label id="device_des"><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i></label>
                  </td>
                </tr>
                <tr>
                  <td>Hardware</td><td><label id="device_hw"><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i></label>
                  </td>
                </tr>
                <tr>
                  <td>Latitud</td><td><label id="device_lat"><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i></label>
                  </td>
                </tr>
                <tr>
                  <td>Longitud</td><td><label id="device_lon"><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i></label>
                  </td>
                </tr>
                <tr>
                  <td>Altura</td><td><label id="device_alt"><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i></label>
                  </td>
                </tr>
                <tr>
                  <td>Ubicación</td><td><label id="device_dir"><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i></label>
                  </td>
                </tr>
                <tr>
                  <td>Contacto</td><td><label id="device_con"><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i></label>
                  </td>
                </tr>
                </table>
              </div>
              </div>
            </div><!-- ******************************************** -->
          </div>  
        </div>      
      
      <!-- FIN FILA PRINCIPAL -->
    </section>
  </div>
  <!-- PIE DE PÁGINA -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2019 <a href="http://argusingenieria.com">Argus Ingeniería</a>.</strong> Todos los derechos reservados
  </footer>
  <!-- ****************** -->

  <!-- PANEL DE CONTROL -->
  <aside class="control-sidebar control-sidebar-dark">
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar-home-tab">
      </div>
      
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="/lib/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/lib/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->

<!-- Sparkline -->
<script src="/lib/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/lib/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/lib/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="/lib/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="/lib/plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/lib/dist/js/app.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/lib/dist/js/demo.js"></script>
<script src="/lib/plugins/flot/jquery.flot.min.js"></script>
<?php
  include("js/compressor_timeline.php");
  include("js/temperature_log.php");
  include("js/statistics.php");
  include("js/dateranges.php");
?>
</body>
</html>
