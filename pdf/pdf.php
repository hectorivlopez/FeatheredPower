<?php
$logoImage = "../img/logo.png";
$logo = "data:image/png;base64," . base64_encode(file_get_contents($logoImage));

$html = "
<html>
<head>
	<meta charset='utf-8'>
	<style>
	body, html {
		background-color: rgb(51, 51, 51);
		margin: 0;
		font-family: Helvetica;
	}

	table {
		color: white;
	}

	.logo-heading {
		width: 100%;
		background-color: rgb(20, 20, 20);
	}

	.logo-table {
		margin: auto;
		border-spacing: 5px;
		
	}
	.logo {
		width: 45px;
		aspect-ratio: 1 / 1;
		object-fit: contain;
		display: inline;

	}
	td {
		color: white;
	}
	span {
		font-weight: light;
	}

	.main {
		margin: 30px;

	}

	.heading {
		margin: auto;
		color: white;
		text-align: center;
	}

	.items-table {
		width: 100%;
		border-spacing: 50px;
	}

	.items-table th {
		text-align: left;
	}

	.product-image {
		width: 130px;
		aspect-ratio: 1 / 1;
		object-fit: contain;
	}

	.price {
		width: 100px;
	}

	</style>

</head>

<body>
	<div class='logo-heading'>
		<table class='logo-table'>
		<tbody>
			<tr>
			<td>
			<img src='{$logo}' class='logo'>
			</td>
			<td>
			<h2> 
			<span class='cosa'>Feathered	</span>Power
			</h2>
			</td>
			</tr>
		</tbody>
		</table>
	</div>
	
	<div class='main'>
		<h2 class='heading'>Detalles del pedido	</h2>

		<table class='items-table'>
			<thead>
				<tr>
					<th>
						Imagen
					</th>
					<th>
						Producto
					</th>
					<th>
						Cant
					</th>
					<th>
						Precio
					</th>
					<th>
						Subtotal
					</th>
				</tr>
			</thead>
			<tbody>
";

foreach($cart as $product) {
	$image = "../productsImg/{$product['productImage']}";
	$productImage = "data:image/png;base64," . base64_encode(file_get_contents($image));

	$subtotal = $product['productPrice'] * $product['amount'];

	$html.= "
			<tr>
				<td>
					<img src='{$productImage}' class='product-image'>
				</td>
				<td>
					{$product['productName']}
				</td>
				<td>
					{$product['amount']}
				</td>
				<td class='price'>
					$ {$product['productPrice']}
				</td>
				<td class='price'>
					$ {$subtotal}
				</td>
				
			</tr>
	";
}


$html.= "
			</tbody>
		</table>
	</div>
	
</body>

</html>
";
