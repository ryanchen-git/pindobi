<?php

class Business extends Controller {

	function Business()
	{
		parent::Controller();
		$this->load->model('member_info');		
		$this->load->model('business_info');
	}

	function index()
	{
	}
	
	function view($business_unique_id)
	{
		//$this->output->cache(10); // Cache for 10 mins.
		
		$data['css'] = 'jquery.lightbox-0.5.css';
		$data['js'] = 'lightbox/jquery.lightbox-0.5.js';
		$data['js_lightbox'] = true;
		$data['js2'] = 'ajax.js';
		$data['google_map_small'] = true;
				
		$data['business_info'] = $this->business_info->get_business($business_unique_id);
		if(!empty($data['business_info'])) {
			/* The following count the page view for business page */
			if(!$this->session->userdata($business_unique_id)) {
				$pageview = array($business_unique_id  => time());
				$this->session->set_userdata($pageview);
				$pageview = $data['business_info']['pageview'] + 1;
				$this->business_info->update_business_pageview($business_unique_id, $pageview);
			}
			else {
				if(time() - $this->session->userdata($business_unique_id) > 1800) { // Session expires after 30min since created
					$this->session->unset_userdata($business_unique_id);
	
					$pageview = array($business_unique_id  => time());
					$this->session->set_userdata($pageview);
					$pageview = $data['business_info']['pageview'] + 1;
					$this->business_info->update_business_pageview($business_unique_id, $pageview);
				}
			}
			
			$data['page_title'] = $data['business_info']['name'] . ', ' . $data['business_info']['city'];	
			$data['meta_desc'] = $data['business_info']['name'] . '的店家評語跟資料';
			$data['meta_key'] = $data['business_info']['name'] . ', ' . $data['business_info']['city'] . ', ' . $data['business_info']['category'] . ', 評語, 商店, 店家';
			
			$data['business_photo_m'] = $this->business_info->get_business_photo_rand_m($business_unique_id);		
			if(!empty($data['business_photo_m'])) {
				$photo_unique_id = $data['business_photo_m']['photo_unique_id']; // Get photo unique ID	above	
				$data['business_photo_s'] = $this->business_info->get_business_photo_rand($business_unique_id, $photo_unique_id);	
				$data['business_photo_count'] = sizeof($this->business_info->get_business_all_photo($business_unique_id));				
			}
			
			$data['business_related'] = $this->business_info->business_related($business_unique_id, $data['business_info']['category'], $data['business_info']['city']);
					
			$member_unique_id = $this->session->userdata('unique_id');
					
			$data['business_review_time'] = $this->business_info->get_business_review($business_unique_id, 'time');
			$data['business_review_useful'] = $this->business_info->get_business_review($business_unique_id, 'useful');
			$data['business_review_rating'] = $this->business_info->get_business_review($business_unique_id, 'rating');		
			$data['num_review'] = sizeof($data['business_review_time']);
					
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('business', $data);
			$this->load->view('includes/footer');
		}
		else {
			show_404();
		}
	}
	
	function map($business_unique_id)
	{
		$data['google_map_big'] = true;		
		$data['business_info'] = $this->business_info->get_business($business_unique_id);
		if(!empty($data['business_info'])) {
			$data['page_title'] = $data['business_info']['name'] . '地圖';
			$data['meta_desc'] = $data['business_info']['name'] . '的地圖';
			$data['meta_key'] = $data['business_info']['name'] . ', 地圖, 地址';
		
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('business', $data);
			$this->load->view('includes/footer');
		}
		else {
			show_404();
		}
	}
	
