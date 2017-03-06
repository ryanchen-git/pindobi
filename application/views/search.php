<?php
	$page = $this->uri->segment(1);
	
	if($page == 'search') { ?>
		<div id="content"> 
		<?php
			if(!empty($business_list)) { ?>
				<h1>搜尋結果</h1> <?php
				foreach($business_list as $business) { ?>
					<div class="search_business_area">
						<div class="name">
							<div class="title"><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a></div>
							類別: <?php echo $business['category']; ?><br />
							縣市:  <a href="<?php echo base_url(); ?>business/city/<?php echo $business['city_english']; ?>/all"><?php echo $business['city']; ?></a>
						</div>
						<div class="biz_info">
							<img src="<?php echo base_url(); ?>img/stars/<?php echo round($business['rating']); ?>.png" /> <?php echo $business['num_rating']; ?>則評價<br />				
							<?php echo $business['address']; ?><br />
							<?php echo $business['phone']; ?>
						</div>
						<?php
                            if(isset($_GET['review'])) { ?>	
                                <div class="review">
                                    <a href="<?php echo base_url(); ?>business/write/<?php echo $business['unique_id']; ?>"><img src="<?php echo base_url(); ?>img/write_review2.gif" /></a>
                                </div> <?php
                            } 
                        ?>
					</div> <?php
				} 
				echo $pagination; ?>
				<br />找不到想找的店家嗎? <a href="<?php echo base_url(); ?>business/add">現在就增加店家!</a> <?php
			}
			else { ?>
				<h1>搜尋結果</h1>
				您的搜尋找不到任何結果. <a href="<?php echo base_url(); ?>business/add">現在就增加店家!</a> <?php
			}
		?>
		</div>
		
		<div id="sidebar">
			
		</div> <?php			
	}
	else if($page == 'business') { ?>
		<div id="content">
		<?php
			if($category_name == 'all') { ?>
				<h1><?php echo $city; ?></h1> <?php
			}
			else { ?>
				<h1><a href="<?php echo base_url(); ?>business/city/<?php echo $city_english; ?>/all"><?php echo $city; ?></a>的<?php echo $category_chinese; ?></h1> <?php
			}
		?>
			以商業類別搜尋<?php echo $city; ?>:
			<div class="category_list_top_nav">
			<?php
				$start = array(0, 4, 8, 12, 16);
				$end = array(3, 7, 11, 15, 19);
				$i = 0;
				foreach($category_list as $category) { 
					if(in_array($i, $start)) { echo "<ul>"; } ?>
					<li><a href="<?php echo base_url(); ?>business/city/<?php echo $city_english; ?>/<?php echo $category['category_english']; ?>"><?php echo $category['category']; ?></a> (<?php echo $category['count']; ?>)</li> <?php
					if(in_array($i, $end)) { echo "</ul>"; }	
					$i++;		 
				} 
			?>
			</div>	
		
			<?php
				if($category_name == 'all') { 
					if(!empty($business_new_1)) { ?>
						<h1>新增店家</h1>
						<div class="business_section">
							<div class="latest">
								<div class="title">餐廳</div>
								<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_1['filename_m']; ?>" class="photo" />
								<ol>
								<?php
									foreach($business_new_1 as $business) { ?>
										<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a></li> <?php
									}
								?>
								</ol>			
								<?php if($category_list[0]['count'] > 5) { ?><a href="<?php echo base_url(); ?>business/city/<?php echo $city; ?>/餐廳">看更多...</a><?php } ?>
							</div>	
							
							<div class="latest">
								<div class="title">百貨商圈</div>			
								<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_2['filename_m']; ?>" class="photo" />
								<ol>
								<?php
									foreach($business_new_2 as $business) { ?>
										<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a></li> <?php
									}
								?>
								</ol>
								<?php if(sizeof($business_new_2) > 5) { ?><a href="<?php echo base_url(); ?>business/city/<?php echo $city; ?>/商店百貨">看更多...</a><?php } ?>												
							</div>	
					
							<div class="latest">
								<div class="title">糕餅甜點</div>			
								<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_5['filename_m']; ?>" class="photo" />
								<ol>
								<?php
									foreach($business_new_5 as $business) { ?>
										<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a></li> <?php
									}
								?>
								</ol>
								<?php if(sizeof($business_new_5) > 5) { ?><a href="<?php echo base_url(); ?>business/city/<?php echo $city; ?>/糕餅甜點">看更多...</a><?php } ?>													
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
										<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a></li> <?php
									}
								?>
								</ol>			
								<?php if(sizeof($business_num_1) > 5) { ?><a href="<?php echo base_url(); ?>business/city/<?php echo $city; ?>/餐廳">看更多...</a><?php } ?>
								</ol>			
							</div>	
							
							<div class="latest">
								<div class="title">百貨商圈</div>			
								<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_2a['filename_m']; ?>" class="photo" />
								<ol>
								<?php
									foreach($business_num_2 as $business) { ?>
										<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a></li> <?php
									}
								?>
								</ol>			
								<?php if(sizeof($business_num_2) > 5) { ?><a href="<?php echo base_url(); ?>business/city/<?php echo $city; ?>/餐廳">看更多...</a><?php } ?>
								</ol>						
							</div>	
					
							<div class="latest">
								<div class="title">糕餅甜點</div>			
								<img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_5a['filename_m']; ?>" class="photo" />
								<ol>
								<?php
									foreach($business_num_5 as $business) { ?>
										<li><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a></li> <?php
									}
								?>
								</ol>			
								<?php if(sizeof($business_num_5) > 5) { ?><a href="<?php echo base_url(); ?>business/city/<?php echo $city; ?>/餐廳">看更多...</a><?php } ?>
								</ol>						
							</div>		
						</div> <?php
					}
					else { ?>
						目前這個縣市還沒有任和店家唷, <a href="<?php echo base_url(); ?>business/write/g">現在就增加店家</a>! <?php
					} 
				}
				else { 
					if(!empty($business_list)) {
						foreach($business_list as $business) { ?>
							<div class="search_business_area">
								<div class="name">
									<div class="title"><a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a></div>
									類別: <?php echo $business['category']; ?><br />
									縣市:  <?php echo $business['city']; ?>
								</div>
								<div class="biz_info">
									<img src="<?php echo base_url(); ?>img/stars/<?php echo round($business['rating']); ?>.png" /> <?php echo $business['num_rating']; ?>則評價<br />				
									<?php echo $business['address']; ?><br />
									<?php echo $business['phone']; ?>
								</div>
								<?php
                                    if(isset($_GET['review'])) { ?>	
                                        <div class="review">
                                            <a href="<?php echo base_url(); ?>business/write/<?php echo $business['unique_id']; ?>"><img src="<?php echo base_url(); ?>img/write_review2.gif" /></a>
                                        </div> <?php
                                    } 
                                ?>
							</div> <?php
						}
					}
					else { ?>
						目前這項類別還沒有商店. <a href="<?php echo base_url(); ?>business/add">現在就增加商店!</a> <?php
					} 
				}
			?>
		</div>
			
        <div id="sidebar"> <?php
            if($category_name == 'all') { ?>
                <div class="column">
                    <h2>其它縣市</h2>
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
                 <?php
            } 
            else { ?>		
                 <?php
            }
        ?>	
        </div> <?php				
    }
?>
