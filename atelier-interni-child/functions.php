<?php
/**
 * Atelier d'Interni child theme functions.
 *
 * @package AtelierInterni
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'ATELIER_THEME_VERSION', '1.5.0' );

function atelier_interni_setup() {
	load_child_theme_textdomain( 'atelier-interni', get_stylesheet_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 90, 'width' => 280, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'elementor' );
	register_nav_menus(
		array(
			'top_bar' => __( 'Menu barra superiore', 'atelier-interni' ),
			'institutional' => __( 'Menu istituzionale', 'atelier-interni' ),
			'product_categories' => __( 'Menu categorie prodotti', 'atelier-interni' ),
			'footer_company' => __( 'Footer azienda', 'atelier-interni' ),
			'footer_customer' => __( 'Footer servizio clienti', 'atelier-interni' ),
		)
	);
}
add_action( 'after_setup_theme', 'atelier_interni_setup' );

function atelier_interni_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'atelier_interni_register_elementor_locations' );

function atelier_interni_assets() {
	wp_enqueue_style( 'hello-elementor', get_template_directory_uri() . '/style.css', array(), wp_get_theme( 'hello-elementor' )->get( 'Version' ) );
	wp_enqueue_style( 'atelier-interni', get_stylesheet_uri(), array( 'hello-elementor' ), ATELIER_THEME_VERSION );
	wp_enqueue_script( 'atelier-interni', get_stylesheet_directory_uri() . '/assets/js/theme.js', array(), ATELIER_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'atelier_interni_assets', 20 );

function atelier_interni_widgets() {
	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar( array( 'name' => sprintf( __( 'Footer colonna %d', 'atelier-interni' ), $i ), 'id' => 'footer-' . $i, 'before_widget' => '<section class="atelier-footer-widget">', 'after_widget' => '</section>', 'before_title' => '<h3>', 'after_title' => '</h3>' ) );
	}
}
add_action( 'widgets_init', 'atelier_interni_widgets' );

function atelier_interni_menu_fallback() {
	$items = array( __( 'Chi siamo', 'atelier-interni' ) => '/chi-siamo/', __( 'Cosa Facciamo', 'atelier-interni' ) => '/cosa-facciamo/', __( 'Pubblica Amministrazione', 'atelier-interni' ) => '/pubblica-amministrazione/', __( 'Foto', 'atelier-interni' ) => '/foto/', __( 'Contatti', 'atelier-interni' ) => '/contatti/' );
	echo '<ul>';
	foreach ( $items as $label => $path ) { printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( home_url( $path ) ), esc_html( $label ) ); }
	echo '</ul>';
}

function atelier_interni_category_fallback() {
	if ( taxonomy_exists( 'product_cat' ) ) { wp_list_categories( array( 'taxonomy' => 'product_cat', 'title_li' => '', 'depth' => 1, 'hide_empty' => true ) ); }
}

function atelier_interni_cart_count_fragment( $fragments ) {
	ob_start(); ?><span class="atelier-cart-count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span><?php
	$fragments['.atelier-cart-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'atelier_interni_cart_count_fragment' );

function atelier_interni_body_classes( $classes ) {
	$classes[] = 'atelier-interni-theme';
	return $classes;
}
add_filter( 'body_class', 'atelier_interni_body_classes' );

function atelier_interni_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) || 'page' === get_option( 'show_on_front' ) ) { return; }
	?>
	<div class="notice notice-info"><p><strong><?php esc_html_e( 'Atelier d’Interni:', 'atelier-interni' ); ?></strong> <?php esc_html_e( 'per modificare la homepage con Elementor, crea una pagina “Home” e impostala come pagina iniziale in Impostazioni → Lettura, quindi aprila con “Modifica con Elementor”.', 'atelier-interni' ); ?></p></div>
	<?php
}
add_action( 'admin_notices', 'atelier_interni_admin_notice' );


/**
 * Top bar options available in Appearance > Customize.
 */
function atelier_interni_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'atelier_social_links',
		array(
			'title'       => __( 'Barra superiore e social', 'atelier-interni' ),
			'description' => __( 'Inserisci gli indirizzi completi dei profili social. Lascia vuoto un campo per nascondere la relativa icona. Il menu a destra si assegna da Aspetto → Menu alla posizione “Menu barra superiore”.', 'atelier-interni' ),
			'priority'    => 35,
		)
	);

	$socials = array(
		'facebook'  => __( 'URL Facebook', 'atelier-interni' ),
		'instagram' => __( 'URL Instagram', 'atelier-interni' ),
		'youtube'   => __( 'URL YouTube', 'atelier-interni' ),
		'linkedin'  => __( 'URL LinkedIn', 'atelier-interni' ),
	);

	foreach ( $socials as $network => $label ) {
		$setting = 'atelier_' . $network . '_url';
		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$setting,
			array(
				'type'    => 'url',
				'section' => 'atelier_social_links',
				'label'   => $label,
			)
		);
	}
}
add_action( 'customize_register', 'atelier_interni_customize_register' );

