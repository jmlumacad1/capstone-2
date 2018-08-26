<?php
	function get_title() {
		echo 'Login';
	}

	function get_content() { ?>
		<h1>Login</h1>

		<?php
			if (isset($_SESSION['error_login'])) {
				echo '<span class="text-danger">' . $_SESSION['error_login'] . '</span>';
				unset($_SESSION['error_login']);
			}
			if (isset($_SESSION['success_register'])) {
				echo '<span class="text-success">' . $_SESSION['success_register'] . '</span>';
				unset($_SESSION['success_register']);
			}
		?>

		<form id="form-login" action="controllers/authenticate.php" method="post">
			<div class="row">
			  <div class="input-field col s12">
			    <input name="username" id="username" type="text">
			    <label for="username">Username</label>
			  </div>
			  <div class="input-field col s12">
			    <input name="password" id="password" type="password">
			    <label for="password">Password</label>
			  </div>
			  <div class="col s12">
					<button class="btn waves-effect waves-light" type="submit" name="action">Submit
				    <i class="material-icons right">send</i>
				  </button>
			  </div>
			</div>
		</form>
<?php } require_once 'template.php'; ?>