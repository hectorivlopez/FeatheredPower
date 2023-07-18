<?php
session_start();
/* -------------------- Protect admin section -------------------- */
$auth = $_SESSION['login'];
if (!$auth or $_SESSION['rol'] != 'admin') {
	header('location: /');
}

/* -------------------- Create product -------------------- */
include('../../includes/config/database.php');

$name = '';
$description = '';
$price = '';
$image = '';
$stock = '';
$type = '';
$specs = '';

$errors = [];
$wrongInputs = [];

if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$image = $_FILES['image'];
	$stock = $_POST['stock'];
	$type = $_POST['type'];
	$specs = $_POST['specs'];

	$filledInfo = true;

	if (empty($name)) {
		$filledInfo = false;
		$wrongInputs[] = 'name';
	}
	if (empty($description)) {
		$filledInfo = false;
		$wrongInputs[] = 'description';
	}
	if (empty($price)) {
		$filledInfo = false;
		$wrongInputs[] = 'price';
	}
	if (empty($stock)) {
		$filledInfo = false;
		$wrongInputs[] = 'stock';
	}
	if (empty($type)) {
		$filledInfo = false;
		$wrongInputs[] = 'type';
	}
	if (empty($specs)) {
		$filledInfo = false;
		$wrongInputs[] = 'specs';
	}

	if (!$filledInfo) {
		$errors[] = 'Campos vacíos';
	}

	if (!$image['name']) {
		$errors[] = 'Se debe subir una imagen';
		$wrongInputs[] = 'image';
	}

	if (empty($errors)) {
		/* Create a images folder */
		$productsImg = '../../productsImg/';
		if (!is_dir($productsImg)) {
			mkdir($productsImg);
		}
		/* Create unique image name */
		$imgName = $type . md5(uniqid(rand(), true)) . '.jpg';
		/*  Save the image */
		move_uploaded_file($image['tmp_name'], $productsImg . $imgName);

		/* ---------- SQL Query ---------- */
		$query = "INSERT INTO products (name, description, price, image, stock, type, specs)
			VALUES('$name', '$description', '$price', '$imgName', '$stock', '$type', '$specs')";
		$result = mysqli_query($db, $query);

		$query = "SELECT MAX(id) FROM products";
		$idResult = mysqli_query($db, $query);
		$lastId = mysqli_fetch_assoc($idResult);

		if ($result) {
			header("location: /admin/products?result=1&updated={$lastId['MAX(id)']}");
		}
	}
}
?>

<?php
$actual = 'create';
$actualRoot = '../../';
include('../../includes/templates/header.php')
?>

<main class="container">
	<div class="actions">
		<a href="/admin/products" class="button blue-button">Volver</a>
	</div>

	<form class="create-form card" method="POST" enctype="multipart/form-data">
		<h3>Nuevo producto</h3>

		<?php foreach ($errors as $error) : ?>
			<h4 class="form-alert"><?php echo $error ?></h4>
		<?php endforeach ?>

		<div class="field <?php echo in_array('name', $wrongInputs) ? 'wrong-input' : '' ?>">
			<label>Nombre del producto</label>
			<input type="text" name="name" value="<?php echo $name ?>" value="<?php echo $name ?>" tabindex="1">
		</div>

		<div class="field <?php echo in_array('description', $wrongInputs) ? 'wrong-input' : '' ?>">
			<label>Descripción</label>
			<textarea name="description" id="description" tabindex="2" rows="1"><?php echo $description ?></textarea>
		</div>

		<div class="field <?php echo in_array('price', $wrongInputs) ? 'wrong-input' : '' ?>">
			<label>Precio</label>
			<input type="number" name="price" value="<?php echo $price ?>" tabindex="3">
		</div>

		<div class="field file-field <?php echo in_array('image', $wrongInputs) ? 'wrong-input' : '' ?>">
			<label>Imagen</label>
			<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp">
		</div>

		<div class="field <?php echo in_array('stock', $wrongInputs) ? 'wrong-input' : '' ?>">
			<label>Cantidad</label>
			<input type="number" name="stock" value="<?php echo $stock ?>" tabindex="4">
		</div>

		<div class="field <?php echo in_array('type', $wrongInputs) ? 'wrong-input' : '' ?>">
			<label>Tipo</label>
			<select name="type">
				<option value="" selected>Seleccione un tipo</option>
				<option value="transformer" <?php echo $type === 'transformer' ? 'selected' : '' ?>>Transformador</option>
				<option value="panelboard" <?php echo $type === 'panelboard' ? 'selected' : '' ?>>Tablero</option>
				<option value="protection" <?php echo $type === 'protection' ? 'selected' : '' ?>>Equipo de protección</option>
				<option value="gabinet" <?php echo $type === 'gabinet' ? 'selected' : '' ?>>Gabinete</option>
			</select>
		</div>

		<div class="field <?php echo in_array('specs', $wrongInputs) ? 'wrong-input' : '' ?>">
			<label>Especificaciones</label>
			<textarea name="specs" id="specs" tabindex="2" rows="1"><?php echo $specs ?></textarea>
		</div>

		<button class="button blue-button" type="submit" name="submit" tabindex="3">Guardar</button>
	</form>
</main>

<?php include('../../includes/templates/footer.php') ?>