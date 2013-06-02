<?php
/**
 * The template for displaying all pages.
 *
 * Template Name: Default Page
 * Description: Page template with a content container and right sidebar
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
<div class="span8">

            <?php the_content();?>
			<ul>
				<?php if( isset( $_GET['i'] )) : ?>
					<?php $display = ""; ?>
					<?php $property_data = teardown_get_property_by_id( $_GET['i'] );
						if( $property_data ) :
							foreach( $property_data as $property ) :
								
								$lat = $property->latitude;
								$long = $property->longitude;
								
								$display .= "<li id='address'>" . $property->address_line_1 . "<br>";
								$display .= $property->city . ", " . $property->state . " " . $property->zip . "</li>";
								$display .= "<li>Lat: " . $lat . "</li>";
								$display .= "<li>Long: " . $long . "</li>";

							endforeach;
							
							echo "<img src='http://maps.googleapis.com/maps/api/streetview?size=600x300&location=" . $long . ",%20" . $lat . "&fov=90&heading=235&pitch=10&sensor=false' />";
							echo $display;
							
						endif;
				endif;
					?>
			</ul>

		<?php endwhile; // end of the loop. ?>
</div><!-- /.span8 -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
