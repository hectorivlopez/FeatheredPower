<!-- --------------- Start session --------------- -->
<?php
$rootRoute = '';
$webdavRoute = './';
$rol = 'visitor';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$initials = strtoupper($firstName[0] . $lastName[0]);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>FeatherPower</title>
	<link rel="shortcut icon" href="./img/logo-icon.png">

	<link rel="preload" href="/styles/normalize.css" as="style">
	<link rel="stylesheet" href="/styles/normalize.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="./global.css">
</head>

<body>
	<header>
		<!-- ------------------------------ Navbar ------------------------------ -->
		<nav class="navbar container">
			<a class="logo" href="<?php echo $rootRoute ?>/">
				<img src="/img/logo.png" alt="Logo image">
				<span>Feathered</span>Power
			</a>
			<!-- -------------------- Navigation -------------------- -->
			<div class="navigation">
				<a href="<?php echo $rootRoute ?>/">Inicio</a>
				<a href="<?php echo $rootRoute ?>/products.php">Productos</a>
				<a href="<?php echo $rootRoute ?>/location.php">Ubicación</a>

				<div class="account-image account-button <?php echo $rol . '-user' ?>">
					<p><?php echo $initials ?></p>
				</div>
			</div> <!-- ---------- .Navigation ---------- -->

			<!-- ---------- .Mobile Navigation ---------- -->
			<div class="toggle closed-menu"></div>
			<div class="menu">
				<a href="<?php echo $rootRoute ?>/">Inicio</a>
				<a href="<?php echo $rootRoute ?>/products.php">Productos</a>
				<a href="<?php echo $rootRoute ?>/location.php">Ubicación</a>
				<a href="<?php echo $rootRoute ?>/cart.php">Carrito</a>
				<a href="<?php echo $webdavRoute ?>">Mis Pedidos</a>
				<a href="<?php echo $rootRoute ?>/logout.php">Cerrar sesión</a>
			</div>
		</nav> <!-- ---------- .Navbar ---------- -->
		<!-- -------------------- Account menu -------------------- -->
		<div class="account-menu-container container">
			<div class="account-menu">
				<div class="profile-detail">
					<div class="account-image visitor-user">
						<p><?php echo $initials ?></p>
					</div>
					<div class="profile-info">
						<h4 class="profile-name"><?php echo $firstName . ' ' . $lastName ?></h4>
						<p class="profile-email"><?php echo $email ?></p>
					</div>
				</div>

				<div class="cart-link">
					<a href="<?php echo $rootRoute ?>/cart.php" class="cart-link">Carrito</a>
				</div>
				<!-- <a href="<?php echo $webdavRoute ?>">Mis Pedidos</a> -->
				<a href="<?php echo $rootRoute ?>/logout.php" class="logout">Cerrar Sesión</a>
			</div>
		</div> <!-- ---------- .Account menu ---------- -->
	</header>

	<div class="content-wrapper">
		<!-- Content -->
	</div>

	<footer>
		<div class="footer-section">
			<div class="footer-field">
				<a class="media-link"><img class="icon" src="/img/instagram-icon.png" alt="Instagram icon"> featherpower</a>
				<a class="media-link"><img class="icon" src="/img/facebook-icon.png" alt="Facebook icon"> FeatherPower</a>
				<a class="media-link"><img class="icon" src="/img/linkedin-icon.png" alt="Linkedin icon"> featherpower</a>
			</div>
		</div>
		<div class="footer-section">
			<div class="footer-field">
				<div class="media-link"><img class="icon" src="/img/email-icon.png" alt="Email-icon">featherpower@quetzal.com
				</div>
				<div class="media-link"><img class="icon" src="/img/phone-icon.png" alt="Phone icon">3314891645</div>
				<div class="media-link"><img class="icon" src="/img/phone-icon.png" alt="Phone icon">3336095985</div>
			</div>
		</div>
		<div class="footer-section">
			<div class="footer-field">
				<div class="media-link"><img class="icon" src="/img/location-icon.png" alt="Location icon">Guadalajara, México
				</div>
				<div class="media-link"><img class="icon" src="/img/location-icon.png" alt="Location icon">Río de Janeiro,
					Brasil
				</div>
				<div class="media-link"><img class="icon" src="/img/location-icon.png" alt="Location icon">Medellín, Colombia
				</div>
			</div>
		</div>
	</footer>
	<script src="/js/app.js"></script>
	<script src="/js/data.js"></script>
</body>

</html>