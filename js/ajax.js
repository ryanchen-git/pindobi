function getHTTPObject() {
	var XMLHttpRequestObject = false;
	if(window.XMLHttpRequest) {
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
	else if (window.ActiveXObject) {
		try {
			XMLHttpRequestObject = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try {
				XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e) {
				XMLHttpRequestObject = false;
			}
		}
	}
	return XMLHttpRequestObject;
}

function useful(which_review) {
	var review_id = which_review.getAttribute("href");
	return grabFile(review_id);
}

function grabFile(review_id) {
	var request = getHTTPObject();
	if(request) {
		document.getElementById(review_id).className = "displayLoading";		
		document.getElementById(review_id).innerHTML = "<span style='color: #fff;'>.</span>";
		request.onreadystatechange = function() {
			displayMsg(request, review_id);	
		}
		request.open("GET", "http://www.pindobi.com/business/useful?updates=true&review_id=" + review_id, true);
		request.send(null);
	}		
}

function displayMsg(request, review_id) {
	if(request.readyState == 4) {
		if(request.status == 200 || request.status == 304) {
			var display = document.getElementById(review_id);
			if(request.responseText == "ok") {
				document.getElementById(review_id).className = "";
				display.innerHTML = "已儲存, 謝謝你的投票";
				return true;
			}
		}
	}
}