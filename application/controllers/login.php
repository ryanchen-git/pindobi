<?php

class Login extends Controller {

	function Login()
	{
		parent::Controller();	
		$this->load->model('member_info');		
		$this->load->library('email');				
	}

	function index()
	{
		$data['js'] = 'validate/jquery.validate.min.js';
		$data['js_validate_login'] = true;
		$data['focus_id'] = 'email';		

		$data['page_title'] = '會員登入 | 評多比';
		$data['meta_desc'] = '評多比的會員登入';
		$data['meta_key'] = '會員登入, 評多比';		
		
		if(isset($_GET['dest'])) {
			switch ($this->input->get('dest'))
			{
			case 'edit':
			  $data['action'] = 'login?dest=edit&id=' . $_GET['id'];
			  break;
			case 'bookmark':
			  $data['action'] = 'login?dest=bookmark&id=' . $_GET['id'];
			  break;	
			case 'write':
			  $data['action'] = 'login?dest=write&id=' . $_GET['id'];
			  break;	
			case 'photo':
			  $data['action'] = 'login?dest=photo&id=' . $_GET['id'];
			  break;			  			  			  
			} 
		}
		else {
			$data['action'] = 'login/';
		}
		
		if(isset($_POST['login_submit'])) {
			$member_login['member'] = $this->member_info->member_login($_POST);
			if(!empty($member_login['member'])) {
				if($member_login['member']['unique_id'] != '') {
					$data = array(
					   'firstname'  => $member_login['member']['first_name'],
					   'lastname' => $member_login['member']['last_name'],
					   'email' => $_POST['email'],
					   'city'  => $member_login['member']['city'],					 
					   'city_english'  => $member_login['member']['city_english'],					   					   
					   'unique_id' => $member_login['member']['unique_id']
					);
					$this->session->set_userdata($data);
					
					if(isset($_GET['dest'])) {
						switch ($_GET['dest'])
						{
						case 'edit':
						  $redirect = 'business/write/' . $_GET['id'] . '/';
						  break;
						case 'bookmark':
						  $redirect = 'business/bookmark/' . $_GET['id'] . '/';
						  break;	
						case 'write':
						  $redirect = 'business/write/' . $_GET['id'] . '/';
						  break;	
						case 'photo':
						  $redirect = 'business/photo_upload/' . $_GET['id'] . '/';
						  break;			  						  						  						  
						} 
						redirect($redirect);
						exit();
					}
					else {
						redirect();
						exit();
					}
				}
			}
			else {
				$data['login_error'] = true;
			}
		}	
				
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('login', $data);
		$this->load->view('includes/footer');		
	}
		
	function logout() 
	{
		$this->session->sess_destroy();
		redirect();
		exit();
	}
	
	function forgot() 
	{
		$data['js'] = 'validate/jquery.validate.min.js';
		$data['js_validate_forgot'] = true;
		$data['focus_id'] = 'email';		
		
		$data['page_title'] = '重設密碼 | 評多比';
		$data['meta_desc'] = '評多比會員密碼的重新設定';
		$data['meta_key'] = '重設密碼, 評多比';		
		
		if(isset($_POST['forgot_submit'])) {
			$new_timestamp = time();
			$member_info = $this->member_info->get_member_timestamp($_POST['email'], 1);  // Member is active (1)
			$member_unique_id = $member_info['unique_id'];
			$this->member_info->update_timestamp($_POST['email'], $new_timestamp);
			$timestamp_encode = base64_encode($new_timestamp);
			
			$config['mailtype'] = 'html';
			$this->email->initialize($config);									

			$url = base_url() . "reset/" . $member_unique_id . "/" . $timestamp_encode;
			$message ="您好,<br /><br />請點選以下的連結來重新設定你評多比的密碼:<br />";
			$message .="<a href=\"$url\">$url</a><br /><br />";
			$message .="評多比<br />";
			$message .="<a href=\"http://www.pindobi.com/\">www.pindobi.com</a><br /><br />";
			$message .="如果你不清楚這是什麼請忽略此封信.";
						
			$this->email->from('no-reply@pindobi.com', 'Pindobi.com');
			$this->email->to($_POST['email']);
			
			$this->email->subject('評多比重新設定密碼');
			$this->email->message($message);
									
			$this->email->send();
			redirect('forgot?updates=true&email=sent');
			exit();
		}	
				
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('login', $data);
		$this->load->view('includes/footer');		
	}	
	
}

?>