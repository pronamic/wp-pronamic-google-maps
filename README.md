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
