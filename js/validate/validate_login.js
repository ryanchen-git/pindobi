$(document).ready(function() {
	$("#login").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: "required"
		},
		messages: {
			email: {
				required: "必填欄位",
				email: "錯誤的電子信箱"
			},
			password: "必填欄位"
		}
	});
});
