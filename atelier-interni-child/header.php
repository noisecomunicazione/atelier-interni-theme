<?php
/**
 * Site header with Elementor Pro Theme Builder support.
 *
 * @package AtelierInterni
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
wp_body_open();
$atelier_elementor_header = function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' );
if ( ! $atelier_elementor_header ) :
?>
<a class="screen-reader-text" href="#content"><?php esc_html_e( 'Vai al contenuto', 'atelier-interni' ); ?></a>
<header class="atelier-site-header">
	<div class="atelier-topbar">
		<div class="atelier-wrap">
			<span><?php esc_html_e( 'Arredo, forniture e soluzioni per ogni ambiente', 'atelier-interni' ); ?></span>
			<span class="atelier-topbar-right"><?php esc_html_e( 'Assistenza e consulenza professionale', 'atelier-interni' ); ?></span>
		</div>
	</div>
	<div class="atelier-header-main">
		<div class="atelier-wrap">
			<div class="atelier-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php if ( has_custom_logo() ) { the_custom_logo(); } else { ?><span class="atelier-site-name"><?php bloginfo( 'name' ); ?></span><?php } ?>
				</a>
			</div>
			<div class="atelier-search" role="search">
				<?php if ( function_exists( 'get_product_search_form' ) ) { get_product_search_form(); } else { get_search_form(); } ?>
			</div>
			<div class="atelier-actions">
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a class="atelier-action" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><span class="atelier-icon" aria-hidden="true">♙</span><span class="atelier-action-label"><?php esc_html_e( 'Account', 'atelier-interni' ); ?></span></a>
					<a class="atelier-action" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><span class="atelier-icon" aria-hidden="true">🛒</span><span class="atelier-action-label"><?php esc_html_e( 'Carrello', 'atelier-interni' ); ?></span><span class="atelier-cart-count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<nav class="atelier-nav" aria-label="<?php esc_attr_e( 'Navigazione principale', 'atelier-interni' ); ?>">
		<div class="atelier-wrap">
			<button class="atelier-menu-toggle" type="button" aria-expanded="false"><?php esc_html_e( 'Menu', 'atelier-interni' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'institutional', 'container' => false, 'fallback_cb' => 'atelier_interni_menu_fallback' ) ); ?>
			<div class="atelier-products">
				<button class="atelier-products-toggle" type="button" aria-expanded="false" aria-controls="atelier-products-panel">
					<span><?php esc_html_e( 'Prodotti', 'atelier-interni' ); ?></span>
					<span class="atelier-products-chevron" aria-hidden="true">⌄</span>
				</button>
			</div>
		</div>
		<div id="atelier-products-panel" class="atelier-products-panel" hidden>
			<div class="atelier-wrap">
				<div class="atelier-products-heading">
					<strong><?php esc_html_e( 'Esplora le categorie', 'atelier-interni' ); ?></strong>
					<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'Vedi tutto il catalogo', 'atelier-interni' ); ?> →</a>
				</div>
				<ul><?php
				if ( has_nav_menu( 'product_categories' ) ) {
					wp_nav_menu( array( 'theme_location' => 'product_categories', 'container' => false, 'items_wrap' => '%3$s', 'fallback_cb' => false ) );
				} else {
					atelier_interni_category_fallback();
				}
				?></ul>
			</div>
		</div>
	</nav>
</header>
<?php endif; ?>
<main id="content" class="site-content">
