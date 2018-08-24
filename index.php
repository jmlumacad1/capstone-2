<?php
	function get_title() {
		echo 'Home';
	}

	function get_content() { ?>
		<div class="row">
			<?php
				global $conn;
				$sql = "SELECT * FROM items";
				$items = mysqli_query($conn, $sql);
				foreach ($items as $item) {
					extract($item); ?>
					<div class="col s12 m6 l3">
						<div class="card">
							<div class="card-image">
								<img src="<?php echo $image; ?>">
							</div>
							<div class="card-content">
								<span class="card-title"><?php echo $name ?></span>
								<span><?php echo $price ?></span>
								<p>some description</p>
							</div>
							<div class="card-action">
								<a class="waves-effect waves-light btn"><i class="material-icons left">add_shopping_cart</i>Add to Cart</a>
							</div>
						</div>
					</div>
			<?php } ?>
		</div>
<?php } require_once 'template.php'; ?>