function atelier_interni_social_icon( $network ) {
	$icons = array(
		'facebook'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3 0-5 2-5 5v2H6v4h3v7h4v-7h3l1-4h-4V9c0-.7.3-1 1-1Z"/></svg>',
		'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>',
		'youtube'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 8.2a3 3 0 0 0-2.1-2.1C17.1 5.6 12 5.6 12 5.6s-5.1 0-6.9.5A3 3 0 0 0 3 8.2 31 31 0 0 0 2.5 12 31 31 0 0 0 3 15.8a3 3 0 0 0 2.1 2.1c1.8.5 6.9.5 6.9.5s5.1 0 6.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .5-3.8 31 31 0 0 0-.5-3.8Z"/><path class="atelier-social-play" d="m10 15 5-3-5-3v6Z"/></svg>',
		'linkedin'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 8.5h4V21H5V8.5ZM7 3a2.3 2.3 0 1 1 0 4.6A2.3 2.3 0 0 1 7 3Zm4 5.5h3.8v1.7h.1c.5-1 1.8-2.1 3.8-2.1 4 0 4.8 2.7 4.8 6.1V21h-4v-6c0-1.4 0-3.3-2-3.3s-2.4 1.6-2.4 3.2V21h-4V8.5Z"/></svg>',
	);
	return isset( $icons[ $network ] ) ? $icons[ $network ] : '';
}


/**
 * Homepage slider options.
 */
function atelier_interni_slider_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'atelier_home_slider',
		array(
			'title'       => __( 'Slider homepage', 'atelier-interni' ),
			'description' => __( 'Attiva lo slider e configura fino a cinque slide. Le slide prive di titolo e immagine vengono ignorate.', 'atelier-interni' ),
			'priority'    => 36,
		)
	);

	$wp_customize->add_setting(
		'atelier_slider_enabled',
		array(
			'default'           => false,
			'sanitize_callback' => 'atelier_interni_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'atelier_slider_enabled',
		array(
			'type'    => 'checkbox',
			'section' => 'atelier_home_slider',
			'label'   => __( 'Attiva lo slider in homepage', 'atelier-interni' ),
		)
	);

	$wp_customize->add_setting(
		'atelier_slider_interval',
		array(
			'default'           => 5000,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'atelier_slider_interval',
		array(
			'type'    => 'select',
			'section' => 'atelier_home_slider',
			'label'   => __( 'Velocità autoplay', 'atelier-interni' ),
			'choices' => array(
				4000 => __( '4 secondi', 'atelier-interni' ),
				5000 => __( '5 secondi', 'atelier-interni' ),
				6000 => __( '6 secondi', 'atelier-interni' ),
				8000 => __( '8 secondi', 'atelier-interni' ),
			),
		)
	);

	for ( $i = 1; $i <= 5; $i++ ) {
		$prefix = 'atelier_slide_' . $i . '_';
		$defaults = 1 === $i ? array(
			'title' => __( 'Spazi da vivere, soluzioni da scegliere.', 'atelier-interni' ),
			'text'  => __( 'Arredo, forniture e prodotti selezionati per la casa, il lavoro e la Pubblica Amministrazione.', 'atelier-interni' ),
			'label' => __( 'Scopri il catalogo', 'atelier-interni' ),
		) : array( 'title' => '', 'text' => '', 'label' => '' );

		$wp_customize->add_setting( $prefix . 'image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$prefix . 'image',
				array(
					'label'       => sprintf( __( 'Slide %d — immagine', 'atelier-interni' ), $i ),
					'section'     => 'atelier_home_slider',
					'description' => __( 'Formato consigliato: 1920 × 760 px.', 'atelier-interni' ),
				)
			)
		);

		foreach ( array(
			'title' => array( sprintf( __( 'Slide %d — titolo', 'atelier-interni' ), $i ), 'text', 'sanitize_text_field' ),
			'text'  => array( sprintf( __( 'Slide %d — testo', 'atelier-interni' ), $i ), 'textarea', 'sanitize_textarea_field' ),
			'label' => array( sprintf( __( 'Slide %d — testo pulsante', 'atelier-interni' ), $i ), 'text', 'sanitize_text_field' ),
			'url'   => array( sprintf( __( 'Slide %d — link pulsante', 'atelier-interni' ), $i ), 'url', 'esc_url_raw' ),
		) as $field => $args ) {
			$wp_customize->add_setting(
				$prefix . $field,
				array(
					'default'           => isset( $defaults[ $field ] ) ? $defaults[ $field ] : '',
					'sanitize_callback' => $args[2],
				)
			);
			$wp_customize->add_control(
				$prefix . $field,
				array(
					'type'    => $args[1],
					'section' => 'atelier_home_slider',
					'label'   => $args[0],
				)
			);
		}
	}
}
add_action( 'customize_register', 'atelier_interni_slider_customize_register' );

