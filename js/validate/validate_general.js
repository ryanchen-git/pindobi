$(document).ready(function() {
	$("#info").validate({
		rules: {
			lastname: "required",
			firstname: "required",
			gender: "required",			
			city: "required",			
			birth_year: "required",
			birth_month: "required",
			birth_date: "required"
		},
		messages: {
			lastname: "必填欄位",
			firstname: "必填欄位",
			gender: "必填欄位",			
			city: "必填欄位",
			birth_year: "",
			birth_month: "",
			birth_date: ""		
		}
	});
						   
	$("#password_change").validate({
		rules: {
			password: {
				required: true,
				minlength: 6
			},
			confirm_password: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			}
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
			}
		}
	});
	
	$("#password_reset").validate({
		rules: {
			password: {
				required: true,
				minlength: 6
			},
			confirm_password: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			}
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
			}
		}
	});
	
});
