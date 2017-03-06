<?php

class Member_info extends Model {

    function Member_info()
    {
        parent::Model();
    }
	
	function add_member($member_signup_data)
	{		
		$password = md5($member_signup_data['password']);
		$unique_id = uniqid();
		$timestamp = time();
		
		$query = "INSERT INTO member 
					(last_name, first_name, email, password, gender, city, birth_month, birth_date, birth_year, unique_id, signup_time, timestamp, active) 
					VALUES ('" . $member_signup_data['lastname']  . "',
						'" . $member_signup_data['firstname'] . "',
						'" . $member_signup_data['email'] . "',
						'" . $password . "',
						'" . $member_signup_data['gender'] . "',
						'" . $member_signup_data['city'] . "',						
						" . $member_signup_data['birth_month'] . ",
						" . $member_signup_data['birth_date'] . ",
						" . $member_signup_data['birth_year'] . ",
						'" . $unique_id . "',
						NOW(), " . $timestamp . ", 0)";
						
		$result = $this->db->query($query);
	}
	
	function member_login($member_login_data)
	{
		$password = md5($member_login_data['password']);
		
		$query = "SELECT m.first_name, m.last_name, m.city, c.city_english, m.unique_id
					FROM member m, city c
					WHERE m.email = '" . $member_login_data['email'] . "' 
					AND m.password = '" . $password . "' 
					AND m.city = c.city
					AND m.active = 1";
		
		$result = $this->db->query($query);
		return $result->row_array();
	}
	
	function get_member($memeber_unique_id)
	{
		$query = "SELECT email, first_name, last_name, gender, city, birth_month, birth_date, birth_year, pageview, unique_id, signup_time
					FROM member
					WHERE unique_id = '" . $memeber_unique_id . "'
					AND active = 1";
		
		$result = $this->db->query($query);
		return $result->row_array();
	}
	
	function get_member_timestamp($email, $active)
	{
		$query = "SELECT unique_id, timestamp
					FROM member
					WHERE email = '" . $email . "' 
					AND active = " . $active;
					
		$result = $this->db->query($query);
		return $result->row_array();
	}	
	
	function get_member_unique_id($timestamp)
	{
		$query = "SELECT unique_id
					FROM member
					WHERE timestamp = '" . $timestamp . "' 
					AND active = 1";

		$result = $this->db->query($query);
		return $result->row_array();
	}		
	
	function get_member_activate($timestamp)
	{
		$query = "UPDATE member 
					SET active = 1 
					WHERE timestamp = '" . $timestamp . "' 
					AND active = 0";
					
		$result = $this->db->query($query);
		return $this->db->affected_rows();
	}
	
	function get_member_reset($member_unique_id, $timestamp)
	{
		$query = "SELECT id
					FROM member
					WHERE unique_id = '" . $member_unique_id . "' 
					AND timestamp = '" . $timestamp . "'
					AND active = 1";

		$result = $this->db->query($query);
		return $result->row_array();
	}	
		
	function update_timestamp($email, $new_timestamp)
	{
		$query = "UPDATE member 
					SET timestamp = '" . $new_timestamp . "'
					WHERE email = '" . $email . "'
					AND active = 1"; 
					
		$result = $this->db->query($query);					
	}
	
	
	function update_info($member_update_data, $email)
	{
		$query = "UPDATE member 
					SET first_name = '" . $member_update_data['firstname'] . "',
					last_name = '" . $member_update_data['lastname'] . "',
					gender = '" . $member_update_data['gender'] . "',
					city = '" . $member_update_data['city'] . "',					
					birth_month = '" . $member_update_data['birth_month'] . "',
					birth_date = '" . $member_update_data['birth_date'] . "',	
					birth_year = '" . $member_update_data['birth_year'] . "'
					WHERE email = '" . $email . "' 
					AND active = 1";	
					
		$result = $this->db->query($query);
	}
	
	function update_password($member_update_data, $email)
	{
		$password = md5($member_update_data['password']);
		$query = "UPDATE member 
					SET password = '" . $password . "'
					WHERE email = '" . $email . "' 
					AND active = 1";	
					
		$result = $this->db->query($query);
	}
	
	function update_reset_password($member_unique_id, $password)
	{
		$password = md5($password);
		$query = "UPDATE member 
					SET password = '" . $password . "'
					WHERE unique_id = '" . $member_unique_id . "' 
					AND active = 1";	
					
		$result = $this->db->query($query);
	}	
	
	function update_member_pageview($member_unique_id, $pageview)
	{
		$query = "UPDATE member 
					SET pageview = '" . $pageview . "'
					WHERE unique_id = '" . $member_unique_id . "' 
					AND active = 1";	
					
		$result = $this->db->query($query);
	}		
	
	function get_member_review($member_unique_id)
	{
		$query = "SELECT m2b.review_unique_id, m2b.rating, m2b.review, m2b.usefulness, m2b.review_time, b.name, b.address, b.city, b.phone, b.unique_id, c.category
					FROM member2business_review m2b, business b, category c
					WHERE m2b.member_unique_id = '" . $member_unique_id . "' 
					AND m2b.business_unique_id = b.unique_id
					AND b.category = c.id
					AND m2b.active = 1 AND b.active = 1
					ORDER BY m2b.review_time DESC";
					
		$result = $this->db->query($query);
		return $result->result_array();					
	}	
	
