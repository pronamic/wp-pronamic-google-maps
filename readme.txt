=== Pronamic Google Maps ===
Contributors: pronamic, remcotolsma 
Tags: pronamic, google maps, geo, geocode
Donate link: http://pronamic.eu/donate/?for=wp-plugin-pronamic-google-maps&source=wp-plugin-readme-txt
Requires at least: 3.0
Tested up to: 6.8
Stable tag: 2.4.1
License: GPLv2 or later

This plugin makes it easy to add Google Maps to your WordPress post, pages or other custom post types.

== Description ==



= Intro = 

With this plugin a user can easily add location (latitude, longitude) meta data to a page, post or a 
custom post type. This plugin adds a meta box with an Google Map to the post editor. Users can easily 
drag and drop a marker on the map to save location meta data for a post.

There are quite a few Google Maps plugins available in the WordPress Plugin Directory. Why should you 
use the Pronamic Google Maps plugin:

*	**Google Maps API version 3**
	Most of the available plugins still use the Google Maps version 2 API. To use the Google Maps v2 API you 
	have to require an API key and include this in the plugin configuration.  The Pronamic Google Maps plugin 
	uses the Google Maps version 3 API. Wich no longer requires an API key, so you don't have 
	to configure this plugin.

*	**Shortcode**
	Easily integrate a Google Maps in your post content:

		[googlemaps]
		[googlemaps static=true]
		[googlemaps static=true label=M]
		[googlemaps width=200 height=200]
		[googlemaps new_design=true]

	Also easily integrate an Google Maps mashup in your post content:

		[googlemapsmashup query="post_type=company&nopaging=true" map_type_id="satellite"]

