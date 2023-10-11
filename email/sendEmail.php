<?php

use PHPMailer\PHPMailer\PHPMailer;
/* use Dompdf\Dompdf;
use Dompdf\Options; */

require "../vendor/autoload.php";

if (isset($_POST)) {
	include('../includes/config/database.php');

	$userId = $_POST['userId'];
	$query = "SELECT * FROM users WHERE id = '$userId'";
	$result = mysqli_query($db, $query);
	$user = mysqli_fetch_assoc($result);

	$query = "SELECT * FROM cart WHERE userId = '$userId'";
	$result = mysqli_query($db, $query);

	/* $data = file_get_contents('php://input');
	$dataDecoded = json_decode($data, true);
	$user = $dataDecoded['user'];
	$cart = $dataDecoded['cart']; */

	/* include('pdf.php');


	$options = new Options();
	$options->set('isRemoteEnabled', true);

	$dompdf = new Dompdf($options);

	$dompdf->loadHtml($html);
	$dompdf->render();
	$dompdf->stream('document.pdf', array('Attachment' => 0));
	$pdfOutput = $dompdf->output(); */

	/* --------------- Create a pdf --------------- */
	require 'fpdf/fpdf.php';

	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->Image('../img/logo.png', 10, 8, 33);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->setFillColor(30, 30, 30);
	$pdf->Cell(0, 10, "FeatheredPower", 0, 1, 'C', 1);

	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial', 'B', 10);

	$pdf->Cell(100, 7, "Producto", 1, 0, 'L', 0);
	$pdf->Cell(20, 7, "Cantidad", 1, 0, 'L', 0);
	$pdf->Cell(35, 7, "Precio", 1, 0, 'L', 0);
	$pdf->Cell(34.8, 7, "Subtotal", 1, 1, 'L', 0);

	//$pdf->Cell('w','h','txt','border','ln','align','fill','link')

	while ($product = mysqli_fetch_assoc($result)) {
		$image = "../productsImg/{$product['productImage']}";
		$productImage = "data:image/png;base64," . base64_encode(file_get_contents($image));

		$subtotal = $product['productPrice'] * $product['amount'];

		$pdf->Cell(100, 7, $product['productName'], 1, 0, 'L', 0);
		$pdf->Cell(20, 7, $product['amount'], 1, 0, 'L', 0);
		$pdf->Cell(35, 7, $product['productPrice'], 1, 0, 'L', 0);
		$pdf->Cell(34.8, 7, $subtotal, 1, 1, 'L', 0);
	}

	$pdfdoc = $pdf->Output('S', '');

	/* --------------- Save pdf in WebDav --------------- */
	// $pdf->Output('F', 'pdfs/cosa.pdf');

	/* --------------- Create a PHPMailer instance --------------- */
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
	//$mail->addStringAttachment($pdfOutput, 'document.pdf');
	$mail->addStringAttachment($pdfdoc, 'document.pdf');

	/* Send email */
	if ($mail->send()) {
		header('location: /cart.php?result=1');
	} else {
		header('location: /cart.php?result=2');
	}
	$mail->ClearAddresses();
}
