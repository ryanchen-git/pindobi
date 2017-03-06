<?php

class Member extends Controller {

	function Member()
	{
		parent::Controller();	
		$this->load->model('member_info');		
		$this->load->model('business_info');		
	}

	function index()
	{
		if($this->session->userdata('unique_id')) {
			redirect('member/user/' . $this->session->userdata('unique_id') . '/');
			exit();
		}
		else {
			redirect('login/');	
			exit();
		}	
	}
			
	function activate($timestamp)
	{
		$timestamp_decode = base64_decode($timestamp);
		$query_result = $this->member_info->get_member_activate($timestamp_decode);
		if($query_result ==  1) {
			$member_info = $this->member_info->get_member_unique_id($timestamp_decode);
			$member_unique_id = $member_info['unique_id'];
			$this->member_info->add_profile_photo($member_unique_id, '', '', '');
			redirect('login?updates=true&activate=success');
			exit();
		}
		else {
			redirect('signup/');
			exit();
		}
	}
		
	function user($member_unique_id) {
		$data['css'] = 'jquery.lightbox-0.5.css';
		$data['js'] = 'lightbox/jquery.lightbox-0.5.js';
		$data['js_lightbox'] = true;
		$data['js2'] = 'ajax.js';
						
		$data['member_profile'] = $this->member_info->get_member($member_unique_id);
						
		if(!empty($data['member_profile'])) {
			$data['page_title'] = $data['member_profile']['first_name'] . ' | ' . $data['member_profile']['city']. ' | 評多比';
			$data['meta_desc'] = '會員' . $data['member_profile']['first_name'] . '的專區';
			$data['meta_key'] = '會員專區, 瀏覽評語';	
			
			if(!$this->session->userdata($member_unique_id)) {
				$pageview = array($member_unique_id  => time());
				$this->session->set_userdata($pageview);
				$pageview = $data['member_profile']['pageview'] + 1;
				$this->member_info->update_member_pageview($member_unique_id, $pageview);
			}
			else {
				if(time() - $this->session->userdata($member_unique_id) > 1800) { // Session expires after 30min since created
					$this->session->unset_userdata($member_unique_id);

					$pageview = array($member_unique_id  => time());
					$this->session->set_userdata($pageview);
					$pageview = $data['member_profile']['pageview'] + 1;
					$this->member_info->update_member_pageview($member_unique_id, $pageview);
				}
			}
				
			$data['profile_photo'] = $this->member_info->get_profile_photo($member_unique_id);
			if(empty($data['profile_photo'])) {
				$data['no_photo'] = true;
			}
			
			$data['num_photo'] = sizeof($this->member_info->get_member_business_all_photo($member_unique_id));
			
			$data['member_review'] = $this->member_info->get_member_review($member_unique_id);
			$data['num_review'] = sizeof($data['member_review']);
			
			$data['member_bookmark'] = $this->member_info->get_bookmark($member_unique_id);
			$data['num_bookmark'] = sizeof($data['member_bookmark']);	
			
			if($this->session->userdata('unique_id')) {
				if($this->session->userdata('unique_id') == $member_unique_id) {
					$data['logged_in'] = true;	
				}
			}					
					
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('member', $data);
			$this->load->view('includes/footer');
		}
		else {
			if($member_unique_id == 'e') {
				redirect('login/');
				exit();
			}
			else {
				show_404();
			}
		}
	}
	
