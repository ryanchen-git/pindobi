<?php

class Search extends Controller {

	function Search()
	{
		parent::Controller();
		$this->load->model('business_info');
		$this->load->library('pagination');		
	}

	function index()
	{
		$data['page_title'] = '搜尋結果 | 評多比';
		$data['meta_desc'] = '搜尋店家結果';
		$data['meta_key'] = '搜尋結果, 評多比';		
				
		if(isset($_GET['business']) || isset($_GET['city'])) {
			if($_GET['city'] == '') {
				if($this->session->userdata('city')) {
					$_GET['city'] = $this->session->userdata('city');
				}
				else {
					$_GET['city'] = '';
				}
			}
			
			$data['business_list'] = $this->business_info->search_business($_GET['business'], $_GET['city'], 'all', 'all');
			$total_num = sizeof($data['business_list']);
			
			if(isset($_GET['page'])) {
				if(!empty($_GET['page'])) {
					$data['business_list'] = $this->business_info->search_business($_GET['business'], $_GET['city'], $_GET['page'], 10);	
				}
				else {
					$data['business_list'] = $this->business_info->search_business($_GET['business'], $_GET['city'], 0, 10);				
				}
			}
			else {
				$data['business_list'] = $this->business_info->search_business($_GET['business'], $_GET['city'], 0, 10);				
			}
			
			if(isset($_GET['review'])) {
				$config['base_url'] = base_url() . 'search?business=' . $_GET['business'] . '&city=' . $_GET['city'] . '&review=true';
			}
			else {
				$config['base_url'] = base_url() . 'search?business=' . $_GET['business'] . '&city=' . $_GET['city'];
			}
			
			$config['total_rows'] = $total_num;
			$config['per_page'] = '10';
			$config['query_string_segment'] = 'page';
			$config['first_link'] = '第一頁';
			$config['last_link'] = '最後一頁';
			$config['prev_link'] = '< 上一頁';
			$config['next_link'] = '下一頁 >';
			$config['full_tag_open'] = '<div class="full_tag_open">';
			$config['full_tag_close'] = '</div>';			
			$config['first_tag_open'] = '<div class="first_tag_open">';
			$config['first_tag_close'] = '</div>';			
			$config['prev_tag_open'] = '<div class="prev_tag_open">';
			$config['prev_tag_close'] = '</div>';			
			$config['last_tag_open'] = '<div class="last_tag_open">';
			$config['last_tag_close'] = '</div>';
			$config['next_tag_open'] = '<div class="next_tag_open">';
			$config['next_tag_close'] = '</div>';
			$config['cur_tag_open'] = '<div class="cur_tag_open">';
			$config['cur_tag_close'] = '</div>';
			$config['num_tag_open'] = '<div class="num_tag_open">';
			$config['num_tag_close'] = '</div>';
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();		
		}
		
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('search', $data);
		$this->load->view('includes/footer');		
	}
		
}

?>