<?php
  session_destroy();
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Argus FROZEN | Inicio de sesión</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/lib/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/lib/plugins/iCheck/square/blue.css">
  <script src="/lib/plugins/jQuery/jquery-2.2.3.min.js"></script>

</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <a href="../../index.html"><b>Argus</b> FROZEN</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <center><font size=4>Inicio de sesión</font></center>

    <?php
      switch($_SESSION['status']){
        case 1: $status = "Por favor suministre su E-mail y Contraseña"; break;
        case 2: $status = "Email o Contraseña incorrectos"; break;
        case 3: $status = "Usuario inactivo en el sistema"; break;
      }
      echo "<br><font color=red>$status</font>";
      unset($_SESSION['status']);
      session_destroy();
   ?>
    <form method="POST" action="auth.php" id="loginForm" data-togle="validator" role="form">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Contraseña" id="password" data-error="Error" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"><font size=2> Recordarme en este equipo</font>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-success btn-block btn-flat">Continuar</button>
        </div>

        <!-- /.col -->
      </div>
    </form>

    <!--
    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>
    -->
  </div>
 <font color=gray><p align=right>&copy; 2017 Argus Ingeniería<p>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="/lib/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/lib/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '10%' // optional
    });
  });
</script>
</body>
</html>
