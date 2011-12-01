<? 
	function MakeAssoc($array) {
		$result = array();
		$i=0;
		while ($row = mysql_fetch_assoc($array)) {
			$result[$i++] = $row;
		}
		return $result;
	}
	
	function Recalculate ($brandid) {
	
		$human_tweets = mysql_fetch_assoc(mysql_query('
			SELECT COUNT(tweet.id) as tweetcount, SUM(tweet.mood) as mood
			FROM tweet, tweet_brand, brand
			WHERE tweet.tweet_id = tweet_brand.tweet_id
			AND tweet_brand.brand_id = brand.id
			AND ( brand.id = '.$brandid.' OR brand.parent_id = '.$brandid.' )
			AND tweet.human = 1
			AND tweet.valid = 1
		'));

		$bot_tweets = mysql_fetch_assoc(mysql_query('
			SELECT COUNT(tweet.id) as tweetcount
			FROM tweet, tweet_brand, brand
			WHERE tweet.tweet_id = tweet_brand.tweet_id
			AND tweet_brand.brand_id = brand.id
			AND (brand.id = '.$brandid.' OR brand.parent_id = '.$brandid.')
			AND tweet.human = 0
			AND tweet.valid = 1
		'));		
		
		$retweets = mysql_fetch_assoc(mysql_query('
			SELECT COUNT(tweet.id) as retweetcount
			FROM tweet, tweet_brand, brand
			WHERE tweet.tweet_id = tweet_brand.tweet_id
			AND tweet_brand.brand_id = brand.id
			AND ( brand.id = '.$brandid.' OR brand.parent_id = '.$brandid.' )
			AND tweet.human = 1
			AND tweet.valid = 1
			AND INSTR(tweet.text, "RT @") <> 0
		'));
		
		$replies = mysql_fetch_assoc(mysql_query('
			SELECT COUNT(tweet.id) as replycount
			FROM tweet, tweet_brand, brand
			WHERE tweet.tweet_id = tweet_brand.tweet_id
			AND tweet_brand.brand_id = brand.id
			AND ( brand.id = '.$brandid.' OR brand.parent_id = '.$brandid.' )
			AND tweet.human = 1
			AND tweet.valid = 1
			AND INSTR(tweet.text, "@") <> 0
		'));
				
		$human_tweets['tweetcount'] = $human_tweets['tweetcount'] - $retweets['retweetcount'] - $replies['replycount'];
		$full_value = ($human_tweets['mood'] * 5) + ($human_tweets['tweetcount']) + ($bot_tweets['tweetcount'] * 0.2) + ($retweets['retweetcount'] * 0.6) + ($replies['replycount'] * 0.4);
		mysql_query('
			UPDATE brand
			SET value = '.$full_value.'
			WHERE brand.id = '.$brandid.'
		');
		
		/*
		Weekly stats will be here
		*/
	}
?>
