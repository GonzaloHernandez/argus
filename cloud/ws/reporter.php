<?php
	header("Access-Control-Allow-Origin: *");

	$request = $_GET['request'];	//<device_id>;<rows>;<id_variable>;<from_date>;<to_date>
	if(empty($request)) exit(1);

	$request = explode(";",$request);
	if(empty($request[0]) || empty($request[1]) || empty($request[2])) 	exit(1);	// No minimo de argumentos requeridos <device_id>;<rows>;<id_variable>
	if(!empty($request[3]) && empty($request[4])) 	exit(1);				// No fecha final
	if(empty($request[3]) && !empty($request[4])) 	exit(1);				//No fecha inicial

	require_once "../code/common/connection.php";
	try {
			if(!empty($request[3]) && !empty($request[4])) {
				$sql = "SELECT * FROM registro WHERE (id_dispositivo = ? AND id_variable = ? AND fecha >= ? AND fecha <= ?) ORDER BY fecha DESC LIMIT ?";
				$values = array($request[0],$request[2],$request[3],$request[4],$request[1]);
			}
			else {
				$sql = "SELECT * FROM registro WHERE (id_dispositivo = ? AND id_variable = ?)  ORDER BY fecha DESC LIMIT ?";
				$values = array($request[0],$request[2],$request[1]);
			}
			$query= $db->prepare($sql);
			$query->execute($values);
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($result);
	}
	catch(PDOException $e){
			echo $e->getMessage();
	}
?>
