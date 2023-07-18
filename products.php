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

$activeCategory = 'Transformadores';
$type = 'transformer';

if (isset($_GET['category'])) {
	$activeCategory = $_GET['category'];
	switch ($activeCategory) {
		case 'Transformadores':
			$type = 'transformer';
			break;
		case 'Tableros':
			$type = 'panelboard';
			break;
		case 'Equipos de proteccion':
			$type = 'protection';
			break;
		case 'Gabinetes':
			$type = 'gabinet';
			break;
	}
}
?>

<?php
$actual = 'products';
$actualRoot = './';
include('includes/templates/header.php');
?>


	<form class="categories-navigation" method="GET">
		<input class="product-category <?php if ($activeCategory === 'Transformadores') {
																			echo 'category-selected';
																		} ?>" type="submit" name="category" value="Transformadores">
		<input class="product-category <?php if ($activeCategory === 'Tableros') {
																			echo 'category-selected';
																		} ?>" type="submit" name="category" value="Tableros">
		<input class="product-category <?php if ($activeCategory === 'Equipos de proteccion') {
																			echo 'category-selected';
																		} ?>" type="submit" name="category" value="Equipos de proteccion">
		<input class="product-category <?php if ($activeCategory === 'Gabinetes') {
																			echo 'category-selected';
																		} ?>" type="submit" name="category" value="Gabinetes">
	</form>

	<div class="products-container">
		<?php
		$query = "SELECT * FROM products WHERE type = '$type'";
		$result = mysqli_query($db, $query);

		while ($row = mysqli_fetch_assoc($result)) :
		?>
			<div class="product-card card">
				<div class="product-image">
					<img src="/productsImg/<?php echo $row['image'] ?>" alt="product image">
				</div>

				<div class="product-content">
					<div class="product-info">
						<h3><?php echo $row['name'] ?></h3>
						<p><?php echo $row['description'] ?></p>
						<h3><?php echo "$ " . $row['price'] ?></h3>
					</div>

					<div class="product-actions">
						<a href="product.php?id=<?php echo $row['id'] ?>" class="button blue-button">Ver producto</a>
						<?php if ($login) : ?>
							<?php if ($rol != 'admin') : ?>
								<form class="add-to-cart-form" method="POST">
									<input type="hidden" name="productId" value="<?php echo $row['id'] ?>">
									<button class="button red-button add-to-cart-btn">Agregar al carrito</button>
								</form>
							<?php endif ?>
						<?php endif ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>


<?php include('includes/templates/footer.php'); ?>