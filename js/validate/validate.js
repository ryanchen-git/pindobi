$(document).ready(function() {
	$("#password").validate({
		rules: {
			password: {
				required: true,
				minlength: 6
			},
			confirm_password: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			},
		},
		messages: {
			password: {
				required: "必填欄位",
				minlength: "密碼最少6位數"
			},
			confirm_password: {
				required: "必填欄位",
				minlength: "密碼最少6位數",
				equalTo: "與上面的密碼不同"
			},
		}
	});
});
