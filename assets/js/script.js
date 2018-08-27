// materialize js initializations
$(".dropdown_menu").dropdown();
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