	function write($which_unique_id)
	{
		$business_or_g = $this->business_info->get_business($which_unique_id);
		
		if(!empty($business_or_g)) {
			$business_unique_id = $which_unique_id;
		}
		else {
			if($which_unique_id == 'g') {
				$business_unique_id = 'g';
			}
		}
	
		if($this->session->userdata('firstname')) {				
			if($which_unique_id == 'g') {
				$data['page_title'] = '寫評語 | 評多比';
				$data['meta_desc'] = '評多比寫評語';
				$data['meta_key'] = '評多比, 寫評語';	
						
				$data['city_list'] = $this->business_info->get_city();	
			}
			else {
				$data['js'] = 'validate/jquery.validate.min.js';
				$data['js_validate_rating'] = true;			
				$data['css'] = 'crystal-stars.css?v=2.0.3b38';
				$data['js2'] = 'rating/jquery-ui.custom.min.js?v=1.8';
				$data['js3'] = 'rating/jquery.ui.stars.js?v=3.0.0b38';			
				$data['js_rating'] = true;
				
				$member_unique_id = $this->session->userdata('unique_id');				
				$business_or_review = $this->business_info->get_business($which_unique_id);
				
				if(!empty($business_or_review)) {
					$business_unique_id = $which_unique_id;
				}
				else {
					$review_unique_id = $which_unique_id;
				}

				if(isset($business_unique_id)) {
					$data['business_info'] = $this->business_info->get_business($business_unique_id);	
					$data['page_title'] = '寫評語 - ' . $data['business_info']['name'];
					$data['meta_desc'] = '寫評價跟評語給' . $data['business_info']['name'];
					$data['meta_key'] = '寫評價, 寫評語';					
														
					if(isset($_POST['rating_form_submit'])) {
						if(empty($_POST['vote'])) {
							$_POST['vote'] = '1';
						}
						$this->business_info->add_business_review($member_unique_id, $business_unique_id, $_POST['vote'], addslashes($_POST['review']));
						
						$all_review = $this->business_info->get_business_review($business_unique_id, 'time');
						$total_rating = 0;
						foreach($all_review as $rating) {
							$total_rating += $rating['rating'];
						}
						$num_review = sizeof($all_review);
						$rating = $total_rating / $num_review;
						$this->business_info->update_business_rating($business_unique_id, $num_review, $rating);
						
						redirect('business/view/' . $business_unique_id . '?updates=true&type=review');
						exit();
					}
				}
				else if(isset($review_unique_id)) {
					$data['review_info'] = $this->member_info->get_single_review($review_unique_id);
					if(empty($data['review_info'])) {
						show_404();
					}
					
					$data['page_title'] = '修改評語 - ' . $data['review_info']['name'];
					$data['meta_desc'] = '修改對於' . $data['review_info']['name'] . '的評價跟評語';
					$data['meta_key'] = '修改評語, 評多比';					
					
					if(isset($_POST['rating_form_edit_submit'])) {
						if(empty($_POST['vote'])) {
							$_POST['vote'] = '1';
						}
						$this->member_info->update_business_review($review_unique_id, $_POST['vote'], addslashes($_POST['review']));
						
						$business_unique_id = $data['review_info']['business_unique_id'];
						$all_review = $this->business_info->get_business_review($business_unique_id, 'time');
						$total_rating = 0;
						foreach($all_review as $rating) {
							$total_rating += $rating['rating'];
						}
						$num_review = sizeof($all_review);
						$rating = $total_rating / $num_review;
						$this->business_info->update_business_rating($business_unique_id, $num_review, $rating);

						redirect('member/user/' . $member_unique_id . '?updates=true&type=edit_review');
						exit();
					}
				}					
			}
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('business', $data);
			$this->load->view('includes/footer');							
		}
		else {
			redirect('login?dest=write&id=' . $business_unique_id);
			exit();
		}
	}	
	
	function add()
	{
		if($this->session->userdata('firstname')) {				
			$data['js'] = 'validate/jquery.validate.min.js';
			$data['js_validate_business'] = true;
			
			$data['page_title'] = '增加店家資料 | 評多比';
			$data['meta_desc'] = '增加店家資料';
			$data['meta_key'] = '增加店家資料, 評多比';		
				
			$data['city_list'] = $this->business_info->get_city();	
			$data['category_list'] = $this->business_info->get_category();					
			
			if(isset($_POST['add_business_submit'])) {		
				$unique_id = uniqid();				
				$this->business_info->add_business($_POST, $unique_id);
				redirect('business/view/' . $unique_id . '?updates=true&type=add');
				exit();
			}					
			
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('business', $data);
			$this->load->view('includes/footer');
		}
		else {
			redirect('login/');
			exit();
		}
	}	
	
