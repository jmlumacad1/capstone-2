<?php
	function get_title() {
		echo 'Home';
	}

	function get_content() {
		global $conn; ?>
		<div class="row">
			<div class="col l2">
				<form>
					<h5>Sort by:</h5>
					<h6>Order:</h6>
					<h5>Filter by:</h5>
					<div class="input-field col s12">
				    <select multiple>
				      <option value="" disabled>Choose your option</option>
							<?php
								$sql = "SELECT * FROM categorys";
								$categorys = mysqli_query($conn, $sql);
								foreach ($categorys as $category): ?>
						      <option value=<?php echo $category['id'] ?>><?php echo $category['name'] ?></option>
							<?php endforeach ?>
				    </select>
				    <label>Category</label>
				  </div>
					<button class="btn waves-effect waves-light" type="submit" name="action">Filter/Sort
				    <!-- <i class="material-icons right">send</i> -->
				  </button>
				</form>
			</div> <!-- end left col -->
			<div class="col l10">
				<div class="row">
					<?php
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
										<span class="card-title"><?php echo $name; ?></span>
										<span><?php echo $price; ?></span>
										<p>some description</p>
									</div>
									<div class="card-action">
										<div class="input-field">
											<input placeholder="How many?" id=<?php echo "quantity".$id; ?> type="number" min=1 class="validate">
											<label for=<?php echo "quantity".$id; ?>>Quantity</label>
										</div>
										<a class="waves-effect waves-light btn cart_add" data-id=<?php echo $id; ?>><i class="material-icons left">add_shopping_cart</i>Add to Cart</a>
									</div>
								</div>
							</div>
					<?php } ?>
				</div>
			</div> <!-- end right col -->
		</div> <!-- end row -->
<?php } require_once 'template.php'; ?>