*   **No extra tables**
	Some plugin create additional tables in your WordPress database to store additional data. In many
	cases this is not necessary, it's only pollutes your database. WordPress offers enough [functions to 
	store additional data](http://codex.wordpress.org/Custom_Fields).

*	**Custom Post Types**
	A lot of the WordPress plugins are developed before WordPress 3 was launched. These plugins not
	always use the new features of WordPress 3. Many plugins only focus on posts and pages, but not 
	on other custom post types. This plugin does!

*	**Mashup**
	Easily create an Google Maps mashup to show all your posts on Google Maps. You can use an very powerfull 
	pronamic_google_maps_mashup() function or the shortcode. Both methods allow you to pass [custom 
	WordPress query parameters](http://codex.wordpress.org/Function_Reference/WP_Query#Parameters).

*	**No notices or warning**
	Pronamic is one of the few companies that develop all WordPress plugins in debug mode. This results
	in high quality plugins with no errors, warnings or notices. 



= Custom Post Types = 

The nice thing about this plugin that developers can configure on what post type the meta box should be visible. 
Developers can activate the meta box for every custom post type they registered with the 
[register\_post\_type function](http://codex.wordpress.org/Function_Reference/register_post_type).

For example: if a developer registers a custom post type for *real estate* it is very easy to activate and 
manage location data for that post type. It comes in handy for all kind of custom post types!

*	Projects
*   Real estate
*   Restaurants
*   Accommodations
*   Hotels
*   Ships
*   Ports



= Microformats =

The plugin uses the latest [GEO microformat standards](http://microformats.org/wiki/geo).

	<div class="geo">
		<abbr class="latitude" title="37.408183">N 37° 24.491</abbr> 
		<abbr class="longitude" title="-122.13855">W 122° 08.313</abbr>
	</div>



= Support Development =

If you like this plugin we hope that you will help support our continued development. 
The two best ways to offer your support is to send us a donation. Even $1 helps encourage 
us to do more. If you can't donate, please help us reach our 5-star rating by rating this 
plugin.



= Donate =

[Donate today!](http://pronamic.eu/donate/?for=wp-plugin-pronamic-google-maps&source=wp-plugin-readme-txt)



= Rate Us =

Please [rate us](http://wordpress.org/extend/plugins/pronamic-google-maps/)!
Give us a chance to <a href="http://pronamic.eu/contact/">address your concerns</a> 
if we didn't earn 5 stars.



= Special Requests =

We do accept feature requests for all of our plugins, free ones included. The most requested features 
will make it into the next version.
    
<strong>If you need a special feature NOW, <a href="http://pronamic.eu/contact/">contact us</a>!</strong> 
We offer expedited feature development. Most features can be implemented in less than a week for $200!



== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your 
WordPress installation and then activate the Plugin from Plugins page.

You should add some code to you templates to add the Google Map.

**Dynamic Google Maps**

	<?php

	if ( function_exists( 'pronamic_google_maps' ) ) {
		pronamic_google_maps( array(
			'width'  => 290,
			'height' => 200 
		) );
	}

	?>


**Static Google Maps**

	<?php

	if ( function_exists( 'pronamic_google_maps' ) ) {
		pronamic_google_maps( array(
			'width'  => 290,
			'height' => 200,
			'static' => true,
			'color'  => '0xFFD800',
			'label'  => 'M'
		) );
	}

	?>


**Filter the_content()**

	<?php

	if ( function_exists( 'pronamic_google_maps' ) ) {
		function custom_pronamic_google_maps_the_content( $content ) {
			$content .= pronamic_google_maps( array(
				'width'  => 500,
				'height' => 500,
				'echo'   => false
			) );
		
			return $content;
		}
		
		add_filter( 'the_content', 'custom_pronamic_google_maps_the_content', 9 );
	}

	?>


**Google Maps Mashup**

	<?php

	if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
		pronamic_google_maps_mashup(
			array(
				'post_type' => 'post'
			), 
			array(
				'width'          => 300,
				'height'         => 200, 
				'nopaging'       => true,
				'map_type_id'    => 'satellite', 
				'marker_options' => array(
					'icon' => 'http://google-maps-icons.googlecode.com/files/photo.png'
				)
			)
		);
	}

	?>


**Microformat**

If you want to display the [GEO microformat](http://microformats.org/wiki/geo) with the 
latitude and longitude information you should call the following function in your template:

	<?php pronamic_google_maps_geo_microformat(); ?>
Or througt an filter

	<?php
	
	function custom_pronamic_google_maps_the_content( $content ) {
		$content .= pronamic_google_maps( array(
			'width'  => 500 , 
			'height' => 500 , 
			'echo'   => false
		) );
	
		$content .= pronamic_google_maps_geo_microformat( array(
			'echo' => false
		) );
	
		return $content;
	}

	add_filter( 'the_content', 'custom_pronamic_google_maps_the_content', 9 );


== Frequently Asked Questions ==

1.	Have a question? Make a thread in the support forum and we will get back to you.



== Screenshots ==

1.	The Google Maps widget.

2.	Meta box where you can easily manage the Google Maps / GEO data.

3.	Configuration panel of the Pronamic Google Maps plugin. Within this panel you can easily activate the Google Maps functionality for the registered post types.

4.	The geocoder can be used to geocode multiple posts at once.



== Changelog ==

= todo =
*	Add options for different dimension types pixels, percentages, etc.
*	$("#pronamic-google-maps-meta-box-hide").change(function() { google.maps.event.trigger(map, "resize"); });
*	$("#pronamic-google-maps-meta-box .handlediv").change(function() { google.maps.event.trigger(map, "resize"); });
*	http://wordpress.org/support/topic/plugin-pronamic-google-maps-need-routes-too?replies=1#post-2741427
*	http://wordpress.org/support/topic/plugin-pronamic-google-maps-is-it-possible-to-set-the-default-location-etc-for-post-edit-map?replies=4#post-2811858

= Unreleased - 2015-08-21 =

<!-- Start changelog -->

### [2.4.1] - 2025-07-09

#### Changed

- Use file hash as script version number. ([d8db811](https://github.com/pronamic/wp-pronamic-google-maps/commit/d8db8118e2792419374e8c8d88e335c797e5de0f))

Full set of changes: [`2.4.0...2.4.1`][2.4.1]

[2.4.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/v2.4.0...v2.4.1

### [2.4.0] - 2025-06-27

#### Changed

- Load Google Maps asynchronously.
- Updated admin menu page icon. ([5b9afe4](https://github.com/pronamic/wp-pronamic-google-maps/commit/5b9afe4c162f15c4c860d7821b454b3a7d03f1d9))
- Tested up to: 6.8. ([45e990a](https://github.com/pronamic/wp-pronamic-google-maps/commit/45e990aa13c80a8b108e66370addba3b5d11b6c6))

#### Fixed

- Fixed using deprecated event listeners. ([cf670fc](https://github.com/pronamic/wp-pronamic-google-maps/commit/cf670fc26373c7fb3b372ddd1fdeba297813bb4e))
- Fixed "jQuery.parseJSON is deprecated; use JSON.parse". ([633fb8d](https://github.com/pronamic/wp-pronamic-google-maps/commit/633fb8da316b4b18caa1bc8fb28a61e5c58b4013))

#### Removed

- Removed visual refresh setting. ([555b9db](https://github.com/pronamic/wp-pronamic-google-maps/commit/555b9db872888ed13ff78fac5cd3585452e76ac3))
- Removed unused style. ([69d1d32](https://github.com/pronamic/wp-pronamic-google-maps/commit/69d1d324c72587d4d9b02acc1a269c3da34145a4))
- Removed unused scripts. ([7f2e919](https://github.com/pronamic/wp-pronamic-google-maps/commit/7f2e919257c135719a56903d3a83c6bd70cee79a))
- Removed unused images. ([0503062](https://github.com/pronamic/wp-pronamic-google-maps/commit/05030627f9eec376af186095239371b3bf757c03))
- Removed WordPress < 3.3 compatibility. ([282d959](https://github.com/pronamic/wp-pronamic-google-maps/commit/282d959ae06230061c90dd8bc1d59c7fcda730c7))

Full set of changes: [`2.3.3...2.4.0`][2.4.0]

[2.4.0]: https://github.com/pronamic/wp-pronamic-google-maps/compare/v2.3.3...v2.4.0

### [2.3.3] - 2024-11-27

#### Commits

- Use `esc_textarea` instead of `esc_attr` in `<textarea>` element. ([c9361f5](https://github.com/pronamic/wp-pronamic-google-maps/commit/c9361f5dd2a8c76ab148bb9cbd074b5783c6f986))
- Use `esc_textarea` instead of `esc_attr` in `<textarea>` element. ([145ce66](https://github.com/pronamic/wp-pronamic-google-maps/commit/145ce661adc1522dc435b2db2e40eeb9ca216199))
- Coding standards. ([60a9b88](https://github.com/pronamic/wp-pronamic-google-maps/commit/60a9b884b0960c63a05b4a240c11a83b29585997))
- Tested up to: 6.7, closes #38. ([09a66a5](https://github.com/pronamic/wp-pronamic-google-maps/commit/09a66a580699b34474cbda7d2f70aa2d1637b94c))
- Added API key for GEO coordinates. ([90b18ce](https://github.com/pronamic/wp-pronamic-google-maps/commit/90b18ce0f604c925ddf2eda8eeaef88670527195))
- Added API key to static map URL. ([092d85b](https://github.com/pronamic/wp-pronamic-google-maps/commit/092d85b0a05887d072127388ebdf6f50e135b6a8))
- Removed sensor parameter (as recommended by Google in https://developers.google.com/maps/documentation/javascript/error-messages#sensor-not-required) ([7a5c480](https://github.com/pronamic/wp-pronamic-google-maps/commit/7a5c480b773548ce252a1dcd87abdb113477b3db))

Full set of changes: [`2.3.2...2.3.3`][2.3.3]

[2.3.3]: https://github.com/pronamic/wp-pronamic-google-maps/compare/v2.3.2...v2.3.3

### [2.3.2] - 2016-09-15
- Fixed issue with the geocoded.
- Added an delay of 10 seconds for Google Maps API Usage Limit.
- Fixed name of arguments variable for widget.
- Added example map with link to directions.
- Fixed JavaScript error "fromDivPixelToLatLng: Point.x and Point.y must be of type number".
- Fixed 'Deprecated: Methods with the same name as their class will not be constructors in a future version of PHP'.
- Use bower package `markerclustererplus` instead of `google-maps-marker-clusterer-plus` to fix incorrect MarkerClusterer.IMAGE_PATH.
- Fixed loading map while editing widget.
- Updated MarkerClustererPlus library to version 2.1.1.

### [2.3.1] - 2015-10-09
- Load the new text domain 'pronamic-google-maps'.

### [2.3.0] - 2015-10-09
- All serverside Google Maps API request now run via https://.
- Improved documentation in README.md file.
- Improved support for marker cluster options in shortcodes.
- WordPress Coding Standards optimizations.
- Removed deprecated screen_icon() function calls.
- Deprecated Pronamic_Google_Maps_Post::META_KEY_* constants.
- Deprecated Pronamic_Google_Maps_Filters::FILTER_* constants.
- Changed text domain from 'pronamic_google_maps' to 'pronamic-google-maps'.

### [2.2.9] - 2014-05-15
- WordPress Coding Standards optimizations and tested up to version 3.9.1.

### [2.2.8] - 2014-02-21
- Added a <noscript> tag around the fallback static map.

### [2.2.7] - 2013-11-15
- Fixed error on saving Pronamic Google Maps options.
- Improved support for percentage dimensions on singular maps.

### [2.2.6] - 2013-11-13
- Improved support for Shopp products post type.

### [2.2.5] - 2013-08-23
- Added support for new Google Maps Visual Refresh setting
- Improved post meta data saving, only save meta data if needed
- Mashup width and height can now be in percents (for responsive designs)

### [2.2.4] - 2013-02-13
- Changed the directory structure of the PHP classes files
- Added support for https:// (SSL)
- Added API client for backend geocode
- Fixed notice on saving an post (visible in debug mode)

### [2.2.3] - 2012-07-02
- Added WordPress query parameters 'pronamic_latitude' and 'pronamic_longitude'
- Register the default Google Maps script in addition to the Google API loader script

### [2.2.2] - 2012-06-22
- Allow other units (percent, em, etc.) for the width and height attributes in the Google Maps mashup

### [2.2.1] - 2012-06-11
- Added Portuguese Brazil translation by [Ruan Mer](http://ruanmer.com/)
- Apply html_entity_decode() to the query attribute in the mashup shortcode

### [2.2] - 2012-05-08
- Added support for some [google-maps-utility-library-v3 libraries](http://code.google.com/p/google-maps-utility-library-v3/wiki/Libraries)
- Added support for [MarkerClustererPlus](http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclustererplus/2.0.6/)
- Added support for [MarkerManager](http://google-maps-utility-library-v3.googlecode.com/svn/tags/markermanager/1.0/)
- Fixed bug with an fixed zoom level wich was not set in the pronamic_google_maps_mashup() function
- If you disbale the 'fit_bounds' option in the mashup the mashup will no longer center the client location
- Added extra option 'center_client_location' to center the mashup center to the client location, default false
- Added 'geo' shortcode wich will display the latitude and longitude in the microformat of the post in wich it is placed
- Apply the 'pronamic_google_maps_item_description' filter not in admin
- Added shortcode 'googlemapsmashup' for an Google Maps mashup
- Changed shortcode 'google-maps' to 'googlemaps'
- Deprecated the 'google-maps' shortcode, changed it to 'googlemaps', [hyphen use can cause collisions](http://codex.wordpress.org/Shortcode_API)
- Changed the text domain from 'pronamic-google-maps' to 'pronamic_google_maps'
- Replaced all references to class constant TEXT_DOMAIN to an string
- Improved the way we enqueue te frontend script becease the way wp_enqueue_script() works is changed since WordPress 3.3

### [2.1.6] - 2011-12-14
- Fixed notice undefined property in the Pronamic_Google_Maps class related to zoom and map type ID values

### [2.1.5] - 2011-11-23
- Added the map options argument to the mashup and did some improvements on the mashup functions
- Fixed a small bug with determing the zoom level, thanks to Sascha Paukner

### [2.1.4] - 2011-09-26
- Added Polish translation by [Marcin Modestowicz](http://modestowicz.com/)
- Improved the use of the 'pronamic_google_maps_item_description' filter

### [2.1.3] - 2011-09-16
- Fixed some notices caused by the new 'map_options' settings key
- Improved the Pronamic Google Maps widget

### [2.1.2] - 2011-09-15
- Added JavaScript to WordPress widget admin page for the Pronamic Google Maps widget
- Added the 'pronamic_google_maps_marker_options_$key' filter for dynamic icons on the Google Maps mashup
- Added the 'pronamic_google_maps_post_meta' filter for manipulating the Google Maps post meta
- Adjusted the Google Maps mashup JavaScripts, now each post can have it's own custom marker icon
- It's now possible to define all the Google Maps map options within the pronamic_google_maps() function

### [2.1.1] - 2011-08-29
- Added a short description to the meta box, thanks to [andrewhouse](http://wordpress.org/support/profile/andrewhouse)
- Removed some PHP 5.3+ namespace slashes that were causing warnings on lower versions of PHP (unexpected character in input: '\' (ASCII=92))

### [2.1] - 2011-08-04
- Mashup map is now also rendered if there are no posts found
- First parameter of the pronamic_google_maps_mashup() function now also be an WP_Query object
- Fixed issue with the Google Maps shortcode, in most cases it was not returning the output from the shortcode function
- Added an uninstall form so you can easily delete options and meta data

### [2.0] - 2011-07-18
- Fixed Notice: Undefined index: fit_founds
- Removed wp_register_script('google-maps', ...), we now only use the Google JavaScript load API
- Fix issue with the JavaScript variabel google.loader.ClientLocation wich can be null
- Added default zoom and map type values in the constants: Pronamic_Google_Maps::MAP_ZOOM_DEFAULT and Pronamic_Google_Maps::MAP_TYPE_DEFAULT
- If there is no meta information about the zoom level and the map type the default values will be set
- Replaced all the require once statements for the classes with an SPL autoload function
- Changed the default width and height values, now based on the output of the wp_embed_defaults() function
- Added shortcode [google-maps] functionality
- Added JavaScript event trigger "pronamic-google-maps-ready"
- Fixed the rendering of the mashup, if there are no posts found the empty ul element will not be added
- Added 'marker_options' as argument for the pronamic_google_maps() function
- Added the new Google Maps favicon to the WordPress admin menu

### [1.9] - 2011-06-20
- Replaced the normal Google Maps v3 JavaScripts with the Google JavaScript API loader scripts
- Thanks to the Google JavaScript API loader we can now use the "google.loader.ClientLocation" JavaScript variable
- Replaced some "jQuery" JavaScript variables to the shorter notation "$"
- Added all required map options (center, mapTypeId and zoom) to the creation of mashup maps
- Added 'fit_bounds' option for the pronamic_google_maps_mashup($query, $arguments) function
- Combined the JavaScript file widget.js into admin.js and did some improvements
- Browser check after changing some core JavaScripts:
  - Mozilla Firefox 3.6.17
  - Google Chrome 12.0.742.100
  - Opera 11.11
  - Safari 5.0.5
  - Internet Explorer 9.0.8112.16421
  - Internet Explorer 8.0.6001.19088
  - Intenret Explorer 7.0.5730.11

### [1.8] - 2011-06-16
- Changed jQuery selectors [property=value] to [property="value"], jQuery 1.5.0 no longer allows these selectors
- Added extra meta data field for address information
- Added address field
- Added geocode and reverse geocode buttons
- Removed search field and button
- Combined the latitude and longitude fields into one form table row
- Replaced the add_options_page() with an add_menu_page() call
- Combined the class Pronamic_Google_Maps_OptionPage into the Pronamic_Google_Maps_Admin class
- Replaced the HTML buttons in the options pages with the function submit_button()
- Added geocoder page to bulk geocode posts
- Changed the way the JavaScript are loaded, we use a solution from Scribu: "[How to load JavaScript like a WordPress Master](http://scribu.net/wordpress/optimal-script-loading.html)"

### [1.7.1] - 2011-05-25
- Added an wp_reset_postdata() call after the custom query in the mashup class in request of [ezlxq73](http://wordpress.org/support/topic/bug-in-pronamic_google_maps_mashup?replies=1#post-2128808)

### [1.7] - 2011-05-25
- Changed 'WP_query' to the 'WP_Query' class name
- Improved the way the frontend JavaScripts are enqueued, on singular pages only when Google Maps is active. If your Google Maps mashup is not working anymore you probably have to call wp_enqueue_script('pronamic-google-maps-site') in your mashup template. We adjusted this in request of [MrVictor](http://wordpress.org/support/topic/plugin-pronamic-google-maps-load-script-only-on-pages-post-types-with-maps?replies=2#post-2096660)

### [1.6.3] - 2011-04-07
- Made it possible to use HTML in the title and description field (uses [function wp_kses_post()](http://codex.wordpress.org/Data_Validation)), request of [Paul Craig](http://fusio.net/) and [bigchiefrandomchaos](http://wordpress.org/support/profile/bigchiefrandomchaos).

### [1.6.2] - 2011-04-04
- Changed the scope of some JavaScript functions in site.js and admin.js
- Changed some JavaScripts so the Google Maps object is binded to some DOM elements (http://api.jquery.com/data/)

### [1.6.1.2] - 2011-03-18
- Removed some unnecessary JavaScript, in response to problems in IE6 and 7.

### [1.6.1.1] - 2011-03-02
- Fixed the static map the image source attribute was empty since version 1.6.1.
- Fixed a bug in Internet Explorer 8, we now use the window [load event](http://api.jquery.com/load-event/) instead of the [ready event](http://api.jquery.com/ready//). If we use the read event the markers will not show up on the map (thanks to SweetManiac).

### [1.6.1] - 2011-02-28
- Added 'echo' argument in the pronamic_google_maps() and pronamic_google_maps_mashup() functions
- Fixed the 'pronamic_google_maps_geo_microformat()' function, if Google Maps is not active for the current post or post type don't render the microformat

### [1.6] - 2011-02-28
- Share a single info window on the mashup map (Demo: [Single Info Windows](http://gmaps-samples-v3.googlecode.com/svn/trunk/single-infowindow/single-infowindow.html))
- The marker options of the mashup map can now be configured.

### [1.5.1.1] - 2011-02-21
- Fixed a typo in the GEO micrformat render function.

### [1.5.1] - 2011-02-10
- Fixed bug in version 1.5, function get_the_ID() was not working in all cases, now back to global $post; and $post->ID;
- Updated the screenschots

### [1.5] - 2011-02-09
- Replaced all hidden HTML fields with one hidden field with JSON data
- Removed "Like this plugin?" from options page
- Removed "Donate $10, $20 or $50!" from options page
- Removed "Latest news from Pronamic" from options page
- Removed "Found a bug?" from options page
- Added a search field above the Google Map in the admin
- Added the pronamic_google_maps_is_active() function
- Added the pronamic_google_maps_title() function and the "pronamic_google_maps_item_title" filter
- Added the pronamic_google_maps_description() function and the "pronamic_google_maps_item_description" filter
- Added mashup function: pronamic_google_maps_mashup($query, $arguments)
- Added the 'pronamic_google_maps_mashup_item' filter
- Added 'nl_NL' translations

### [1.4.1] - 2010-12-15
- Fixed marker on frontend should not be draggable (thanks to [Pim Vellinga](http://twitter.com/brainscrewer))
- Added function pronamic_google_maps_location() for custom directions forms.

### [1.4] - 2010-10-28
- Fixed bug dynamic map fixed width and height (thanks to [Joost Baaij](http://www.spacebabies.nl/))
- Added Google Maps widget
- Add JavaScripts with the [wp_enqueue_script function](http://codex.wordpress.org/Function_Reference/wp_enqueue_script)
- [GEO microformat](http://microformats.org/wiki/geo) added. You should add the folowing CSS code to your stylesheet if you don't want to display the GEO microformat.

### [1.3] - 2010-10-07
- Fixed a bug dynamic maps didn't show up (thanks to ThomasBuxo)
- Made the latitude and longitude fields visibile again (request from ThomasBuxo)
- Added change and keyup events to latitude and longitude fields
- Mozilla Firefox 3.6.10 browser check
- Google Chrome 6.0.472.63 browser check
- Safari 5.0.2 browser check
- Opera 10.62 browser check
- Internet Explorer 8 browser check
- Internet Explorer 7 browser check

### [1.2] - 2010-10-06
- Fixed bug with fixed zoom value of 12 on static Google Maps
- Added translation options (Dutch language added)
- Changed the latitude and longitude fields from text to hidden

### [1.1] - 2010-10-06
- Added static and dynamic Google Maps support

### [1.0] - 2010-10-05
- Initial release

[unreleased]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.3.2...HEAD
[2.3.2]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.3.1...2.3.2
[2.3.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.3.0...2.3.1
[2.3.0]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2.9...2.3.0
[2.2.9]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2.8...2.2.9
[2.2.8]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2.7...2.2.8
[2.2.7]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2.6...2.2.7
[2.2.6]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2.5...2.2.6
[2.2.5]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2.4...2.2.5
[2.2.4]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2.3...2.2.4
[2.2.3]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2.2...2.2.3
[2.2.2]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2.1...2.2.2
[2.2.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.2...2.2.1
[2.2]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.1.6...2.2
[2.1.6]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.1.5...2.1.6
[2.1.5]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.1.4...2.1.5
[2.1.4]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.1.3...2.1.4
[2.1.3]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.1.2...2.1.3
[2.1.2]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.1.1...2.1.2
[2.1.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.1...2.1.1
[2.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/2.0...2.1
[2.0]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.9...2.0
[1.9]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.8...1.9
[1.8]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.7.1...1.8
[1.7.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.7...1.7.1
[1.7]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.6.3...1.7
[1.6.3]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.6.2...1.6.3
[1.6.2]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.6.1.2...1.6.2
[1.6.1.2]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.6.1.1...1.6.1.2
[1.6.1.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.6.1...1.6.1.1
[1.6.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.6...1.6.1
[1.6]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.5.1.1...1.6
[1.5.1.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.5.1...1.5.1.1
[1.5.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.5...1.5.1
[1.5]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.4.1...1.5
[1.4.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.4...1.4.1
[1.4]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.3...1.4
[1.3]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.2...1.3
[1.2]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.1...1.2
[1.1]: https://github.com/pronamic/wp-pronamic-google-maps/compare/1.0...1.1

<!-- End changelog -->

== Upgrade Notice ==

= 2.2.4 =
Thanks for using the Pronamic Google Maps plugin! As always, this update is very strongly recommended.



== Translations ==

*	pl_PL by [Marcin Modestowicz](http://modestowicz.com/)



== Pronamic ==
*	[Pronamic](http://pronamic.eu/)
*	[Twitter](http://twitter.com/pronamic)
*	[Facebook](http://www.facebook.com/Pronamic)
*	[LinkedIN](http://www.linkedin.com/company/pronamic)



== Links ==

*	[google-maps-utility-library-v3](http://code.google.com/p/google-maps-utility-library-v3/)
*	[Geocode with Google Maps API v3](http://tech.cibul.org/geocode-with-google-maps-api-v3/)
*	[WordPress event locations](http://icalevents.anmari.com/2343-event-locations-geo-tags-for-custom-post-types/)
*	[JavaScript Regular Expression](http://lawrence.ecorp.net/inet/samples/regexp-format.php)
*	[Remco Tolsma](http://remcotolsma.nl/)
*	[Markdown's Syntax Documentation][markdown syntax]

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"



== Plugin in the wild ==

*	[Metz Ameland](http://metz-ameland.nl/)
*	[Earthcircuit](http://www.earthcircuit.org/blog/)
*	[Comando Lechuga](http://www.comandolechuga.com/)
*	[Professionele Fotografie](http://pf.nl/)
*	[Bouwwereld](http://bouwwereld.nl/)
*	[Architectuur](http://architectuur.nl/)
*	[Longboard.no](http://longboard.no/)
*	[Professionele Fotografie](http://pf.nl/)
*	[Emonta](http://emonta.nl/)



== Pronamic plugins ==

*	[Pronamic Google Maps](http://wordpress.org/extend/plugins/pronamic-google-maps/)
*	[Gravity Forms (nl)](http://wordpress.org/extend/plugins/gravityforms-nl/)
*	[Pronamic Page Widget](http://wordpress.org/extend/plugins/pronamic-page-widget/)
*	[Pronamic Page Teasers](http://wordpress.org/extend/plugins/pronamic-page-teasers/)
*	[Maildit](http://wordpress.org/extend/plugins/maildit/)
*	[Pronamic Framework](http://wordpress.org/extend/plugins/pronamic-framework/)
*	[Pronamic iDEAL](http://wordpress.org/extend/plugins/pronamic-ideal/)
