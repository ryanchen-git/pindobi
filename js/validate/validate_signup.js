$(document).ready(function() {
	$("#signup").validate({
		rules: {
			lastname: "required",
			firstname: "required",
			email: {
				required: true,
				email: true,
				remote: 'http://www.pindobi.com/library/check_email.php'
			},
			password: {
				required: true,
				minlength: 6
			},
			confirm_password: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			},
			city: "required",			
			gender: "required",
			birth_year: "required",
			birth_month: "required",
			birth_date: "required"
		},
		messages: {
			lastname: "必填欄位",
			firstname: "必填欄位",
			email: {
				required: "必填欄位",
				email: "錯誤的電子信箱",
				remote: "這個電子信箱已被使用"
			},
			password: {
				required: "必填欄位",
				minlength: "密碼最少6位數"
			},
			confirm_password: {
				required: "必填欄位",
				minlength: "密碼最少6位數",
				equalTo: "與上面的密碼不同"
			},
			city: "必填欄位",
			gender: "必填欄位",
			birth_year: "",
			birth_month: "",
			birth_date: ""		
		}
	});

	$("#login2").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: "required"
		},
		messages: {
			email: "",
			password: ""
		}
	});
});
