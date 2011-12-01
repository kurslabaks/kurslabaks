		<h1><a href="/grupa2/brands.php">Category list</a> - <a href='/grupa2/brands.php?catid=<?=$category['id']?>'><?=$category['text']?></a> - <?=$brand['text']?></h1>
		<?  foreach ($subbrands as $subbrand) { ?>
			<p><?=$subbrand['text']?> <a href='/grupa2/brands.php?deletebrand=<?=$subbrand['id']?>'>[X]</a></p>
		<? } ?>
		
		<h2>New subbrand</h2>
		<form method="POST">
			<input type="text" name="subbrandname"/>
			<input type="hidden" name="brand" value="<?=$brand['id']?>"/>
			<input type="submit" value="add"/>
		</form>
		
		<h1>Info</h1>
		<form method="POST" enctype="multipart/form-data">
			Info: <textarea rows="5" cols= "80" name="info"><?=$brand['info']?></textarea><br/>
			Facebook: <input type="text" size="60" name="facebook" value="<?=$brand['facebook']?>"/><br/>
			Twitter: <input type="text" size="60" name="twitter" value="<?=$brand['twitter']?>"/><br/>
			<input type="hidden" name="brand" value="<?=$brand['id']?>"/>
			<input type="submit" value="edit"/>
		</form>
		
		<h1>Tweets</h1>
		<form method="POST">
			<p>IF NOT IsGood THEN NOT CHECK IsHuman && IsPositive. IF NOT IsHuman THEN NOT CHECK IsPositive.</p>
			<p>Brand value is recalculated every time the form is sent.</p>
			<input type="hidden" name="brand" value="<?=$brand['id']?>"/>
			<table rules="rows">
				<tr>
					<th>User</th>
					<th>Text</th>
					<th width="80">IsValid</th>
					<th width="90">IsHuman</th>
					<th width="100">IsPositive</th>
				</tr>
				<?  $retweets = array();
					foreach ($tweets as $tweet) { 
						if (strpos($tweet['text'], 'RT @') !== false) {
							array_push($retweets, $tweet);
							continue;
						}
				?>
				<tr>	
					<td><?=$tweet['user']?></td>
					<td><?=$tweet['text']?></td>
					<td height="50">
					<? if (!isset($tweet['valid'])) { ?>
						<input type="radio" value="1" name="v_<?=$tweet['id']?>"/>Good<br/>
						<input type="radio" value="0" name="v_<?=$tweet['id']?>"/>Bad
					<? } else { ?>
						<?=$tweet['valid'];?>
					<? } ?>
					</td>
					<td height="50">
					<? if (!isset($tweet['human'])) { ?>
						<input type="radio" value="1" name="h_<?=$tweet['id']?>"/>Human<br/>
						<input type="radio" value="0" name="h_<?=$tweet['id']?>"/>Bot
					<? } else { ?>
						<?=$tweet['human'];?>
					<? } ?>
					</td>
					<td height="50">
					<? if (!isset($tweet['mood'])) { ?>
						<input type="radio" value="1" name="m_<?=$tweet['id']?>"/>Positive<br/>
						<input type="radio" value="0" name="m_<?=$tweet['id']?>"/>Neutral<br/>
						<input type="radio" value="-1" name="m_<?=$tweet['id']?>"/>Negative
					<? } else { ?>
						<?=$tweet['mood'];?>
					<? } ?>
					</td>
				</tr>
				<? } ?>
			</table>
			<input type="submit" value="send" name="mark" style="margin-left:400px; width:200px;"/>
			
		<h1>Retweets {dunno what to do with them, don't mark them}</h1>
		<form method="POST">
			<p>IF NOT IsGood THEN NOT CHECK IsHuman && IsPositive. IF NOT IsHuman THEN NOT CHECK IsPositive.</p>
			<p>Brand value is recalculated every time the form is sent.</p>
			<input type="hidden" name="brand" value="<?=$brand['id']?>"/>
			<input type="hidden" name="retweet" value="1"/>
			<table rules="rows">
				<tr>
					<th>User</th>
					<th>Text</th>
					<th width="80">IsValid</th>
					<th width="90">IsHuman</th>
					<th width="100">IsPositive</th>
				</tr>
				<?  foreach ($retweets as $tweet) { ?>
				<tr>	
					<td><?=$tweet['user']?></td>
					<td><?=$tweet['text']?></td>
					<td height="50">
					<? if (!isset($tweet['valid'])) { ?>
						<input type="radio" value="1" name="v_<?=$tweet['id']?>"/>Good<br/>
						<input type="radio" value="0" name="v_<?=$tweet['id']?>"/>Bad
					<? } else { ?>
						<?=$tweet['valid'];?>
					<? } ?>
					</td>
					<td height="50">
					<? if (!isset($tweet['human'])) { ?>
						<input type="radio" value="1" name="h_<?=$tweet['id']?>"/>Human<br/>
						<input type="radio" value="0" name="h_<?=$tweet['id']?>"/>Bot
					<? } else { ?>
						<?=$tweet['human'];?>
					<? } ?>
					</td>
					<td height="50">
					<? if (!isset($tweet['mood'])) { ?>
						<input type="radio" value="1" name="m_<?=$tweet['id']?>"/>Positive<br/>
						<input type="radio" value="0" name="m_<?=$tweet['id']?>"/>Neutral<br/>
						<input type="radio" value="-1" name="m_<?=$tweet['id']?>"/>Negative
					<? } else { ?>
						<?=$tweet['mood'];?>
					<? } ?>
					</td>
				</tr>
				<? } ?>
			</table>
			<input type="submit" value="send" name="mark" style="margin-left:400px; width:200px;"/>
		</form>