<?php
	function get_title() {
		echo 'View cart';
	}

	function get_content() {
		global $conn;
		if (isset($_POST['cart_empty'])) {
			unset($_SESSION['cart']);
		}
		if (isset($_POST['cart_remove'])) {
			$id = $_POST['cart_remove'];
			unset($_SESSION['cart'][$id]);
			if (count($_SESSION['cart']) == 0) {
				unset($_SESSION['cart']);
			}
		}

		if (isset($_SESSION['cart'])) { ?>
			<div class="row">
				<div class="col l2"></div>
				<div class="col l10">
					<a id="cart-empty" class="waves-effect waves-light btn">Empty cart</a>
					<div class="row"><?php
					$total = 0;
					foreach ($_SESSION['cart'] as $id => $quantity) {
						$sql = "SELECT * FROM items WHERE id = $id";
						$result = mysqli_query($conn, $sql);
						$item = mysqli_fetch_assoc($result); ?>
							<div class="col s12 m6" id=<?php echo "item$id" ?>>
						    <div class="card horizontal">
						      <!-- <div class="card-image">
						        <img src=<?php //echo $item['image'] ?>>
						      </div> -->
						      <div class="card-stacked">
						        <div class="card-content">
						        	<h6><?php echo $item['name'] ?></h6>
						        	<p>Price: <?php echo $item['price'] ?></p>
						          <p>Quantity: <?php echo $quantity ?> | <a href="#">edit</a></p>
						          <p>Subtotal: <?php
						          	$subtotal = $item['price']*$quantity;
						          	$total += $subtotal;
						          	echo $subtotal; ?></p>
						        </div>
						        <div class="card-action">
						          <a href="#" class="cart-remove" data-id=<?php echo $id ?>>Remove from cart</a>
						        </div>
						      </div>
						    </div>
						  </div><?php
					} ?>
					</div>
					<p>Total: <?php echo $total ?></p>
				</div>
			</div><?php
		} else {
			echo "Cart is empty.";
		}
	}

	require_once 'template.php';
?>