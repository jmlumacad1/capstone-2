<div class="row">
	<form id="admin-form-add-item" class="col s12" action="controllers/admin_item_add.php" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="input-field col s6">
				<input name="item_name" id="item_name" type="text" class="validate">
				<label for="item_name">Item name</label>
			</div>
			<div class="input-field col s6">
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
						<input name="item_image" type="file">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text">
					</div>
				</div>
		</div>
	</form>
</div>