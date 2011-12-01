<!DOCTYPE html>
<html>
<head>
	<title><? if ($title) echo $title.' | '; ?>Kurš labāks?</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<link rel="stylesheet" href="/grupa2/css/main.css" />
	<link rel="stylesheet" href="/grupa2/css/MyFontsWebfontsOrderM3311950.css" />
	<script src="/grupa2/js/jquery-1.5.1.js"></script>
	<script src="/grupa2/js/animation.js"></script>
</head>
<body>
	<div class="content">
	
		<div id="header">
		<ul>	
			<li>
				<?if (!$get) { ?>Visas kategorijas<? } else { ?><a href="/grupa2/index.php">Visas kategorijas</a><? } ?>
			</li>
			<? foreach ($categories as $cat) {?>
			<li>
				<?if ($get['catid'] != $cat['id']) { ?><a href="/grupa2/index.php?catid=<?=$cat['id']?>"><?=$cat['text']?></a><? } else  echo $cat['text']; ?>
			</li>
			<? } ?>							
		</ul>
		</div>
		<? if ($category['text']) {?>
		<div id="category_name">
			<h1><?=$category['text'];?></h1>
		</div>
		<? } ?>
