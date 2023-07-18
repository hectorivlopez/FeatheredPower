<?php

use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;
use Dompdf\Options;

require "../vendor/autoload.php";

if (isset($_POST)) {
	include('../includes/config/database.php');

	$data = file_get_contents('php://input');
	$dataDecoded = json_decode($data, true);
	$user = $dataDecoded['user'];
	$cart = $dataDecoded['cart'];

	include('pdf.php');

	$options = new Options();
	$options->set('isRemoteEnabled', true);

	$dompdf = new Dompdf($options);

	$dompdf->loadHtml($html);
	$dompdf->render();
	$dompdf->stream('document.pdf', array('Attachment' => 0));
	$pdfOutput = $dompdf->output();

	/* Create a PHPMailer instance */
	$mail = new PHPMailer();

	/* SMTP settings */
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Port = 465;
	$mail->Username = 'featheredpower@gmail.com';
	$mail->Password = 'bsgbrkbkkawdsjih';
	$mail->SMTPSecure = 'ssl';

	/* Mail content settings */
	$mail->setFrom('FeatheredPower');
	$mail->addAddress("{$user['email']}");
	$mail->Subject = 'Detalles de la compra';

	/* Enable HTML */
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';


	$mail->Body = '<html></html>';
	$mail->addStringAttachment($pdfOutput, 'document.pdf');

	/* Send email */
	if ($mail->send()) {
		header('location: /cart.php?result=1');
	} else {
		header('location: /cart.php?result=2');
	}

	$mail->ClearAddresses();
}
