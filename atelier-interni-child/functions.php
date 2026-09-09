<?php
/**
 * Atelier d'Interni child theme functions.
 *
 * @package AtelierInterni
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ATELIER_THEME_VERSION', '1.0.0' );

function atelier_interni_setup() {
	load_child_theme_textdomain( 'atelier-interni', get_stylesheet_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 90, 'width' => 280, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	register_nav_menus(
		array(
			'institutional' => __( 'Menu istituzionale', 'atelier-interni' ),
			'product_categories' => __( 'Menu categorie prodotti', 'atelier-interni' ),
			'footer_company' => __( 'Footer azienda', 'atelier-interni' ),
			'footer_customer' => __( 'Footer servizio clienti', 'atelier-interni' ),
		)
	);
}
add_action( 'after_setup_theme', 'atelier_interni_setup' );

function atelier_interni_assets() {
	wp_enqueue_style( 'hello-elementor', get_template_directory_uri() . '/style.css', array(), wp_get_theme( 'hello-elementor' )->get( 'Version' ) );
	wp_enqueue_style( 'atelier-interni', get_stylesheet_uri(), array( 'hello-elementor' ), ATELIER_THEME_VERSION );
	wp_enqueue_script( 'atelier-interni', get_stylesheet_directory_uri() . '/assets/js/theme.js', array(), ATELIER_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'atelier_interni_assets', 20 );

function atelier_interni_widgets() {
	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( __( 'Footer colonna %d', 'atelier-interni' ), $i ),
				'id'            => 'footer-' . $i,
				'before_widget' => '<section class="atelier-footer-widget">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'atelier_interni_widgets' );

function atelier_interni_menu_fallback() {
	$items = array(
		__( 'Chi siamo', 'atelier-interni' ) => '/chi-siamo/',
		__( 'Cosa Facciamo', 'atelier-interni' ) => '/cosa-facciamo/',
		__( 'Pubblica Amministrazione', 'atelier-interni' ) => '/pubblica-amministrazione/',
		__( 'Foto', 'atelier-interni' ) => '/foto/',
		__( 'Contatti', 'atelier-interni' ) => '/contatti/',
	);
	echo '<ul>';
	foreach ( $items as $label => $path ) {
		printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( home_url( $path ) ), esc_html( $label ) );
	}
	echo '</ul>';
}

function atelier_interni_category_fallback() {
	if ( taxonomy_exists( 'product_cat' ) ) {
		wp_list_categories( array( 'taxonomy' => 'product_cat', 'title_li' => '', 'depth' => 1, 'hide_empty' => true ) );
	}
}

function atelier_interni_cart_count_fragment( $fragments ) {
	ob_start();
	?>
	<span class="atelier-cart-count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
	<?php
	$fragments['.atelier-cart-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'atelier_interni_cart_count_fragment' );

function atelier_interni_body_classes( $classes ) {
	$classes[] = 'atelier-interni-theme';
	return $classes;
}
add_filter( 'body_class', 'atelier_interni_body_classes' );
