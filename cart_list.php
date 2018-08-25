<?php
	function get_title() {
		echo 'View cart';
	}

	function get_content() {
		global $conn;
		if (isset($_SESSION['cart'])) { ?>
			<div class="row">
				<div class="col l2"></div>
				<div class="col l10">
					<div class="row">
<?php
					$total = 0;
					foreach ($_SESSION['cart'] as $id => $quantity) {
						$sql = "SELECT * FROM items WHERE id = $id";
						$result = mysqli_query($conn, $sql);
						$item = mysqli_fetch_assoc($result);
?>
							<div class="col s12 m6">
						    <div class="card horizontal">
						      <!-- <div class="card-image">
						        <img src=<?php //echo $item['image'] ?>>
						      </div> -->
						      <div class="card-stacked">
						        <div class="card-content">
						        	<h6><?php echo $item['name'] ?></h6>
						        	<p>Price: <?php echo $item['price'] ?></p>
						          <p>Quantity: <?php echo $quantity ?></p>
						          <p>Subtotal: <?php
						          	$subtotal = $item['price']*$quantity;
						          	$total += $subtotal;
						          	echo $subtotal; ?></p>
						        </div>
						        <div class="card-action">
						          <a href="#">Update quantity</a>
						          <a href="#">Remove from cart</a>
						        </div>
						      </div>
						    </div>
						  </div>
<?php
					}
?>
					</div>
					<p>Total: <?php echo $total ?></p>
				</div>
			</div>
<?php
		} else {
			echo "Cart is empty.";
		}
	}

	require_once 'template.php';
?>