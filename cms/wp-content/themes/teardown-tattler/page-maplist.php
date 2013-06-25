<?php
/**
 * The template for displaying all pages.
 *
 * Template Name: Map List (DEV)
 * Description: 
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 *
 * Last Revised: July 16, 2012
 */

get_header(); ?>
<?php while( have_posts() ) : the_post(); ?>
  <div class="row">
  <div class="container">
   <?php if ( function_exists( 'bootstrapwp_breadcrumbs' ) ) bootstrapwp_breadcrumbs(); ?>
   </div><!--/.container -->
   </div><!--/.row -->
   <div class="container">
    <header class="page-title">
        <h1><?php the_title();?></h1>
      </header>
        <div class="row content">
			<div class="span12">
				
				<?php the_content(); ?>
				
				<script type="text/javascript" src="http://welcome.totheinter.net/autocolumn/autocolumn.js"></script>
				<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
				
				<script type="text/javascript"> 
				jQuery(function() {
					initialize();
					jQuery('#gsidebar').columnize({columns:4});
				});
				
				//<![CDATA[
					// setup
					var side_bar_html = ""; 
					var gmarkers = []; 
					var map = null;
					
				function initialize() {
					// create the map
					var myOptions = {
						zoom: 11,
						mapTypeControl: true,
						mapTypeControlOptions: { style: google.maps.MapTypeControlStyle.DROPDOWN_MENU },
						navigationControl: true,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						center: new google.maps.LatLng( 39.099727, -94.578567 ),
					}
					map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
					
					google.maps.event.addListener(map, 'click', function() {
						infowindow.close();
					});
					
				  // Add markers
				
					<?php $property_data = teardown_get_properties( 99 );
						if( $property_data ) :
							foreach( $property_data as $property ) :
								
								$id = $property->id;
								$lat = $property->latitude;
								$long = $property->longitude;
								$title = $property->address_line_1;
								
								$streetview = '<img src=\"http://maps.googleapis.com/maps/api/streetview?size=350x170&location=' . $long . ',%20' . $lat . '&fov=90&heading=235&pitch=10&sensor=false\" width=\"100%\" />';
								
								?>var point = new google.maps.LatLng(<?php echo $long; ?>,<?php echo $lat; ?>);
								
								var infowindow_content = "<div class='google-infowindow'>";
								    infowindow_content += "<a href='property/?i=<?php echo $id; ?>'><?php echo $title; ?><br><?php echo $streetview;?></a>";
								    infowindow_content += "<?php $geoinfo = teardown_get_geo_info( $title, 'kansas city', 'mo' ); echo $geoinfo; ?></div>";
									
								var marker = createMarker( point, "<?php echo $title; ?>", infowindow_content );<?php
								
							endforeach;
						endif; ?>
						
				
					// put the assembled side_bar_html contents into the side_bar div
					document.getElementById("gsidebar").innerHTML = side_bar_html;
				
				//	if( navigator.geolocation ) {
				//		navigator.geolocation.getCurrentPosition( function( position ) {
				//			var latitude = position.coords.latitude;
				//			var longitude = position.coords.longitude;
				//			var geolocpoint = new google.maps.LatLng(latitude, longitude);
				//			map.setCenter( geolocpoint );
						
							// Place a marker
							//var geolocation = new google.maps.Marker({
							//	position: geolocpoint,
							//	map: map,
							//	title: 'Your location',
							//	icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
							//});
				//		});
				//	}
				
				}
				
				var infowindow = new google.maps.InfoWindow({ 
				    size: new google.maps.Size(450,350)
				  });
				
				// This function picks up the click and opens the corresponding info window
				function detail(i) {
				  google.maps.event.trigger(gmarkers[i], "click");
				}
				
				// create the marker and set up the event window function 
				function createMarker(latlng, name, html) {
					var contentString = html;
					var marker = new google.maps.Marker({
						position: latlng,
						map: map,
						zIndex: Math.round(latlng.lat()*-100000)<<5
					});
						
					google.maps.event.addListener(marker, 'click', function() {
						infowindow.setContent(contentString); 
						infowindow.open(map,marker);
					});
					// save the info we need to use later for the side_bar
					gmarkers.push(marker);
					// add a line to the side_bar html
					side_bar_html += '<a href="javascript:detail(' + (gmarkers.length-1) + ')">' + name + '<\/a><br>';
				}
				
				// GOOGLE FONTS
				WebFontConfig = {
					google: { families: [ 'Six+Caps::latin' ] }
					};
					(function() {
					var wf = document.createElement('script');
					wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
					 '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
					wf.type = 'text/javascript';
					wf.async = 'true';
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(wf, s);
				})();
				

				</script>
				
				<div id="map_canvas" style="width: 100%; height: 450px; background: white url(http://google-web-toolkit.googlecode.com/svn-history/r8457/trunk/user/src/com/google/gwt/cell/client/loading.gif) no-repeat 50% 50%;"></div> 
	
			<?php endwhile; // end of the loop. ?>
</div><!-- /.span8 -->
</div>
<div class="row">
	<div class="span12">
		<div id="gsidebar"></div>
	</div>
</div>

<?php get_footer(); ?>
