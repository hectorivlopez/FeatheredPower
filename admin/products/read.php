<?php
session_start();
/* -------------------- Protect admin section -------------------- */
$auth = $_SESSION['login'];
if (!$auth or $_SESSION['rol'] != 'admin') {
	header('location: /');
}
?>

<?php
/* -------------------- Delete product -------------------- */
include('../../includes/config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];

	if ($id) {
		$query = "SELECT image FROM products WHERE id = '$id'";
		$result = mysqli_query($db, $query);
		$product = mysqli_fetch_assoc($result);
		/* Delete the product image from the images folder */
		unlink('../../productsImg/' . $product['image']);
		
		/* ---------- SQL Query ---------- */
		$query = "DELETE FROM products WHERE id = '$id'";
		$result = mysqli_query($db, $query);

		if ($result) {
			header('location: /admin/products&result=3');
		}
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
$query = "SELECT * FROM products WHERE id = '$search' or name = '$search'";
$result = mysqli_query($db, $query);

if ($target = mysqli_fetch_assoc($result)) { ?>
	<div class="product card">
		<h3><?php echo $target['name'] ?></h3>

		<div class="product-info">
			<div class="product-img">
				<img src="/productsImg/<?php echo $target['image'] ?>" alt="product image">
			</div>

			<div class="product-details">
				<p>ID: <?php echo $target['id'] ?></p>
				<p>Descripción: <?php echo $target['description'] ?></p>
				<p>Tipo: <?php echo $target['type'] ?></p>
				<p>Especificaciones: <?php echo $target['specs'] ?></p>
				<p>Precio: <?php echo $target['price'] ?></p>
				<p>Stock: <?php echo $target['stock'] ?></p>
			</div>
		</div>

		<div class="actions">
			<a class="button" href="/admin/products/update.php?id=<?php echo $target['id'] ?>">Editar</a>
			
			<form class="delete-form" method="POST">
				<input type="hidden" name="id" value="<?php echo $target['id'] ?>">
				<button class="button red-button" type="submit">Eliminar</button>
			</form>
		</div>
	</div>
<?php 
} else {
	header("location: /admin/products/?result=4&search={$search}");
}
?>


<?php include('../../includes/templates/footer.php') ?>