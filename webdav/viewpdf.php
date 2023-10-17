<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$pdf = $_GET['pdf'];

	header("Content-type: application/pdf");
	header("Content-Disposition: inline; filename={$pdf}");
	@readfile('./pdfs/' . $pdf);
}