<?php
/*
Plugin Name: Pronamic Google Maps
Plugin URI: http://pronamic.eu/wordpress/google-maps/
Description: This plugin makes it simple to add Google Maps to your WordPress post, pages or other custom post types.
Version: 1.5.1
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

require_once 'classes/Pronamic_Google_Maps.php';
require_once 'classes/Pronamic_Google_Maps_Plugin.php';
require_once 'classes/Pronamic_Google_Maps_MapTypeId.php';
require_once 'classes/Pronamic_Google_Maps_Post.php';
require_once 'classes/Pronamic_Google_Maps_Filters.php';
require_once 'classes/Pronamic_Google_Maps_LatLng.php';
require_once 'classes/Pronamic_Google_Maps_Info.php';
require_once 'classes/Pronamic_Google_Maps_Site.php';
require_once 'classes/Pronamic_Google_Maps_Admin.php';
require_once 'classes/Pronamic_Google_Maps_OptionPage.php';
require_once 'classes/Pronamic_Google_Maps_MetaBox.php';
require_once 'classes/Pronamic_Google_Maps_Widget.php';
require_once 'classes/Pronamic_Google_Maps_Mashup.php';
require_once 'classes/Pronamic_Google_Maps_GeoMicroformat.php';

require_once 'functions.php';

Pronamic_Google_Maps::bootstrap(__FILE__);
