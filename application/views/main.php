<div id="content">
<?php
	if($this->session->userdata('firstname')) { ?>
		<div class="welcome_box">
		<?php
			if(!empty($profile_photo['filename_s'])) { ?>
				<img src="<?php echo base_url(); ?>img/member/<?php echo $profile_photo['filename_s']; ?>" class="photo" /> <?php
			}
			else { ?>
				<img src="<?php echo base_url(); ?>img/blank_member.gif" class="photo" /> <?php
			}
		?>
			<div class="info">
				<div class="title">歡迎回來，<?php echo $this->session->userdata('lastname'); ?><?php if(preg_match("/[a-zA-Z]/",$member_profile['last_name'])) { echo "，"; } ?><?php echo $this->session->userdata('firstname'); ?></div>
				<?php
					if(!empty($business_rand['unique_id'])) { ?>
						<p>我們在<a href="<?php echo base_url(); ?>business/city/<?php echo $this->session->userdata('city_english'); ?>/all"><?php echo $this->session->userdata('city'); ?></a>隨機選了一個<a href="<?php echo base_url(); ?>business/view/<?php echo $business_rand['unique_id']; ?>">店家</a>，趕快去看看你去過了沒。</p> <?php
					}
				?>
				<p>你的<a href="<?php echo base_url(); ?>member/user/<?php echo $this->session->userdata('unique_id'); ?>">個人首頁</a>已被瀏覽過<?php echo $member_profile['pageview']; ?>次。</p>
				<p>總共有<?php echo $total_usefulness; ?>人覺得你寫的<a href="<?php echo base_url(); ?>member/user/<?php echo $this->session->userdata('unique_id'); ?>">評語</a>實用。</p>
			</div>
		</div> <?php
	}
?>

	<h1>新增店家</h1>
	<div class="business_section">
		<div class="latest">
			<div class="title">餐廳</div>
			<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_1['filename_m']; ?>" class="photo" />
			<ol>
			<?php
				foreach($business_new_1 as $business) { ?>
					<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a> (<?php echo $business['city']; ?>)</li> <?php
				}
			?>
			</ol>		
		</div>	
		
		<div class="latest">
			<div class="title">商店百貨</div>			
			<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_2['filename_m']; ?>" class="photo" />
			<ol>
			<?php
				foreach($business_new_2 as $business) { ?>
					<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a> (<?php echo $business['city']; ?>)</li> <?php
				}
			?>
			</ol>						
		</div>	

		<div class="latest">
			<div class="title">糕餅甜點</div>			
			<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_5['filename_m']; ?>" class="photo" />
			<ol>
			<?php
				foreach($business_new_5 as $business) { ?>
					<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a> (<?php echo $business['city']; ?>)</li> <?php
				}
			?>
			</ol>						
		</div>		
	</div>	
	
	<h1>熱門店家</h1>
	<div class="business_section">		
		<div class="latest">
			<div class="title">餐廳</div>			
			<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_1a['filename_m']; ?>" class="photo" />
			<ol>
			<?php
				foreach($business_num_1 as $business) { ?>
					<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a> (<?php echo $business['city']; ?>)</li> <?php
				}
			?>
			</ol>			
		</div>	
		
		<div class="latest">
			<div class="title">商店百貨</div>			
			<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_2a['filename_m']; ?>" class="photo" />
			<ol>
			<?php
				foreach($business_num_2 as $business) { ?>
					<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a> (<?php echo $business['city']; ?>)</li> <?php
				}
			?>
			</ol>						
		</div>	

		<div class="latest">
			<div class="title">糕餅甜點</div>			
			<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_5a['filename_m']; ?>" class="photo" />
			<ol>
			<?php
				foreach($business_num_5 as $business) { ?>
					<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a> (<?php echo $business['city']; ?>)</li> <?php
				}
			?>
			</ol>						
		</div>		
	</div>
</div>

<div id="sidebar">		

	<div class="column">
		<h2>以縣市搜尋店家</h2>
		<div class="city">
		<?php
			$start = array(0, 9, 18);
			$end = array(8, 17, 24);
			$i = 0;						
			foreach($city_list as $city) { 
				if(in_array($i, $start)) { echo "<ul>"; } ?>
				<li><a href="<?php echo base_url(); ?>business/city/<?php echo $city['city_english']; ?>/all"><?php echo $city['city']; ?></a> (<?php echo $city['count']; ?>)</li> <?php 
				if(in_array($i, $end)) { echo "</ul>"; }	
				$i++;
			} // End foreach loop
		?>
		</div>                        
	</div>
	
	<div class="latest_review">
		<h2>最新店家評語</h2> 
		<?php
			if(!empty($latest_review)) {
				foreach($latest_review as $review) { ?>
					<div class="title">
						<a href="<?php echo base_url(); ?>business/view/<?php echo $review['business_unique_id']; ?>"><?php echo $review['name']; ?></a> <img src="<?php echo base_url(); ?>img/stars/<?php echo $review['rating']; ?>.png" /> 
					</div>
					<div class="info">
						<?php echo substr($review['review_time'], 0, 4) . "年" . substr($review['review_time'], 5, 2) . "月" . substr($review['review_time'], 8, 2) . "日"; ?> <a href="<?php echo base_url(); ?>member/user/<?php echo $review['member_unique_id']; ?>"><?php echo $review['first_name']; ?></a>
					</div>
					<div class="profile_photo">
						<a href="<?php echo base_url(); ?>member/user/<?php echo $review['member_unique_id']; ?>"> 
						<?php
							if(!empty($review['filename_s'])) { ?>
								<img src="<?php echo base_url(); ?>img/member/<?php echo $review['filename_s']; ?>" class="photo" /></a> <?php
							}
							else { ?>
								<img src="<?php echo base_url(); ?>img/blank_member.gif" class="photo" /></a> <?php
							}
						?>
					</div>
					<div class="review">
						<?php echo mb_substr($review['review'], 0, 85, 'utf-8'); ?>... <a href="<?php echo base_url(); ?>business/view/<?php echo $review['business_unique_id']; ?>">看全部</a>
					</div> <?php					
				} // End foreach loop
			}
			else { ?>
				目前這個縣市還沒有任和評語唷, <a href="<?php echo base_url(); ?>business/write/g">現在就寫評語</a>! <?php
			}
		?>						
	</div>

</div>