<div id="pronamic-feed" class="postbox">
	<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div>

	<h3 class="hndle">
		<span><?php _e('Latest news from Pronamic', Pronamic_Google_Maps::TEXT_DOMAIN); ?></span>
	</h3>

	<div class="inside">

		<?php 
		
		include_once(ABSPATH . WPINC . '/feed.php');

		$rss = fetch_feed(Pronamic::FEED_URL);
		$rssItems = $rss->get_items(0, $rss->get_item_quantity(5));

		if($rssItems): ?>

		<ul>
			<?php foreach($rssItems as $item): ?>

			<li class="pronamic">
				<a class="rsswidget" href="<?php echo esc_url($item->get_permalink(), $protocolls = null, 'display'); ?>">
					<?php echo htmlentities($item->get_title()); ?>
				</a>
			</li>

			<?php endforeach; ?>
		</ul>

		<?php else: ?>
		
		<p>
			<?php _e('no news items, feed might be broken...', Pronamic_Google_Maps::TEXT_DOMAIN); ?>
		</p>

		<?php endif; ?>

		<p>
			<a href="http://feeds.feedburner.com/pronamic"><?php _e('Subscribe with RSS', Pronamic_Google_Maps::TEXT_DOMAIN); ?></a>

			<a href="http://pronamic.nl/"><?php _e('Subscribe by e-mail', Pronamic_Google_Maps::TEXT_DOMAIN); ?></a>
		</p>
	</div>
</div>