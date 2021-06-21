<?php

    //use PHPMailer\PHPMailer;
    //use PHPMailer\Exception;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    // Componentes para el envío de mensajes de texto SMS 
    
    function sendSMS($origin, $destination, $text){
        $url="http://sapiens.udenar.edu.co:3017/sms/enviarSMS";
        $channel = curl_init();
        $data = "remitente=$origin&destinatario=$destination&texto=$text";
  
        curl_setopt($channel, CURLOPT_POST, 1);
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_POSTFIELDS, $data);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
        $response = $result = curl_exec($channel);
        curl_close($channel);
        
        if(!$response) {
            return false;
        }
        else{
            return $response;
        }
    }
    
    function sendEmail($destinatarios,$asunto,$cuerpo){
       try{
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->Debugoutput = 'html';
            $mail->SMTPDebug = 5;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'ingenieriaargus@gmail.com'; 
            $mail->Password = 'Losh3233'; 
            $mail->SMTPSecure = 'tls/ssl';
            $mail->Port = 587; 
            
            $mail->setFrom('frozen@argusingenieria.com', 'ARGUS Frozen');
            
            $destinos = explode(',',$destinatarios);
            foreach($destinos as $destino)
                $mail->addAddress($destino);
            
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;
            $mail->send();
            //echo "Mensaje enviado";
       }
       catch (Exception $e){
           echo "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
       }
    }
    
    
    /* Pruebas SMS
    $status = sendSMS('Argus Fozen','573014290590','Hola Juan prueba desde Argus');
    if($status){
        echo "Mensaje enviado: $status";
    }
    else{
        echo "Ocurrió un problema enviando el mensaje $status";
    }
    */
    
    // Pruebas Email
    sendEmail("jcastillo@udenar.edu.co,jjcastilloj@gmail.com","Prueba desde argus","<font color=red>Este es un mensaje de prueba, no responder");
        
?>