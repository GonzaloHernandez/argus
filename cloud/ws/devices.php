<?php
	header("Access-Control-Allow-Origin: *");

	$request = $_GET['request'];	//id_cliente>
	if(empty($request)) exit(1);

	require_once "../code/common/connection.php";
	try {
				$sql = "SELECT	*
								FROM
									contrato  C INNER JOIN dispositivo D ON D.id_dispositivo = C.id_dispositivo INNER JOIN registro R ON R.id_dispositivo = D.id_dispositivo
									INNER JOIN (SELECT id_dispositivo,MAX(fecha) AS ultima_fecha FROM registro GROUP BY id_dispositivo) AS U ON U.id_dispositivo = R.id_dispositivo AND U.ultima_fecha = R.fecha
								WHERE C.id_cliente = ?";
				
				$query= $db->prepare($sql);
				$query->execute(array($request));
				if($query->rowCount()==0) {
					header('Location:../pages/error.php');
					exit(0);
				}
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				echo json_encode($result);
				//print_r($result[0]);
	}
	catch(PDOException $e){
			echo $e->getMessage();
	}
?>
