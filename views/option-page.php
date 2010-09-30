<?php

$options = Pronamic_Google_Maps::getOptions();

$title = __('Configuration', Pronamic_Google_Maps::TEXT_DOMAIN) . ' - ' . self::PAGE_TITLE;

$types = get_post_types(array(
	'public' => true
) , 'objects');

$activeTypes = $options['active'];

?>
<div class="wrap">
	<?php screen_icon(); ?>

	<h2><?php echo esc_html($title); ?></h2>

	<div class="postbox-container" style="width: 65%;">
		<div class="metabox-holder">
			<div class="meta-box-sortables">
				<form action="" method="post">
					<?php wp_nonce_field('pronamic_google_maps_update_options', Pronamic_Google_Maps::NONCE_NAME); ?>

					<div class="postbox " id="postexcerpt">
						<div class="handlediv" title="Click to toggle"><br /></div>

						<h3 class="hndle">
							<span>Post Types</span>
						</h3>

						<div class="inside">

							<table class="form-table">

								<?php foreach($types as $name => $type): ?>

								<tr>
									<?php $active = isset($activeTypes[$name]) && $activeTypes[$name]; ?>

									<th scope="row">
										<label for="pronamic-google-maps-type-<?php echo $name; ?>"><?php echo $type->labels->name; ?></label>
									</th>
									<td>
										<input id="pronamic-google-maps-type-<?php echo $name; ?>" name="_pronamic_google_maps_active[]" value="<?php echo $name; ?>" type="checkbox" <?php if($active): ?>checked="checked"<?php endif; ?> />

										<label for="pronamic-google-maps-type-<?php echo $name; ?>">
											<?php _e('Activate Google Maps functionality'); ?>
										</label>
									</td>
								</tr>

								<?php endforeach; ?>

							</table>

							<input type="hidden" name="action" value="update" />

							<p class="submit">
								<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', Pronamic_Google_Maps::TEXT_DOMAIN) ?>" />
							</p>

					</div>
				</div>

			</form>
		</div>
	</div>
</div>

<div class="postbox-container side" style="width: 20%;">
	<div class="metabox-holder">
		<div class="meta-box-sortables">

			<div id="pronamic-google-maps-wordpress-like" class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>

				<h3 class="hndle">
					<span>Like this plugin?</span>
				</h3>

				<div class="inside">
					<p>Why not do any or all of the following:</p>

					<ul>
						<li>
							<a href="http://pronamic.nl/wordpress/google-maps/">
								Link to it so other folks can find out about it.</a>
							</li>
						<li>
							<a href="http://wordpress.org/extend/plugins/pronamic-google-maps/">
								Give it a good rating on WordPress.org.
							</a>
						</li>
						<li>
							<a href="http://wordpress.org/extend/plugins/pronamic-google-maps/">
								Let other people know that it works with your WordPress setup.
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div id="donate" class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>

				<h3 class="hndle">
					<span><strong class="red">Donate $10, $20 or $50!</strong></span>
				</h3>

				<div class="inside">
					<p>
						This plugin has cost us countless hours of work, if you use it, please donate a token of your appreciation!
					</p>

					<form style="margin-left:50px;" action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_s-xclick" />
						<input type="hidden" name="hosted_button_id" value="" />

						<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" />

						<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
					</form>
				</div>
			</div>

			<div id="google-analytics-for-wordpresssupport" class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>

				<h3 class="hndle"><span>Found a bug?</span></h3>

				<div class="inside">
					<p>
						If you've found a bug in this plugin, please submit it in the 
						<a href="http://pronamic.nl/contact/">Pronamic Bug Tracker</a> 
						with a clear description.
					</p>
				</div>
			</div>

			<div id="yoastlatest" class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>

				<h3 class="hndle"><span>Latest news from Pronamic</span></h3>

				<div class="inside">

					<?php 
					
					include_once(ABSPATH . WPINC . '/feed.php');

					$rss = fetch_feed('http://feeds.feedburner.com/pronamic');
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
						no news items, feed might be broken...
					</p>

					<?php endif; ?>

					<p>
						<a href="http://feeds.feedburner.com/pronamic">Subscribe with RSS</a>

						<a href="http://pronamic.nl/">Subscribe by e-mail</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>