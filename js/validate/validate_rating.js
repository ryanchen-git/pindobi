$(document).ready(function() {
	$("#rating_form").validate({
		rules: {
			vote: "required",
			review: "required"
		},
		messages: {
			vote: "必填欄位",
			review: "必填欄位"
		}
	});
});
