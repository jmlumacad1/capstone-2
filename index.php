<?php
	function get_title() {
		echo 'Home';
	}

	function get_content() {
		global $conn; ?>
		<div class="row">
			<div class="col l2">
			</div> <!-- end left col -->
			<div class="col l10">
				<div class="row">
					<form>
						<div class="input-field col s12 m6 l3">
					    <select name="sort">
					      <option value="" disabled selected></option>
					      <option>name</option>
					      <option>price</option>
					    </select>
					    <label>Sort by</label>
					  </div>
						<div class="input-field col s12 m6 l3">
					    <select name="order">
					      <option value="" disabled selected></option>
					      <option>ascending</option>
					      <option>descending</option>
					    </select>
					    <label>Order</label>
					  </div>
						<div class="input-field col s12 m6 l3">
					    <select name="filter[]" multiple>
					      <optgroup label="Subject">
									<?php
										$sql = "SELECT * FROM categorys";
										$categorys = mysqli_query($conn, $sql);
										foreach ($categorys as $category):
											extract($category); ?>
								      <option value=<?php echo $id ?>><?php echo $name ?></option>
									<?php endforeach ?>
					      </optgroup>
					    </select>
					    <label>Filter by</label>
					  </div>
					  <div class="col l3">
							<button class="btn waves-effect waves-light" type="submit" name="action">Filter/Sort
						    <!-- <i class="material-icons right">send</i> -->
						  </button>
					  </div>
					</form>
				</div> <!-- end row -->
				<div class="row">
					<?php
						$sql_extension = '';
						if (isset($_GET['filter'])) {
							$filter = $_GET['filter'];
							$sql_extension .= " WHERE category_id = ".$filter[0];
							if (count($filter) > 1) {
								for ($i=1; $i < count($filter); $i++) { 
									$sql_extension .= " OR category_id = ".$filter[$i];
								}
							}
						}
						if (isset($_GET['sort']) && isset($_GET['order'])) {
							$sort = " ORDER BY ".$_GET['sort'];
							$order = $_GET['order'] == 'descending' ? " DESC" : "";
							$sql_extension .= $sort.$order;
						}
						$sql = "SELECT * FROM items".$sql_extension;
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