	function business_photo($member_unique_id) 
	{
		$data['css'] = 'jquery.lightbox-0.5.css';
		$data['js'] = 'lightbox/jquery.lightbox-0.5.js';
		$data['js_lightbox'] = true;
		$data['js_lightbox_business_photo'] = true;
		
		$data['member_profile'] = $this->member_info->get_member($member_unique_id);
				
		if(!empty($data['member_profile'])) {	
			$data['page_title'] = $data['member_profile']['first_name'] . '的相簿 | 評多比';
			$data['meta_desc'] = '會員' . $data['member_profile']['first_name'] . '的相簿';
			$data['meta_key'] = $data['member_profile']['first_name'] . ', 相簿, 評多比';
		
			$data['profile_photo'] = $this->member_info->get_profile_photo($member_unique_id);
			if(empty($data['profile_photo'])) {
				$data['no_photo'] = true;
			}
			
			$data['num_photo'] = sizeof($this->member_info->get_member_business_all_photo($member_unique_id));
			$data['business_photo'] = $this->member_info->get_member_business_all_photo($member_unique_id);
			
			if($this->session->userdata('unique_id')) {
				if($this->session->userdata('unique_id') == $member_unique_id) {
					$data['logged_in'] = true;	
				}
			}
		
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('member', $data);
			$this->load->view('includes/footer');
		}
		else if($member_unique_id == 'e') {
			redirect('login/');
			exit();
		}
		else {
			show_404();																					
		}				
	}
	
	function delete_photo($photo_unique_id)
	{
		$data['page_title'] = '刪除照片 | 評多比';
		$data['meta_desc'] = '刪除上傳的照片';
		$data['meta_key'] = '刪除照片, 評多比';		
		
		$data['get_photo'] = $this->business_info->get_business_photo($photo_unique_id);	
		if(empty($data['get_photo'])) {
			show_404();
		}	
		
		if(isset($_POST['delete_photo_submit'])) {		
			$data['remove_photo'] = $this->business_info->remove_business_photo($photo_unique_id);
			unlink("img/business/" . $data['get_photo']['filename_l']);
			unlink("img/business/" . $data['get_photo']['filename_m']);
			unlink("img/business/" . $data['get_photo']['filename_s']);
			
			redirect('member/business_photo/' . $this->session->userdata('unique_id') . "?updates=true&type=photo");
			exit();
		}
		
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('delete', $data);
		$this->load->view('includes/footer');	
	}
	
	function delete_review($review_unique_id)
	{
		$data['page_title'] = '刪除評語 | 評多比';
		$data['meta_desc'] = '刪除寫過的評語';
		$data['meta_key'] = '刪除評語, 評多比';		
		
		$data['business_review'] = $this->member_info->get_single_review($review_unique_id);
		if(empty($data['business_review'])) {
			show_404();
		}
		
		if(isset($_POST['delete_review_submit'])) {		
			$data['remove_review'] = $this->member_info->remove_business_review($review_unique_id);
			
			$business_unique_id = $data['business_review']['business_unique_id'];
			$all_review = $this->business_info->get_business_review($business_unique_id);
			$total_rating = 0;
			foreach($all_review as $rating) {
				$total_rating += $rating['rating'];
			}
			$num_review = sizeof($all_review);
			$rating = $total_rating / $num_review;
			$this->business_info->update_business_rating($business_unique_id, $num_review, $rating);
			
			redirect('member/user/' . $this->session->userdata('unique_id') . "?updates=true&type=review");
			exit();
		}
		
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('delete', $data);
		$this->load->view('includes/footer');	
	}
	
	function delete_bookmark($bookmark_unique_id)
	{
		$data['page_title'] = '刪除書籤 | 評多比';
		$data['meta_desc'] = '刪除儲存的書籤';
		$data['meta_key'] = '刪除書籤, 評多比';		
		
		$data['bookmark'] = $this->member_info->get_single_bookmark($bookmark_unique_id);	
		if(empty($data['bookmark'])) {
			show_404();
		}
		
		if(isset($_POST['delete_bookmark_submit'])) {		
			$data['remove_bookmark'] = $this->member_info->remove_bookmark($bookmark_unique_id);
			
			redirect('member/user/' . $this->session->userdata('unique_id') . "/bookmark?updates=true&type=bookmark");
			exit();
		}
		
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('delete', $data);
		$this->load->view('includes/footer');	
	}	
	
}

?>