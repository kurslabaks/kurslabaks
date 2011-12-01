<?    
	require_once "conf.php";

	foreach ($_POST as $posttitle => $postvalue) {
		$post[$posttitle] = trim(addslashes(htmlspecialchars(strip_tags($postvalue))));
	}
		
	foreach ($_GET as $gettitle => $getvalue) {
		$get[$gettitle] = trim(addslashes(htmlspecialchars(strip_tags($getvalue))));
	}
		
	/* Kategoriju un zīmolu pievienošana */
	
	if ($post['subbrandname']) {
	
		$brand = mysql_fetch_assoc(mysql_query('
			SELECT * 
			FROM brand 
			WHERE id = '.$post['brand']
		));
		mysql_query('
			INSERT INTO brand(text, category_id, parent_id) 
			VALUES ("'.$post['subbrandname'].'","'.$brand['category_id'].'","'.$post['brand'].'")
		');
		return header('Location: /grupa2/brands.php?brandid='.url_encode($post['brand']));
		
	} elseif ($post['info']) {

			mysql_query('
				UPDATE brand
				SET info = "'.$post['info'].'", 
					twitter = "'.$post['twitter'].'", 
					facebook = "'.$post['facebook'].'"
				WHERE id = '.$post['brand'].'
			');		
		
		
	} elseif ($post['brandname']) {
	
		mysql_query('INSERT INTO brand(text, category_id)
			VALUES ("'.$post['brandname'].'","'.$post['category'].'")');	
		return header('Location: /grupa2/brands.php?catid=' . url_encode($post['category']));
		
	} elseif ($post['categoryname']) {
	
		mysql_query('
			INSERT INTO category(text)
			VALUES ("'.$post['categoryname'].'")
		');	
		return header('Location: /grupa2/brands.php');	
		
	} elseif (isset($post['mark'])) {
		foreach ($post as $k => $v) {
			if ($k != "mark" && substr($k, 0,2) == "v_") {
			
				mysql_query('
					UPDATE tweet
					SET valid = "'.$v.'"
					WHERE id = '.substr($k, 2).'
				');
				
				if ($v == 0) {
					mysql_query('
						UPDATE tweet
						SET human = "0", mood = "0"
						WHERE id = '.substr($k, 2).'
					');								
				}
				
			} elseif ($k != "mark" && substr($k, 0,2) == "h_") {
			
				mysql_query('
					UPDATE tweet
					SET human = "'.$v.'"
					WHERE id = "'.substr($k, 2).'"
				');			

				if ($v == 0) {
					mysql_query('
						UPDATE tweet
						SET mood = "0"
						WHERE id = '.substr($k, 2).'
					');								
				}
				
			} elseif ($k != "mark" && substr($k, 0,2) == "m_") {
			
				mysql_query('
					UPDATE tweet
					SET mood = "'.$v.'"
					WHERE id = '.substr($k, 2).'
				');			
				
			}
		}
		
		Recalculate($post['brand']);		
		//return header('Location: '.$_SERVER['HTTP_REFERER']);
	}
	
	if (isset($get['brandid'])) {
	
		$subbrands = MakeAssoc(mysql_query('
			SELECT * 
			FROM brand 
			WHERE parent_id = '.$get['brandid']
		));
		$brand = mysql_fetch_assoc(mysql_query('
			SELECT * 
			FROM brand 
			WHERE id = '.$get['brandid']
		));
		$category = mysql_fetch_assoc(mysql_query('
			SELECT * 
			FROM category 
			WHERE id = '.$brand['category_id']
		));
		$tweets = MakeAssoc(mysql_query('
			SELECT DISTINCT tweet.user as user, tweet.text as text, tweet.date as date, tweet.id as id, tweet.valid as valid, tweet.mood as mood, tweet.human as human
			FROM tweet, tweet_brand, brand 
			WHERE brand.parent_id = '.$get['brandid'].'
			AND tweet.tweet_id = tweet_brand.tweet_id
			AND tweet_brand.brand_id = brand.id
		'));
		
	} elseif (isset($get['catid'])) {
	
		$brands = MakeAssoc(mysql_query('
			SELECT brand.text as text, brand.id as id, category.text as cat 
			FROM brand, category 
			WHERE brand.parent_id IS NULL 
			AND brand.category_id = category.id 
			AND category.id = '.$get['catid']
		));
		$category = mysql_fetch_assoc(mysql_query('
			SELECT * 
			FROM category 
			WHERE id = '.$get['catid']
		));

	} elseif (isset($get['deletebrand'])) {
	
		$brand = mysql_fetch_assoc(mysql_query('
			SELECT * 
			FROM brand 
			WHERE id = '.$get['deletebrand']
		));

		if ($brand['parent_id']) {
			mysql_query('
				DELETE FROM brand 
				WHERE id = '.$get['deletebrand']
			);
			
			mysql_query('
				DELETE tweet, tweet_brand FROM tweet, tweet_brand
				WHERE tweet.tweet_id = tweet_brand.tweet_id
				AND tweet_brand.brand_id = '.$get['deletebrand'].'
			');
		}
		return header('Location: /grupa2/brands.php');
		
	} elseif (isset($get['deletecat'])) {
	
		mysql_query('
			DELETE FROM brand 
			WHERE category_id = '.$get['deletecat']
		);
		mysql_query('
			DELETE FROM category 
			WHERE id = '.$get['deletecat']
		);
		return header('Location: /grupa2/brands.php');		
		
	} else {	
	
		$categories = MakeAssoc(mysql_query('
			SELECT * 
			FROM category
		'));
		
	}

	require_once "view/admin-header.php";

	if ($brand) { 
		require_once "view/subbrandlist.php"; 
	} elseif ($brands) { 
		require_once "view/brandlist.php"; 
	} else {
		require_once "view/catlist.php"; 
	}
	require_once "view/footer.php";

	?>