<?php
/**
 * WooCommerce wrapper.
 *
 * @package AtelierInterni
 */
get_header();
?>
<div class="atelier-wrap atelier-content">
	<?php woocommerce_content(); ?>
</div>
<?php get_footer(); ?>
