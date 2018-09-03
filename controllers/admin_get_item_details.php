<?php
	$id = $_POST['id'];
	$sql = "SELECT * FROM items WHERE id = $id";
	require 'connect.php';
	$result = mysqli_query($conn, $sql);
	$item = mysqli_fetch_assoc($result);
	$mode = 'edit';
?>
<h4><?php echo ($mode === 'add') ? 'Add new item' : 'Edit item' ; ?></h4>
<div class="row">
	<form id="admin-form-<?php echo $mode; ?>-item" class="col s12" action="controllers/admin_item_<?php echo $mode; ?>.php?id=<?php echo $item['id'] ?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="input-field col s12 m6">
				<input value="<?php echo($item['name']) ?>" name="item_name" id="item_name" type="text" class="validate">
				<label class="active" for="item_name">Item name</label>
			</div>
			<div class="input-field col s12 m6">
				<input value="<?php echo($item['price']) ?>" name="item_price" id="item_price" type="number" class="validate">
				<label class="active" for="item_price">Item price</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<select name="item_category_id">
					<option value="" disabled>Choose your option</option>
					<?php
						$sql = "SELECT * FROM categorys";
						$categorys = mysqli_query($conn, $sql);
						foreach ($categorys as $category):
							extract($category); ?>
				      <option value=<?php echo $id ?><?php if ($id == $item['category_id']) {
				      	echo " selected";
				      } ?>><?php echo $name ?></option>
					<?php endforeach ?>
				</select>
				<label>Item category</label>
				<script type="text/javascript">$('select').formSelect();</script>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<textarea name="item_description" id="item_description" class="materialize-textarea"><?php echo $item['description']; ?></textarea>
				<label class="active" for="item_description">Item description</label>
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