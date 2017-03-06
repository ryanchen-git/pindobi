<?php

class Business_info extends Model {

    function Business_info()
    {
        parent::Model();
    }
		
	function get_business($unique_id)
	{
		$query = "SELECT b.name, b.address, b.city, ct.city_english, b.phone, b.url, c.category, b.rating, b.pageview, b.unique_id
					FROM business b, category c, city ct
					WHERE b.unique_id = '" . $unique_id . "'
					AND b.city = ct.city
					AND b.active = 1 AND b.category = c.id AND c.active = 1";
		
		$result = $this->db->query($query);
		return $result->row_array();
	}
	
	function get_business_list($city, $category, $order, $limit)
	{
		$query = "SELECT b.name, b.address, b.phone, b.url, b.city, c.category, b.num_rating, b.rating, b.unique_id
					FROM business b, category c
					WHERE b.category = c.id
					AND b.active = 1  AND c.active = 1 ";
		
		if($city != 'all') {
			$query .= "AND b.city = '" . $city . "' ";
		}

		if($category != 'all') {
			$query .= "AND b.category = " . $category . " ";
		}
		
		if($order != 'all') {
			$query .= "ORDER BY " . $order . " DESC ";
		}
		
		if($limit != 'all') {
			$query .= "LIMIT " . $limit . "";
		}
		
		$result = $this->db->query($query);
		return $result->result_array();
	}	
	
	function get_business_rand($city)
	{
		$query = "SELECT unique_id
					FROM business
					WHERE city = '" . $city . "'
					AND active = 1
					ORDER BY RAND() 
					LIMIT 1";
		
		$result = $this->db->query($query);
		return $result->row_array();
	}	
	
