<?php

class About extends Controller {

	function About()
	{
		parent::Controller();
	}

	function index()
	{
		$data['page_title'] = '關於評多比';
		$data['meta_desc'] = '關於評多比';
		$data['meta_key'] = '關於評多比';
	
		$this->load->view('includes/header', $data);
		$this->load->view('about', $data);
		$this->load->view('includes/footer');		
	}
	
	function terms()
	{
		$data['page_title'] = '服務條款 | 評多比';
		$data['meta_desc'] = '評多比的服務條款';
		$data['meta_key'] = '評多比, 服務條款';
	
		$this->load->view('includes/header', $data);
		$this->load->view('about', $data);
		$this->load->view('includes/footer');	
	}	
		
}

?>