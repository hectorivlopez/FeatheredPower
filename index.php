	<?php
	$actual = 'home';
	$actualRoot = './';
	include('includes/templates/header.php'); ?>

	<!-- -------------------- Products -------------------- -->
	<section>
		<div class="products container">
			<div class="products-item" href="https://www.youtube.com/">
				<a class="product-image" href="/products.php?category=Transformadores">
					<img src=" ./img/transformer-icon.png" alt="">
				</a>
				<p>Transformadores</p>
			</div>
			<a class="products-item" href="/products.php?category=Tableros">
				<div class="product-image ">
					<img src="./img/panelboard-icon.png" alt="">
				</div>
				<p class="">Tableros</p>
			</a>
			<a class="products-item" href="/products.php?category=Equipos+de+proteccion">
				<div class="product-image">
					<img src="./img/breaker-icon.png" alt="">
				</div>
				<p>Equipos de protección</p>
			</a>
			<a class="products-item" href="/products.php?category=Gabinetes">
				<div class="product-image">
					<img src="./img/cabinet-icon.png" alt="">
				</div>
				<p>Gabinetes</p>
			</a>
		</div>
	</section>

	<!-- -------------------- Description -------------------- -->
	<section>
		<div class="container">
			<h2>Usted hace el diseño, nosotros lo hacemos realidad</h2>
			<div class="section-content">
				<div class="section-image">
					<img src="./img/opened-panelboard.jpg" alt="">
				</div>
				<div class="section-info">
					<p>Somos una empresa con presencia a lo largo de Latinoamérica, que brinda soluciones de equiopos eléctricos para su instalación, contando con un amplio catálogo y con equipos hechos a la medida para las necesidades de nuestros usuarios premium</p>
				</div>
			</div>
		</div>
	</section>

	<!-- -------------------- About us -------------------- -->
	<section>
		<div class="container">
			<h2>Sobre nosotros</h2>

			<div class="us-content">
				<div class="us-item card">
					<div class="us-item-heading">
						<div class="us-icon">
							<img src="./img/mission-icon.png" alt="">
						</div>
						<h3>Misión</h3>
					</div>
					<div class="us-item-content">
						<p>En FeatheredPower tenemos la misión de brindar la mayor variedad de soluciónes para su instalación
							eléctrica, contando con un amplio catálogo de productos, así como la opción de equipos diseñados para
							adaptarse a sus necesidades</p>
					</div>
				</div>

				<div class="us-item card">
					<div class="us-item-heading">
						<div class="us-icon">
							<img src="./img/vision-icon.png" alt="">
						</div>
						<h3>Visión</h3>
					</div>
					<div class="us-item-content">
						<p>FeatheredPower tiene la visión de ser la distribuidora de equipos eléctricos estandarizados más
							importante de
							Latinoamérica</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php include('includes/templates/footer.php'); ?>