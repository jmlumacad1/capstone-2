$('select').formSelect();

$('.cart_add').click(function() {
	const id = $(this).data("id");
	const idSelector = "#quantity" + id;
	const quantity = Number($(idSelector).val());
	if (quantity <= 0 || !Number.isInteger(quantity)) {
		alert('Please enter a positive integer.')
	} else {
		$.post('controllers/cart_add.php',
			{ id: id, quantity: quantity },
			function(data) {
				M.toast({html: 'Added to cart successfully!'});
				console.log(data);
		});
	}
});