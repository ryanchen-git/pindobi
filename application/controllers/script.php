<?php

class Script extends Controller {

	function Script()
	{
		parent::Controller();	
		$this->load->model('business_info');				
	}

	function index()
	{
	}
	
	function business()
	{
		$data['type'] = 'business';
		$data['business_list'] = $this->business_info->get_business_list('all', 'all', 'all', 'all');
		$this->load->view('script', $data);
	}
	
	function city()
	{
		$data['type'] = 'city';	
		$data['city_list'] = $this->business_info->get_city();
		$this->load->view('script', $data);
	}
		
}

?>