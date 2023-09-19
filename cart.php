<?php
session_start();
include('includes/config/database.php');

$user = $_SESSION['user'];
$userId = $user['id'];

$payResult = $_GET['result'] ?? null;

if ($payResult == 1) {
	$query = "DELETE FROM cart WHERE userId = '$userId'";
	$result = mysqli_query($db, $query);
}

/* -------------------- Delete product -------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];

	/* ---------- Decrease product in cart amount ---------- */
	$query = "SELECT * FROM cart WHERE id = '$id'";
	$result = mysqli_query($db, $query);
	$product = mysqli_fetch_assoc($result);

	if ($product['amount'] > 1) {
		$amount = $product['amount'] - 1;
		$query = "UPDATE cart SET amount = $amount WHERE id = '$id'";
		$result = mysqli_query($db, $query);
	}
	/* ---------- Delete from the cart ---------- */ else {
		$query = "DELETE FROM cart WHERE id = '$id'";
		$result = mysqli_query($db, $query);
	}
}

$query = "SELECT * FROM cart WHERE userId = '$userId'";
$cartResult = mysqli_query($db, $query);
$total = 0;

/* echo '<pre>';
var_dump(mysqli_fetch_assoc($cartResult));
echo '</pre>'; */

?>

<?php
$actual = 'cart';
$actualRoot = './';
include('includes/templates/header.php');
?>

<div class="cart-container container">
	<?php if (!$payResult) : ?>

		<div class="products-container ">
			<?php

			while ($row = mysqli_fetch_assoc($cartResult)) :
				$productId = $row['productId'];
				$total += ($row['productPrice'] * $row['amount']);
			?>
				<div class="product-card card">
					<div class="product-image">
						<img src="/productsImg/<?php echo $row['productImage'] ?>" alt="">
					</div>

					<div class="product-content">
						<div class="product-info">
							<div class="product-heading">
								<h3><?php echo $row['productName'] ?></h3>

								<?php if ($row['amount'] > 1) : ?>
									<div class="amount">
										<p><?php echo $row['amount'] ?></p>
									</div>
								<?php endif ?>
							</div>

							<p><?php echo $row['productDescription'] ?></p>

							<div class="price">
								<p><?php if ($row['amount'] > 1) {
											echo 'Unidad: ';
										} ?> $ <?php echo $row['productPrice'] ?></p>
								<?php if ($row['amount'] > 1) : ?>
									<p>Total: $ <?php echo $row['productPrice'] * $row['amount'] ?></p>
								<?php endif ?>
							</div>
						</div>

						<div class="product-actions">
							<a href="/product.php?id=<?php echo $productId ?>" class="button blue-button">Ver producto</a>
							<form class="add-to-cart-form" method="POST">
								<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
								<button type="submit" class="button red-button ">Eliminar del carrito</button>
							</form>
						</div>
					</div>
				</div>
			<?php endwhile ?>
		</div>

		<form class="cart-summary" id="cart-summary">
			<h2>Total: $ <?php echo $total ?> </h2>
			<input type="hidden" name="userId" value="<?php echo $userId ?>">
			<button class="button green-button <?php echo !$total ? 'hidden' : '' ?>" id="payCartBtn" type="submit">Proceder al pago</button>
		</form>

	<?php endif ?>

	<?php if ($payResult) : ?>
		<div class="card success-card">
			<h3>Pedido en camino</h3>
			<p>Los detalles de su compra fueron enviados a su correo</p>
			<div class="success-card-actions">
				<a href="/" class="button blue-button">Volver a inicio</a>
				<a href="/products.php" class="button green-button">Ver más productos</a>
			</div>
		</div>
	<?php endif ?>
</div>

<?php include('includes/templates/footer.php') ?>