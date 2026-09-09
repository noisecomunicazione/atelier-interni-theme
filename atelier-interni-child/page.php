<?php
/**
 * Default page template.
 *
 * @package AtelierInterni
 */
get_header();
?>
<div class="atelier-wrap atelier-content">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<header><h1><?php the_title(); ?></h1></header>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>
</div>
<?php get_footer(); ?>
