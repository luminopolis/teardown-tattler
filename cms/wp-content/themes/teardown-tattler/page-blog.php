<?php
/**
 * Template Name: Blog Page
 * Description: Page template to display blog posts
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">
    <div class="container">
      <?php if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
    </div><!--/.container -->
  </div><!--/.row -->
  <div class="container">
 <!-- Masthead
 ================================================== -->
 <header class="jumbotron subhead" id="overview">
  <h1><?php the_title();?></h1>
</header>

<div class="row content">
  <div class="span8">
    <?php the_content();
    endwhile;
           // end of the loop
    wp_reset_query();
          // resetting the loop
    ?>
    <hr />
  </div><!-- /.span8 -->

  <div class="span8">
    <?php
              // Blog post query
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts( array( 'post_type' => 'post', 'paged'=>$paged, 'showposts'=>0) );
    if (have_posts()) : while ( have_posts() ) : the_post(); ?>
    <div <?php post_class(); ?>>
      <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h3><?php the_title();?></h3></a>
      <p class="meta"><?php echo bootstrapwp_posted_on();?></p>
      <div class="row">
	<?php
	$image_args = array( 'post_type' => 'attachment', 'numberposts' => 1, 'post_mime_type' => 'image', 'post_parent' => $post->ID, 'order' => 'desc' );
	$attached_image = get_children( $image_args );
	if ( bootstrapwp_post_thumbnail_check() == 'true' || $attached_image ) {
	echo '<div class="span2"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">';
	echo bootstrapwp_autoset_featured_img();
	echo '</a></div><!-- /.span2 --><div class="span6">';
	} else {
	echo '<div class="span8">';
	}
	the_excerpt();
	echo '</div><!-- /.span6 or span8 -->';
	?>
	</div><!-- /.row -->
     <hr />
   </div><!-- /.post_class -->
 <?php endwhile; endif; ?>
 <?php bootstrapwp_content_nav('nav-below');?>

</div><!-- /.span8 -->
<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>