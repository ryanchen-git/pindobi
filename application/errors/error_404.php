<?php
	if($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
		$base_url = 'http://dev.pindobi.com/';
	}
	else {
		$base_url = 'http://www.pindobi.com/';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>找不到網頁</title>

<meta name="description" content="" />
<meta name="keywords" content="" />

<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>css/autocomplete.css" />

<script type='text/javascript' src='<?php echo $base_url; ?>js/autocomplete/jquery.autocomplete.js'></script>

<script type="text/javascript">
$().ready(function() {
	$("#search").autocomplete("<?php echo $base_url; ?>script/business/", {
		width: 250,
		selectFirst: false
	});
});
</script>

<script type="text/javascript">
$().ready(function() {
	$("#city").autocomplete("<?php echo $base_url; ?>script/city/", {
		width: 250,
		selectFirst: false
	});
});
</script>

<style>
.error { text-align: center; }
.error h2 { font-size: 16px; }
</style>

</head>

<body>

<div id="body_wrapper">

    <div id="above_header">
        <div class="text">
                <a href="<?php echo $base_url; ?>signup">加入會員</a> | <a href="<?php echo $base_url; ?>login">登入</a> 		
		</div> <!-- End text div -->
    </div> <!-- End above_header div -->
    
    <div id="header">
        <div class="logo"><a href="<?php echo $base_url; ?>"><img src="<?php echo $base_url; ?>img/logo.gif" width="157" height="78" /></a></div>

        <form name="search" id="search_form" method="get" action="<?php echo $base_url; ?>search">
            <div class="input">
                <label for="search"><span>店家 <span class="example">(例: 鼎泰豐)</span></span></label><br />
                <input type="text" name="business" id="search"  />
    
            </div>
    
            <div class="input">
                <label for="place"><span>縣市 <span class="example">(例: 台北市)</span></span></label><br />
                <input type="text" name="city" id="city"  />
            </div>
            
            <div class="submit_btn">
                <input type="submit" class="search_submit" value="" />
            </div>
        </form>
        
        <div id="nav">
            <ul>
               <li><a href="<?php echo $base_url; ?>business/write/g">寫評語</a></li>
               <li><a href="<?php echo $base_url; ?>business/city/台北市/all">看評語</a></li>			   
               <li><a href="<?php echo $base_url; ?>login">我的地盤</a></li>
               <li><a href="<?php echo $base_url; ?>member/user/e">我的評語</a></li>
               <li><a href="<?php echo $base_url; ?>member/business_photo/e">我的相簿</a></li>
               <li><a href="<?php echo $base_url; ?>member/user/e/bookmark">我的書籤</a></li>
               <li><a href="<?php echo $base_url; ?>profile">我的帳號</a></li>			   
            </ul>
        </div>
    </div> <!-- End header div -->
	
	<div id="content_wrapper"> 			
		<div class="error">	
			<h2>找不到這個網頁喔!</h2>
			<br /><a href="javascript:history.back();">按這裡</a>回上一頁或是回<a href="<?php echo $base_url; ?>">評多比首頁</a>。
		</div>
	</div> <!-- End content_wrapper div -->
	
	<div id="footer">
		<a href="<?php echo $base_url; ?>about">關於評多比</a> | <!--<a href="faq">常見問題</a> | --><a href="<?php echo $base_url; ?>terms">服務條款</a>
		<div id="copyright">版權所有&copy; <?php echo date('Y');?> 評多比</div>
	</div>
</div> <!-- End body_wrapper div -->

</body>
</html>