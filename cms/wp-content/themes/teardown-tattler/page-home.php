<?php
/**
 * Template Name: Home Hero Template with 3 widget areas
 *
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.5
 *
 * Last Revised: July 16, 2012
 */
get_header(); ?>
<div class="jumbotron masthead">
    <div class="container">
  <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
	
			<iframe width="640" height="360" src="http://www.youtube.com/embed/Inf6MJvlado?rel=0" frameborder="0" seamless="seamless" allowfullscreen></iframe>
			<br><small>"We don't make 'em like we used to &amp; once they're gone, they're gone!"<br>by <a href="https://twitter.com/luminopolis">Jase Wilson</a> <a href="http://citycampkc.org">#CCKC13</a></small>
			<div class="spacer20"></div>
			<a class="btn btn-large btn-primary" href="signup">Take action now!</a>
	</div>
</div>

<?php endwhile; endif; ?>
<div class="container">
  <div class="marketing">
  <div class="row-fluid">
    <div class="span4 offset1">
      <?php if( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "home-left" ); ?>
	<a class="btn btn-primary btn-large" href="<?php echo site_url(); ?>/signup">Take Action</a>
    </div>
    <div class="span3">
    <?php if( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "home-middle" ); ?>
    </div>
    <div class="span3">
		<h2>Endangered Buildings</h2>
		<ul class="nav nav-pills nav-stacked">
			<?php
				//if ( function_exists( 'dynamic_sidebar' ) ) dynamic_sidebar( "home-right" );
				$results = teardown_get_properties( 5 );
				
				foreach( $results as $result ) :
					echo "<li><a href='" . site_url() . "/property?i=" . $result->id . "'>" . $result->address_line_1 . "</a></li>";
				endforeach;
				
				
				// fooed you!
			?>
		</ul>
    </div>
  </div>
</div><!-- /.marketing -->
</div>
<?php get_footer();?>