	function business_related($business_unique_id, $category, $city)
	{
		$query = "SELECT DISTINCT b.unique_id, b.name, b.address, b.city, b.phone, b.url, c.category, b.num_rating, b.rating
					FROM business b, category c, city ct
					WHERE b.unique_id != '" . $business_unique_id . "'
					AND c.category = '" . $category ."'
					AND b.city = '" . $city ."'
					AND b.active = 1 AND b.category = c.id AND c.active = 1
					ORDER BY RAND() 
					LIMIT 3";
					
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function add_business($add_business_data, $unique_id)
	{	
		$add_business_data['name'] = addslashes($add_business_data['name']);
	
		$query = "INSERT INTO business 
					(name, address, city, phone, url, category, unique_id, insert_time) 
					VALUES ('" . $add_business_data['name'] . "',
						'" . $add_business_data['address'] . "',
						'" . $add_business_data['city'] . "',
						'" . $add_business_data['phone'] . "',
						'" . $add_business_data['website_url'] . "',
						'" . $add_business_data['category'] . "',
						'" . $unique_id . "', NOW())";
		
		$result = $this->db->query($query);
	}	
	
	function update_business($update_business_data, $unique_id)
	{
		$update_business_data['name'] = addslashes($update_business_data['name']);
	
		$query = "UPDATE business 
					SET name = '" . $update_business_data['name'] . "',
					address = '" . $update_business_data['address'] . "',
					city = '" . $update_business_data['city'] . "',					
					phone = '" . $update_business_data['phone'] . "',
					url = '" . $update_business_data['website_url'] . "',	
					category = '" . $update_business_data['category'] . "'
					WHERE unique_id = '" . $unique_id . "' AND active = 1";	
					
		$result = $this->db->query($query);
	}	
	
	function update_business_pageview($business_unique_id, $pageview)
	{
		$query = "UPDATE business 
					SET pageview = '" . $pageview . "'
					WHERE unique_id = '" . $business_unique_id . "' 
					AND active = 1";	
					
		$result = $this->db->query($query);
	}	
	
	function add_business_review($member_unique_id, $business_unique_id, $vote, $review)
	{
		$unique_id = uniqid();
	
		$query = "INSERT INTO member2business_review 
					(member_unique_id, business_unique_id, review_unique_id, rating, review, review_time) 
					VALUES ('" . $member_unique_id . "',
						'" . $business_unique_id . "',
						'" . $unique_id ."',
						'" . $vote . "',
						'" . $review . "',
						NOW())";
		
		$result = $this->db->query($query);
	}	
	
	function get_business_review($business_unique_id, $sort)
	{
		$query = "SELECT m2b.member_unique_id, m2b.review_unique_id, m2b.rating, m2b.review,m2b.usefulness, m2b.review_time, m.last_name, m.first_name, m.city, m.unique_id, m2p.filename_s
					FROM member2business_review m2b, member m, member2profile_photo m2p
					WHERE m2b.business_unique_id = '" . $business_unique_id . "' 
					AND m2b.member_unique_id = m.unique_id
					AND m2p.member_unique_id = m2b.member_unique_id
					AND m2b.active = 1 AND m.active = 1 AND m2p.active = 1 ";
	
		if($sort == 'time') {
			$query .= "ORDER BY m2b.review_time DESC";
		}
		else if($sort == 'useful') {
			$query .= "ORDER BY m2b.usefulness DESC";
		}
		else if($sort == 'rating') {
			$query .= "ORDER BY m2b.rating DESC";
		}

		$result = $this->db->query($query);
		return $result->result_array();					
	}
	
	function get_latest_review($city, $limit)
	{
		$query = "SELECT m2b.member_unique_id, m2b.business_unique_id, m2b.rating, m2b.review,m2b.usefulness, m2b.review_time, b.name, m.last_name, m.first_name, m.city, m.unique_id, m2p.filename_s
					FROM member2business_review m2b, business b, member m, member2profile_photo m2p
					WHERE m2b.business_unique_id = b.unique_id
					AND m2b.member_unique_id = m.unique_id
					AND m2p.member_unique_id = m2b.member_unique_id
					AND m2b.active = 1 AND b.active = 1 AND m.active = 1 AND m2p.active = 1 ";
					
		if($city != 'all') {
			$query .= "AND b.city = '" . $city . "' ";
		}
					
		$query .= "ORDER BY m2b.review_time DESC
					LIMIT " . $limit;
					
		$result = $this->db->query($query);
		return $result->result_array();					
	}	
	
	function update_business_rating($business_unique_id, $num_review, $rating)
	{
		$query = "UPDATE business 
					SET num_rating = '" . $num_review . "',
					rating = '" . $rating . "'
					WHERE unique_id = '" . $business_unique_id . "' 
					AND active = 1";
		
		$result = $this->db->query($query);
	}
	
	function search_business($business_name, $city, $start, $num)
	{
				
		$query = "SELECT b.name, b.address, b.city, ct.city_english, b.phone, b.num_rating, b.rating, b.unique_id, c.category
					FROM business b, category c, city ct
					WHERE b.category = c.id
					AND b.city = ct.city
					AND b.active = 1 AND c.active = 1 ";
					
		if($business_name == '') {
			$query .= "AND b.city LIKE '%" . $city . "%' ";
		}
		else if($city == '') {
			$query .= "AND b.name LIKE '%" . $business_name . "%' ";
		}
		else {
			$query .= "AND b.name LIKE '%" . $business_name . "%' AND b.city LIKE '%" . $city . "%' ";
		}
		
		$query .= "ORDER BY num_rating DESC ";
		
		if(is_numeric($start) && is_numeric($num)) {
			$query .= "LIMIT " . $start . ", " . $num;
		}
		
		$result = $this->db->query($query);
		return $result->result_array();
	}	
	
	function get_city()
	{
		$query = "SELECT city, city_english
					FROM city 
					WHERE active = 1";
					
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function get_individual_city($city = '')
	{
		$query = "SELECT city, city_english
					FROM city 
					WHERE city_english = '" . $city . "'
					AND active = 1";
			
					
		$result = $this->db->query($query);
		return $result->row_array();
	}	
	
	function get_num_in_city($city)
	{
		$query = "SELECT * 
					FROM business 
					WHERE city = '" . $city . "'
					AND active = 1";
					
		$result = $this->db->query($query);
		return $result->num_rows($result);
	}
	
	function get_category()
	{
		$query = "SELECT id, category, category_english
					FROM category 
					WHERE active = 1";
					
		$result = $this->db->query($query);
		return $result->result_array();
	}	
	
	function get_category_id($category_name)
	{
		$query = "SELECT id, category 
					FROM category 
					WHERE category_english = '" . $category_name . "' 
					AND active = 1";
					
		$result = $this->db->query($query);
		return $result->row_array();
	}		
	
	function get_num_in_category($city, $category)
	{
		$query = "SELECT b.* 
					FROM business b, category c
					WHERE b.category = c.id
					AND c.category = '" . $category . "'
					AND b.active = 1 AND c.active = 1 ";
					
		if($city != 'all') {
			$query .= "AND b.city = '" . $city ."'";
		}			
					
		$result = $this->db->query($query);
		return $result->num_rows($result);
	}	
		
	function add_business_photo($member_unique_id, $business_unique_id, $filename_l, $filename_m, $filename_s)
	{		
		$unique_id = uniqid();
	
		$query = "INSERT INTO member2business_photo 
					(member_unique_id, business_unique_id, photo_unique_id, filename_l, filename_m, filename_s, upload_time) 
					VALUES ('" . $member_unique_id  . "', 
						'" . $business_unique_id  . "', 
						'" . $unique_id  . "', 
						'" . $filename_l . "', 
						'" . $filename_m . "', 
						'" . $filename_s . "', NOW())";
		
		$result = $this->db->query($query);
	}
	
	function get_business_all_photo($business_unique_id)
	{
		$query = "SELECT m2b.member_unique_id, m2b.filename_l, m2b.filename_s, m.last_name, m.first_name
					FROM member2business_photo m2b, member m
					WHERE m2b.business_unique_id = '" . $business_unique_id . "' 
					AND m2b.member_unique_id = m.unique_id
					AND m2b.active = 1 AND m.active = 1
					ORDER BY m2b.upload_time";

		$result = $this->db->query($query);
		return $result->result_array();
	}						
		
	function get_business_photo_rand_m($business_unique_id)
	{
		$query = "SELECT photo_unique_id, filename_l, filename_m
					FROM member2business_photo
					WHERE business_unique_id = '" . $business_unique_id . "' 
					AND active = 1 
					ORDER BY RAND() 
					LIMIT 1";

		$result = $this->db->query($query);
		return $result->row_array();
	}	
		
	function get_business_photo_rand($business_unique_id, $photo_unique_id)
	{
		$query = "SELECT filename_l, filename_m, filename_s 
					FROM member2business_photo
					WHERE business_unique_id = '" . $business_unique_id . "' 
					AND photo_unique_id <> '" . $photo_unique_id . "'
					AND active = 1 
					ORDER BY RAND()
					LIMIT 3";

		$result = $this->db->query($query);
		return $result->result_array();
	}		
	
	function get_business_photo($photo_unique_id)
	{
		$query = "SELECT photo_unique_id, filename_l, filename_m, filename_s
					FROM member2business_photo
					WHERE photo_unique_id = '" . $photo_unique_id . "' 
					AND active = 1";

		$result = $this->db->query($query);
		return $result->row_array();		
	}
	
	function get_business_photo_by_category($category)
	{
		$query = "SELECT m2b.filename_m
					FROM business b, member2business_photo m2b
					WHERE b.category = " . $category . "
					AND b.unique_id = m2b.business_unique_id
					AND b.active = 1 AND m2b.active = 1
					ORDER BY rand()
					LIMIT 1";

		$result = $this->db->query($query);
		return $result->row_array();		
	}	
	
	function remove_business_photo($photo_unique_id)
	{
		$query = "UPDATE member2business_photo 
					SET active = 0 
					WHERE photo_unique_id = '" . $photo_unique_id . "' 
					AND active = 1";
		
		$result = $this->db->query($query);		
	}
	
	function add_bookmark($member_unique_id, $business_unique_id)
	{
		$unique_id = uniqid();
	
		$query = "INSERT INTO member2bookmark 
					(member_unique_id, business_unique_id, bookmark_unique_id, insert_time) 
					VALUES ('" . $member_unique_id . "', 
						'" . $business_unique_id . "', 
						'" . $unique_id . "', NOW())";
					
		$result = $this->db->query($query);
	}		
	
	function get_usefulness($review_unique_id)
	{
		$query = "SELECT usefulness
					FROM member2business_review
					WHERE review_unique_id = '" . $review_unique_id . "' 
					AND active = 1";

		$result = $this->db->query($query);
		return $result->row_array();		
	}
	
	function add_usefulness($review_unique_id, $usefulness)
	{
		$query = "UPDATE member2business_review 
					SET usefulness = " . $usefulness . "
					WHERE review_unique_id = '" . $review_unique_id . "' 
					AND active = 1";
		
		$result = $this->db->query($query);		
	}
			
}

?>