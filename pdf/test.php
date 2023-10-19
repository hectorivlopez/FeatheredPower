<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	shell_exec("bash ./savePdfScript.sh");
	echo "Si";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form method="POST">
		<Button>Mandar</Button>
	</form>
</body>
</html>