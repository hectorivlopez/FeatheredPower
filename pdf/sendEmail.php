<?php

use PHPMailer\PHPMailer\PHPMailer;

/* $mail = new PHPMailer();

// SMTP settings 
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Port = 465;
$mail->Username = 'featheredpower@gmail.com';
$mail->Password = 'bsgbrkbkkawdsjih';
$mail->SMTPSecure = 'ssl';

//Mail content settings 
$mail->setFrom('FeatheredPower');
$mail->addAddress("{$user['email']}");
$mail->Subject = 'Detalles de la compra';

// Enable HTML 
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';


$mail->Body = '<html></html>';
//$mail->addStringAttachment($pdfOutput, 'document.pdf');
$mail->addStringAttachment($pdfdoc, 'document.pdf');

// Send email 
if ($mail->send()) {
	header('location: /cart.php?result=1');
} else {
	header('location: /cart.php?result=2');
}
$mail->ClearAddresses(); */
