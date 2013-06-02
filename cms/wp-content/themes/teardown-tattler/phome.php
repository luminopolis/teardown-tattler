<?php 
/*  Template Name: Home */
get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="row">
	<div class="container">
	<?php if( function_exists( 'bootstrapwp_breadcrumbs' )) bootstrapwp_breadcrumbs(); ?>
	</div><!--/.container -->
</div><!--/.row -->
<div class="container">
	<header class="page-title">
		<h1><?php the_title(); ?> - home</h1>
	</header>
	<div class="row content">
		<div class="span8">
			<?php the_content(); ?>
<?php endwhile; // end of the loop. ?>
		</div><!-- /.span8 -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>