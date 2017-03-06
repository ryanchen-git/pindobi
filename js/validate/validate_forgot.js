$(document).ready(function() {
	$("#forgot").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
		},
		messages: {
			email: {
				required: "必填欄位",
				email: "錯誤的電子信箱"
			},
		}
	});
});
