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

					<?php if( isset( $_GET['i'] )) : ?>
						<?php $address = ""; ?>
						<?php $property_data = teardown_get_property_by_id( $_GET['i'] );
							if( $property_data ) :
								foreach( $property_data as $property ) :
						
									$lat = $property['latitude'];
									$long = $property['longitude'];
								
									$address .= $property['address_line_1'] . "<br>";
									$address .= "<span class='single-city-state-zip'>" . $property['city'] . ", " . $property['state'] . " " . $property['zip'] . "</span>";
									
								endforeach;
							
								// output ?>
								
								<div class="alert alert-info">
									<a class="close" data-dismiss="alert">×</a>
									<i class="icon-warning-sign"> </i> This structure has been on our radar since <?php echo $property['311_creation_date']; ?>.  Please take action today!
								</div>
								<script type="text/javascript">
									jQuery(function() {
										jQuery('#tabs a').click(function (e) {
											e.preventDefault();
											jQuery(this).tab('show');
										})
									});
								</script>
								
														<div class="well">
															
															<p class="property-details"><?php echo $address; ?></p>
															
															<img src='http://maps.googleapis.com/maps/api/streetview?size=745x400&location=<?php echo $long; ?>,%20<?php echo $lat; ?>&fov=90&heading=235&pitch=10&sensor=false' width="100%" />
															
															<div class="spacer20"></div>
															
															<p><span class='label'><?php echo $lat . "&nbsp; " . $long; ?></span></p>
															
															<hr>
															
															<p class="property-details">311 Info:</p>
															<ul>
																<li>Case created: <?php echo $property['311_creation_date']; ?></li>
																<li>Case ID: <?php echo $property['311_case_id']; ?></li>
																<li>Case summary: <?php echo $property['311_case_summary']; ?></li>
															</ul>
															
															<hr>
															
															<div class="spacer30"></div>
															
															<p><a class="btn btn-primary btn-large" id="huge-call-to-action">Take action</a></p>
															
															<div class="spacer30"></div>
																<hr>
															<div class="spacer30"></div>
																
																
															<div id="disqus_thread"></div>
															<script type="text/javascript">
																var disqus_shortname = 'teardowntattler'; // required: replace example with your forum shortname
																
																(function() {
																	var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
																	dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
																	(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
																})();
															</script>
															<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
															<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
										    				
							
								
								</div>
								
								
								
								
								
								
								<?php

							endif; // if property_data
					endif; // if isset get['i]
			endwhile; // end of the loop. ?>
</div><!-- /.span8 -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
