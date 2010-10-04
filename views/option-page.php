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

	<form action="" method="post">
		<?php wp_nonce_field('pronamic_google_maps_update_options', Pronamic_Google_Maps::NONCE_NAME); ?>

		<div id="poststuff" class="metabox-holder has-right-sidebar">

			<div class="postbox-container" style="width: 64%; margin-right: 1%;">
				<div class="metabox-holder"><div class="meta-box-sortables"> 
					<?php include 'option-page-post-types.php'; ?>
				</div></div>
			</div>

			<div class="postbox-container side" style="width:20%;">
				<div class="metabox-holder"><div class="meta-box-sortables">
					<?php include 'option-page-like.php'; ?>
	
					<?php include 'option-page-donate.php'; ?>
	
					<?php include 'option-page-support.php'; ?>
	
					<?php include 'option-page-feed.php'; ?>
				</div></div>
			</div>

		</div>
	</form>
</div>