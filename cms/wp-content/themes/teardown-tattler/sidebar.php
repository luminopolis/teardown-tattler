<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */
?>
<div class="span4">
	
		<?php $property_data = teardown_get_property_by_id( $_GET['i'] );
			if( $property_data ) :
				foreach( $property_data as $property ) :
		
					$lat = $property['latitude'];
					$long = $property['longitude'];
				
					$address = $property['address_line_1'] . " " . $property['city'] . ", " . $property['state'] . " " . $property['zip'];
					
				endforeach;
			endif;
	?>
	
	<?php echo do_shortcode('[pw_map address="' . $address . '" width="100%" height="300px"]'); ?>
	
	<div class="spacer25"></div>
	
	<div class="well sidebar-nav">
		
		<h3>At risk properties</h3>
		<ul id="endangered-sidebar" class="nav nav-pills nav-stacked">
            <?php
			$results = teardown_get_properties( 5 );
	
			foreach( $results as $result ) :
				echo "<li><a href='" . site_url() . "/property?i=" . $result->id . "'>" . $result->address_line_1 . "</a></li>";
			endforeach;

?>
		</ul>

	</div><!--/.well .sidebar-nav -->
</div><!-- /.span4 -->
</div><!-- /.row .content -->
</div><!-- /.row -->
