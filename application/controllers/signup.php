<?php

class Signup extends Controller {

	function Signup()
	{
		parent::Controller();
		$this->load->model('member_info');
		$this->load->library('email');		
	}

	function index()
	{
		$data['js'] = 'validate/jquery.validate.min.js';
		$data['js_validate_signup'] = true;
		$data['focus_id'] = 'lastname';		
		
		$data['page_title'] = '加入會員 | 評多比';
		$data['meta_desc'] = '加入會員';
		$data['meta_key'] = '加入會員, 評多比';		
		
		$data['city_list'] = $this->member_info->get_city();			
		$data['birth_year'] = $this->member_info->get_birth_year();
		
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('signup', $data);
		$this->load->view('includes/footer');		
	}
	
	function submit()
	{
		if(isset($_POST['signup_submit'])) {
			$add_member = $this->member_info->add_member($_POST);
			
			$new_member = $this->member_info->get_member_timestamp($_POST['email'], 0); // Member is not active (0)
			$timestamp_encode = base64_encode($new_member['timestamp']);
			
			$config['mailtype'] = 'html';
			$this->email->initialize($config);									

			$url = base_url() . "member/activate/" . $timestamp_encode;
			$message ="您好,<br /><br />請點選以下的連結來啟動您的評多比帳號:<br />";
			$message .="<a href=\"$url\">$url</a><br /><br />";
			$message .="評多比<br />";
			$message .="<a href=\"http://www.pindobi.com/\">www.pindobi.com</a><br /><br />";
			$message .="如果你不清楚這是什麼請忽略此封信.";
						
			$this->email->from('no-reply@pindobi.com', '評多比');
			$this->email->to($_POST['email']);
			
			$this->email->subject('評多比帳號啟動連結');
			$this->email->message($message);
									
			$this->email->send();
			$data['post_signup'] = true;
		}
		else {
			redirect('signup');
			exit();
		}
		
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('signup', $data);
		$this->load->view('includes/footer');	
	}
	
	function check_email()
	{
		$email = trim(strtolower($_REQUEST['email']));
		$check_email = $this->member_info->check_email($email);
		if($check_email == 0) {
			echo "true";
		}
		else {
			echo "false";
		}
	}
	
}

?>