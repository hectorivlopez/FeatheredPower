<?php
session_start();
/* -------------------- Protect admin section -------------------- */
$auth = $_SESSION['login'];
if (!$auth or $_SESSION['rol'] != 'admin') {
	header('location: /');
}

/* -------------------- Create user -------------------- */
include('../../includes/config/database.php');

$firstName = '';
$lastName = '';
$company = '';
$email = '';
$pass = '';
$confPass = '';

$errors = [];
$wrongInputs = [];

if (isset($_POST['submit'])) {
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$company = $_POST['company'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$confPass = $_POST['confPass'];

	$filledInfo = true;

	if (empty($firstName)) {
		$filledInfo = false;
		$wrongInputs[] = 'firstName';
	}
	if (empty($lastName)) {
		$filledInfo = false;
		$wrongInputs[] = 'lastName';
	}
	if (empty($email)) {
		$filledInfo = false;
		$wrongInputs[] = 'email';
	}
	if (empty($pass)) {
		$filledInfo = false;
		$wrongInputs[] = 'pass';
	}
	if (empty($confPass)) {
		$filledInfo = false;
		$wrongInputs[] = 'confPass';
	}

	if (!$filledInfo) {
		$errors[] = 'Campos vacíos';
	}

	if ($pass !== $confPass) {
		$errors[] = 'Las contraseñas deben ser iguales';
		$wrongInputs[] = 'pass';
		$wrongInputs[] = 'confPass';
	}

	if (empty($errors)) {
		/* ---------- Verify user existnce ---------- */
		$query = "SELECT email FROM users WHERE email = '$email'";
		$result = mysqli_query($db, $query);

		if ($user = mysqli_fetch_assoc($result)) {
			$errors[] = 'Correo ya registrado';
			$wrongInputs[] = 'email';
		} else {
			/* ---------- SQL Query ---------- */
			$query = "INSERT INTO users (firstName, lastName, company, email, pass, orders) VALUES('$firstName', '$lastName', '$company', '$email', '$pass', 0)";
			$result = mysqli_query($db, $query);

			$query = "SELECT MAX(id) FROM users";
			$idResult = mysqli_query($db, $query);
			$lastId = mysqli_fetch_assoc($idResult);

			if ($result) {
				header("location: /admin/users?result=1&updated={$lastId['MAX(id)']}");
			}
		}
	}
}
?>

<?php
$actual = 'signup';
$actualRoot = '../../';
include('../../includes/templates/header.php');
?>
<div class="actions container">
	<a href="/admin/products" class="button blue-button">Volver</a>
</div>

<form class="signup-form" method="POST">
	<div class="logo-signup">
		<img src="./img/logo.png" alt="">
	</div>

	<h3>Crea una cuenta</h3>

	<?php foreach ($errors as $error) : ?>
		<h4 class="form-alert"><?php echo $error ?></h4>
	<?php endforeach ?>

	<div class="signup-fields">
		<div class="section-fields">
			<div class="field <?php echo in_array('firstName', $wrongInputs) ? 'wrong-input' : '' ?>">
				<label>Nombre</label>
				<input type="text" name="firstName" value="<?php echo $firstName ?>" tabindex="1">
			</div>

			<div class="field <?php echo in_array('lastName', $wrongInputs) ? 'wrong-input' : '' ?>">
				<label>Apellido</label>
				<input type="text" name="lastName" value="<?php echo $lastName ?>" tabindex="2">
			</div>

			<div class="field">
				<label>Compañia (opcional)</label>
				<input type="text" name="company" value="<?php echo $company ?>" tabindex="3">
			</div>
		</div>

		<div class="section-fields">
			<div class="field <?php echo in_array('email', $wrongInputs) ? 'wrong-input' : '' ?>">
				<label>Correo electrónico</label>
				<input type="text" name="email" value="<?php echo $email ?>" tabindex="4">
			</div>

			<div class="field <?php echo in_array('pass', $wrongInputs) ? 'wrong-input' : '' ?>">
				<label>Contraseña</label>
				<input type="password" name="pass" value="<?php echo $pass ?>" tabindex="5">
			</div>

			<div class="field <?php echo in_array('confPass', $wrongInputs) ? 'wrong-input' : '' ?>">
				<label>Confirmar contraseña</label>
				<input type="password" name="confPass" value="<?php echo $confPass ?>" tabindex="6">
			</div>
		</div>
	</div>

	<div class="field">
		<button class="button blue-button" type="submit" name="submit" tabindex="3">Continuar</button>
	</div>
</form>

<?php include('../../includes/templates/footer.php'); ?>