	function edit($business_unique_id)
	{
		if(isset($_POST['edit_business_submit'])) {				
			$this->business_info->update_business($_POST, $business_unique_id);
			redirect('business/view/' . $business_unique_id . '?updates=true&type=edit');
			exit();
		}							
		
//if($this->session->userdata('firstname')) {		
		$data['js'] = 'validate/jquery.validate.min.js';
		$data['js_validate_business'] = true;
		
		$data['page_title'] = '修改店家資料 | 評多比';
		$data['meta_desc'] = '修改店家資料';
		$data['meta_key'] = '修改店家資料, 評多比';
				
		$data['business_info'] = $this->business_info->get_business($business_unique_id);
		if(empty($data['business_info'])) {
			show_404();
		}
		$data['city_list'] = $this->business_info->get_city();
		$data['category_list'] = $this->business_info->get_category();					
					
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('business', $data);
		$this->load->view('includes/footer');
/*}
else {
	redirect('login?dest=edit&id=' . $business_unique_id);
	exit();
}*/
	}
	
	function bookmark($business_unique_id)
	{
		if($this->session->userdata('firstname')) {				
			$member_unique_id = $this->session->userdata('unique_id');
			$this->business_info->add_bookmark($member_unique_id, $business_unique_id);
			redirect('business/view/' . $business_unique_id . '?updates=true&type=bookmark');
			exit();
		}
		else {
			redirect('login?dest=bookmark&id=' . $business_unique_id);
			exit();
		}
	}		
	
	function photo($business_unique_id)
	{
		$data['css'] = 'jquery.lightbox-0.5.css';		
		$data['js'] = 'lightbox/jquery.lightbox-0.5.js';
		$data['js_lightbox_business_photo'] = true;
				
		$data['business_info'] = $this->business_info->get_business($business_unique_id);
		if(!empty($data['business_info'])) {
			$data['business_photo'] = $this->business_info->get_business_all_photo($business_unique_id);
			
			$data['page_title'] = $data['business_info']['name'] . '的照片';
			$data['meta_desc'] = $data['business_info']['name'] . '的照片';
			$data['meta_key'] = $data['business_info']['name'] . ', 照片';
			
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('business', $data);
			$this->load->view('includes/footer');				
		}
		else {
			show_404();
		}
	}	
	
