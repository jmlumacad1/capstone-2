<!-- Dropdown Structure -->
<!-- <ul id="dropdown1" class="dropdown-content">
  <li><a href="#!">Profile</a></li>
  <li class="divider"></li>
  <li><a href="logout.php">Logout</a></li>
</ul> -->
<nav class="blue" role="navigation">
  <div class="nav-wrapper container">
    <a id="logo-container" href="index.php" class="brand-logo">Book Coll&#x259;ge</a>
    <ul class="right hide-on-med-and-down">
        <li><a href="index.php">Books</a></li>
      <?php if (!isset($logged_in) || (isset($logged_in) && $logged_in['role_id'] != 1)): ?>
        <li><a href="cart_list.php">Cart<span class="badge-items"><?php 
        if (isset($_SESSION['cart'])) {
          $count = array_sum($_SESSION['cart']); ?>
          <span class="new badge" data-badge-caption=<?php echo $count == 1 ? "item" : "items"; ?>><?php echo $count; ?></span><?php
        } ?></span></a></li>
      <?php else: ?>
        <li><a href="orders.php">Orders</a></li>
      <?php endif ?>
      <?php if (isset($logged_in)): ?>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li>
          <!-- Modal Trigger -->
          <a class="modal-trigger" href="#modal-register">Register</a>
        </li>
        <li>
          <!-- Modal Trigger -->
          <a class="modal-trigger" href="#modal-login">Login</a>
        </li>
      <?php endif ?>
      <!-- Dropdown Trigger -->
      <!-- <li><a class="dropdown-trigger dropdown_menu" href="#!" data-target="dropdown1">User<i class="material-icons right">arrow_drop_down</i></a></li> -->
    </ul>

    <ul class="sidenav" id="nav-mobile">
      <?php if (!isset($logged_in) || (isset($logged_in) && $logged_in['role_id'] != 1)): ?>
        <li><a href="cart_list.php">Cart<span class="badge-items"><?php 
        if (isset($_SESSION['cart'])) {
          $count = array_sum($_SESSION['cart']); ?>
          <span class="new badge" data-badge-caption=<?php echo $count == 1 ? "item" : "items"; ?>><?php echo $count; ?></span><?php
        } ?></span></a></li>
      <?php else: ?>
        <li><a href="orders.php">Orders</a></li>
      <?php endif ?>
      <?php if (isset($logged_in)): ?>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li>
          <!-- Modal Trigger -->
          <a class="modal-trigger" href="#modal-register">Register</a>
        </li>
        <li>
          <!-- Modal Trigger -->
          <a class="modal-trigger" href="#modal-login">Login</a>
        </li>
      <?php endif ?>
      <!-- Dropdown Trigger -->
      <!-- <li><a class="dropdown-trigger dropdown_menu" href="#!" data-target="dropdown1">User<i class="material-icons right">arrow_drop_down</i></a></li> -->
    </ul>
    <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
  </div>
</nav>

<!-- Modal Structure -->
<div id="modal-register" class="modal">
  <div class="modal-content">
    <h4>Register</h4>
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
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
  </div>
</div>

<!-- Modal Structure -->
<div id="modal-login" class="modal">
  <div class="modal-content">
    <h4>Login</h4>
    <form id="form-login" action="controllers/authenticate.php" method="post">
    	<div class="row">
    	  <div class="input-field col s12">
    	    <input name="username" id="login-username" type="text">
    	    <label for="login-username">Username</label>
    	  </div>
    	  <div class="input-field col s12">
    	    <input name="password" id="login-password" type="password">
    	    <label for="login-password">Password</label>
    	  </div>
    	  <div class="col s12">
    			<button class="btn waves-effect waves-light" type="submit" name="action">Submit
    		    <i class="material-icons right">send</i>
    		  </button>
    	  </div>
    	</div>
    </form>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
  </div>
</div>