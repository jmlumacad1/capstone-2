<?php
	function foo($conn,$mode) { ?>
	    <div class="modal-content">
	      <h4><?php echo ($mode === 'add') ? 'Add new item' : 'Edit item' ; ?></h4>
	      <div class="row">
					<form id="admin-form-<?php echo $mode; ?>-item" class="col s12" action="controllers/admin_item_<?php echo $mode; ?>.php" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="input-field col s12 m6">
								<input name="item_name" id="item_name" type="text" class="validate"<?php if (isset($_POST['name'])) {
									echo " value='".$_POST['name']."'";
								} ?>>
								<label <?php if ($mode === 'edit') {
									echo "class=active";
								} ?> for="item_name">Item name</label>
							</div>
							<div class="input-field col s12 m6">
								<input name="item_price" id="item_price" type="number" class="validate">
								<label <?php if ($mode === 'edit') {
									echo "class=active";
								} ?> for="item_price">Item price</label>
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
								<label <?php if ($mode === 'edit') {
									echo "class=active";
								} ?>>Item category</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea name="item_description" id="item_description" class="materialize-textarea"></textarea>
								<label <?php if ($mode === 'edit') {
									echo "class=active";
								} ?> for="item_description">Item description</label>
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
?>