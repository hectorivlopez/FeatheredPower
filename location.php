<?php
$actual = 'location';
$actualRoot = './';
include('includes/templates/header.php');
?>

<section class="location container">
	<div class="location-map location-1">

	</div>
	<div class="location-info">
		<div class="location-element card location-active" onclick="changeMap('mexico')">
			<div class="location-icon">
				<img src="./img/mexico-icon.png" alt="">
			</div>
			<div class="location-name">
				<h3>México</h3>
				<p>Paseo de las Miserias 123. Guadalajara, Jal.</p>
			</div>
		</div>

		<div class="location-element card" onclick="changeMap('brazil')">
			<div class="location-icon">
				<img src="./img/brazil-icon.png" alt="">
			</div>
			<div class="location-name">
				<h3>Brasil</h3>
				<p>Traquinada do picapau 354. Río de Janeiro, Brasil</p>
			</div>
		</div>
		
		<div class="location-element card" onclick="changeMap('colombia')">
			<div class="location-icon">
				<img src="./img/colombia-icon.png" alt="">
			</div>
			<div class="location-name">
				<h3>Colombia</h3>
				<p>El puma loco 152. Medellín, Colombia</p>
			</div>
		</div>
	</div>
</section>

<?php include('includes/templates/footer.php'); ?>