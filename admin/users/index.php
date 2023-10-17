<?php
session_start();
/* -------------------- Protect admin section -------------------- */
$auth = $_SESSION['login'];
if (!$auth or $_SESSION['rol'] != 'admin') {
	header('location: /');
}

/* -------------------- Delete user -------------------- */
include('../../includes/config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];

	if ($id) {
		$query = "DELETE FROM users WHERE id = '$id'";
		$result = mysqli_query($db, $query);

		if ($result) {
			header('location: /admin/users?result=3');
		}
	}
}

$search = $_GET['search'] ?? null;
?>

<?php
$actual = 'adminShow';
$actualRoot = '../../';
include('../../includes/templates/header.php');
?>

<main class="container">
	<h2 class="heading">Usuarios</h2>

	<div class="actions">
		<a href="/admin" class="button blue-button">Volver</a>

		<div class="data-actions">
			<form class="search" action="/admin/users/read.php" method="GET">
				<input type="text" name="search" value="<?php echo $search ? $search : '' ?>" placeholder="Buscar" required>
				<button type="submit"><img src="/img/search-icon.svg" alt=""></button>
			</form>

			<div class="create">
				<a href="/admin/users/create.php" class="button green-button">Agregar usuario</a>
			</div>
		</div>
	</div>

	<?php
	$result = $_GET['result'] ?? null;
	$updated = $_GET['updated'] ?? null;

	if ($result == 1) :
	?>
		<h4 class="alert">
			Usuario Agregado Correctanemte
		</h4>
	<?php endif ?>

	<?php if ($result == 2) : ?>
		<h4 class="alert">
			Usuario Editado Correctanemte
		</h4>

	<?php endif ?>
	<?php if ($result == 3) : ?>
		<h4 class="alert">
			Usuario Eliminado Correctanemte
		</h4>
	<?php endif ?>

	<?php if ($result == 4) : ?>
		<h4 class="alert error-alert">
			No se encontró el usuario
		</h4>
	<?php endif ?>

	<table class="items">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Compañía</th>
				<th>Correo</th>
				<th>Contraseña</th>
				<th>Pedidos</th>
			</tr>
		</thead>

		<tbody>
			<?php
			$result = mysqli_query($db, "SELECT * FROM users");

			while ($row = mysqli_fetch_assoc($result)) : ?>
				<tr class="<?php echo $updated == $row['id'] ? 'updated' : '' ?>">
					<td><?php echo $row['id'] ?></td>
					<td><?php echo $row['firstName'] ?></td>
					<td><?php echo $row['lastName'] ?></td>
					<td><?php echo $row['company'] ?></td>
					<td><?php echo $row['email'] ?></td>
					<td><?php echo $row['pass'] ?></td>
					<td><?php echo $row['orders'] ?></td>
					<td>
						<div class=" item-actions">
							<button type="button" class="button red-button" onclick="deleteAlert(<?php echo $row['id'] ?>)">Eliminar</button>
							<a class="button" href="/admin/users/update.php?id=<?php echo $row['id'] ?>">Editar</a>
						</div>
					</td>
				</tr>
			<?php endwhile ?>
		</tbody>
	</table>

	<form class="delete-alert card hidden" method="POST">
		<h3 id="delete-alert-heading">¿Eliminar Producto</h3>
		<div class="del-actions">
			<button type="button" class="button" onclick="deleteAlert()">Cancelar</button>
			<button type="submit" class="button red-button">Eliminar</button>
		</div>
	</form>
</main>

<?php include('../../includes/templates/footer.php'); ?>