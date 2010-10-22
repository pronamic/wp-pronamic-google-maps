=== Pronamic Google Maps ===
Contributors: pronamic, remcotolsma 
Tags: pronamic, google maps, placemarker, geo, v3, api, custom types, latitude, longitude, location
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 1.3

This plugin makes it easy to add Google Maps to your WordPress post, pages or other custom post types.

== Description ==

**So what does this Google Maps plugin do?**

= Intro = 

With this plugin a user can easily add location (latitude, longitude) meta data to a page, post or a 
custom post type. This plugin adds a meta box with an Google Map to the post editor. Users can easily 
drag and drop a marker on the map to save location meta data for a post.

There are quite a few Google Maps plugins available in the WordPress Plugin Directory. Most of
the available plugins have a few drawbacks:

*	**Google Maps API version 3**
	Most of the available plugin still use the Google Maps version 2 API. The use the Google Maps v2 API you 
	have to require an API key and include this in the plugin configuration.  The Pronamic Google Maps plugin 
	uses the Google Maps version 3 API. Wich no longer requires an API key, so you don't have 
	to configure this plugin.

*	**No confusing shortcodes**
	This plugin does *not* work with the [WordPress shortcode API][1]. Although it's an very powerful 
	technique, it's not always very user friendly. Not all users understand the shortcodes like;

		[google-map-sc external_links="true" zoom="3"]

*   **No extra tables**
	Some plugin create additional tables in your WordPress database to store additional data. In many
	cases this is not necessary, it's only pollutes your database. WordPress offers enough [functions to 
	store additional data][2].

*	**Custom Post Types**
	A lot of the WordPress plugins are developed before WordPress 3 was launched. These plugins not
	always use the new features of WordPress 3. Many plugins only focus on posts and pages, but not 
	on other custom post types. This plugin does!

= Custom Post Types = 

The nice thing about this plugin that developers can configure on what post type the meta box should be visible. 
Developers can activate the meta box for every custom post type they registered with the [register\_post\_type function][3].

For example: if a developer registers a custom post type for *real estate* it is very easy to activate and 
manage location data for that post type. It comes in handy for all kind of custom post types!

*   Real estate
*   Ships
*   Ports
*   Restaurants
*   Accommodations
*   Hotels

= How to use? =

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

 [1]: http://codex.wordpress.org/Shortcode_API
 [2]: http://codex.wordpress.org/Custom_Fields
 [3]: http://codex.wordpress.org/Function_Reference/register_post_type

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

== Changelog ==

= 1.3.1 =
*	Fixed bug dynamic map fixed width and height (thanks to [Joost Baaij](http://www.spacebabies.nl/)) 

= 1.3 =
*	Fixed a bug dynamic maps didn't show up (thanks to ThomasBuxo)
*	Made the latitude and longitude fields visibile again (request from ThomasBuxo)
*	Added change and keyup events to latitude and longitude fields
*	Mozilla Firefox 3.6.10 browser check
*	Google Chrome 6.0.472.63 browser check
*	Safari 5.0.2 browser check
*	Opera 10.62 browser check
*	Internet Explorer 8 browser check
*	Internet Explorer 7 browser check

= 1.2 =
*	Fixed bug with fixed zoom value of 12 on static Google Maps
*	Added translation options (Dutch language added)
*	Changed the latitude and longitude fields from text to hidden
 
= 1.1 =
*	Added static and dynamic Google Maps support 

= 1.0 =
*	Initial release

== Links ==

*	[Pronamic](http://pronamic.nl/ "Pronamic")
*	[Remco Tolsma](http://remcotolsma.nl/)
*	[Markdown's Syntax Documentation][markdown syntax]

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"