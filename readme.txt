=== Pronamic Google Maps ===
Contributors: pronamic, remcotolsma 
Tags: google maps, geo, v3, api, custom types, latitude, longitude
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 1.2

This plugin makes it easy to add Google Maps to your WordPress post, pages or other custom post types.

== Description ==

**So what does this Google Maps plugin do?**

With this plugin a user can easily add location (latitude, longitude) meta data to a page, post or a custom post type. This plugin adds a meta box with an Google Map to the post editor. Users can easily drag and drop a marker on the map to save location meta data for a post.

The nice thing about this plugin that developers can configure on what post type the meta box should be visible. Developers can activate the meta box for every custom post type they registered with the [register\_post\_type function][1].

For example: if a developer registers a custom post type for *real estate* it is very easy to activate and manage location data for that post type. It comes in handy for all kind of custom post types!

*   Real estate
*   Ships
*   Ports
*   Restaurants
*   Accommodations
*   Hotels

 [1]: http://codex.wordpress.org/Function_Reference/register_post_type

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

You should add some code to you templates to add the Google Map.

**Dynamic Google Maps**

	pronamic_google_maps(array(
		'width' => 290 ,
		'height' => 200 
	));

**Static Google Maps**
	
	pronamic_google_maps(array(
		'width' => 290 ,
		'height' => 200 ,
		'static' => true ,
		'color' => '0xFFD800' ,
		'label' => 'M'
	));

== Screenshots ==

1. The configuration panel of the Pronamic Google Maps plugin. Within this panel you can easily activate the Google Maps functionality for the registered post types.

2. The metabox where you can easily manage the GEO meta data.

==Readme Generator== 

This Readme file was generated using <a href = 'http://sudarmuthu.com/wordpress/wp-readme'>wp-readme</a>, which generates readme files for WordPress Plugins.

== Changelog ==

= 1.2 =
* Fixed bug with fixed zoom value of 12 on static Google Maps
* Added translation options (Dutch language added)
* Changed the latitude and longitude fields from text to hidden
 
= 1.1 =
* Added static and dynamic Google Maps support 

= 1.0 =
* Initial release