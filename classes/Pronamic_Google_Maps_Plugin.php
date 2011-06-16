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
}