	function get_single_review($review_unique_id)
	{
		$query = "SELECT m2b.member_unique_id, m2b.business_unique_id, m2b.review_unique_id, m2b.rating, m2b.review, m2b.review_time, b.name, b.city, b.unique_id
					FROM member2business_review m2b, business b
					WHERE m2b.review_unique_id = '" . $review_unique_id . "' 
					AND m2b.business_unique_id = b.unique_id
					AND m2b.active = 1 AND b.active = 1";
					
		$result = $this->db->query($query);
		return $result->row_array();					
	}	
	
	function update_business_review($review_unique_id, $vote, $review)
	{
		$query = "UPDATE member2business_review 
					SET rating = " . $vote . ", 
					review = '" . $review . "'
					WHERE review_unique_id = '" . $review_unique_id . "' 
					AND active = 1";
					
		$result = $this->db->query($query);
	}		
	
	function remove_business_review($review_unique_id)
	{
		$query = "UPDATE member2business_review 
					SET active = 0 
					WHERE review_unique_id = '" . $review_unique_id . "' 
					AND active = 1";

		$result = $this->db->query($query);
	}	
	
	function get_bookmark($member_unique_id)
	{
		$query = "SELECT m2b.business_unique_id, m2b.bookmark_unique_id, b.name, b.address, b.city, b.phone, c.category
					FROM member2bookmark m2b, business b, category c
					WHERE m2b.member_unique_id = '" . $member_unique_id . "' 
					AND m2b.business_unique_id = b.unique_id
					AND b.category = c.id
					AND m2b.active = 1
					ORDER BY m2b.insert_time DESC";

		$result = $this->db->query($query);
		return $result->result_array();
	}	
	
	function get_single_bookmark($bookmark_unique_id)
	{
		$query = "SELECT m2b.bookmark_unique_id, b.name
					FROM member2bookmark m2b, business b
					WHERE m2b.bookmark_unique_id = '" . $bookmark_unique_id . "' 
					AND m2b.business_unique_id = b.unique_id
					AND m2b.active = 1";
					
		$result = $this->db->query($query);
		return $result->row_array();					
	}
	
	function remove_bookmark($bookmark_unique_id)
	{
		$query = "UPDATE member2bookmark 
					SET active = 0 
					WHERE bookmark_unique_id = '" . $bookmark_unique_id . "' 
					AND active = 1";

		$result = $this->db->query($query);	
	}
	
	function check_email($email)
	{
		$query = "SELECT id FROM member WHERE email = '" . $email . "'";

		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	function get_birth_year()
	{
		$query = "SELECT year FROM year ORDER BY id DESC;";

		$result = $this->db->query($query);
		return $result->result_array();
	}		
	
	function add_profile_photo($member_unique_id, $newfilename_l, $newfilename_m, $newfilename_s)
	{		
		$unique_id = uniqid();	
	
		$query = "INSERT INTO member2profile_photo 
					(member_unique_id, photo_unique_id, filename_l, filename_m, filename_s, upload_time) 
					VALUES ('" . $member_unique_id  . "', 
						'" . $unique_id . "', 
						'" . $newfilename_l . "', 
						'" . $newfilename_m . "', 
						'" . $newfilename_s . "', NOW())";
		
		$result = $this->db->query($query);
	}	
	
	function get_profile_photo($member_unique_id)
	{
		$query = "SELECT filename_l, filename_m, filename_s 
					FROM member2profile_photo 
					WHERE member_unique_id = '" . $member_unique_id . "' 
					AND active = 1";

		$result = $this->db->query($query);
		return $result->row_array();
	}	
	
	function get_all_profile_photo($member_unique_id)
	{
		$query = "SELECT photo_unique_id, filename_l, filename_m, filename_s 
					FROM member2profile_photo 
					WHERE member_unique_id = '" . $member_unique_id . "' 
					AND active = 1";

		$result = $this->db->query($query);
		return $result->row_array();
	}				
	
	function delete_profile_photo($photo_unique_id)
	{
		$query = "UPDATE member2profile_photo 
					SET active = 0 
					WHERE photo_unique_id = '" . $photo_unique_id . "' 
					AND active = 1";

		$result = $this->db->query($query);
	}		
	
	function get_member_business_all_photo($member_unique_id)
	{
		$query = "SELECT DISTINCT m2b.business_unique_id, m2b.photo_unique_id, m2b.filename_l, m2b.filename_s, b.name
					FROM member2business_photo m2b, member m, business b
					WHERE m2b.member_unique_id = '" . $member_unique_id . "' 
					AND m2b.business_unique_id = b.unique_id
					AND m2b.active = 1 AND m.active = 1 AND b.active = 1
					ORDER BY b.category, b.name";

		$result = $this->db->query($query);
		return $result->result_array();
	}							
		
	function get_city()
	{
		$query = "SELECT city FROM city WHERE active = 1";
					
		$result = $this->db->query($query);
		return $result->result_array();
	}	
	
}

?>