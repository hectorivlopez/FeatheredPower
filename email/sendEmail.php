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


	/* --------------- Create a pdf using DomPDF --------------- */
	/* include('pdf.php');

	$options = new Options();
	$options->set('isRemoteEnabled', true);

	$dompdf = new Dompdf($options);

	$dompdf->loadHtml($html);
	$dompdf->render();
	$dompdf->stream('document.pdf', array('Attachment' => 0));
	$pdfOutput = $dompdf->output(); */

	/* --------------- Create a pdf using FPDF --------------- */
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

	/* --------------- Save pdf in WebDAV --------------- */

	// ----- Using FTP as an intermediary -----
	// Generate unique pdf name
	date_default_timezone_set('America/Mexico_City');
	$pdfFolder = __DIR__ . '/pdfs/';
	$pdfName = 'id' .  $userId . '_' . $user['orders'] . '_' . date('d-m-Y') . '_' . date('h-i-s') . '.pdf';

	// Save pdf in folder
	$pdf->Output('F', $pdfFolder . $pdfName);

	/* // Parameters
	$httpFileURL = '' . $pdfName; 
	$ftpServer = '';
	$ftpUser = 'user1';
	$ftpPassword = '12';
	$webdavServerURL = '';
	$webdavUser = 'hector';
	$webdavPassword = '12';
	$destinationFilename = $pdfName; 
 */
	/* // Method 1
	// Initialize cURL
	$ch = curl_init();

	// Set cURL options
	curl_setopt($ch, CURLOPT_URL, $httpFileURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$ftpUser:$ftpPassword");
	curl_setopt($ch, CURLOPT_UPLOAD, 1);
	curl_setopt($ch, CURLOPT_INFILE, fopen($httpFileURL, 'rb'));
	curl_setopt($ch, CURLOPT_INFILESIZE, filesize($httpFileURL));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_URL, $ftpServer . $destinationFilename);

	// Execute cURL request
	$result = curl_exec($ch);

	// Close cURL session
	curl_close($ch);

	if ($result === false) {
		echo 'File transfer failed: ' . curl_error($ch);
	} else {
		echo 'File transferred successfully.';

		// Notify the WebDAV server to move the file
		$ch2 = curl_init();
		$webdavMoveURL = $webdavServerURL . $destinationFilename;
		curl_setopt($ch2, CURLOPT_URL, $webdavMoveURL);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'MOVE');
		curl_setopt($ch2, CURLOPT_POSTFIELDS, '');

		// WebDAV server authentication 
		curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch2, CURLOPT_USERPWD, "$webdavUser:$webdavPassword");

		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch2);
		curl_close($ch2);

		if ($response === false) {
			echo 'WebDAV server move request failed: ' . curl_error($ch2);
		} else {
			echo 'File moved to WebDAV server successfully.';
		}
	} */

	/* // Method 2
	// Establish an FTP connection
	$ftpConnection = ftp_connect($ftpServer);

	// Log in to the FTP server
	if (ftp_login($ftpConnection, $ftpUser, $ftpPassword)) {
		$localFile = $pdfFolder . $pdfName;

		// Upload the file to the FTP server
		if (ftp_put($ftpConnection, $destinationFilename, $localFile, FTP_BINARY)) {
			// Notify the WebDAV server to move the file
			$webdavMoveURL = $webdavServerURL . $destinationFilename;
			file_get_contents($webdavMoveURL, false, stream_context_create([
				'http' => [
					'method' => 'MOVE',
					'header' => 'Destination: ' . $webdavMoveURL,
				]
			]));

			echo 'File transferred and moved successfully.';
		} else {
			echo 'FTP file upload failed.';
		}

		// Close the FTP connection
		ftp_close($ftpConnection);
	} else {
		echo 'FTP login failed.';
	}

	exit; */

	// ----- Saving directly in WebDAV -----
	// Initialize cURL session
	$localFilePath = $pdfFolder . $pdfName; 
	$webdavServerURL = "http://10.0.0.5/pdfs/$pdfName"; 
	$username = 'hector';
	$password = '12';

	// Initialize cURL session
	$ch = curl_init();

	// Set cURL options
	curl_setopt($ch, CURLOPT_URL, $webdavServerURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_UPLOAD, 1);
	curl_setopt($ch, CURLOPT_INFILE, fopen($localFilePath, 'rb'));
	curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localFilePath));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

	// Execute cURL request
	$result = curl_exec($ch);

	// Check for errors
	if ($result === false) {
		echo 'cURL error: ' . curl_error($ch);
	} else {
		echo 'File uploaded or overwritten successfully.';
	}

	// Close cURL session
	curl_close($ch);
	
	unlink($pdfFolder . $pdfName);

	// Increment user orders 
	$orders = $user['orders'] + 1;
	$query = "UPDATE users SET orders = '$orders' WHERE id = '$userId'";
	$result = mysqli_query($db, $query);

	header('location: /cart.php?result=1');


	/* --------------- Send email using PHPMailer --------------- */
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
}
