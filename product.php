<?php
session_start();
/* -------------------- Add to cart -------------------- */
include('includes/config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($_SESSION['rol'] != 'admin') {

		$productId = $_POST['productId'];
		$query = "SELECT * FROM products WHERE id = '$productId'";
		$result = mysqli_query($db, $query);
		$product = mysqli_fetch_assoc($result);

		$user = $_SESSION['user'];
		$userId = $user['id'];

		$productName = $product['name'];
		$productDescription = $product['description'];
		$productPrice = $product['price'];
		$productImage = $product['image'];
		$productSpecs = $product['specs'];

		/* ---------- Increase product in cart amount ---------- */
		$query = "SELECT * FROM cart WHERE userId = '$userId'";
		$result = mysqli_query($db, $query);

		$added = false;
		while ($row = mysqli_fetch_assoc($result)) {
			if ($row['productId'] === $productId) {
				$id = $row['id'];
				$amount = $row['amount'] + 1;
				$query = "UPDATE cart SET amount = $amount WHERE id = '$id'";
				$result = mysqli_query($db, $query);
				$added = true;
				break;
			}
		}

		/* ---------- Create a row in cart ---------- */
		if (!$added) {
			/* ---------- SQL Query ---------- */
			$query = "INSERT INTO cart (id, userId, productId, productName, productDescription, productSpecs, productPrice, productImage, amount ) VALUES(0, '$userId', '$productId', '$productName', '$productDescription', '$productSpecs', '$productPrice', '$productImage', 1)";
			$result = mysqli_query($db, $query);
		}
	}
}

?>

<?php
$actual = 'read';
$actualRoot = './';
include('includes/templates/header.php')
?>

<?php
/* -------------------- Search the product -------------------- */
$id = $_GET['id'];
$query = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($db, $query);

if ($product = mysqli_fetch_assoc($result)) : ?>
	<div class="product card">
		<h3><?php echo $product['name'] ?></h3>

		<div class="product-info">
			<div class="product-img">
				<img src="/productsImg/<?php echo $product['image'] ?>" alt="product image">
			</div>

			<div class="product-details">
				<p>Descripción: <?php echo $product['description'] ?></p>
				<p>Especificaciones: <?php echo $product['specs'] ?></p>
				<p>Precio: $ <?php echo $product['price'] ?></p>

			</div>
		</div>

		<div class="actions">
			<?php if ($login and $rol != 'admin') : ?>
				<form class="add-to-cart-form" method="POST">
					<input type="hidden" name="productId" value="<?php echo $id ?>">
					<button type="submit" class="button green-button add-to-cart-btn">Agregar al carrito</button>
				</form>
			<?php endif ?>
		</div>
	</div>
<?php endif ?>


<?php include('includes/templates/footer.php') ?>