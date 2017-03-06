<?php
	$page = $this->uri->segment(1);
	
	if(isset($_GET['activate']) && $_GET['activate'] == 'success') { ?>
		<div class="top_status_bar">
			帳號已成功啓動, 請登入帳號
		</div> <?php
	}
	
	if(isset($_GET['reset']) && $_GET['reset'] == 'success') { ?>
		<div class="top_status_bar">
			密碼已重新設定, 請登入帳號
		</div> <?php
	}	

	if($page == 'login') { 
		if(isset($login_error)) { ?>
            <div class="top_status_bar">
                帳號或密碼有錯誤, 請再試一次
            </div> <?php
		} ?>
    
		<div id="content2">
			<h1>會員登入</h1>
			請輸入你的電子信箱跟密碼
			<form name="login" id="login" method="post" action="<?php echo base_url(); ?><?php echo $action; ?>">
				<ol>
					<li>
						<label for="email" class="display">電子信箱:</label>
						<input type="text" name="email" id="email" />
					</li>
					<li>
						<label for="password" class="display">密碼:</label>
						<input type="password" name="password" id="password" />
					</li>
					<li class="forgot"><a href="<?php echo base_url(); ?>forgot">無法登入?</a></li>
				</ol>
				<input type="hidden" name="login_submit" />
				<input type="submit" class="login_submit" value="" />		
			</form>
		</div>
		
		<div id="sidebar2">
			<h2>還不是會員嗎?</h2>
			加入會員就是現在!<br /><br />
			<a href="<?php echo base_url(); ?>signup"><img src="<?php echo base_url(); ?>img/signup.gif" /></a>
		</div> <?php
	}
	else if($page == 'forgot') { 
		if(isset($_GET['email'])) { ?> 
			E-mail已寄出. 請登入你的電子郵件信箱來重新設定你評多比的密碼 <?php
		}
		else {?>
			<div id="content3">	
				<h1>重設密碼</h1>
				請輸入電子信箱, 我們將會寄一封email讓你重新設定密碼
				<form name="forgot" id="forgot" method="post" action="<?php echo base_url(); ?>forgot">
					<ol>
						<li>
							<label for="email" class="display">電子信箱:</label>
							<input type="text" name="email" id="email" />
						</li>
					</ol>
					<input type="hidden" name="forgot_submit" />				
					<input type="submit" class="forgot_submit" value="" />		
				</form>   
                <br /><a href="javascript:history.back();">取消</a>
			</div> <?php
		}
	} 
?>