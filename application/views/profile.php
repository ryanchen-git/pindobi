<?php
	$page = $this->uri->segment(1);
	$type = $this->uri->segment(2);

    if(isset($invalid_file)) { ?>
        <div class="top_status_bar"> 
            照片檔案有錯誤. 目前只接受jpg跟gif檔, 檔案不得大於1MB
        </div> <?php	
    }
?>

<div id="content3">
<?php
	if($page == 'reset') { ?>
		<h1>重新設定密碼</h1>	
		<form name="password_reset" id="password_reset" method="post" action="<?php echo base_url(); ?>profile/password_reset">
			<ol>
				<li>
					<label for="password" class="display">新的密碼:</label>
					<input type="password" name="password" id="password" />
				</li>
						
				<li>
					<label for="confirm_password" class="display">再輸入新的密碼:</label>
					<input type="password" name="confirm_password" id="confirm_password" />
				</li>
			</ol>
			<input type="hidden" name="member_unique_id" value="<?php echo $member_unique_id; ?>" />
			<input type="hidden" name="reset_password_submit" />
            <input type="submit" id="password_reset_submit" value="" />
	    </form> <?php
	}	

	if($type == 'info') { ?>
		<h1>我的個人資料</h1>
		<form name="info" id="info" method="post" action="<?php echo base_url(); ?>profile/info">
			<ol>
				<li><span class="name">姓名:</span>
					<label for="lastname">姓</label> 
					<input type="text" name="lastname" id="lastname" value="<?php echo $member_profile['last_name']; ?>" />
	
					<label for="firstname">名</label>
					<input type="text" name="firstname" id="firstname" value="<?php echo $member_profile['first_name']; ?>" />
				</li>
							
				<li>
					<label for="gender" class="display">性別:</label>
					<select name="gender" id="gender">
						<option value="m" <?php if($member_profile['gender'] == 'm') { echo "selected"; } ?>>男生</option>
						<option value="f" <?php if($member_profile['gender'] == 'f') { echo "selected"; } ?>>女生</option>
					</select>
				</li>
                
				<li>
					<label for="city" class="display">居住地:</label>
					<select name="city" class="city">
					<?php
						foreach($city_list as $city) { ?>
							<option value="<?php echo $city['city']; ?>" <?php if($member_profile['city'] == $city['city']) { echo "selected"; }?>><?php echo $city['city']; ?></option> <?php
						}
					?>
					</select>
				</li>			
						
				<li>
					<label for="birthday" class="display">生日:</label> 
					<select name="birth_year" class="birth_year">
					<?php
						foreach($birth_year as $year) { ?>		
							<option value="<?php echo $year['year']; ?>" <?php if($member_profile['birth_year'] == $year['year']) { echo "selected"; } ?>><?php echo $year['year']; ?></option> <?php
						}
					?>					                
					</select> 年
					<select name="birth_month" class="birth_month">
						<option value="1" <?php if($member_profile['birth_month'] == '1') { echo "selected"; } ?>>1</option>
						<option value="2" <?php if($member_profile['birth_month'] == '2') { echo "selected"; } ?>>2</option>
						<option value="3" <?php if($member_profile['birth_month'] == '3') { echo "selected"; } ?>>3</option>
						<option value="4" <?php if($member_profile['birth_month'] == '4') { echo "selected"; } ?>>4</option>
						<option value="5" <?php if($member_profile['birth_month'] == '5') { echo "selected"; } ?>>5</option>
						<option value="6" <?php if($member_profile['birth_month'] == '6') { echo "selected"; } ?>>6</option>
						<option value="7" <?php if($member_profile['birth_month'] == '7') { echo "selected"; } ?>>7</option>
						<option value="8" <?php if($member_profile['birth_month'] == '8') { echo "selected"; } ?>>8</option>
						<option value="9" <?php if($member_profile['birth_month'] == '9') { echo "selected"; } ?>>9</option>
						<option value="10" <?php if($member_profile['birth_month'] == '10') { echo "selected"; } ?>>10</option>
						<option value="11" <?php if($member_profile['birth_month'] == '11') { echo "selected"; } ?>>11</option>
						<option value="12" <?php if($member_profile['birth_month'] == '12') { echo "selected"; } ?>>12</option>
					</select> 月
					<select name="birth_date" class="birth_date">
						<option value="1" <?php if($member_profile['birth_date'] == '1') { echo "selected"; } ?>>1</option>
						<option value="2" <?php if($member_profile['birth_date'] == '2') { echo "selected"; } ?>>2</option>
						<option value="3" <?php if($member_profile['birth_date'] == '3') { echo "selected"; } ?>>3</option>
						<option value="4" <?php if($member_profile['birth_date'] == '4') { echo "selected"; } ?>>4</option>
						<option value="5" <?php if($member_profile['birth_date'] == '5') { echo "selected"; } ?>>5</option>
						<option value="6" <?php if($member_profile['birth_date'] == '6') { echo "selected"; } ?>>6</option>
						<option value="7" <?php if($member_profile['birth_date'] == '7') { echo "selected"; } ?>>7</option>
						<option value="8" <?php if($member_profile['birth_date'] == '8') { echo "selected"; } ?>>8</option>
						<option value="9" <?php if($member_profile['birth_date'] == '9') { echo "selected"; } ?>>9</option>
						<option value="10" <?php if($member_profile['birth_date'] == '10') { echo "selected"; } ?>>10</option>
						<option value="11" <?php if($member_profile['birth_date'] == '11') { echo "selected"; } ?>>11</option>
						<option value="12" <?php if($member_profile['birth_date'] == '12') { echo "selected"; } ?>>12</option>
						<option value="13" <?php if($member_profile['birth_date'] == '13') { echo "selected"; } ?>>13</option>
						<option value="14" <?php if($member_profile['birth_date'] == '14') { echo "selected"; } ?>>14</option>
						<option value="15" <?php if($member_profile['birth_date'] == '15') { echo "selected"; } ?>>15</option>
						<option value="16" <?php if($member_profile['birth_date'] == '16') { echo "selected"; } ?>>16</option>
						<option value="17" <?php if($member_profile['birth_date'] == '17') { echo "selected"; } ?>>17</option>
						<option value="18" <?php if($member_profile['birth_date'] == '18') { echo "selected"; } ?>>18</option>
						<option value="19" <?php if($member_profile['birth_date'] == '19') { echo "selected"; } ?>>19</option>
						<option value="20" <?php if($member_profile['birth_date'] == '20') { echo "selected"; } ?>>20</option>
						<option value="21" <?php if($member_profile['birth_date'] == '21') { echo "selected"; } ?>>21</option>
						<option value="22" <?php if($member_profile['birth_date'] == '22') { echo "selected"; } ?>>22</option>
						<option value="23" <?php if($member_profile['birth_date'] == '23') { echo "selected"; } ?>>23</option>
						<option value="24" <?php if($member_profile['birth_date'] == '24') { echo "selected"; } ?>>24</option>
						<option value="25" <?php if($member_profile['birth_date'] == '25') { echo "selected"; } ?>>25</option>
						<option value="26" <?php if($member_profile['birth_date'] == '26') { echo "selected"; } ?>>26</option>
						<option value="27" <?php if($member_profile['birth_date'] == '27') { echo "selected"; } ?>>27</option>
						<option value="28" <?php if($member_profile['birth_date'] == '28') { echo "selected"; } ?>>28</option>
						<option value="29" <?php if($member_profile['birth_date'] == '29') { echo "selected"; } ?>>29</option>
						<option value="30" <?php if($member_profile['birth_date'] == '30') { echo "selected"; } ?>>30</option>
						<option value="31" <?php if($member_profile['birth_date'] == '31') { echo "selected"; } ?>>31</option>
					</select> 日
				</li>
			</ol>
			<input type="hidden" name="update_info_submit" />
			<input type="submit" id="info_submit" value="" />		
	    </form> 
		<a href="javascript:history.back();">取消</a> <?php
	}
	else if($type == 'password') { ?>
		<h1>我的密碼</h1>	
		<form name="password" id="password_change" method="post" action="<?php echo base_url(); ?>profile/password">
			<ol>
				<li>
					<label for="password" class="display">新的密碼:</label>
					<input type="password" name="password" id="password" />
				</li>
						
				<li>
					<label for="confirm_password" class="display">再輸入新的密碼:</label>
					<input type="password" name="confirm_password" id="confirm_password" />
				</li>
			</ol>
			<input type="hidden" name="update_password_submit" />
			<input type="submit" id="password_submit" value="" />		
	    </form> 
		<a href="javascript:history.back();">取消</a> <?php
	}
	else if($type == 'photo') {  ?>
		<h1>我的個人照片</h1>	
		請從電腦裡選擇想上傳的照片, 然後按"確定". <br />
		一個會員只能擁有一張個人照片, 新上傳的照片將會自動取代舊的照片.
		<form class="file_upload" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>profile/photo">
			<label for="file"></label>
			<input type="file" name="file" class="image_file" />
			<br />
			<input type="hidden" name="update_photo_submit" />			
			<input type="submit" class="upload_submit" value="" />		            
		</form>
        
		<div class="uploaded_photo">
			<p>現有照片:</p>
			<?php
				if(!empty($profile_photo['filename_m'])) { ?>
					<img src="<?php echo base_url(); ?>img/member/<?php echo $profile_photo['filename_m']; ?>" class="photo" /> <a href="<?php echo base_url(); ?>profile/delete_profile_photo">刪除照片</a><?php
				}
				else { ?>
					<img src="<?php echo base_url(); ?>img/blank_member.gif" class="photo" /> <?php
				}
			?>
			<?php if(isset($photo_avil)) { ?><?php } ?>
		</div> 
		<a href="<?php echo base_url(); ?>profile">返回我的帳號</a> <?php
	}	
	else if($type == '') { 
		if(isset($updates)) { ?>
			<div class="top_status_bar_short">
				資料更新完成
			</div> <?php	
		} ?>
	
		<div class="profile_column_left">
			<div class="profile_section">
				<h2>個人照片</h2>
                <div class="main">
                <?php
					if(!empty($profile_photo['filename_m'])) { ?>
						<a href="<?php echo base_url(); ?>img/member/<?php echo $profile_photo['filename_l']; ?>"><img src="<?php echo base_url(); ?>img/member/<?php echo $profile_photo['filename_m']; ?>" class="photo" /></a> <?php
					}
					else { ?>
						<img src="<?php echo base_url(); ?>img/blank_member.gif" class="photo" /> <?php
					}
				?>
                </div>
				我現在的照片
				<div class="link">
					<a href="<?php echo base_url(); ?>profile/photo">上傳或改變我的個人照片</a>
				</div>			
			</div>
			<div class="profile_section">
				<h2>個人資料</h2>
				在評多比的個人資料
				<div class="link">
					<a href="<?php echo base_url(); ?>profile/info">修改我的個人資料</a>
				</div>
			</div>
		</div>		
		
		<div class="profile_column_right">		
			<div class="profile_section">
				<h2>電子信箱</h2>
				<span><?php echo $this->session->userdata('email'); ?></span>
				<div class="link">
					目前暫不接受管理電子信箱的服務
				</div>			
			</div>
			<div class="profile_section">
				<h2>密碼</h2>
				更換登入評多比的密碼
				<div class="link">
					<a href="<?php echo base_url(); ?>profile/password">更改我的密碼</a>
				</div>			
			</div>	
		</div>	<?php
	}
?>
</div>