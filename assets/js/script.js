// materialize js initializations
$(".dropdown_menu").dropdown();
$('select').formSelect();
$('.modal').modal();
$('.collapsible').collapsible();
$('.sidenav').sidenav();

$(document).ready(function() {
    $('[alt="www.000webhost.com"]').parent().parent().hide();
});

const updateCartBadge = function() {
	$.ajax({
		url: 'controllers/update_cart_badge.php',
		success : function(data) {
			$('.badge-items').html(data);
		}
	});
};

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
				updateCartBadge();
				// console.log(data);
		});
	}
});

$('.cart-update').click(function() {
	const id = $(this).data("id");
	const quantity = Number($(this).prev().val());
	if (quantity <= 0 || !Number.isInteger(quantity)) {
		alert('Please enter a positive integer.')
	} else {
    	const price = $('#price'+id).html();
    	const prevQuantity = $('#quantity'+id).html();
		$.post('controllers/cart_update.php',
			{ id: id, quantity: quantity, prev_qty: price*prevQuantity, price: price },
			function(data) {
				M.toast({html: 'Updated cart successfully!'});
				// console.log(data);
				const prevTotal = $('#total').html();
				$('#quantity'+id).html(quantity);
				$('#subtotal'+id).html(quantity*price);
				$('#total').html(prevTotal - price*prevQuantity + price*quantity);
				updateCartBadge();
		});
	}
});

$('#cart-empty').click(function() {
	$.ajax({
		method: 'post',
		url: 'cart_list.php',
		data: { cart_empty: true }
	}).done(function() {
		location.reload();
	});
});

$('.cart-remove').click(function() {
	const id = $(this).data('id');
	$.ajax({
		method: 'post',
		url: 'cart_list.php',
		data: { cart_remove: id }
	}).done(function() {
		location.reload();
	});
});

const setValid = function(selector) {
	$(selector).removeClass('invalid');
	$(selector).addClass('valid');
};

const setInvalid = function(selector) {
	$(selector).removeClass('valid');
	$(selector).addClass('invalid');
};

const requireField = function(selector) {
	$(selector+' .helper-text').attr('data-error','This field is required.');
};

const validateRegForm = function() {
	const validateUsername = function() {
		let errorFlag = false;
		const usernameSelector = '#form-register #div-username';
		const username = $(usernameSelector+' #username').val();
		if (username === '') {
			requireField(usernameSelector);
			setInvalid(usernameSelector+' #username');
			errorFlag = true;
		} else {
			$.ajax({
				url: 'controllers/username_check.php',
				method: 'post',
				data: {username: username},
				async: false
			}).done( data => {
				errorFlag = (data === 'username already exists'); // use data.trim() instead of data if needed
				if (errorFlag) {
					$(usernameSelector+' .helper-text').attr('data-error','Username already exists.');
					setInvalid(usernameSelector+' #username');
				} else {
					setValid(usernameSelector+' #username');
				}
			});
		}
		return errorFlag;
	};

	const validatePassword = function() {
		let errorFlag = false;
		const passwordSelector = '#form-register #div-password';
		const password = $(passwordSelector+' #password').val();
		if (password === '') {
			requireField(passwordSelector);
			setInvalid(passwordSelector+' #password');
			errorFlag = true;
		} else {
			setValid(passwordSelector+' #password');
		}

		return errorFlag;
	};

	const validateConfirmPassword = function() {
		let errorFlag = false;
		const passwordSelector = '#form-register #div-password';
		const confirmPasswordSelector = '#form-register #div-confirm-password';
		const confirmPassword = $(confirmPasswordSelector+' #confirm-password').val();
		if (confirmPassword !== $(passwordSelector+' #password').val()) {
			$(confirmPasswordSelector+' .helper-text').attr('data-error','Passwords do not match.');
			setInvalid(confirmPasswordSelector+' #confirm-password');
			errorFlag = true;
		} else if (confirmPassword === '') {
			requireField(confirmPasswordSelector);
			setInvalid(confirmPasswordSelector+' #confirm-password');
			errorFlag = true;
		} else {
			setValid(confirmPasswordSelector+' #confirm-password');
		}

		return errorFlag;
	};

	$('#form-register #div-username #username').blur(validateUsername);
	$('#form-register #div-password #password').blur(validatePassword);
	$('#form-register #div-confirm-password #confirm-password').blur(validateConfirmPassword);
	$('#form-register').submit(function() {
		let res = true;
		const b = [validateUsername,validatePassword,validateConfirmPassword];
		for (var i = 0; i < b.length; i++) {
			res = !b[i]() && res;
		}
		return res;
	});
};
validateRegForm();

$('.admin-btn-delete-item').click(function() {
	const id = $(this).data('id');
	$.ajax({
		url: 'controllers/admin_item_delete.php',
		method: 'post',
		data: { id: id },
		success: function() {
			location.reload();
		}
	});
});

$('#admin-btn-add-item').click(function() {
	$('#admin-form-add-item').submit();
});

// $('.admin-btn-edit-item').click(function() {
// 	const id = $(this).data('id');
// 	const item = $(this).data('item');
// 	$.ajax({
// 		url: 'controllers/admin_item_form_show.php',
// 		method: 'post',
// 		data: item,
// 		success: function(data) {
// 			$('#modal-edit').html(data);
// 		}
// 	});
// 	console.log(item);
// 	for (let key in item) {
// 		if (key != 'image') {
// 			if (key == 'category_id') {
// 				// $(`[name="item_${key}"] [value="${item[key]}"]`).attr('selected','selected');
// 				$(`[name="item_${key}"]`).val(item[key]);
// 			} else {
// 				$(`[name="item_${key}"]`).val(item[key]);
// 			}
// 			$(`[name="item_${key}"]`).next().addClass('active');
// 		}
// 	}
// 	const action = $('#admin-form-edit-item').attr('action');
// 	$('#admin-form-edit-item').attr('action',`${action}?id=${id}`);
// });

$('.admin-btn-edit-item').click(function() {
	const id = $(this).data('id');
	$('#admin-form-edit-item'+id).submit();
	// location.reload();
});

$('.admin-select-order-status').change(function() {
	const orderID = $(this).data('order-id');
	const statusID = $(this).val();
	alert('changing status...');
	$.ajax({
		url: 'controllers/admin_change_order_status.php',
		data: { order_id: orderID, status_id: statusID },
		method: 'post',
		success: function(data) {
			$(`select[data-order-id="${orderID}"] [value="${statusID}"]`).prevAll().attr('disabled','disabled');
		}
	});
});

$('[href="#view-order-details"]').click(function() {
	const orderID = $(this).data('order-id');
	$.ajax({
		url: 'controllers/admin_view_order_details.php',
		data: { order_id: orderID },
		method: 'post',
		success: function(data) {
			$('#view-order-details .modal-content').html(data);
		}
	});
});