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

let errorFlag = false;
$('#form-register #div-username #username').blur(function() {
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
			data: {username: username}
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
});

$('#form-register #div-password #password').blur(function() {
	const passwordSelector = '#form-register #div-password';
	const password = $(passwordSelector+' #password').val();
	if (password === '') {
		requireField(passwordSelector);
		setInvalid(passwordSelector+' #password');
		errorFlag = true;
	} else {
		setValid(passwordSelector+' #password');
	}
});

$('#form-register #div-confirm-password #confirm-password').blur(function() {
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
});

$('#form-register').submit(function () {
	let errorFlag1 = false;
	const requiredFields = ['username','password','confirm-password'];
	for (let requiredField of requiredFields) {
		const currentField = '#form-register #'+ requiredField;
		if ($(currentField).val() === '') {
			requireField('#form-register #div-'+requiredField);
			setInvalid(currentField);
			errorFlag1 = true;
		}
	}
	return !errorFlag && !errorFlag1;
});