	<div id="diagram_box"> 
		<div id="row">	
			<? foreach ($chart_brands as $brand) { ?>
			<div class="brand_value">
				<div id="brand<?=$brand['id'];?>">
					<p><?=$brand['value']?></p>
				</div>
				<div class="thumb"></div>
			</div>
			<? } ?>
		</div>
	</div>

	<div id="brand_names">
		<? foreach ($chart_brands as $brand) { ?>
		<div class="brand_name">
			<p><a href="/grupa2/brandinfo.php?id=<?=$brand['id'];?>"><?=$brand['text']?></a></p>
		</div>
		<? } ?>
	</div>

	<script> 
		function loop(rand, ele) {
			rand += 1;
			ele.html(rand);
			return rand;
		}
		
		function calculatenumber(brandid, timeout, brandvalue) {
			var ele = $("#brand" + brandid + " p");
			var rand = 0;
			while (rand != brandvalue) {
				setTimeout('s', 5);
				rand = loop(rand, ele);
			}
		}	
		
		$(document).ready(function(){
		<? foreach ($chart_brands as $brand) { ?>
			$("#brand<?=$brand['id'];?>").animate({height:'<?=round(($brand['value']*300/$maxval['maxval']), 0);?>px'}, <?=round(($brand['value']*300/$maxval['maxval']), 0)*10;?>);
			calculatenumber(<?=$brand['id'];?>, <?=round(($brand['value']*300/$maxval['maxval']), 0)*10;?>, <?=$brand['value']?>);
		<? } ?>		
		});

	</script>
	
	<? if (!$get['catid']) { ?>
	<h3>Zīmola vērtības rēķinašanas formula:</h3>
	<p>		
		$human_tweets['tweetcount'] = $human_tweets['tweetcount'] - $retweets['retweetcount'] - $replies['replycount'];
	</p>
	<p>
		$full_value = ($human_tweets['mood'] * 5) + ($human_tweets['tweetcount']) + ($bot_tweets['tweetcount'] * 0.2) + ($retweets['retweetcount'] * 0.6) + ($replies['replycount'] * 0.4);
	</p>
	<p>
		Kur $human_tweets['mood'] ir SUM() no attieksmes, visi citi mainīgie ir COUNT(). 
	</p>
	<p>
		Gatavi pieņemt priekšlikumus algoritma uzlabošanai un atsevišķo vērtību koeficientu mainīšanai.
	</p>
	
	<h3><a href="/grupa2/brands.php?brandid=32">Tvītu marķēšanas interfeiss</a></h3>

	<p>
	Tikai uz [X] nespiediet ;\,
	</p>
	
	<h3><a href="/grupa2/brandinfo.php?id=45">Zіmola informācijas importēšanas no facebook un twitter piemērs</a></h3>
	<br/>
	<? } ?>
	
	<? if ($get['catid'] && $other_brands) { ?>
	<h3>Citi zīmoli:</h3>
	<? foreach ($other_brands as $brand) { ?>
		<p><?=$brand['text']?> &mdash; <?=$brand['value'];?></p>
	<? } ?>
	<? } ?>