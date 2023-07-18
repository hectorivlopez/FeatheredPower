<?php
session_start();
/* -------------------- Protect admin section -------------------- */
$auth = $_SESSION['login'];
if (!$auth or $_SESSION['rol'] != 'admin') {
	header('location: /');
}

/* -------------------- Prefill the inputs -------------------- */
include('../../includes/config/database.php');

$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($db, $query);

$user = mysqli_fetch_assoc($result);

$firstName = $user['firstName'];
$lastName = $user['lastName'];
$company = $user['company'];
$email = $user['email'];
$pass = $user['pass'];

$errors = [];
$wrongInputs = [];

/* -------------------- Update user -------------------- */
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

	if (empty($errors) && $email !== $user['email']) {
		/* ---------- Verify user existnce ---------- */
		$query = "SELECT email FROM users WHERE email = '$email'";
		$result = mysqli_query($db, $query);

		if ($user = mysqli_fetch_assoc($result)) {
			$errors[] = 'Correo ya registrado';
			$wrongInputs[] = 'email';
		}
	}

	if (empty($errors)) {
		/* ---------- SQL Query ---------- */
		$query = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', company = '$company', email = '$email', pass = '$pass' WHERE id = '$id'";
		$result = mysqli_query($db, $query);

		if ($result) {
			header("location: /admin/users?result=2&updated=$id");
		}
	}
}
?>

<?php
$actual = 'create';
$actualRoot = '../../';
include('../../includes/templates/header.php')
?>

<main class="container">
	<h2 class="heading">Editar Usuario</h2>

	<div class="actions">
		<a href="/admin/users" class="button blue-button">Volver</a>
	</div>

	<form class="create-form card" method="POST">
		<div class="logo-signup">
			<img src="./img/logo.png" alt="">
		</div>

		<h3>ID de Usuario: <?php echo $id ?></h3>

		<?php foreach ($errors as $error) : ?>
			<h4 class="form-alert"><?php echo $error ?></h4>
		<?php endforeach ?>

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
			<input type="password" name="confPass" value="<?php echo $pass ?>" tabindex="6">
		</div>

		<div class="field">
			<button class="button blue-button" type="submit" name="submit" tabindex="3">Continuar</button>
		</div>
	</form>
</main>

<?php include('../../includes/templates/footer.php') ?>