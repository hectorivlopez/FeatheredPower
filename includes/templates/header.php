<!-- --------------- Start session --------------- -->
<?php
$webdavRoute = 'http://10.0.0.5/';
$rol = 'visitor';

if (!isset($_SESSION)) {
	session_start();
}

$login = isset($_SESSION['login']);

if ($login) {
	$rol = $_SESSION['rol'];
	$actualUser = $_SESSION['user'];
	$initials = strtoupper($actualUser['firstName'][0] . $actualUser['lastName'][0]);

	include($actualRoot . 'includes/config/database.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>FeatheredPower</title>
	<link rel="shortcut icon" href="./img/logo-icon.png">

	<link rel="preload" href="/styles/normalize.css" as="style">
	<link rel="stylesheet" href="/styles/normalize.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="/styles/global.css">
	<link rel="stylesheet" href=<?php echo '/styles/' . $actual . '.css' ?>>
</head>

<body>
	<header>
		<!-- ------------------------------ Navbar ------------------------------ -->
		<nav class="navbar container">
			<a class="logo" href="/index.php">
				<img src="/img/logo.png" alt="Logo image">
				<span>Feathered</span>Power
			</a>
			<!-- -------------------- Navigation -------------------- -->
			<div class="navigation">
				<?php if ($login and $rol === 'admin') : ?>
					<a href="/admin">Admin</a>
				<?php endif ?>

				<a href="/index.php">Inicio</a>
				<a href="/products.php">Productos</a>
				<a href="/location.php">Ubicación</a>

				<div class="account-image account-button <?php echo $rol . '-user' ?>">
					<?php if (!$login) : ?>
						<img src="/img/user-icon.png" alt="profile image">
					<?php endif ?>
					<?php if ($login) : ?>
						<p><?php echo $initials ?></p>

						<!-- ---------- Cambiar ---------- -->
						<?php if ($rol != 'admin') :
							$userId = $actualUser['id'];
							$query = "SELECT * FROM cart WHERE userId = '$userId' ";
							$result = mysqli_query($db, $query);
							if ($cart = mysqli_fetch_assoc($result)) :
						?>
								<div class="account-notf"></div>
							<?php endif ?>
						<?php endif ?>
					<?php endif ?>
				</div>

			</div> <!-- ---------- .Navigation ---------- -->

			<!-- ---------- .Mobile Navigation ---------- -->
			<div class="toggle closed-menu"></div>
			<div class="menu">
				<?php if (!$login) : ?>
					<a class="text-gradient login-link" href="/login.php">Iniciar sesión</a>
					<a href="/signup.php">Registrarse</a>
				<?php endif ?>
				<a href="/index.php">Inicio</a>
				<a href="/products.php">Productos</a>
				<a href="/location.php">Ubicación</a>
				<?php if ($login) : ?>
					<a href="/cart.php">Carrito</a>
					<a href="<?php echo $webdavRoute ?>">Mis Pedidos</a>
					<a href="/logout.php">Cerrar sesión</a>
				<?php endif ?>
			</div>
		</nav> <!-- ---------- .Navbar ---------- -->
		<!-- -------------------- Account menu -------------------- -->
		<div class="account-menu-container container">
			<div class="account-menu">
				<?php if (!$login) : ?>
					<a class="login-link" href="/login.php">Iniciar Sesión</a>
					<a href="/signup.php">Registrarse</a>
				<?php endif ?>

				<?php if ($login) : ?>
					<div class="profile-detail">
						<div class="account-image <?php echo $rol . '-user' ?>">
							<!-- <img src="/img/user-icon.png" alt=""> -->
							<p><?php echo $initials ?></p>
						</div>
						<div class="profile-info">
							<h4 class="profile-name"><?php echo $actualUser['firstName'] . ' ' . $actualUser['lastName'] ?></h4>
							<p class="profile-email"><?php echo $actualUser['email'] ?></p>
						</div>
					</div>


					<?php if ($rol != 'admin') :
						$userId = $actualUser['id'];
						$query = "SELECT * FROM cart WHERE userId = '$userId'";
						$result = mysqli_query($db, $query);
						$productsInCart = 0;
						while ($row = mysqli_fetch_assoc($result)) {
							$productsInCart++;
						}
					?>
						<div class="cart-link">
							<a href="/cart.php" class="cart-link">Carrito</a>
							<?php if ($productsInCart > 0) : ?>
								<p class="cart-notf"><?php echo $productsInCart ?></p>
							<?php endif ?>
						</div>
						<!-- <a href="<?php echo $webdavRoute ?>?cosa=3">Mis pedidos</a> -->

						<form action="<?php echo $webdavRoute ?>" method="GET">
							<input type="hidden" name="id" value="<?php echo $actualUser['id'] ?>">
							<input type="hidden" name="firstName" value="<?php echo $actualUser['firstName'] ?>">
							<input type="hidden" name="lastName" value="<?php echo $actualUser['lastName'] ?>">
							<input type="hidden" name="email" value="<?php echo $actualUser['email'] ?>">
							<input type="submit" value="Mis Pedidos">
						</form>

						<!-- <a href="<?php echo $webdavRoute ?>">Mis Pedidos</a> -->
					<?php endif ?>
					<a href="/logout.php" class="logout">Cerrar Sesión</a>
				<?php endif ?>
			</div>
		</div> <!-- ---------- .Account menu ---------- -->

		<!-- ------------------------------ Hero ------------------------------ -->
		<?php if ($actual === 'home') : ?>
			<section>
				<div class="hero container">
					<div class="hero-content">
						<h1>
							Los Mejores <br /><span class="text-gradient">Equipos Eléctricos</span><br /> Al Mejor Precio
						</h1>
						<p>Con FeatheredPower obtenga los equipos eléctricos de la mejor calidad necesarios para su
							instalación</p>
					</div>

					<div class="hero-image">
						<img src="./img/panelboard2.png" alt="">
					</div>
				</div>
			</section>
		<?php endif ?>

	</header>

	<div class="content-wrapper">