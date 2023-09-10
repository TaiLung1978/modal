<?php
 function conectar($servidor, $user, $pass, $name)
 {
	$mysqli = new mysqli($servidor, $user, $pass, $name);
	$mysqli->set_charset("utf8");
 }
 
 function enviarMail($mailDest)
 {
	//require 'PHPMailer.php';
	require('PHPMailer-master/src/PHPMailer.php');
	require('PHPMailer-master/src/SMTP.php');
	require('PHPMailer-master/src/Exception.php');

	$mail = new PHPMailer\PHPMailer\PHPMailer();

	/** Configurar SMTP **/
	$mail->isSMTP();                                      // Indicamos que use SMTP
	$mail->Host = 'smtp.office365.com';  					// Indicamos los servidores SMTP
	$mail->SMTPAuth = true;                               // Habilitamos la autenticación SMTP
	$mail->Username = 'cat@quitohonesto.gob.ec';        // SMTP username
	$mail->Password = 'Admin1721';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Habilitar encriptación TLS o SSL
	$mail->Port = 587;                                    // TCP port

	/** Configurar cabeceras del mensaje **/
	$mail->From = 'cat@quitohonesto.gob.ec';                       // Correo del remitente
	$mail->FromName = 'Simposio Anticorrupción Quito Honesto';           // Nombre del remitente
	$mail->Subject = 'Confirmación Inscripción Simposio Anticorrupción 2022';                // Asunto

	/** Incluir destinatarios. El nombre es opcional **/
	$mail->addAddress($mailDest);
	//$mail->addAddress('destinatario2@correo.com', 'Nombre2');
	//$mail->addAddress('destinatario3@correo.com', 'Nombre3');

	/** Con RE, CC, BCC **/
	//$mail->addReplyTo('info@correo.com', 'Informacion');
	//$mail->addCC('cat@quitohonesto.gob.ec');
	//$mail->addBCC('bcc@correo.com');

	/** Incluir archivos adjuntos. El nombre es opcional **/
	//$mail->addAttachment('/archivos/miproyecto.zip');        
	//$mail->addAttachment('/imagenes/imagen.jpg', 'nombre.jpg');

	/** Enviarlo en formato HTML **/
	$mail->isHTML(true);                                  

	/** Configurar cuerpo del mensaje **/
	$mail->Body    = '<b>Ud se encuentra Inscrito en el I Simposio anticorrupción Quito Honesto 2022!</b>';
	//$mail->AltBody = 'Este es el mansaje en texto plano para clientes que no admitan HTML';

	/** Para que use el lenguaje español **/
	$mail->setLanguage('es');

	/** Enviar mensaje... **/
	if(!$mail->send()) {
		phpAlert(   "El mensaje no pudo ser enviado"   ); //echo 'El mensaje no pudo ser enviado.';
		phpAlert(   "Mailer Error: " + $mail->ErrorInfo  ); //echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		phpAlert(   "Mensaje enviado correctamente"   ); //echo 'Mensaje enviado correctamente';
	}
 }
 
 function validaCedula($cedula) {
    $sum = 0;
    $sumi = 0;
    for ($i = 0; $i < strlen($cedula) - 2; $i++) {
        if ($i % 2 == 0) {
            $sum += substr($cedula, $i + 1, 1);
        }
    }
    $j = 0;
    while ($j < strlen($cedula) - 1) {
        $b = substr($cedula, $j, 1);
        $b = $b * 2;
        if ($b > 9) {
            $b = $b - 9;
        }
        $sumi += $b;
        $j = $j + 2;
    }
    $t = $sum + $sumi;
    $res = 10 - $t % 10;
    $aux = substr($cedula, 9, 9);
    if ($res == $aux) {
        return true;
    } else {
        return false;
    }
}

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

?>