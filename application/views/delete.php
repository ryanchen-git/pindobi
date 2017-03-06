<div id="content_delete">
<?php
	$page = $this->uri->segment(2);
	
	if($page == 'delete_photo') { ?>
		<img src="<?php echo base_url(); ?>img/business/<?php echo $get_photo['filename_m']; ?>" class="photo" /><br />
		<p>確定刪除?</p>
		<form id="delete_photo" method="post" action="<?php echo base_url(); ?>member/delete_photo/<?php echo $get_photo['photo_unique_id']; ?>">
			<input type="hidden" name="delete_photo_submit" />
			<input type="submit" id="delete_submit" value="" />		
		</form>
		<br /><a href="javascript:history.back();">取消</a> <?php    
	}
	else if($page == 'delete_profile_photo') { ?>
        <img src="<?php echo base_url(); ?>img/member/<?php echo $profile_photo['filename_m']; ?>" class="photo" /><br />
        <p>確定刪除?</p>
        <form id="delete_photo" method="post" action="<?php echo base_url(); ?>profile/delete_profile_photo">
            <input type="hidden" name="delete_photo_submit" />
            <input type="submit" id="delete_submit" value="" />		
        </form>
        <br /><a href="javascript:history.back();">取消</a> <?php
	}	
	else if($page == 'delete_review') { ?>
		<p>確定刪除你在<span><?php echo substr($business_review['review_time'], 0, 4) . "年" . substr($business_review['review_time'], 5, 2) . "月" . substr($business_review['review_time'], 8, 2) . "日"; ?></span>對<span><?php echo $business_review['name']; ?></span>的評語?</p>
		<form id="delete_review" method="post" action="<?php echo base_url(); ?>member/delete_review/<?php echo $business_review['review_unique_id']; ?>">
			<input type="hidden" name="delete_review_submit" />
			<input type="submit" id="delete_submit" value="" />		
		</form>
		<br /><a href="javascript:history.back();">取消</a> <?php    
	}
	else if($page == 'delete_bookmark') { ?>
		<p>確定從書籤中刪除<span><?php echo $bookmark['name']; ?></span>?</p>
		<form id="delete_bookmark" method="post" action="<?php echo base_url(); ?>member/delete_bookmark/<?php echo $bookmark['bookmark_unique_id']; ?>">
			<input type="hidden" name="delete_bookmark_submit" />
			<input type="submit" id="delete_submit" value="" />		
		</form>
		<br /><a href="javascript:history.back();">取消</a> <?php    
	}
?>
</div>