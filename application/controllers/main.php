<?php

class Main extends Controller {

	function Main()
	{
		parent::Controller();	
		$this->load->model('business_info');
		$this->load->model('member_info');										
	}

	function index()
	{
		$data['page_title'] = '評多比';
		$data['meta_desc'] = '評多比 - 一個瀏覽店家資料, 資訊, 評價跟評語的網站';
		$data['meta_key'] = '評多比, 店家評價, 店家評語, 店家資料, 店家資訊';
		
		$data['focus_id'] = 'search';
		
		if($this->session->userdata('unique_id')) {
			$data['business_rand'] = $this->business_info->get_business_rand($this->session->userdata('city'));		
			$data['member_profile'] = $this->member_info->get_member($this->session->userdata('unique_id'));
			$data['member_review'] = $this->member_info->get_member_review($this->session->userdata('unique_id'));
			
			$data['profile_photo'] = $this->member_info->get_profile_photo($this->session->userdata('unique_id'));			
			
			$total_usefulness = 0;
			foreach($data['member_review'] as $review) {
				$total_usefulness = $total_usefulness + $review['usefulness'];
			}
			$data['total_usefulness'] = $total_usefulness;
		}
		
		$data['business_new_1'] = $this->business_info->get_business_list('all', 1, 'insert_time', 5); // Parameters: city, category, order, limit
		$data['business_new_2'] = $this->business_info->get_business_list('all', 2, 'insert_time', 5);
		$data['business_new_5'] = $this->business_info->get_business_list('all', 5, 'insert_time', 5);
		$data['business_new_7'] = $this->business_info->get_business_list('all', 7, 'insert_time', 5);
	
		$data['business_num_1'] = $this->business_info->get_business_list('all', 1, 'num_rating', 5);
		$data['business_num_2'] = $this->business_info->get_business_list('all', 2, 'num_rating', 5);
		$data['business_num_5'] = $this->business_info->get_business_list('all', 5, 'num_rating', 5);
		$data['business_num_7'] = $this->business_info->get_business_list('all', 7, 'num_rating', 5);		
		
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
				
		$data['latest_review'] = $this->business_info->get_latest_review('all', 3);			
		
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('main', $data);
		$this->load->view('includes/footer');
	}
		
}

?>