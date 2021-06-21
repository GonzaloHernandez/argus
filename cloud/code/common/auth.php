<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
</head>


<?php
  session_start();
  $_SESSION["user"]=$_POST['email'];
  $_SESSION["pass"]=$_POST['password'];
  $_SESSION["status"]=0;

  $email = $_POST['email'];
  $password = $_POST['password'];

  if(empty($email)||empty($password)){
    $_SESSION["status"]=1;
    //session_destroy();
    header("Location:/frozen/pages/login.php");
    exit(1);
  }
  require_once "connection.php";
  try {

  			$sql = "SELECT * FROM argusing_argus.cliente WHERE (email = ? AND password = SHA(?))";
  			$values = array($email, $password);
  			$query= $db->prepare($sql);
  			$query->execute($values);
  			$result = $query->fetchAll();
        if($query->rowCount()==0){
          $_SESSION["status"]=2; // Email or password incorrect
          //session_destroy();
          header("Location:/frozen/pages/login.php");
          exit(1);
        }
        else{
             echo $result[0][id_cliente];
             echo $query->rowCount();
             $_SESSION["logged"]=1;
             $_SESSION['cliente']=$result[0];
             header("Location:/frozen/pages/monitor.php");
        }
  }
  catch(PDOException $e){
  			echo $e->getMessage();
  }
?>
