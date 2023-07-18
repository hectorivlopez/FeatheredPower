<?php
session_start();
/* -------------------- Protect admin section -------------------- */
$auth = $_SESSION['login'];
if (!$auth or $_SESSION['rol'] != 'admin') {
	header('location: /');
}
?>

<?php
$actual = 'admin';
$actualRoot = '../';
include('../includes/templates/header.php');
?>

<main class="container">
	<h2 class="heading">Administrador</h2>

	<div class="items">
		<a class="item card" href="/admin/users">
			<div class="item-image">
				<img src="/img/user-icon.png" alt="">
			</div>
			<h3>Usuarios</h3>
		</a>
		<a class="item card" href="/admin/products">
			<div class="item-image">
				<img src="/img/product-icon.png" alt="">
			</div>
			<h3>Productos</h3>
		</a>
	</div>
</main>

<?php include('../includes/templates/footer.php'); ?>