## Shortcode `googlemapsmashup`

### Attributes

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

#### marker_clusterer_options

Type: `string|array`  
Default: `array`  

For all cluster marker options see the [MarkerClustererOptions](http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html)
section on the [MarkerClustererPlus](http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html) documentation page.

Example: `maxZoom=15&gridSize=30`  

#### overlapping_marker_spiderfier_options

Type: `string|array`  
Default: `array`  

For all overlapping marker spiderfier options check the https://github.com/jawj/OverlappingMarkerSpiderfier page.

Example: `markersWontMove=true&markersWontHide=true`  
