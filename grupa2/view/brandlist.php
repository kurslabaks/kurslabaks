		<h1><a href="/grupa2/brands.php">Category list</a> - <?=$category['text']?></h1>
		<? foreach ($brands as $brand) { ?>
			<p><a href='/grupa2/brands.php?brandid=<?=$brand['id']?>'><?=$brand['text']?></a> <!--<a href='/grupa2/brands.php?deletebrand=<?=$brand['id']?>'>[X]</a>--></p>
		<? } ?>
		<h2>New brand</h2>
		<form method="POST">
			<input type="text" name="brandname"/>
			<input type="hidden" name="category" value="<?=$category['id']?>"/>
			<input type="submit" value="add"/>
		</form>	
