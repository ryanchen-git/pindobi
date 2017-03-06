$(document).ready(function() {
	$("#business").validate({
		rules: {
			name: "required",
			address: "required",
			city: "required",
			website_url: {
				url: true
			},
			category: "required"
		},
		messages: {
			name: "必填欄位",
			address: "必填欄位",
			city: "必填欄位",
			website_url: "錯誤的網址",
			category: "必填欄位" 
		}
	});
});
