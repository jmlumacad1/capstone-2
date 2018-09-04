<?php
	function get_title() {
		echo 'Home';
	}

	function admin_get_modal_structure_item($conn,$mode) { ?>
		<!-- Modal Structure -->
	  <div id="modal-<?php echo $mode; ?>" class="modal">
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
									<option value="" disabled selected>Choose your option</option>
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
										<input name="item_image" type="file" required>
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
	    </div>
	  </div><?php
	}

	function admin_get_modal_add_item($conn) {
	  $mode = 'add'; ?>
		<!-- Modal Trigger -->
	  <!-- <button data-target="modal-<?php echo $mode; ?>" class="btn modal-trigger">Add item</button> -->

	  <?php admin_get_modal_structure_item($conn,$mode);
	}

	function admin_get_modal_edit_item($conn) {
	  $mode = 'edit'; ?>
		<!-- Modal Structure -->
	  <div id="modal-<?php echo $mode; ?>" class="modal">
	    <div class="modal-content">
	    </div>
	    <div class="modal-footer">
	      <button class="admin-btn-<?php echo $mode; ?>-item modal-close waves-effect waves-green btn-flat"><?php echo ($mode === 'add') ? 'Add to Database' : 'Save' ; ?></button>
	    </div>
	  </div><?php
	}

	function get_content_section_sort_and_filter($conn) { ?>
		<form>
			<div class="input-field col s12">
		    <select name="sort">
		      <option value="" disabled selected></option>
		      <option>name</option>
		      <option>price</option>
		    </select>
		    <label>Sort by</label>
		  </div>
			<div class="input-field col s12">
		    <select name="order">
		      <option value="" disabled selected></option>
		      <option>ascending</option>
		      <option>descending</option>
		    </select>
		    <label>Order</label>
		  </div>
			<div class="input-field col s12">
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
				<button class="btn waves-effect waves-light modal-close" type="submit" name="action">Go
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
				<div class="card card-book">
					<div class="card-image">
						<img src="<?php echo $image; ?>">
					</div>
					<div class="card-content">
					    <span class="card-title"><?php echo $name; ?></span>
						<span>Php <?php echo $price; ?></span>
						<!-- <p>some description</p> -->
					</div>
					<div class="card-action">
						<?php if (!isset($logged_in) || (isset($logged_in) && $logged_in['role_id'] != 1)): ?>
							<div class="input-field">
								<input placeholder="How many?" id=<?php echo "quantity".$id; ?> type="number" min=1 class="validate">
								<label for=<?php echo "quantity".$id; ?>>Quantity</label>
							</div>
							<a class="waves-effect waves-light btn cart-add" data-id=<?php echo $id; ?>><i class="material-icons left">add_shopping_cart</i>Add to Cart</a>
						<?php else: ?>
							<button data-item='<?php echo json_encode($item) ?>' data-target="modal-edit" data-id=<?php echo $id ?> class="btn waves-effect waves-light modal-trigger">Edit</button>
							<button data-target="modal-confirm-delete-item" data-id=<?php echo $id ?> class="btn waves-effect waves-light modal-trigger">Delete</button>
						<?php endif ?>
					</div>
				</div> <!-- end card -->
			</div> <!-- end col --><?php
		}
	}

	function get_content() {
		global $logged_in;
		global $conn; ?>
		<?php
        //   if (isset($_SESSION['error_login'])) {
        //     echo '<span class="red-text">' . $_SESSION['error_login'] . '</span>';
        //     // unset($_SESSION['error_login']);
        //   }
        //   if (isset($_SESSION['success_register'])) {
        //     echo '<span class="green-text">' . $_SESSION['success_register'] . '</span>';
        //     // unset($_SESSION['success_register']);
        //   }
        ?>
		<div class="section no-pad-bot" id="index-banner">
      <div class="container">
        <br><br>
        <h1 class="header center teal-text">Coll&aelig;ge Books</h1>
        <div class="row center">
          <h5 class="header col s12 light">A collage of college books</h5>
        </div>
        <div class="row center">
          <!--<a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light teal">Get Started</a>-->
        </div>
        <br><br>
      
      </div>
    </div>
    <!-- <div class="container">
    	<div class="row">
	    	<div class="col s12">
	    	</div>
    	</div>
    </div> -->
		<div class="row">
			<!-- <div class="col l2">
			</div> --> <!-- end left col -->
			<div class="col l12">
				<!--<div class="row"></div>--> <!-- end row -->
				<div class="row"><?php get_content_items($conn); ?></div> <!-- end row -->
			</div> <!-- end right col -->
		</div> <!-- end row -->

		<!-- Modal Structure -->
	  <div id="modal-confirm-delete-item" class="modal">
	    <div class="modal-content">
	      <h4>Delete item</h4>
	      <p>Are you sure?</p>
	    </div>
	    <div class="modal-footer">
	      <a href="#!" class="admin-btn-delete-item modal-close waves-effect waves-green btn-flat" data-action=1>Yes</a>
	      <a href="#!" class="admin-btn-delete-item modal-close waves-effect waves-green btn-flat" data-action=0>No</a>
	    </div>
	  </div>

	  <!-- floating action button -->
	  <?php if ($logged_in && $logged_in['role_id'] == 1): ?>
		  <div class="fixed-action-btn">
			  <a class="btn-floating btn-large teal">
			    <i class="large material-icons">more_vert</i>
			  </a>
			  <ul>
			    <li>
			    	<a class="btn-floating red modal-trigger waves-effect waves-light" data-target="modal-add">
					    <i class="large material-icons">add</i>
					  </a>
					</li>
			    <li>
			    	<a class="btn-floating blue modal-trigger waves-effect waves-light" data-target="modal-filter-sort">
					    <i class="large material-icons">sort</i>
					  </a>
					</li>
			  </ul>
			</div>
	  <?php else: ?>
		  <div class="fixed-action-btn">
			  <a class="btn-floating btn-large blue modal-trigger waves-effect waves-light" data-target="modal-filter-sort">
			    <i class="large material-icons">sort</i>
			  </a>
			</div>
	  <?php endif ?>

	  <!-- Modal Structure -->
	  <div id="modal-filter-sort" class="modal">
	    <div class="modal-content">
	      <h4>Filter and Sort</h4>
	      <div class="row">
	      	<div class="col s12">
				    <?php get_content_section_sort_and_filter($conn); ?>
	      	</div>
	      </div>
	    </div>
	  </div>
<?php } require_once 'template.php'; ?>