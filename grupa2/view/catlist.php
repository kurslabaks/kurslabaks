		<h1>Category list</h1>

		<? foreach ($categories as $cat) {?>
		<p>
			<a href="/grupa2/brands.php?catid=<?=$cat['id']?>"><?=$cat['text']?></a>
			<!--<a href="/grupa2/brands.php?deletecat=<?=$cat['id']?>">[X]</a>-->
		</p>
		<? } ?>

		<h2>New category</h2>		
		<form method="POST">
			<input type="text" name="categoryname"/>
			<input type="submit" value="add"/>
		</form>	