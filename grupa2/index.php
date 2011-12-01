<? 
	require_once "conf.php";

	foreach ($_GET as $gettitle => $getvalue) {
		$get[$gettitle] = trim(addslashes(htmlspecialchars(strip_tags($getvalue))));
	}

	$categories = MakeAssoc(mysql_query('
		SELECT * 
		FROM category
	'));
		
	if ($get['catid']) {
		$chart_brands = MakeAssoc(mysql_query('
			SELECT brand.text as text, brand.id as id, brand.value as value, category.text as cat
			FROM brand, category 
			WHERE brand.parent_id IS NULL 
			AND brand.category_id = category.id 
			AND category.id = '.$get['catid'].'
			ORDER BY brand.value DESC
			LIMIT 8 
		'));
		
		$other_brands = MakeAssoc(mysql_query('
			SELECT brand.text as text, brand.id as id, brand.value as value, category.text as cat
			FROM brand, category 
			WHERE brand.parent_id IS NULL 
			AND brand.category_id = category.id 
			AND category.id = '.$get['catid'].'
			ORDER BY brand.value DESC
			LIMIT 8, 1000
		'));
		
		$category = mysql_fetch_assoc(mysql_query('
			SELECT * 
			FROM category 
			WHERE id = '.$get['catid']
		));	
		$maxval = mysql_fetch_assoc(mysql_query('
			SELECT max(brand.value) as maxval
			FROM brand, category 
			WHERE brand.parent_id IS NULL 
			AND brand.category_id = category.id 
			AND category.id = '.$get['catid'].'
			ORDER BY brand.value DESC
			LIMIT 8 
		'));		
	} else {
		$chart_brands = MakeAssoc(mysql_query('
			SELECT *
			FROM brand 
			WHERE parent_id IS NULL 
			ORDER BY value DESC
			LIMIT 8
		'));	
		shuffle($chart_brands);
		
		$maxval = mysql_fetch_assoc(mysql_query('
			SELECT max(value) as maxval
			FROM brand 
			WHERE parent_id IS NULL 
			ORDER BY value DESC
			LIMIT 8
		'));	
		$category['text'] = 'Visas kategorijas';
	}

	require_once "view/header.php";
	require_once "view/charts.php";
	require_once "view/footer.php"; 
?>