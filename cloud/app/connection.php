<?php
try {
  //ALTER TABLE xyz CONVERT TO CHARACTER SET utf8;
  $db = new PDO('mysql:localhost;dbname=argusing_argus;charset=utf8mb4', 'argusing_friotecnia', 'UP^Gf9zthKDiD', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

}catch(PDOException $ex) {
      echo "Ha ocurrido un error: ";
      echo "<font color=red>";
      echo $ex->getMessage();
      echo "</font>";
}
?>
