<?php
/* -------------------- Log in -------------------- */
include('includes/config/database.php');

$email = '';
$pass = '';

if (isset($_GET['email'])) {
	$email = $_GET['email'];
}

$errors = [];
$wrongInputs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = $_POST['email'];
	$pass = $_POST['pass'];

	$filledInfo = true;

	if (empty($email)) {
		$filledInfo = false;
		$wrongInputs[] = 'email';
	}
	if (empty($pass)) {
		$filledInfo = false;
		$wrongInputs[] = 'pass';
	}

	if (!$filledInfo) {
		$errors[] = 'Campos vacíos';
	}

	if (empty($errors)) {
		/* ---------- SQL Query admins ---------- */
		$query = "SELECT * FROM admins WHERE email = '$email' AND pass = '$pass'";
		$result = mysqli_query($db, $query);

		if ($admin = mysqli_fetch_assoc($result)) {
			session_start();
			$_SESSION['user'] = $admin;
			$_SESSION['rol'] = 'admin';
			$_SESSION['login'] = true;

			header('location: /admin');
		} else {
			/* ---------- SQL Query users ---------- */
			$query = "SELECT * FROM users WHERE email = '$email' AND pass = '$pass'";
			$result = mysqli_query($db, $query);

			if ($user = mysqli_fetch_assoc($result)) {
				session_start();
				$_SESSION['user'] = $user;
				$_SESSION['rol'] = 'normal';
				$_SESSION['login'] = true;

				header('location: /');
			} else {
				$errors[] = 'Usuario o contraseña incorrectos';
			}
		}
	}
}
?>

<?php
$actual = 'login';
$actualRoot = './';
include('includes/templates/header.php');
?>

<div class="login-content">
	<form class="login-form" method="POST">
		<div class="logo-login">
			<img src="/img/logo.png" alt="">
		</div>

		<h3>Iniciar Sesión</h3>

		<?php foreach ($errors as $error) : ?>
			<h4 class="form-alert"><?php echo $error ?></h4>
		<?php endforeach ?>

		<div class="field <?php echo in_array('email', $wrongInputs) ? 'wrong-input' : '' ?>">
			<label>Correo electrónico</label>
			<input type="email" name="email" value="<?php echo $email ?>" tabindex="1">
		</div>

		<div class="field <?php echo in_array('pass', $wrongInputs) ? 'wrong-input' : '' ?>">
			<label>Contraseña</label>
			<input type="password" name="pass" value="<?php echo $pass ?>" tabindex="2" <?php echo isset($_GET['email']) ? 'autofocus' : '' ?>>
			<a href="#" class="field-text">Olvidé mi contraseña</a>
		</div>

		<div class="field">
			<button class="button blue-button" type="submit" name="submit" tabindex="3">Iniciar sesión</button>
			<p class="field-text">¿No tienes cuenta? <a href="/signup.php" class="field-text">Registrate ahora</a></p>
		</div>
	</form>
</div>

</div>

<script src="/js/app.js"></script>
</body>

</html>