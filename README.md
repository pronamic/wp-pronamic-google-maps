# [Pronamic Google Maps](http://www.happywp.com/plugins/pronamic-google-maps/)

This plugin makes it easy to add Google Maps to your WordPress post, pages or other custom post types.

## Shortcode - [googlemaps] [googlemapsmashup]

### Parameters

#### width

Type: `int|string`  
Default: *WordPress default embed width*

#### height

Type: `int|string`  
Default: *WordPress default embed height*

#### marker_options

Type: `array|json`  
Default: `array()`  

#### map_options

Type: `array|json`  
Default: `array()`  

#### new_design

Type: `boolean`  
Default: `false`  


## Shortcode - [googlemaps]

### Parameters

#### static

Type: `boolean`  
Default: `false`  

#### label

Type: `char`  
Default: `null`  

#### color

Type: `string`  
Default: `null`  


## Shortcode - [googlemapsmashup]

### Parameters

#### query

Type: `string`  
Default: `null`  

#### map_type_id

Type: `string`  
Default: `roadmap`  

Map style, can be: `roadmap`, `satellite`, `hybrid`, `terrain`.

#### latitude

Type: `float`  
Default: `0`  

Latitude value for the map center, only works if `fit_bounds` is set to `false`. 

#### longitude

Type: `float`  
Default: `0`  

Longitude value for the map center, only works if `fit_bounds` is set to `false`.

#### zoom

Type: `int`  
Default: `8`  

#### fit_bounds

Type: `boolean`  
Default: `true`  


## Function - `pronamic_google_maps()`

### Parameters

#### width

Type: `int|string`  
Default: *WordPress default embed width*

#### height

Type: `int|string`  
Default: *WordPress default embed height*

#### static

Type: `boolean`  
Default: `false`  

#### label

Type: `string`  
Default: `null`  

The `label` parameter is only available for Static Maps, for more information 
see the [Marker Styles](https://developers.google.com/maps/documentation/staticmaps/#MarkerStyles) section
of the [Static Maps](https://developers.google.com/maps/documentation/staticmaps/) documentation page.

#### color

Type: `string`  
Default: `null`  

#### echo

Type: `boolean`  
Default: `true`  

#### marker_options

Type: `array`  
Default: `array()`  

For all map options see the [MarkerOptions](https://developers.google.com/maps/documentation/javascript/reference#MarkerOptions)
section on the [Google Maps JavaScript API](https://developers.google.com/maps/documentation/javascript/reference) documentation page.

#### map_options

Type: `array`  
Default: `array()`  

For all map options see the [MapOptions](https://developers.google.com/maps/documentation/javascript/reference#MapOptions)
section on the [Google Maps JavaScript API](https://developers.google.com/maps/documentation/javascript/reference) documentation page.

