	<div id="brand_name">
		<h1>
		<? if ($brand['img']) { ?><img src="/grupa2/images/<?=$brand['img'];?>" /><? } ?>
		<?=$brand['text'];?> - <?=$brand['value'];?>
		</h1>
	</div>
	
	<div id="brand_info">
		<p><?=$brand['info'];?></p>
		<p>Facebook: <a href="http://www.facebook.com/<?=$brand['facebook'];?>"><img src="http://static.ak.fbcdn.net/rsrc.php/yi/r/q9U99v3_saj.ico" /><?=$brand['facebook'];?></a></p>
		<p>Twitter: <a href="http://www.twitter.com/<?=$brand['twitter'];?>"><img src="http://twitter.com/phoenix/favicon.ico" /><?=$brand['twitter'];?></a></p>
	</div> 
	
	<div id="imported">
		<p>
		<? if ($brand['facebook']) { 
			echo "<h3>Taken from Facebook</h3>";
			$facebook_info = file_get_contents("https://graph.facebook.com/" . urlencode($brand['facebook']));
			$facebook_info = json_decode($facebook_info);
			if ($facebook_info->website)
				echo "<p><a href='" . $facebook_info->website . "'>" . $facebook_info->website . "</a></p>";
				
			if ($facebook_info->picture)
				echo "<p><img src='" . $facebook_info->picture . "' /></p>";
	
			if ($facebook_info->likes)
				echo "<p>Likes: " . $facebook_info->likes ."</p>";
				
			if ($facebook_info->company_overview)
				echo "<p>Info: " . $facebook_info->company_overview . "</p>";
		} ?>
		</p>
		<p>
		<? if ($brand['twitter']) { 
			echo "<h3>Taken from Twitter</h3>";
			$twitter_info = file_get_contents("https://api.twitter.com/1/users/show.json?screen_name=" . urlencode($brand['twitter']) . "&include_entities=true");	
			$twitter_info = json_decode($twitter_info);

			if ($twitter_info->followers_count)
				echo "<p>Followers: " .$twitter_info->followers_count . "</p>";
				
			if ($twitter_info->friends_count)
				echo "<p>Friends: " .$twitter_info->friends_count . "</p>";
	
			if ($twitter_info->statuses_count)
				echo "<p>Tweets: $twitter_info->statuses_count</p>";
				
			if (!$facebook_info->website && $twitter_info->url)
				echo "<p><a href='" . $twitter_info->url . "'>" . $twitter_info->url . "</a></p>";	

			if (!$facebook_info->picture && $twitter_info->profile_image_url)
				echo "<p><img src='" . $twitter_info->profile_image_url . "' /></p>";				
				
			echo "<h4>5 Last Tweets</h4>";
			$tweets = file_get_contents("https://api.twitter.com/1/statuses/user_timeline.json?include_entities=false&include_rts=false&screen_name=" . urlencode($brand['twitter']) . "&count=5");	
			$tweets = json_decode($tweets);
			
			foreach($tweets as $tweet) {
				echo "<p>" . $tweet->created_at . "</p>";
				echo "<p>" . $tweet->text . "</p>";
			}
		} ?>		
		</p>

	</div>

	