function atelier_interni_sanitize_checkbox( $checked ) {
	return (bool) $checked;
}

/**
 * Render the optional homepage slider.
 *
 * @return bool True when the slider was rendered.
 */
function atelier_interni_render_slider() {
	if ( ! get_theme_mod( 'atelier_slider_enabled', false ) ) {
		return false;
	}

	$slides = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$prefix = 'atelier_slide_' . $i . '_';
		$slide  = array(
			'image' => get_theme_mod( $prefix . 'image', '' ),
			'title' => get_theme_mod( $prefix . 'title', 1 === $i ? __( 'Spazi da vivere, soluzioni da scegliere.', 'atelier-interni' ) : '' ),
			'text'  => get_theme_mod( $prefix . 'text', 1 === $i ? __( 'Arredo, forniture e prodotti selezionati per la casa, il lavoro e la Pubblica Amministrazione.', 'atelier-interni' ) : '' ),
			'label' => get_theme_mod( $prefix . 'label', 1 === $i ? __( 'Scopri il catalogo', 'atelier-interni' ) : '' ),
			'url'   => get_theme_mod( $prefix . 'url', '' ),
		);
		if ( $slide['image'] || $slide['title'] ) {
			$slides[] = $slide;
		}
	}

	if ( empty( $slides ) ) {
		return false;
	}

	$interval = max( 3000, absint( get_theme_mod( 'atelier_slider_interval', 5000 ) ) );
	?>
	<section class="atelier-slider" data-atelier-slider data-interval="<?php echo esc_attr( $interval ); ?>" aria-roledescription="<?php esc_attr_e( 'carosello', 'atelier-interni' ); ?>">
		<div class="atelier-slides">
			<?php foreach ( $slides as $index => $slide ) : ?>
				<article class="atelier-slide<?php echo 0 === $index ? ' is-active' : ''; ?>" aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>">
					<?php if ( $slide['image'] ) : ?><img class="atelier-slide-image" src="<?php echo esc_url( $slide['image'] ); ?>" alt=""><?php endif; ?>
					<div class="atelier-slide-overlay"></div>
					<div class="atelier-wrap atelier-slide-content">
						<span class="atelier-eyebrow"><?php esc_html_e( 'Atelier d’Interni', 'atelier-interni' ); ?></span>
						<?php if ( $slide['title'] ) : ?><h2><?php echo esc_html( $slide['title'] ); ?></h2><?php endif; ?>
						<?php if ( $slide['text'] ) : ?><p><?php echo esc_html( $slide['text'] ); ?></p><?php endif; ?>
						<?php if ( $slide['label'] && $slide['url'] ) : ?><a class="atelier-btn atelier-btn-light" href="<?php echo esc_url( $slide['url'] ); ?>"><?php echo esc_html( $slide['label'] ); ?></a><?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<?php if ( count( $slides ) > 1 ) : ?>
			<button class="atelier-slider-arrow atelier-slider-prev" type="button" aria-label="<?php esc_attr_e( 'Slide precedente', 'atelier-interni' ); ?>">‹</button>
			<button class="atelier-slider-arrow atelier-slider-next" type="button" aria-label="<?php esc_attr_e( 'Slide successiva', 'atelier-interni' ); ?>">›</button>
			<div class="atelier-slider-dots" role="tablist" aria-label="<?php esc_attr_e( 'Seleziona slide', 'atelier-interni' ); ?>">
				<?php foreach ( $slides as $index => $slide ) : ?>
					<button type="button" class="<?php echo 0 === $index ? 'is-active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Vai alla slide %d', 'atelier-interni' ), $index + 1 ) ); ?>" aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"></button>
				<?php endforeach; ?>
			</div>
			<button class="atelier-slider-pause" type="button" aria-pressed="false"><span class="atelier-pause-label"><?php esc_html_e( 'Pausa', 'atelier-interni' ); ?></span></button>
		<?php endif; ?>
	</section>
	<?php
	return true;
}
