<?php
	$page = $this->uri->segment(2);
	$type = $this->uri->segment(4);
	
	if(isset($_GET['updates'])) { ?>
		<div class="top_status_bar"> 
		<?php
			switch ($_GET['type'])
			{
			case 'photo':
			  echo "照片已刪除";
			  break;
			case 'review':
			  echo "評語已刪除";
			  break;
			case 'edit_review':
			  echo "評語已更改";
			  break;			  
			case 'bookmark':
			  echo "書籤已刪除";
			  break;
			} 
		?>	
		</div> <?php	
	} ?> 	

	<div id="top_sub_nav">
		<ul>
			瀏覽<?php echo $member_profile['first_name']; ?>的:
			<li><a href="<?php echo base_url(); ?>member/user/<?php echo $member_profile['unique_id']; ?>">評語</a></li>
			<li><a href="<?php echo base_url(); ?>member/business_photo/<?php echo $member_profile['unique_id']; ?>">相簿</a></li>				
			<li><a href="<?php echo base_url(); ?>member/user/<?php echo $member_profile['unique_id']; ?>/bookmark">書籤</a></li>
		</ul>
	</div>

	<div id="member_sidebar_left">
		<div class="name"><?php echo $member_profile['first_name']; ?></div>
		<div class="main">
		<?php
			if(empty($profile_photo['filename_m'])) { ?>
				<img src="<?php echo base_url(); ?>img/blank_member.gif" class="photo" /><?php
			}
			else { ?>
				<a href="<?php echo base_url(); ?>img/member/<?php echo $profile_photo['filename_l']; ?>"><img src="<?php echo base_url(); ?>/img/member/<?php echo $profile_photo['filename_m']; ?>" class="photo" /></a> <?php
			} 
		?>
		</div>
		<?php
			if($num_photo != 0) { ?>
				<p><a href="<?php echo base_url(); ?>member/business_photo/<?php echo  $member_profile['unique_id']; ?>">相簿</a> (<?php echo $num_photo; ?>)</p> <?php
			} 
		?>
		
		<span>居住縣市:</span>
		<p><?php echo $member_profile['city']; ?></p>
		
		<span>加入評多比日期:</span>
		<p><?php echo substr($member_profile['signup_time'], 0, 4) . "年" . substr($member_profile['signup_time'], 5, 2) . "月"; ?></p>
	</div>

