<?    
	$link = mysql_connect("localhost", "grupa2", "Pie9afey")
        or die("Could not connect: " . mysql_error());

	mysql_select_db("grupa2");

	mysql_query("
		SET character_set_results = 'utf8', 
		character_set_client = 'utf8', 
		character_set_connection = 'utf8', 
		character_set_database = 'utf8', 
		character_set_server = 'utf8'
	");
	
	require_once "model/main.php";
?>