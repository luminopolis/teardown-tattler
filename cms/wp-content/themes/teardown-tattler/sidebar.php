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
	<div class="well sidebar-nav">
		<h2>At risk properties</h2>
		<ul id="endangered-sidebar">
            <?php
    //if ( function_exists('dynamic_sidebar')) dynamic_sidebar("sidebar-page");
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
