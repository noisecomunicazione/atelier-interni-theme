<?php
/**
 * Fallback template.
 *
 * @package AtelierInterni
 */
get_header();
?>
<div class="atelier-wrap atelier-content">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
		</article>
	<?php endwhile; the_posts_pagination(); else : ?>
		<p><?php esc_html_e( 'Nessun contenuto trovato.', 'atelier-interni' ); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
