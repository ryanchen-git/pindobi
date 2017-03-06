<?php

class Profile extends Controller {

	function Profile()
	{
		parent::Controller();	
		$this->load->model('member_info');				
	}

	function index()
	{
		if($this->session->userdata('firstname')) {
			$data['css'] = 'jquery.lightbox-0.5.css';		
			$data['js'] = 'lightbox/jquery.lightbox-0.5.js';
			$data['js_lightbox'] = true;
			
			$data['page_title'] = '我的帳號 | 評多比';
			$data['meta_desc'] = '評多比的會員個人帳號';
			$data['meta_key'] = '我的帳號, 評多比';
			
			$member_unique_id = $this->session->userdata('unique_id');
			$data['profile_photo'] = $this->member_info->get_profile_photo($member_unique_id);		
			
			if($this->input->get('updates')) {
				$data['updates'] = true;
			}
							
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('profile', $data);
			$this->load->view('includes/footer');
		}
		else {
			redirect('login');
			exit();
		}
	}
		
	function photo()
	{
		if($this->session->userdata('firstname')) {	
			$data['js'] = 'file_uploads/file_uploads.js';
			$data['js_file_uploads'] = true;			
			
			$data['page_title'] = '我的個人照片 | 評多比';
			$data['meta_desc'] = '評多比的會員個人照片';
			$data['meta_key'] = '我的照片, 評多比';
			
			require_once('library/thumbnail/ThumbLib.inc.php');
			
			$member_unique_id = $this->session->userdata('unique_id');			
									
			if(isset($_POST['update_photo_submit'])) {
				if((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 1000000)) {
					if($_FILES["file"]["error"] > 0) {
						//echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
						$data['invalid_file'] = true;
					}
					else {
						$ext = substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], '.') + 1);	// Get file extension
						$newfilename = substr(md5(uniqid(rand(),1)), 3, 10)  . "." . $ext;
						$newfilename_l = substr(md5(uniqid(rand(),1)), 3, 10)  . "." . $ext;						
						$newfilename_m = substr(md5(uniqid(rand(),1)), 3, 10)  . "." . $ext;						
						$newfilename_s = substr(md5(uniqid(rand(),1)), 3, 10)  . "." . $ext;						

						move_uploaded_file($_FILES["file"]["tmp_name"], "img/member/" . $newfilename);

						$thumb = PhpThumbFactory::create('img/member/' . $newfilename);
						$thumb->resize(400, 400);
						$thumb->save("img/member/".$newfilename_l);
						
						$thumb = PhpThumbFactory::create('img/member/' . $newfilename);
						$thumb->resize(150, 150);
						$thumb->save("img/member/".$newfilename_m);
						
						$thumb = PhpThumbFactory::create('img/member/' . $newfilename);
						$thumb->adaptiveResize(50, 50);
						$thumb->save("img/member/".$newfilename_s);
						
						unlink("img/member/" . $newfilename);	// Remove original uploaded file

						$profile_photo = $this->member_info->get_profile_photo($member_unique_id);
						if(!empty($profile_photo)) {
							$profile_photo = $this->member_info->get_all_profile_photo($member_unique_id);
							if(!empty($profile_photo)) {
								unlink("img/member/" . $profile_photo['filename_l']);
								unlink("img/member/" . $profile_photo['filename_m']);
								unlink("img/member/" . $profile_photo['filename_s']);																  
								$this->member_info->delete_profile_photo($profile_photo['photo_unique_id']);
							}
						}
						
						$this->member_info->add_profile_photo($member_unique_id, $newfilename_l, $newfilename_m, $newfilename_s);
						
						redirect('profile/photo/');
						exit();
					}
				}
				else {
					$data['invalid_file'] = true;
				}
			}
						
			$data['profile_photo'] = $this->member_info->get_profile_photo($member_unique_id);			
					
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('profile', $data);
			$this->load->view('includes/footer');
		}
		else {
			redirect('login');
			exit();
		}
	}	
	
	function delete_profile_photo()
	{
		$data['page_title'] = '刪除個人照片 | 評多比';
		$data['meta_desc'] = '刪除會員的個人照片';
		$data['meta_key'] = '刪除個人照片, 評多比';		
		
		$data['profile_photo'] = $this->member_info->get_all_profile_photo($this->session->userdata('unique_id'));		
		
		if(isset($_POST['delete_photo_submit'])) {			
			unlink("img/member/" . $data['profile_photo']['filename_l']);
			unlink("img/member/" . $data['profile_photo']['filename_m']);
			unlink("img/member/" . $data['profile_photo']['filename_s']);																  
			$this->member_info->delete_profile_photo($data['profile_photo']['photo_unique_id']);
			redirect('profile/photo');
			exit();
		}
		
		// Load View
		$this->load->view('includes/header', $data);
		$this->load->view('delete', $data);
		$this->load->view('includes/footer');	
	}	
	
	function info()
	{
		if($this->session->userdata('firstname')) {	
			$data['js'] = 'validate/jquery.validate.min.js';
			$data['js_validate_general'] = true;		
			
			$data['page_title'] = '我的個人資料 | 評多比';
			$data['meta_desc'] = '修改會員個人資料';
			$data['meta_key'] = '我的個人資料, 評多比';			
			
			$data['member_profile'] = $this->member_info->get_member($this->session->userdata('unique_id'));	
			$data['city_list'] = $this->member_info->get_city();						
			$data['birth_year'] = $this->member_info->get_birth_year();					
			
			if(isset($_POST['update_info_submit'])) {
				$this->member_info->update_info($_POST, $this->session->userdata('email'));
				redirect('profile?updates=true&status=done');
				exit();
			}
					
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('profile', $data);
			$this->load->view('includes/footer');
		}
		else {
			redirect('login');
			exit();
		}
	}
	
	function password()
	{
		if($this->session->userdata('firstname')) {	
			$data['js'] = 'validate/jquery.validate.min.js';
			$data['js_validate_general'] = true;		
			
			$data['page_title'] = '我的密碼 | 評多比';
			$data['meta_desc'] = '修改會員登入密碼';
			$data['meta_key'] = '我的密碼, 評多比';			
			
			if(isset($_POST['update_password_submit'])) {
				$this->member_info->update_password($_POST, $this->session->userdata('email'));
				redirect('profile?updates=true&status=done');
				exit();
			}					
					
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('profile', $data);
			$this->load->view('includes/footer');
		}
		else {
			redirect('login');
			exit();
		}
	}	
	
	function reset_pass($member_unique_id, $timestamp) // When user forgot the password, the user directred to this page by e-mail
	{
		$data['js'] = 'validate/jquery.validate.min.js';
		$data['js_validate_general'] = true;		
	
		$timestamp_decode = base64_decode($timestamp);
		$query_result = $this->member_info->get_member_reset($member_unique_id, $timestamp_decode);
		$data['member_unique_id'] = $member_unique_id;
		if($query_result) {
			$data['page_title'] = '重新設定密碼 | 評多比';
			$data['meta_desc'] = '重新設定會員密碼';
			$data['meta_key'] = '重新設定密碼, 評多比';		
		
			// Load View
			$this->load->view('includes/header', $data);
			$this->load->view('profile', $data);
			$this->load->view('includes/footer');
		}
		else {
			redirect('signup');
			exit();
		}
	}		
	
	function password_reset() // This function only accepts form data from above function
	{
		if(isset($_POST['reset_password_submit'])) {
			$this->member_info->update_reset_password($_POST['member_unique_id'], $_POST['password']);
			redirect('login?updates=true&reset=success');
			exit();
		}
		else {
			redirect('/');
			exit();
		}					
	}		
	
}

?>