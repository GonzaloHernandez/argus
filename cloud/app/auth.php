<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
</head>
<?php
  session_start();
  $_SESSION["status"]=0;
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(empty($email)||empty($password)){  
    $_SESSION["status"]=1;
    header("Location:login.php");
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
          header("Location:login.php");
          //exit(1);
        }
        else{
            if($result[0]['estado'] == 'A') {
                $_SESSION["logged"] = 1;
                $_SESSION['cliente'] = $result[0];
                header("Location:main.php");
            }
            else {
                $_SESSION["status"] = 3; // User disabled
                 header("Location:login.php"); 
            }
        }
  }
  catch(PDOException $e){
  			echo $e->getMessage();
  }
?>
