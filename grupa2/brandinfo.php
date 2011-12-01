<? 
	require_once "conf.php";

	foreach ($_GET as $gettitle => $getvalue) {
		$get[$gettitle] = trim(addslashes(htmlspecialchars(strip_tags($getvalue))));
	}

	$categories = MakeAssoc(mysql_query('
		SELECT * 
		FROM category
	'));
		
	if ($get['id']) {
		$brand = mysql_fetch_assoc(mysql_query('
			SELECT * 
			FROM brand 
			WHERE id = '.$get['id']
		));	
			
		if ($brand['parent_id'])
			header ('Location: /');
			
		$title = $brand['text'];
		
		require_once "view/header.php";
		require_once "view/brandinfo.php";
		require_once "view/footer.php"; 
	} else 
		header ('Location: /');

?>