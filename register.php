<?php
	function get_title() {
		echo 'Register';
	}

	function get_content() { ?>
		<form id="form-register" action="controllers/endpoint_register.php" method="post">
			<div class="row">
			  <div id="div-username" class="input-field col s12">
			    <input id="username" name="username" type="text">
			    <label for="username">Username</label>
			    <span class="helper-text"></span>
			  </div>
			  <div id="div-password" class="input-field col s12">
			    <input id="password" name="password" type="password">
			    <label for="password">Password</label>
			    <span class="helper-text"></span>
			  </div>
			  <div id="div-confirm-password" class="input-field col s12">
			    <input id="confirm-password" type="password">
			    <label for="confirm-password">Confirm Password</label>
			    <span class="helper-text"></span>
			  </div>
			  <div class="col s12">
					<button class="btn waves-effect waves-light" type="submit" name="action">Submit
				    <i class="material-icons right">send</i>
				  </button>
			  </div>
			</div>
		</form>
<?php } require_once 'template.php'; ?>