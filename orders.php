<?php
	function get_title() {
		echo 'Orders list';
	}

	function get_content() {
		global $logged_in;
		if (!$logged_in || ($logged_in['role_id'] != 1)) {
			echo('Unauthorized.');
		} else {
		global $conn; ?>
		<table class="striped centered responsive-table">
      <thead>
        <tr>
        		<th>Transaction Code</th>
        		<th>Username</th>
        		<th>Date Created</th>
        		<th>Status</th>
        		<th>Payment Method</th>
        		<th>Total (PHP)</th>
        		<th></th>
        </tr>
      </thead>

      <tbody>
      	<?php
				$sql = "
					SELECT orders.id id, transaction_code, username, date_created, status_id, name payment_method, total_price FROM orders
					JOIN users ON user_id = users.id LEFT JOIN payment_methods ON payment_method_id = payment_methods.id
				";
				$orders = mysqli_query($conn, $sql) or die(mysqli_error($conn));
				foreach ($orders as $order): ?>
	        <tr>
	        	<td><?php echo $order['transaction_code']; ?></td>
	        	<td><?php echo $order['username']; ?></td>
	        	<td><?php echo $order['date_created']; ?></td>
	        	<td>
	        		<!-- <label>Browser Select</label> -->
						  <select class="browser-default admin-select-order-status" data-order-id=<?php echo $order['id']; ?>>
	        		<?php
							$sql = "SELECT * FROM statuss ORDER BY id";
							$statuss = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	        		foreach ($statuss as $status): ?>
						    <option value=<?php echo $status['id']; ?><?php
							    echo ($order['status_id'] == $status['id']) ? " selected" : '' ;
							    echo ($order['status_id'] > $status['id']) ? " disabled" : '' ;
						    ?>><?php echo $status['name']; ?></option>
	        		<?php endforeach ?>
						  </select>
	        	</td>
	        	<td><?php echo $order['payment_method']; ?></td>
	        	<td><?php echo number_format($order['total_price'],2); ?></td>
	        	<td>
					    <!-- Modal Trigger -->
						  <a class="modal-trigger" href="#view-order-details" data-order-id=<?php echo $order['id']; ?>>
		        		View details
						  </a>
	        	</td>
	        </tr>
      	<?php endforeach ?>
      </tbody>
    </table>

	  <!-- Modal Structure -->
	  <div id="view-order-details" class="modal">
	    <div class="modal-content"></div>
	    <div class="modal-footer">
	      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
	    </div>
	  </div>
<?php }} require_once 'template.php'; ?>