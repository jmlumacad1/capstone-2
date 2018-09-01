<?php

require 'connect.php';

$order_id = $_POST['order_id']; ?>
<h4>Order details</h4>
<table class="striped responsive-table">
	<thead>
		<tr>
			<!-- <th>Item no.</th> -->
			<th>Item Name</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Subtotal</th>
		</tr>
	</thead>

	<tbody>
		<?php
		$sql = "SELECT * FROM order_details LEFT JOIN items ON item_id = items.id WHERE order_id = $order_id";
		$order_details = mysqli_query($conn, $sql);
		foreach ($order_details as $order_detail): ?>
			<tr>
				<!-- <td><?php echo $order_detail['item_id'] ?></td> -->
				<td><?php echo $order_detail['name'] ?></td>
				<td><?php echo $order_detail['quantity'] ?></td>
				<td>PHP <?php echo $order_detail['price'] ?></td>
				<td>PHP <?php echo $order_detail['price']*$order_detail['quantity'] ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<!-- <ul class="collapsible">
  <li>
    <div class="collapsible-header">Status History</div>
    <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
  </li>
</ul>
<script type="text/javascript">$('.collapsible').collapsible();</script> -->
<h5>Status history</h5>
<ul class="collection">
	<?php
	$sql = "SELECT * FROM orders_statuss LEFT JOIN statuss ON statuss.id = status_id WHERE order_id = $order_id ORDER BY time_stamp";
	$order_statuss = mysqli_query($conn, $sql);
	foreach ($order_statuss as $order_status): ?>
		<li class="collection-item">Marked as '<?php echo $order_status['name'] ?>' on <?php echo $order_status['time_stamp'] ?></li>
	<?php endforeach ?>
</ul>