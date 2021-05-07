<?php

    include_once("messenger.php");
    
	$data = $_GET['data'];
	//$archivo = fopen("received.txt","a");
	//fwrite($archivo,date("r") . " => Recibido: $data\n");
    //fclose($archivo);
    
	$max_temp = 30;  // Temperatura limite para envio de alertas
	$samples_temperature = 15; // Número de muestras en las que la variable permanece por encima del valor $max_temp
	$samples_voltaje = 5;
	
	$archivo = fopen("counter","r");
	$count = (int) fgets($archivo);
	$archivo_v = fopen("counter_v","r");
	$count_v = (int) fgets($archivo_v);
	
	// Lista de correos para envío de notificaciones
	$mail_list = "abravo7@udenar.edu.co,pabloandres@udenar.edu.co,aderburb@udenar.edu.co,camilo.benavides@udenar.edu.co,gonzalohernandez@udenar.edu.co";
    //$mail_list = "jcastillo@udenar.edu.co";
	
	try{
		$db = new PDO('mysql:host=localhost;dbname=argusing_argus;charset=utf8mb4', 'argusing_friotecnia', 'UP^Gf9zthKDiD',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$data = explode(";",$data);
		$info = array_slice($data,0,4);
		$data = array_slice($data,4);
		$device_id = $info[0];
		$latitude = $info[1];
		$longitude = $info[2];
		$altitude = $info[3];
		// Si las coordenadas son cero, se fijan a la Oficna :)
		//if(($latitude == 0)||($longitude == 0)){
		//	$latitude = 1.231337;
		//	$longitude = -77.292783;
		//}
		// Eliminar el bloque anterior para sistemas en producción
		
		//Extraer los valores de voltaje de las fases antes de procesar
		foreach($data as $input){
		    $input = explode(":",$input);
			$key = $input[0];
			$value = $input[1];
			if($key == 12) $r = $value;
			if($key == 13) $s = $value;
			if($key == 14) $t = $value;
		}
		
		// Alertar por correo electrónico la falla del fluido eléctrico cuando la tensión en cualquier fase es menor de 100V
	
		if(($r < 100) || ($s < 100) || ($t < 100)) {
		    if($count_v == $samples_voltaje){
			    $f = gmdate("Y/m/j H:i:s", time() + 3600*(-5 + date("I"))); 
			    $mensaje = "<b><font color=red>ATENCI&OacuteN:</b> <br><br>Se ha detectado fallo en una o m&aacutes de las fases de la red el&eacutectrica principal durante al menos los &uacuteltimos $samples_voltaje minutos.<br>";
    			$mensaje = $mensaje . "Por favor tomar medidas de precauci&oacuten inmediatas.<br>";
    			$mensaje = $mensaje . "<br>&Uacuteltimo registro: " . $f ."  Voltajes de fase: R = $r V, S = $s V, T = $t V<br>";
    			$mensaje = $mensaje . "<br><br><br></font>Argus Frozen - Sistema de monitoreo.";
    			$mensaje = $mensaje . "<br>Argus Ingenier&iacutea &copy2021";
     			$estado = sendEmail($mail_list,'ALERTA: Red electrica', $mensaje);
     			$status = sendSMS('Argus Frozen','573014290590','ALERTA Datacenter: Problemas con la red electrica');
     			$count_v = 0;
     			$archivo_v = fopen("counter_v","w");
    		    fwrite($archivo_v, $count_v);
    			fclose($archivo_v);
		    }
		    else{
		        $count_v++; // Se incrementa cada que recibe una muestra según programación del sensor
    			$archivo_v = fopen("counter_v","w");
    			fwrite($archivo_v, $count_v);
    			fclose($archivo_v);
		    }
		}
		foreach($data as $input){
			$input = explode(":",$input);
			$key = $input[0];
			$value = $input[1];
			
			if($value > 10) {  // Evitar registros erroneos de temperatura reportados por la sonda. Nunca se puede dar el caso de temperatura menor a 10 grados C.
    			$query= $db->prepare("INSERT INTO registro(id_dispositivo,latitude,longitude,altitude,id_variable,valor) VALUES(?,?,?,?,?,?)");
    			try {
    				$query->execute(array($device_id,$latitude,$longitude,$altitude,$key,$value));
    				if(($key == 1) && ($value > $max_temp))  { //Verificación si la temperatura sobrepasa el umbral seguro
    					if($count == $samples_temperature){
    						$f = gmdate("Y/m/j H:i:s", time() + 3600*(-5 + date("I"))); 
    						$mensaje = "<b><font color=red>ATENCI&OacuteN:</b> <br><br>La temperatura en el Datacenter ha permanecido superior a $max_temp &degC durante aproximadamente $samples_temperature minutos.<br>";
    						$mensaje = $mensaje . "Por favor tomar medidas de precauci&oacuten inmediatamente.<br>";
    						$mensaje = $mensaje . "<br>&Uacuteltimo registro: " . $f . "<br>TEMPERATURA ACTUAL = $value &degC.<br>";
    						$mensaje = $mensaje . "<br><br><br></font>Argus Frozen - Sistema de monitoreo.";
    						$mensaje = $mensaje . "<br>Argus Ingenier&iacutea &copy2021";
     						sendEmail($mail_list, 'ALERTA: Alta temperatura', $mensaje);
     						$status = sendSMS('Argus Frozen','573014290590','ALERTA Datacenter: Problemas de alta temperatura');
     						
     						$count = 0;
     				        $archivo = fopen("counter","w");
    					    fwrite($archivo, $count);
    					    fclose($archivo);
     						
     					}
     					else {
     					    $count++; // Se incrementa cada que recibe una muestra (cada dos minutos programados en el sensor)
    					    $archivo = fopen("counter","w");
    					    fwrite($archivo, $count);
    					    fclose($archivo);
     					}
     				}
    				echo "OK ";
    			}
    			catch(PDOException $e){
    				echo $e->getMessage();
    				echo "** ERROR **";
    
    			}
			}
			//echo "INSERT INTO registro(id_dispositivo,latitude,longitude,altitude,id_variable,valor) VALUES($device_id,$latitude,$longitude,$altitude,$key,$value)<br>";
		}
		//echo "$device_id<br>$latitude<br>$longitude<br>$altitude<br>";
	}catch(PDOException $ex) {
    		echo "Ha ocurrido un error: ";
    		echo "<font color=red>";
    		echo $ex->getMessage();
    		echo "</font>";
    	}
    //fclose($archivo);
?>
