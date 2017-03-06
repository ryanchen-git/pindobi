$(document).ready(function() {
	$("#star_rating").children().not(":input").hide();
	
	// Create stars from :radio boxes
	$("#star_rating").stars({
		captionEl: $("#stars-cap"),
		cancelShow: false
	});
});