	function photo_upload($business_unique_id)
	{
		if($this->session->userdata('firstname')) {	
			$data['js'] = 'file_uploads/file_uploads.js';
			$data['js_file_uploads'] = true;				
			require_once('library/thumbnail/ThumbLib.inc.php');
									
			$data['business_info'] = $this->business_info->get_business($business_unique_id);		
			
			$data['page_title'] = '上傳' . $data['business_info']['name'] . '的照片';
			$data['meta_desc'] = '上傳' . $data['business_info']['name'] . '的照片';
			$data['meta_key'] = '上傳, ' . $data['business_info']['name'] . ', 照片';
			
			$member_unique_id = $this->session->userdata('unique_id');
			
			if($this->input->get('updates')) {
				$data['status'] = 'photo_uploaded';
				$data['photo_path'] = $_GET['photo'];
			}			
			
			if(!empty($data['business_info'])) {
				if(isset($_POST['update_photo_submit'])) {				
					if((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 1000000)) {
						if($_FILES["file"]["error"] > 0) {
							//echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
							$data['status'] = 'upload_error';
						}
						else {
							$ext = substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], '.') + 1);	// Get file extension
							$newfilename = substr(md5(uniqid(rand(),1)), 3, 10)  . "." . $ext;
							$newfilename_l = substr(md5(uniqid(rand(),1)), 3, 10)  . "." . $ext;						
							$newfilename_m = substr(md5(uniqid(rand(),1)), 3, 10)  . "." . $ext;						
							$newfilename_s = substr(md5(uniqid(rand(),1)), 3, 10)  . "." . $ext;						
	
							move_uploaded_file($_FILES["file"]["tmp_name"], "img/business/" . $newfilename);
	
							$thumb = PhpThumbFactory::create('img/business/' . $newfilename);
							$thumb->resize(550, 400);
							$thumb->save("img/business/".$newfilename_l);
							
							$thumb = PhpThumbFactory::create('img/business/' . $newfilename);
							$thumb->resize(120, 120);
							$thumb->save("img/business/".$newfilename_m);
							
							$thumb = PhpThumbFactory::create('img/business/' . $newfilename);
							$thumb->adaptiveResize(100, 100);
							$thumb->save("img/business/".$newfilename_s);
							
							unlink("img/business/" . $newfilename);	// Remove original file
	
							$this->business_info->add_business_photo($member_unique_id, $business_unique_id, $newfilename_l, $newfilename_m, $newfilename_s);
														
							redirect('business/photo_upload/' . $business_unique_id . '?updates=true&photo=' . $newfilename_m);
							exit();
						}
					}
					else {
						$data['status'] = 'upload_error';
					}
				}
			}
			else {
				show_404();
			}
			
			$this->load->view('includes/header', $data);
			$this->load->view('business', $data);
			$this->load->view('includes/footer');							
		}
		else {
			redirect('login?dest=photo&id=' . $business_unique_id);
			exit();
		}
	}
	
	function useful()
	{
		if(isset($_GET['review_id'])) {
			$usefulness = $this->business_info->get_usefulness($_GET['review_id']);
			$usefulness = $usefulness['usefulness'] + 1;
			$this->business_info->add_usefulness($_GET['review_id'], $usefulness);
			echo "ok";
		}
	}
	
	function city($city, $category)
	{		
		$city = $this->business_info->get_individual_city($city);
		if(empty($city)) {
			show_404();
		}	
		
		if($category != 'all') {
			$category_info = $this->business_info->get_category_id($category);
			if(empty($category_info)) {
				show_404();
			}
			$data['category_chinese'] = $category_info['category'];			
		}			
		
		$data['page_title'] = $city['city'] . ' | 評多比';
		$data['meta_desc'] = $city['city'] . '的店家資訊';
		$data['meta_key'] = $city['city'] . ', 店家資訊, 評多比';

		$data['city'] = $city['city'];
		$data['city_english'] = $city['city_english'];		
		$data['category_name'] = $category;		
		
		if($category == 'all') {
			$data['business_new_1'] = $this->business_info->get_business_list($city['city'], 1, 'insert_time', 5); // Parameters: city, category, order, limit
			$data['business_new_2'] = $this->business_info->get_business_list($city['city'], 2, 'insert_time', 5);
			$data['business_new_5'] = $this->business_info->get_business_list($city['city'], 5, 'insert_time', 5);
					
			$data['business_num_1'] = $this->business_info->get_business_list($city['city'], 1, 'num_rating', 5);
			$data['business_num_2'] = $this->business_info->get_business_list($city['city'], 2, 'num_rating', 5);
			$data['business_num_5'] = $this->business_info->get_business_list($city['city'], 5, 'num_rating', 5);
			
			$data['business_photo_1'] = $this->business_info->get_business_photo_by_category(1);	
			$data['business_photo_2'] = $this->business_info->get_business_photo_by_category(2);	
			$data['business_photo_5'] = $this->business_info->get_business_photo_by_category(5);	
			
			$data['business_photo_1a'] = $this->business_info->get_business_photo_by_category(1);	
			$data['business_photo_2a'] = $this->business_info->get_business_photo_by_category(2);	
			$data['business_photo_5a'] = $this->business_info->get_business_photo_by_category(5);							
			
			$data['city_list'] = $this->business_info->get_city();
			$size = count($data['city_list']);
			for($i=0; $i<$size; $i++) {
				$num = $this->business_info->get_num_in_city($data['city_list'][$i]['city']);
				$data['city_list'][$i] = array('city' => $data['city_list'][$i]['city'], 'city_english' => $data['city_list'][$i]['city_english'], 'count' => $num);
			}
			
			$data['latest_review'] = $this->business_info->get_latest_review($city['city'], 3);
		}
		else {			
			$category_name = $this->business_info->get_category_id($category);
			$data['business_list'] = $this->business_info->get_business_list($city['city'], $category_name['id'], 'insert_time', 'all'); // Parameters: city, category, order, limit
		}
		
		$data['category_list'] = $this->business_info->get_category();	
		$size = count($data['category_list']);
		for($i=0; $i<$size; $i++) {
			$num = $this->business_info->get_num_in_category($city['city'], $data['category_list'][$i]['category']);
			$data['category_list'][$i] = array('category' => $data['category_list'][$i]['category'], 'category_english' => $data['category_list'][$i]['category_english'], 'count' => $num);
		}						
	
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('search', $data);
		$this->load->view('includes/footer');
	}
	
}

?>