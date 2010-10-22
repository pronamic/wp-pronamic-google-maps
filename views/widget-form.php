<?php 

$title = strip_tags($instance['title']);
$description = format_to_edit($instance['description']);
$latitude = strip_tags($instance['latitude']);
$longitude = strip_tags($instance['longitude']);

?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
		<?php _e('Title', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
	</label>

	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('description'); ?>">
		<?php _e('Description', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
	</label>

	<textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo $description; ?>" rows="3" cols="20"></textarea>
</p>

<p>
	<label for="<?php echo $this->get_field_id('latitude'); ?>">
		<?php _e('Latitude', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
	</label>

	<input class="widefat" id="<?php echo $this->get_field_id('latitude'); ?>" name="<?php echo $this->get_field_name('latitude'); ?>" type="text" value="<?php echo $latitude; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('longitude'); ?>">
		<?php _e('Longitude', Pronamic_Google_Maps::TEXT_DOMAIN); ?>:
	</label>

	<input class="widefat" id="<?php echo $this->get_field_id('longitude'); ?>" name="<?php echo $this->get_field_name('longitude'); ?>" type="text" value="<?php echo $longitude; ?>" />
</p>