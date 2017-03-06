<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title; ?></title>

<meta name="description" content="<?php echo $meta_desc; ?>" />
<meta name="keywords" content="<?php echo $meta_key; ?>" />

<link rel="Shortcut Icon" href="<?php echo base_url(); ?>favicon.ico">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>    

<?php
	if(isset($css)) { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/<?php echo $css; ?>" /> <?php
	}
	
	if(isset($google_map_small)) { ?> <script type="text/javascript" src="http://maps.google.com.tw/maps?file=api&v=2&key=ABQIAAAA-KvhRLBEMfUEAhf51QCUZRQcvm6yDE61UwF2x8r5o9DIZsHyjRR2lwyHqksMrYnLCFKHqV_mYEyH1A"></script> <?php }		
	if(isset($google_map_big)) { ?> <script type="text/javascript" src="http://maps.google.com.tw/maps?file=api&v=2&key=ABQIAAAA-KvhRLBEMfUEAhf51QCUZRQcvm6yDE61UwF2x8r5o9DIZsHyjRR2lwyHqksMrYnLCFKHqV_mYEyH1A"></script> <?php }					
	
	if(isset($js)) { ?>	
		<script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo $js; ?>"></script> <?php
		if(isset($js2)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo $js2; ?>"></script> <?php }
		if(isset($js3)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/<?php echo $js3; ?>"></script> <?php }	
		if(isset($js_lightbox)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/lightbox/lightbox.js"></script> <?php }
		if(isset($js_lightbox_business_photo)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/lightbox/business_photo_lightbox.js"></script> <?php }	
		if(isset($js_validate_signup)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/validate/validate_signup.js"></script> <?php }
		if(isset($js_validate_login)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/validate/validate_login.js"></script> <?php }	
		if(isset($js_validate_forgot)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/validate/validate_forgot.js"></script> <?php }		
		if(isset($js_validate_business)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/validate/validate_business.js"></script> <?php }	
		if(isset($js_validate_general)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/validate/validate_general.js"></script> <?php }			
		if(isset($js_validate_add_business)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/validate/validate_add_business.js"></script> <?php }			
		if(isset($js_file_uploads)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/file_uploads/file_uploader.js"></script> <?php }	
		if(isset($js_rating)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/rating/star_rating.js"></script> <?php }	
		if(isset($js_validate_rating)) { ?> <script type="text/javascript" src="<?php echo base_url(); ?>js/validate/validate_rating.js"></script> <?php }	
	}
	
	if(isset($focus_id)) { ?>
		<script type="text/javascript">
			function initPage() {
				document.getElementById("<?php echo $focus_id; ?>").focus();
			} 
		</script> <?php
	}
?>
<script type='text/javascript' src='<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js'></script>

<script type="text/javascript">
$().ready(function() {
	$("#search").autocomplete("<?php echo base_url(); ?>script/business/", {
		width: 250,
		selectFirst: false
	});
});
</script>

<script type="text/javascript">
$().ready(function() {
	$("#city").autocomplete("<?php echo base_url(); ?>script/city/", {
		width: 250,
		selectFirst: false
	});
});
</script>

</head>

<body <?php if(isset($focus_id)) { ?>onload="initPage()"<?php } else if(isset($google_map_small)) { ?>onload="load()" onunload="GUnload()"<?php } else if(isset($google_map_big)) { ?>onload="load2()" onunload="GUnload()"<?php }?>>

<div id="body_wrapper">
	<div id="above_header">
		<div class="text">
<?php 
			if($this->session->userdata('firstname')) { ?>
				Hello, <a href="<?php echo base_url(); ?>member/user/<?php echo $this->session->userdata('unique_id'); ?>"><?php echo $this->session->userdata('firstname'); ?></a> | <a href="<?php echo base_url(); ?>profile">我的帳號</a> | <a href="<?php echo base_url(); ?>logout">登出</a><?php
			}
			else { ?>			
				<a href="<?php echo base_url(); ?>signup">加入會員</a> | <a href="<?php echo base_url(); ?>login">登入</a> <?php
			} 
?>
		</div> <!-- End text div -->
	</div> <!-- End above_header div -->
	
	<div id="header">
	<?php
		if($this->input->get('search_city')) {
			$city = array(
			   'city'  => $this->input->get('search_city')
			);
			$this->session->set_userdata($city);
		}
	?>
		
		<div class="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>img/logo.gif" width="157" height="78" /></a></div>
		
		<form name="search" id="search_form" method="get" action="<?php echo base_url(); ?>search">
			<div class="input">
				<label for="search"><span>店家 <span class="example">(例: 鼎泰豐)</span></span></label><br />
				<input type="text" name="business" id="search" <?php if($this->input->get('business')) { echo 'value="' . $_GET['business'] . '"'; } ?> />
			</div>
	
			<div class="input">
				<label for="place"><span>縣市 <span class="example">(例: 台北市)</span></span></label><br />
				<input type="text" name="city" id="city" <?php if($this->input->get('city')) { echo 'value="' . $_GET['city'] . '"'; } else if($this->session->userdata('city')) { echo 'value="' . $this->session->userdata('city') . '"'; } ?> />
			</div>
			
			<div class="submit_btn">
				<input type="submit" class="search_submit" value="" />
			</div>
		</form>
		
		<div id="nav">
			<ul>
			   <li><a href="<?php echo base_url(); ?>">歡迎</a></li>
			   <li><a href="<?php echo base_url(); ?>business/city/<?php if($this->session->userdata('city')) { echo $this->session->userdata('city_english'); } else { echo "taipei_city"; } ?>/all">看評語</a></li>
			   <li><a href="<?php echo base_url(); ?>business/write/g">寫評語</a></li>
			   <li><?php if($this->session->userdata('unique_id')) { ?><a href="<?php echo base_url(); ?>business/city/<?php echo $this->session->userdata('city_english'); ?>/all"><?php } else { ?><a href="<?php echo base_url(); ?>login"><?php } ?>我的地盤<?php if($this->session->userdata('unique_id')) { echo ': ' . $this->session->userdata('city'); } ?></a></li>
			   <li><a href="<?php echo base_url(); ?>member/user/<?php if($this->session->userdata('unique_id')) { echo $this->session->userdata('unique_id'); } else { echo "e"; } ?>">我的評語</a></li>
			   <li><a href="<?php echo base_url(); ?>member/business_photo/<?php if($this->session->userdata('unique_id')) { echo $this->session->userdata('unique_id'); } else { echo "e"; } ?>">我的相簿</a></li>
			   <li><a href="<?php echo base_url(); ?>member/user/<?php if($this->session->userdata('unique_id')) { echo $this->session->userdata('unique_id'); } else { echo "e"; } ?>/bookmark">我的書籤</a></li>
			   <li><a href="<?php echo base_url(); ?>profile">我的帳號</a></li>			   
			</ul>
		</div>
	</div> <!-- End header div -->
	
	<?php
		if($this->uri->segment(1) == '') { ?>
			<div id="content_wrapper_business_view"> <?php
		}
		else if($this->uri->segment(1) == 'business') {
			if($this->uri->segment(2) == 'view' || $this->uri->segment(2) == 'city') { ?>
				<div id="content_wrapper_business_view"> <?php
			}
			else { ?>
				<div id="content_wrapper"> <?php
			}
		}
		else { ?>
			<div id="content_wrapper"> <?php
		}
	?>
