<?php
session_start();
/* -------------------- Protect admin section -------------------- */
$auth = $_SESSION['login'];
if (!$auth or $_SESSION['rol'] != 'admin') {
	header('location: /');
}
?>

<?php
/* -------------------- Delete user -------------------- */
include('../../includes/config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];
	/* ---------- SQL Query ---------- */
	$query = "DELETE FROM users WHERE id = '$id'";
	$result = mysqli_query($db, $query);

	if ($result) {
		header('location: /admin/users&result=3');
	}
}
?>

<?php
$actual = 'read';
$actualRoot = '../../';
include('../../includes/templates/header.php');
?>

<?php
/* -------------------- Search the product -------------------- */
$search = $_GET['search'];
$query = "SELECT * FROM users WHERE id = '$search' or email = '$search'";
$result = mysqli_query($db, $query);

if ($target = mysqli_fetch_assoc($result)) { ?>
	<div class="product card">
		<h3><?php echo $target['firstName'] . ' ' . $target['lastName'] ?></h3>

		<div class="product-info">
			<div class="product-img">
				<img src="/img/user-icon.png" alt="product image">
			</div>

			<div class="product-details">
				<p>ID: <?php echo $target['id'] ?></p>
				<p>Nombre: <?php echo $target['firstName'] ?></p>
				<p>Apellido: <?php echo $target['lastName'] ?></p>
				<p>Compañia: <?php echo $target['company'] ?></p>
				<p>Correo: <?php echo $target['email'] ?></p>
			</div>
		</div>

		<div class="actions">
			<a class="button edit-button" href="/admin/users/update.php?id=<?php echo $target['id'] ?>">Editar</a>

			<form class="delete-form" method="POST">
				<input type="hidden" name="id" value="<?php echo $target['id'] ?>">
				<input class="button delete-button" type="submit" value="Eliminar">
			</form>
		</div>
	</div>
<?php 
} else {
	header("location: /admin/users/?result=4&search={$search}");
}
?>

<?php include('../../includes/templates/footer.php') ?>