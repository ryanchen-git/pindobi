<?php
	$page = $this->uri->segment(2);
	$type = $this->uri->segment(3);	

	if($page == 'view') { ?>
	<?php
		if(isset($_GET['type'])) { ?>
			<div class="top_status_bar"> 
			<?php
				switch ($_GET['type'])
				{
				case 'add':
				  echo "店家已經增加";
				  break;				
				case 'edit':
				  echo "資料更新完成";
				  break;
				case 'review':
				  echo "謝謝你的評語";
				  break;
				case 'bookmark':
				  echo "已加入書籤";
				  break;
				} 
			?>	
			</div> <?php	
		} 
	?>       
		
		<div id="content">
			<div id="business_view">
			
				<div class="pictures">
				<?php
					if(empty($business_photo_m['filename_m'])) { ?>
						<img src="<?php echo base_url(); ?>img/business_no_pic.gif" width="120" height="90" class="photo" /><br />
						<a href="<?php echo base_url(); ?>business/photo_upload/<?php echo $this->uri->rsegment(3); ?>">上傳照片</a> <?php
					}
					else { ?>
						<div class="main">
							<a href="<?php echo base_url(); ?>img/business/<?php echo $business_photo_m['filename_l']; ?>"><img src="<?php echo base_url(); ?>img/business/<?php echo $business_photo_m['filename_m']; ?>" /></a>
						</div>
						
						<div class="sub"> <?php
							foreach($business_photo_s as $photo_s) { ?>
								<a href="<?php echo base_url(); ?>img/business/<?php echo $photo_s['filename_l']; ?>"><img src="<?php echo base_url(); ?>img/business/<?php echo $photo_s['filename_s']; ?>" width="35" height="35" /></a> <?php
							} ?>                
						</div>
						<a href="<?php echo base_url(); ?>business/photo_upload/<?php echo $this->uri->rsegment(3); ?>">上傳照片</a>
					<?php
						if($business_photo_count > 4) { ?>
							| <a href="<?php echo base_url(); ?>business/photo/<?php echo $this->uri->rsegment(3); ?>">看更多照片</a> <?php
						}
					} 
				?>
				</div> <!-- End pictures div -->                

				<div class="info">
					<h1><?php echo $business_info['name']; ?></h1>
					<?php
						if(!empty($business_review_time)) { ?>
							<img src="<?php echo base_url(); ?>img/stars/<?php echo round($business_info['rating']); ?>.png" /> <?php echo $num_review; ?>則評價<br /> <?php
						} 
						else { ?>
							<img src="<?php echo base_url(); ?>img/stars/0.png" /> 目前沒有評價<br /> <?php
						}
					?>
					<div class="category">
                    	類別: <?php echo $business_info['category']; ?><br />
                    	縣市: <a href="<?php echo base_url(); ?>business/city/<?php echo $business_info['city_english']; ?>/all"><?php echo $business_info['city']; ?></a><br />
                    </div>
					<?php echo $business_info['address']; ?><br />
					<?php echo $business_info['phone']; ?><br />
					<a href="<?php echo $business_info['url']; ?>" target="_blank"><?php echo $business_info['url']; ?></a>
					<div class="action">
						<a href="<?php echo base_url(); ?>business/edit/<?php echo $business_info['unique_id']; ?>"><img src="<?php echo base_url(); ?>img/edit_business.gif" alt="修改店家資料" /></a>
                        <a href="<?php echo base_url(); ?>business/bookmark/<?php echo $business_info['unique_id']; ?>"><img src="<?php echo base_url(); ?>img/add_bookmark.gif" alt="加入我的書籤" /></a>
                        <a href="<?php echo base_url(); ?>business/write/<?php echo $business_info['unique_id']; ?>"><img src="<?php echo base_url(); ?>img/write_review.gif" alt="我要寫評語" /></a>
					</div>
				</div> <!-- End info div -->
				
				<div class="comments">
				<?php
					if(!empty($business_review_time)) { 
						if(isset($_GET['sort']) && $_GET['sort'] == 'useful') { ?>
                            <div class="sort">排列顯示: <a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>">時間</a> | 實用 | <a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>?updates=true&sort=rating">評價</a></div> 
                            <div class="header">大家的評語, 共<?php echo $num_review; ?>則</div>
                            <?php
                            foreach($business_review_useful as $review) { ?>
                                <div class="review_area">
                                    <div class="user">
                                    <?php
                                        if($review['filename_s'] != '') { ?>
                                            <a href="<?php echo base_url(); ?>member/user/<?php echo $review['member_unique_id']; ?>"><img src="<?php echo base_url(); ?>img/member/<?php echo $review['filename_s']; ?>" class="photo" /></a><br /> <?php
                                        }
                                        else { ?>
                                           <img src="<?php echo base_url(); ?>img/blank_member.gif" class="photo" /><br /> <?php
                                        }
                                    ?>
                                        <a href="<?php echo base_url(); ?>member/user/<?php echo $review['member_unique_id']; ?>"><?php echo $review['first_name']; ?></a><br /><?php echo $review['city']; ?>
                                    </div>
                                    <div class="review">
                                        <div class="rate_date">
                                            <div class="star_image"><img src="<?php echo base_url(); ?>img/stars/<?php echo $review['rating']; ?>.png" /></div>
                                            <?php echo substr($review['review_time'], 0, 4) . "年" . substr($review['review_time'], 5, 2) . "月" . substr($review['review_time'], 8, 2) . "日"; ?>
                                        </div>
                                        <div class="review_text">
                                            <?php echo $review['review']; ?>
                                        </div>
                                        <div id="<?php echo $review['review_unique_id']; ?>" class="useful">
											這則評語對你實用嗎? <a href="<?php echo $review['review_unique_id']; ?>" onclick="useful(this); return false;">實用</a> (<?php echo $review['usefulness']; ?>)
										</div>
                                        <!--<div class="flag"><a href="#">檢舉</a></div>-->
                                    </div>
                                </div>  <!-- End review area div --> <?php
                            } // End foreach loop
						}
						else if(isset($_GET['sort']) && $_GET['sort'] == 'rating') { ?>
                            <div class="sort">排列顯示: <a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>">時間</a> | <a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>?updates=true&sort=useful">實用</a> | 評價</div> 
                            <div class="header">大家的評語, 共<?php echo $num_review; ?>則</div>
                            <?php
                            foreach($business_review_rating as $review) { ?>
                                <div class="review_area">
                                    <div class="user">
                                    <?php
                                        if($review['filename_s'] != '') { ?>
                                            <a href="<?php echo base_url(); ?>member/user/<?php echo $review['member_unique_id']; ?>"><img src="<?php echo base_url(); ?>img/member/<?php echo $review['filename_s']; ?>" class="photo" /></a><br /> <?php
                                        }
                                        else { ?>
                                           <img src="<?php echo base_url(); ?>img/blank_member.gif" class="photo" /><br /> <?php
                                        }
                                    ?>
                                        <a href="<?php echo base_url(); ?>member/user/<?php echo $review['member_unique_id']; ?>"><?php echo $review['first_name']; ?></a><br /><?php echo $review['city']; ?>
                                    </div>
                                    <div class="review">
                                        <div class="rate_date">
                                            <div class="star_image"><img src="<?php echo base_url(); ?>img/stars/<?php echo $review['rating']; ?>.png" /></div>
                                            <?php echo substr($review['review_time'], 0, 4) . "年" . substr($review['review_time'], 5, 2) . "月" . substr($review['review_time'], 8, 2) . "日"; ?>
                                        </div>
                                        <div class="review_text">
                                            <?php echo $review['review']; ?>
                                        </div>
                                        <div id="<?php echo $review['review_unique_id']; ?>" class="useful">
											這則評語對你實用嗎? <a href="<?php echo $review['review_unique_id']; ?>" onclick="useful(this); return false;">實用</a> (<?php echo $review['usefulness']; ?>)
										</div>
                                        <!--<div class="flag"><a href="#">檢舉</a></div>-->
                                    </div>
                                </div>  <!-- End review area div --> <?php
                            } // End foreach loop
						}
						else { ?>
                            <div class="sort">排列顯示: 時間 | <a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>?updates=true&sort=useful">實用</a> | <a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>?updates=true&sort=rating">評價</a></div> 
                            <div class="header">大家的評語, 共<?php echo $num_review; ?>則</div>
                            <?php
                            foreach($business_review_time as $review) { ?>
                                <div class="review_area">
                                    <div class="user">
                                    <?php
                                        if($review['filename_s'] != '') { ?>
                                            <a href="<?php echo base_url(); ?>member/user/<?php echo $review['member_unique_id']; ?>"><img src="<?php echo base_url(); ?>img/member/<?php echo $review['filename_s']; ?>" class="photo" /></a><br /> <?php
                                        }
                                        else { ?>
                                           <img src="<?php echo base_url(); ?>img/blank_member.gif" class="photo" /><br /> <?php
                                        }
                                    ?>
                                        <a href="<?php echo base_url(); ?>member/user/<?php echo $review['member_unique_id']; ?>"><?php echo $review['first_name']; ?></a><br /><?php echo $review['city']; ?>
                                    </div>
                                    <div class="review">
                                        <div class="rate_date">
                                            <div class="star_image"><img src="<?php echo base_url(); ?>img/stars/<?php echo $review['rating']; ?>.png" /></div>
                                            <?php echo substr($review['review_time'], 0, 4) . "年" . substr($review['review_time'], 5, 2) . "月" . substr($review['review_time'], 8, 2) . "日"; ?>
                                        </div>
                                        <div class="review_text">
                                            <?php echo $review['review']; ?>
                                        </div>
                                        <div id="<?php echo $review['review_unique_id']; ?>" class="useful">
											這則評語對你實用嗎? <a href="<?php echo $review['review_unique_id']; ?>" onclick="useful(this); return false;">實用</a> (<?php echo $review['usefulness']; ?>)
										</div>
                                        <!--<div class="flag"><a href="#">檢舉</a></div>-->
                                    </div>
                                </div>  <!-- End review area div --> <?php
                            } // End foreach loop
						}
					}
					else { ?>
						目前沒有任何評語<?php
					}
				?>
				</div> <!-- End comments div -->
								
			</div> <!-- End business_view div -->
		</div> <!-- End content div -->
		
		<div id="sidebar">
			<script type="text/javascript">
                var geocoder;
                var map;
                
                var address = "<?php echo $business_info['address']; ?>";
                
                // On page load, call this function
                function load()
                {
                  // Create new map object
				  
                  map = new GMap2(document.getElementById("google_map_small"));
                
                  // Create new geocoding object
                  geocoder = new GClientGeocoder();
                
                  // Retrieve location information, pass it to addToMap()
                  geocoder.getLocations(address, addToMap);
                }
                
                // This function adds the point to the map
                
                function addToMap(response)
                {
                  // Retrieve the object
                  place = response.Placemark[0];
                
                  // Retrieve the latitude and longitude
                  point = new GLatLng(place.Point.coordinates[1], place.Point.coordinates[0]);
                
                  // Center the map on this point
                  map.setCenter(point, 15);
				  
				  // Set UI control (zoom in/out)
				  map.setUIToDefault();
                
                  // Create a marker
                  marker = new GMarker(point);
                
                  // Add the marker to map
                  map.addOverlay(marker);
                
                  // Add address information to marker
                  //marker.openInfoWindowHtml(place.address);
                }
            </script>
            
			<div id="google_map_small"></div>
            <a href="<?php echo base_url(); ?>business/map/<?php echo $business_info['unique_id']; ?>">瀏覽較大的地圖</a>
            
			<?php
				if(!empty($business_related)) { ?>
					<div class="related">
						其它<a href="<?php echo base_url(); ?>business/city/<?php echo $business_info['city_english']; ?>/all"><?php echo $business_info['city']; ?></a>相關的商業類別: <?php echo $business_info['category']; ?>
						<ul>
						<?php
							foreach($business_related as $business) { ?>
								<li>
									<a href="<?php echo base_url(); ?>business/view/<?php echo $business['unique_id']; ?>"><?php echo $business['name']; ?></a><br />
									<img src="<?php echo base_url(); ?>img/stars/<?php echo round($business['rating']); ?>.png" /> (<?php echo $business['num_rating']; ?>)<br />
									<?php echo $business['address']; ?>
								</li> <?php
							} // End foreach loop
						?>
						</ul>
					</div> <?php
				} // End if 
			?>
		</div> <?php
				
	}
	else if($page == 'map') { ?>
		<script type="text/javascript">
            var geocoder;
            var map;
            var address = "<?php echo $business_info['address']; ?>";
            
            function load2()
            {
              map = new GMap2(document.getElementById("google_map_big"));
              geocoder = new GClientGeocoder();
              geocoder.getLocations(address, addToMap);
            }
            
            function addToMap(response)
            {
              place = response.Placemark[0];
              point = new GLatLng(place.Point.coordinates[1], place.Point.coordinates[0]);
              map.setCenter(point, 15);
              map.setUIToDefault();
              marker = new GMarker(point);
              map.addOverlay(marker);
            }
        </script>
    
    	<div id="content3">
            <h1><?php echo $business_info['name']; ?>地圖</h1>
            地址: <?php echo $business_info['address']; ?>
        	<div id="google_map_big"></div>
            <a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>">返回<?php echo $business_info['name']; ?></a>
        </div>
		<?php
    }	
	else if($page == 'write') { 
		if($type == 'g') {?>
			<div id="content">
				<h1>寫評語</h1>
				請輸入店家名稱跟所在的縣市
				<form name="write_review" id="write_review" method="get" action="<?php echo base_url(); ?>search">
					<ol>
						<li>
							<label for="name" class="display">店家名稱:</label> 
							<input type="text" name="business" id="name" />
						</li>
						<li>
							<label for="city" class="display">縣市:</label>
							<select name="city" class="city">
								<option value="">-----</option>
							<?php
								foreach($city_list as $city) { ?>
									<option value="<?php echo $city['city']; ?>"><?php echo $city['city']; ?></option> <?php
								}
							?>
							</select>
						</li>		
						<input type="hidden" name="review" value="true" />				
						<input type="submit" class="write_review_submit" value="" />					
					</ol>
				</form>
			</div> <?php
		}
		else { ?>
			<div id="content">
				<h1><a href="<?php echo base_url(); ?>business/view/<?php if(isset($business_info)) { echo $business_info['unique_id']; } else { echo $review_info['unique_id']; } ?>"><?php if(isset($business_info)) { echo $business_info['name']; } else { echo $review_info['name']; } ?></a> (<?php if(isset($business_info)) { echo $business_info['city']; } else { echo $review_info['city']; } ?>)</h1>
				請輸入你對此店家的評價跟評語
				<form name="rating_form" id="rating_form" method="post" action="<?php echo base_url(); ?>business/write/<?php if(isset($business_info)) { echo $business_info['unique_id']; } else { echo $review_info['review_unique_id']; } ?>">			
					<div class="text">評價:</div>
					<div id="star_rating"> 
						<label for="vote1" class="blockLabel"><input type="radio" name="vote" id="vote1" value="1" title="實在不怎麼樣..." <?php if(isset($review_info) && $review_info['rating'] == 1) {?>checked="checked"<?php } ?> /></label> 
						<label for="vote2" class="blockLabel"><input type="radio" name="vote" id="vote2" value="2" title="勉強接受" <?php if(isset($review_info) && $review_info['rating'] == 2) {?>checked="checked"<?php } ?> /></label> 
						<label for="vote3" class="blockLabel"><input type="radio" name="vote" id="vote3" value="3" title="OK啊, 還會再去" <?php if(isset($review_info) && $review_info['rating'] == 3) {?>checked="checked"<?php } ?> /></label> 
						<label for="vote4" class="blockLabel"><input type="radio" name="vote" id="vote4" value="4" title="很不錯喔" <?php if(isset($review_info) && $review_info['rating'] == 4) {?>checked="checked"<?php } ?> /></label> 
						<label for="vote5" class="blockLabel"><input type="radio" name="vote" id="vote5" value="5" title="一個字: 讚!" <?php if(isset($review_info) && $review_info['rating'] == 5) {?>checked="checked"<?php } ?> /></label> 
					</div>
					<div id="stars-cap"></div>
					<div class="clear"></div>
					
					<label for="city" class="text">評語:</label>
					<textarea name="review"><?php if(isset($review_info)) { echo $review_info['review']; } ?></textarea>
					<div class="clear"></div>
					
					<input type="hidden" name="<?php if(isset($business_info)) { ?>rating_form_submit<?php } else { ?>rating_form_edit_submit<?php } ?>" />				
					<input type="submit" class="write_review_submit" value="" />					
				</form> 
				<a href="javascript:history.back();">取消</a>
			</div> <?php		
		}
	}
	else if($page == 'add' || $page == 'edit') { ?>
		<div id="content">
			<h1><?php if($page == 'add') { echo "增加"; } else { echo "修改"; } ?>店家資料</h1>
			<form name="business" id="business" method="post" action="<?php echo base_url(); ?>business/<?php if($page == 'add') { echo "add/"; } else if($page == 'edit') { echo "edit/" . $business_info['unique_id']; } ?>">
				<ol>
					<li>
						<label for="name" class="display">店家名稱:</label> 
						<input type="text" name="name" id="name" <?php if($page == 'edit') { echo 'value="' . $business_info['name'] . '"'; } ?> />
					</li>
					
					<li>
						<label for="address" class="display">地址:</label>
						<input type="text" name="address" id="address" <?php if($page == 'edit') { echo 'value="' . $business_info['address'] . '"'; } ?> />
					</li>
					
					<li>
						<label for="city" class="display">縣市:</label>
						<select name="city" class="city">
						<option value="">-----</option>
						<?php
							foreach($city_list as $city) { ?>
								<option value="<?php echo $city['city']; ?>" <?php if(($page == 'edit') && ($business_info['city'] == $city['city'])) { echo "selected"; }?>><?php echo $city['city']; ?></option> <?php
							}
						?>
						</select>
					</li>			
					
					<li>
						<label for="phone" class="display">電話:</label>
						<input type="text" name="phone" id="phone" <?php if($page == 'edit') { echo 'value="' . $business_info['phone'] . '"'; } ?> />
					</li>
					
					<li>
						<label for="website_url" class="display">網址:</label>
						<input type="text" name="website_url" id="website_url" <?php if($page == 'edit') { echo 'value="' . $business_info['url'] . '"'; } ?> />
					</li>			
							
					<li>
						<label for="category" class="display">類別:</label> 
						<select name="category" class="category">
						<option value="">-----</option>
					<?php	
						foreach($category_list as $category) { ?>
							<option value='<?php echo $category['id']; ?>' <?php if(($page == 'edit') && ($business_info['category'] == $category['category'])) { echo "selected"; }?>><?php echo $category['category']; ?></option> <?php 
						}
					?>
						</select>
					</li>
				</ol>
				<input type="hidden" name="<?php if($page == 'add') { echo "add"; } else { echo "edit"; } ?>_business_submit" />
				<input type="submit" class="business_submit" value="" />		
			</form> 
			<?php
				if($page == 'edit' ) { ?>
					<a href="javascript:history.back();">取消</a> <?php
				}
			?>
		</div> <?php
	}
	else if($page == 'photo') { ?>
		<div id="content3">
        	<div class="business_photo">
                <h1><a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>"><?php echo $business_info['name']; ?></a>: 照片</h1>
				<?php
					foreach($business_photo as $photo) { ?>
						<p><a href="<?php echo base_url(); ?>img/business/<?php echo $photo['filename_l']; ?>" class="photo"><img src="<?php echo base_url(); ?>img/business/<?php echo $photo['filename_s']; ?>" /></a><br /><a href="<?php echo base_url(); ?>member/user/<?php echo $photo['member_unique_id']; ?>"><?php echo $photo['last_name']; ?><?php echo $photo['first_name']; ?></a></p> <?php
					} // End foreach loop 
				?>
            </div> 
			<a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>">回<?php echo $business_info['name']; ?></a>
        </div> 
		<?php
	}
	else if($page == 'photo_upload') { ?>
		<div id="content3"> <?php
			if(isset($status)) { ?>
				<div class="top_status_bar_short">
				<?php
					switch($status)
					{
					case 'photo_uploaded':
					  echo " 照片已上傳完成";
					  break;
					case 'upload_error':
					  echo "照片檔案有錯誤. 目前只接受jpg跟gif檔, 檔案不得大於1MB";
					  break;
					} 
				?>	
				</div> <?php	
			} ?>        
            <h1><a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>"><?php echo $business_info['name']; ?></a>: 上傳照片</h1>
            請從電腦裡選擇想上傳的照片, 然後按"確定".
            <form class="file_upload" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>business/photo_upload/<?php echo $business_info['unique_id']; ?>">
                <label for="file"></label>
                <input type="file" name="file" class="image_file" />
                <br />
                <input type="hidden" name="update_photo_submit" />			
                <input type="submit" class="upload_submit" value="" />		            
            </form>
			<br /><a href="javascript:history.back();">取消</a>
			<?php
				if(isset($status) && $status == 'photo_uploaded') { ?>
					<div class="uploaded_photo">
						<p>上傳的照片:</p>
						<img src="<?php echo base_url(); ?>img/business/<?php echo $photo_path; ?>" class="photo" />
					</div> 
					<a href="<?php echo base_url(); ?>business/view/<?php echo $business_info['unique_id']; ?>">返回<?php echo $business_info['name']; ?></a> | <a href="<?php echo base_url(); ?>business/photo/<?php echo $business_info['unique_id']; ?>">看<?php echo $business_info['name']; ?>的照片</a><?php
				} 
			?>
		</div> <!-- End content3 div --> <?php
	}	
?>