<?php
	if($page == 'user') { 
		if($type == '') { ?>
			<div id="member_content">
            	<?php
					if($num_review != 0) { ?>
                        <div class="header">共<?php echo $num_review; ?>則評語</div>
                        <?php
                            foreach($member_review as $review) { ?>				
                                <div class="review_area">
                                    <div class="biz_info">
                                        <div class="column_left">
                                            <a href="<?php echo base_url(); ?>business/view/<?php echo $review['unique_id']; ?>"><?php echo $review['name']; ?></a><br />
                                            類別: <?php echo $review['category']; ?>
                                        </div>
                                        <div class="column_right">
                                            <?php echo $review['address']; ?><br />
                                            <?php echo $review['phone']; ?>
                                        </div>			
                                    </div>
                                    <div class="review">
                                        <div class="rate_date">
                                            <div class="star_image"><img src="<?php echo base_url(); ?>img/stars/<?php echo $review['rating']; ?>.png" /></div>
                                            <?php echo substr($review['review_time'], 0, 4) . "年" . substr($review['review_time'], 5, 2) . "月" . substr($review['review_time'], 8, 2) . "日"; ?>							
                                        </div>
                                        <?php echo $review['review']; ?>
                                    </div>
                                    <div class="option">
                                    <?php
                                        if(isset($logged_in)) { ?>
                                            <div class="usefulness">實用度: <?php echo $review['usefulness']; ?>人</div>
                                            <div class="delete">
                                                <a href="<?php echo base_url(); ?>business/write/<?php echo $review['review_unique_id']; ?>">修改</a> | <a href="<?php echo base_url(); ?>member/delete_review/<?php echo $review['review_unique_id']; ?>">刪除</a>
                                            </div> <?php
                                        }
                                        else { ?>
                                            <div id="<?php echo $review['review_unique_id']; ?>" class="useful">
                                                    這則評語對你實用嗎? <a href="<?php echo $review['review_unique_id']; ?>" onclick="useful(this); return false;">實用</a> (<?php echo $review['usefulness']; ?>)
                                            </div> <?php					
                                        } 
                                    ?>
                                    </div>
                                </div> <!-- end review_area div --> <?php
                            } // end foearch
					}
					else { ?>
						<?php echo $member_profile['last_name'] . $member_profile['first_name']; ?>目前還沒有寫過評語. <a href="<?php echo base_url(); ?>business/write/g">現在就來寫評語!</a> <?php
					}
				?>
			</div> <!-- end member_content div --> <?php
		}			
		else if($type == 'bookmark') { ?>
			<div id="member_content">
            	<?php
					if($num_bookmark != 0) { ?>
                        <div class="header">共<?php echo $num_bookmark; ?>個書籤</div>
                        <?php 
						foreach($member_bookmark as $bookmark) { ?>						
							<div class="bookmark">
								<div>
									類別: <a href="#"><?php echo $bookmark['category']; ?></a><br />
									<a href="<?php echo base_url(); ?>business/view/<?php echo $bookmark['business_unique_id']; ?>"><?php echo $bookmark['name']; ?></a> - <?php echo $bookmark['address']; ?> - <?php echo $bookmark['phone']; ?>	<br />
									
								</div>		
								<?php
									if(isset($logged_in)) { ?>
										<div class="delete">
											<a href="<?php echo base_url(); ?>member/delete_bookmark/<?php echo $bookmark['bookmark_unique_id']; ?>">刪除</a>
										</div> <?php
									} 
								?>		
							</div> <!-- end bookmark div --><?php
						} // end foreach
					}
					else { ?>
						<?php echo $member_profile['first_name']; ?>目前還沒有任何加入的書籤. <?php
					}
                 ?>
                </div> <!-- end member_content div --> <?php
		}
		else {
			redirect(base_url().'member/user/' . $this->session->userdata('unique_id') ."/", 'refresh');																					
		}
	}
	else if($page == 'business_photo') { ?>
		<div id="member_content">
			<div class="business_photo">
			<?php
				if(!empty($business_photo)) {
					foreach($business_photo as $photo) { 
						$string_pos = stripos($photo['name'],'-');
						if($string_pos != 0) {
							$business_name = substr($photo['name'], 0, $string_pos);
						}
						else {
							$business_name = $photo['name'];
						}
						
						if(strlen($business_name) > 13) {
							$business_name = mb_substr($business_name, 0, 4, 'utf-8');
							$business_name = $business_name . '...';
						} ?>
						<p>
                        	<a href="<?php echo base_url(); ?>img/business/<?php echo $photo['filename_l']; ?>" class="photo_album"><img src="<?php echo base_url(); ?>img/business/<?php echo $photo['filename_s']; ?>" width="60" height="60" /></a><br />
                            <a href="<?php echo base_url(); ?>business/view/<?php echo $photo['business_unique_id']; ?>"><?php echo $business_name; ?></a><?php if(isset($logged_in)) { ?><br /><a href="<?php echo base_url(); ?>member/delete_photo/<?php echo $photo['photo_unique_id']; ?>">刪除</a><?php } ?>
                        </p> <?php
					}
				}
				else { ?>
					<?php echo $member_profile['last_name'] . $member_profile['first_name']; ?>目前還沒有上傳過任何店家的照片. <?php
				}
			?>
			</div> <!-- end business_photo div -->          
		</div> <!-- end member_content div --> <?php
	} 
?>

	<div id="member_sidebar_right">
		<!-- intentionally leave blank -->
	</div> <?php
?>