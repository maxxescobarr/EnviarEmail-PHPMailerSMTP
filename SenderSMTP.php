<?php 
	include ("../funciones.php");
	require_once ("../class.phpmailer.php");
	include ("../class.smtp.php");

	
	$DestinatarioEmail	=	$_POST["email"];
	$DestinatarioNombre	=	$_POST["nombre"];
	$TAsunto	=	$_POST["asunto"];
	$fecha=date("Y/m/d");

	$txtAsunto=$TAsunto.' - '.$fecha;


	$mail = new PHPMailer(true); // TRUE indica que devolvera exception que nos permiten hacer debug
	$smtp = new SMTP();

	$mail->IsSMTP(); // telling the class to use SMTP
	try {
		$mail->Host       = "mail.dominio.com.ar";	// Servidor SMTP
		$mail->SMTPDebug  = false;					// Habilita  SMTP debug (Parametros 1/2/3)
		$mail->SMTPAuth   = true;					// Servidor SMTP requiere autenticacion
		$mail->Host       = "mail.dominio.com.ar";	// Servidor SMTP (GMAIL - smtp.gmail.com)
		$mail->Port       = 25;						// Puerto SMTP (Puerto GMAIL (26) )
		$mail->SMTPSecure = "tlc";					/*SSL o TLC*/   // Protocolo de Seguridad
		$mail->Username   = "mimail@domain.com.ar";	// SMTP account username
		$mail->Password   = "miclave";				// SMTP account password
		$mail->AddReplyTo('reply@dominio.com.ar', 'Nombre'); //Direccion a donde se responde
		$mail->AddAddress($DestinatarioEmail,$DestinatarioNombre);
		// $mail->addCC("cc@dominio.com.ar");		//Enviar CC (Con Copia)
		// $mail->addBCC("bcc@dominio.com.ar");		//Enviar BCC (Copia Oculta)
		$mail->SetFrom('desde@dominio.com.ar', 'Correo de'); //Parametros de la cuenta remitente
		$mail->Subject = $txtAsunto;
		$mail->AltBody = 'Mail optimizado para cliente HTML compatible!'; // Opcional-MsgHTML crea uno alternativo
		$mail->MsgHTML(eregi_replace("[\]",'',file_get_contents('http://www.dominio.com.ar/reporte/20150925/')));
		$mail->CharSet ="UTF-8";
		$mail->AddAttachment('../images/prod-10345.jpg');    // Adjunto
		$mail->AddAttachment('../images/prod-10348.jpg');	// Adjunto
		$mail->Send();
		echo "Mail enviado correctamente por medio de la funcion SMTP a la cuenta <p>$DestinatarioEmail</p>\n";
	} catch (phpmailerException $e) {
		echo "A: ".$e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
		echo "B: ".$e->getMessage(); //Boring error messages from anything else!
	}

?>