<div id="content2">
<?php
	if(isset($post_signup)) { ?>
		確認信函已經送出, 請登錄到你的電子信箱來啓動你評多比的帳號. <?php
	}
	else { ?>
		<h1>加入會員</h1>
		<form name="signup" id="signup" method="post" action="<?php echo base_url(); ?>signup/submit">
			<ol>
				<li><span class="name">姓名:</span>
					<label for="lastname">姓</label> 
					<input type="text" name="lastname" id="lastname" />
	
					<label for="firstname">名</label>
					<input type="text" name="firstname" id="firstname" />
				</li>
				
				<li>
					<label for="email" class="display">電子信箱:</label> 
					<input type="text" name="email" id="email" />
				</li>
				
				<li>
					<label for="password" class="display">密碼:</label>
					<input type="password" name="password" id="password" />
				</li>
				
				<li>
					<label for="confirm_password" class="display">再輸入密碼:</label>
					<input type="password" name="confirm_password" id="confirm_password" />
				</li>
				
				<li>
					<label for="gender" class="display">性別:</label>
					<select name="gender" id="gender">
						<option value="">------</option>
						<option value="m">男生</option>
						<option value="f">女生</option>
					</select>
				</li>
						
				<li>
					<label for="city" class="display">居住地:</label>
					<select name="city" class="city">
						<option value="">---------</option>                    
					<?php
						foreach($city_list as $city) { ?>
							<option value="<?php echo $city['city']; ?>"><?php echo $city['city']; ?></option> <?php
						}
					?>
					</select>
				</li>			
						
				<li>
					<label for="birthday" class="display">生日:</label> 
					<select name="birth_year" class="birth_year">
						<option value="">西元</option>        
				<?php
						foreach($birth_year as $year) { ?>		
							<option value="<?php echo $year['year']; ?>"><?php echo $year['year']; ?></option> <?php
						}
				?>
					</select> 年
					<select name="birth_month" class="birth_month">
						<option value="">---</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
					</select> 月
					<select name="birth_date" class="birth_date">
						<option value="">---</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						<option value="24">24</option>
						<option value="25">25</option>
						<option value="26">26</option>
						<option value="27">27</option>
						<option value="28">28</option>
						<option value="29">29</option>
						<option value="30">30</option>
						<option value="31">31</option>
					</select> 日
				</li>
				<li class="agree">按下"加入"鈕表示你已閱讀並同意接受評多比的<a href="<?php echo base_url(); ?>terms/" target="_blank">服務條款</a>.</li>                
			</ol>
			<input type="hidden" name="signup_submit" />
			<input type="submit" id="signup_submit" value="" />		
		</form> <?php
	} ?>
</div>

<div id="sidebar2">
	<img src="<?php echo base_url(); ?>img/signUpAd.gif" class="ad_banner" />
	<h2>已經昰會員了嗎? <span class="signin">從這裡登入</span></h2>
	<form name="login2" id="login2" method="post" action="<?php echo base_url(); ?>login">
		<ol>
			<li>
				<label for="email" class="display">電子信箱:</label>
				<input name="email" type="text" id="email" />
			</li>
			<li>
				<label for="password" class="display">密碼:</label>
				<input name="password" type="password" id="password" />
			</li>
			<li class="forgot"><a href="<?php echo base_url(); ?>forgot">忘記密碼了嗎?</a></li>            
		</ol>
		<input type="hidden" name="login_submit" />		
		<input type="submit" class="login2_submit" value="" />		
        
	</form>
</div>