<!-- Dropdown Structure -->
<!-- <ul id="dropdown1" class="dropdown-content">
	<li><a href="#!">Profile</a></li>
	<li class="divider"></li>
	<li><a href="logout.php">Logout</a></li>
</ul> -->
<nav>
	<div class="nav-wrapper">
		<a href="index.php" class="brand-logo">Logo</a>
		<ul class="right hide-on-med-and-down">
			<?php if (!isset($logged_in) || (isset($logged_in) && $logged_in['role_id'] != 1)): ?>
				<li><a href="cart_list.php">Cart<span id="badge-items"><?php 
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
				<li><a href="register.php">Register</a></li>
				<li><a href="login.php">Login</a></li>
			<?php endif ?>
			<!-- Dropdown Trigger -->
			<!-- <li><a class="dropdown-trigger dropdown_menu" href="#!" data-target="dropdown1">User<i class="material-icons right">arrow_drop_down</i></a></li> -->
		</ul>
	</div>
</nav>