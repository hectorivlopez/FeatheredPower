<?php
session_start();
/* -------------------- Protect admin section -------------------- */
$auth = $_SESSION['login'];
if (!$auth or $_SESSION['rol'] != 'admin') {
	header('location: /');
}

/* -------------------- Delete product -------------------- */
include('../../includes/config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];
	var_dump($_POST);

	if ($id) {
		$query = "SELECT image FROM products WHERE id = '$id'";
		$result = mysqli_query($db, $query);
		$image = mysqli_fetch_assoc($result);

		unlink('../../productsImg/' . $image['image']);
		$query = "DELETE FROM products WHERE id = '$id'";
		$result = mysqli_query($db, $query);

		if ($result) {
			header('location: /admin/products?result=3');
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
	<h2 class="heading">Productos</h2>

	<div class="actions">
		<a href="/admin" class="button blue-button">Volver</a>

		<div class="data-actions">
			<form class="search" action="/admin/products/read.php" method="GET">
				<input type="text" name="search" value="<?php echo $search ? $search : '' ?>" placeholder="Buscar" required>
				<button type="submit"><img src="/img/search-icon.svg" alt=""></button>
			</form>

			<div class="create">
				<a href="/admin/products/create.php" class="button green-button">Agregar producto</a>
			</div>
		</div>
	</div>

	<?php
	$result = $_GET['result'] ?? null;
	$updated = $_GET['updated'] ?? null;

	if ($result == 1) :
	?>
		<h4 class="alert">
			Producto Agregado Correctanemte
		</h4>
	<?php endif ?>

	<?php if ($result == 2) : ?>
		<h4 class="alert">
			Producto Editado Correctanemte
		</h4>
	<?php endif ?>

	<?php if ($result == 3) : ?>
		<h4 class="alert">
			Producto Eliminado Correctanemte
		</h4>
	<?php endif ?>

	<?php if ($result == 4) : ?>
		<h4 class="alert error-alert">
			No se encontró el producto
		</h4>
	<?php endif ?>

	<table class="items">
		<thead>
			<tr>
				<th>ID</th>
				<th>Tipo</th>
				<th>Nombre</th>
				<th>Descripción</th>
				<th>Especificaciones</th>
				<th>Imagen</th>
				<th>Precio</th>
				<th>Stock</th>
				<th>Acciones</th>
			</tr>
		</thead>

		<tbody>
			<?php
			$result = mysqli_query($db, "SELECT * FROM products");

			while ($row = mysqli_fetch_assoc($result)) :
				switch ($row['type']) {
					case 'transformer':
						$type = 'Transformador';
						break;
					case 'gabinet':
						$type = 'Gabinete';
						break;
					case 'panelboard':
						$type = 'Tablero';
						break;
					case 'protection':
						$type = 'Protección';
						break;
				}
			?>
				<tr class="<?php echo $updated == $row['id'] ? 'updated' : '' ?>">
					<td><?php echo $row['id'] ?></td>
					<td><?php echo $type ?></td>
					<td><?php echo $row['name'] ?></td>
					<td><?php echo $row['description'] ?></td>
					<td><?php echo $row['specs'] ?></td>
					<td>
						<div class="product-image">
							<img src="/productsImg/<?php echo $row['image'] ?>" alt="">
						</div>
					</td>
					<td class="table-price">$ <?php echo $row['price'] ?></td>
					<td><?php echo $row['stock'] ?></td>
					<td>
						<div class="item-actions">
							<button type="button" class="button red-button" onclick="deleteAlert(<?php echo $row['id'] ?>)">Eliminar</button>
							<a class="button" href="/admin/products/update.php?id=<?php echo $row['id'] ?>">Editar</a>
						</div>
					</td>
				</tr>
			<?php endwhile ?>
		</tbody>
	</table>

	<form class="delete-alert card hidden" method="POST">
		<h3 id="delete-alert-heading">¿Eliminar Usuario</h3>
		<div class="del-actions">
			<button type="button" class="button" onclick="deleteAlert()">Cancelar</button>
			<button type="submit" class="button red-button">Eliminar</button>
		</div>
	</form>
</main>

<?php include('../../includes/templates/footer.php'); ?>