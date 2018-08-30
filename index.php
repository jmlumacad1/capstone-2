<?php
	function get_title() {
		echo 'Home';
	}

	function foo($conn,$mode) { ?>
	    <div class="modal-content">
	      <h4><?php echo ($mode === 'add') ? 'Add new item' : 'Edit item' ; ?></h4>
	      <div class="row">
					<form id="admin-form-<?php echo $mode; ?>-item" class="col s12" action="controllers/admin_item_<?php echo $mode; ?>.php" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="input-field col s12 m6">
								<input name="item_name" id="item_name" type="text" class="validate">
								<label for="item_name">Item name</label>
							</div>
							<div class="input-field col s12 m6">
								<input name="item_price" id="item_price" type="number" class="validate">
								<label for="item_price">Item price</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<select name="item_category_id">
									<option value="" disabled<?php echo ($mode === 'add') ? ' selected' : '' ; ?>>Choose your option</option>
									<?php
										$sql = "SELECT * FROM categorys";
										$categorys = mysqli_query($conn, $sql);
										foreach ($categorys as $category):
											extract($category); ?>
								      <option value=<?php echo $id ?>><?php echo $name ?></option>
									<?php endforeach ?>
								</select>
								<label>Item category</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea name="item_description" id="item_description" class="materialize-textarea"></textarea>
								<label for="item_description">Item description</label>
							</div>
						</div>
						<div class="row">
								<div class="file-field input-field col s12">
									<div class="btn">
										<span>Image</span>
										<input name="item_image" type="file">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text">
									</div>
								</div>
						</div>
					</form>
				</div>
	    </div>
	    <div class="modal-footer">
	      <button id="admin-btn-<?php echo $mode; ?>-item" class="modal-close waves-effect waves-green btn-flat"><?php echo ($mode === 'add') ? 'Add to Database' : 'Save' ; ?></button>
	    </div><?php
	}

	function admin_get_modal_structure_item($conn,$mode) { ?>
		<!-- Modal Structure -->
	  <div id="modal-<?php echo $mode; ?>" class="modal">
	  	<?php foo($conn,$mode); ?>
	  </div><?php
	}

	function admin_get_modal_add_item($conn) {
	  $mode = 'add'; ?>
		<!-- Modal Trigger -->
	  <button data-target="modal-<?php echo $mode; ?>" class="btn modal-trigger">Add item</button>

	  <?php admin_get_modal_structure_item($conn,$mode);
	}

	function admin_get_modal_edit_item($conn) {
	  $mode = 'edit'; ?>

	  <?php admin_get_modal_structure_item($conn,$mode);
	}

	function get_content_section_sort_and_filter($conn) { ?>
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
		</form><?php
	}

	function get_content_items($conn) {
		global $logged_in;
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
		$items = mysqli_query($conn, $sql); ?>
		<div class="col s12">
			<?php if (isset($logged_in) && $logged_in['role_id'] == 1): ?>
				<?php admin_get_modal_add_item($conn); ?>
				<?php admin_get_modal_edit_item($conn); ?>
			<?php endif ?>
		</div>
		<?php
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
						<?php if (!isset($logged_in) || (isset($logged_in) && $logged_in['role_id'] != 1)): ?>
							<div class="input-field">
								<input placeholder="How many?" id=<?php echo "quantity".$id; ?> type="number" min=1 class="validate">
								<label for=<?php echo "quantity".$id; ?>>Quantity</label>
							</div>
							<a class="waves-effect waves-light btn cart_add" data-id=<?php echo $id; ?>><i class="material-icons left">add_shopping_cart</i>Add to Cart</a>
						<?php else: ?>
							<button data-item='<?php echo(json_encode($item)) ?>' data-target="modal-edit" data-id=<?php echo $id ?> class="admin-btn-edit-item btn waves-effect waves-light modal-trigger">Edit</button>
							<button disabled data-id=<?php echo $id ?> class="admin-btn-delete-item btn waves-effect waves-light">Delete</button>
						<?php endif ?>
					</div>
				</div> <!-- end card -->
			</div> <!-- end col --><?php
		}
	}

	function get_content() {
		global $conn; ?>
		<div class="row">
			<div class="col l2">
			</div> <!-- end left col -->
			<div class="col l10">
				<div class="row"><?php get_content_section_sort_and_filter($conn); ?></div> <!-- end row -->
				<div class="row"><?php get_content_items($conn); ?></div> <!-- end row -->
			</div> <!-- end right col -->
		</div> <!-- end row -->
<?php } require_once 'template.php'; ?>