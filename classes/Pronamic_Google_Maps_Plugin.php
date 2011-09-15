<?php

/**
 * Title: Pronamic Google Maps plugin
 * Description: 
 * Copyright: Copyright (c) 2005 - 2011
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0
 */
class Pronamic_Google_Maps_Plugin {
	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		$plugin = plugin_basename(Pronamic_Google_Maps::$file);

		add_filter('plugin_action_links_' . $plugin, array(__CLASS__, 'actionLinks'));
		
		register_uninstall_hook(Pronamic_Google_Maps::$file, 'uninstall');
	}

	//////////////////////////////////////////////////

	/**
	 * Render the option page
	 */
	public static function actionLinks($links) {
		$url = admin_url('options-general.php?page=' . Pronamic_Google_Maps::SLUG);

		$link = '<a href="' . $url . '">' . __('Settings') . '</a>';

		array_unshift($links, $link);

		return $links;
	}

	//////////////////////////////////////////////////

	/**
	 * Uninstall
	 */
	public static function uninstall() {
		global $wpdb;

		// Delete meta
		$metaKeys = "'" . implode("', '", array(
			Pronamic_Google_Maps_Post::META_KEY_ACTIVE ,
			Pronamic_Google_Maps_Post::META_KEY_ADDRESS , 
			Pronamic_Google_Maps_Post::META_KEY_DESCRIPTION , 
			Pronamic_Google_Maps_Post::META_KEY_GEOCODE_STATUS ,
			Pronamic_Google_Maps_Post::META_KEY_LATITUDE , 
			Pronamic_Google_Maps_Post::META_KEY_LONGITUDE , 
			Pronamic_Google_Maps_Post::META_KEY_MAP_TYPE , 
			Pronamic_Google_Maps_Post::META_KEY_TITLE , 
			Pronamic_Google_Maps_Post::META_KEY_ZOOM 
		)) . "'";

		$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key IN ($metaKeys)");

		// Delete options
		delete_option(Pronamic_Google_Maps::OPTION_NAME);
	}
}
