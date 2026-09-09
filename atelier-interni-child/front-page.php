<?php
/**
 * Front page: editable static page content, commercial fallback otherwise.
 *
 * @package AtelierInterni
 */
get_header();

if ( 'page' === get_option( 'show_on_front' ) && get_queried_object_id() ) {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	get_footer();
	return;
}

$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
?>
<section class="atelier-hero">
	<div class="atelier-wrap">
		<div class="atelier-hero-inner">
			<span class="atelier-eyebrow"><?php esc_html_e( 'Atelier d’Interni', 'atelier-interni' ); ?></span>
			<h1><?php esc_html_e( 'Spazi da vivere, soluzioni da scegliere.', 'atelier-interni' ); ?></h1>
			<p><?php esc_html_e( 'Arredo, forniture e prodotti selezionati per la casa, il lavoro e la Pubblica Amministrazione.', 'atelier-interni' ); ?></p>
			<div class="atelier-buttons">
				<a class="atelier-btn atelier-btn-light" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Scopri il catalogo', 'atelier-interni' ); ?></a>
				<a class="atelier-btn" href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>"><?php esc_html_e( 'Richiedi una consulenza', 'atelier-interni' ); ?></a>
			</div>
		</div>
	</div>
</section>
<section class="atelier-section">
	<div class="atelier-wrap">
		<header class="atelier-section-head"><span class="atelier-eyebrow"><?php esc_html_e( 'Scegli per ambiente', 'atelier-interni' ); ?></span><h2><?php esc_html_e( 'Tutto ciò che serve, in un unico atelier', 'atelier-interni' ); ?></h2><p><?php esc_html_e( 'Una navigazione commerciale immediata per trovare prodotti e soluzioni in base alle tue esigenze.', 'atelier-interni' ); ?></p></header>
		<div class="atelier-grid">
			<article class="atelier-card"><div><h3><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Casa e interni', 'atelier-interni' ); ?></a></h3><p><?php esc_html_e( 'Comfort, stile e funzionalità per ogni stanza.', 'atelier-interni' ); ?></p></div></article>
			<article class="atelier-card"><div><h3><a href="<?php echo esc_url( home_url( '/cosa-facciamo/' ) ); ?>"><?php esc_html_e( 'Servizi e progetti', 'atelier-interni' ); ?></a></h3><p><?php esc_html_e( 'Dalla scelta alla realizzazione, con supporto dedicato.', 'atelier-interni' ); ?></p></div></article>
			<article class="atelier-card"><div><h3><a href="<?php echo esc_url( home_url( '/pubblica-amministrazione/' ) ); ?>"><?php esc_html_e( 'Pubblica Amministrazione', 'atelier-interni' ); ?></a></h3><p><?php esc_html_e( 'Forniture e soluzioni per enti e spazi pubblici.', 'atelier-interni' ); ?></p></div></article>
		</div>
	</div>
</section>
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<section class="atelier-section atelier-section-light">
	<div class="atelier-wrap">
		<header class="atelier-section-head"><span class="atelier-eyebrow"><?php esc_html_e( 'In evidenza', 'atelier-interni' ); ?></span><h2><?php esc_html_e( 'Prodotti selezionati', 'atelier-interni' ); ?></h2></header>
		<?php echo do_shortcode( '[products limit="8" columns="4" visibility="featured"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>
<?php endif; ?>
<section class="atelier-section">
	<div class="atelier-wrap"><div class="atelier-benefits">
		<div class="atelier-benefit"><strong><?php esc_html_e( 'Selezione professionale', 'atelier-interni' ); ?></strong><span><?php esc_html_e( 'Prodotti scelti con cura', 'atelier-interni' ); ?></span></div>
		<div class="atelier-benefit"><strong><?php esc_html_e( 'Consulenza dedicata', 'atelier-interni' ); ?></strong><span><?php esc_html_e( 'Supporto prima e dopo l’acquisto', 'atelier-interni' ); ?></span></div>
		<div class="atelier-benefit"><strong><?php esc_html_e( 'Pagamenti sicuri', 'atelier-interni' ); ?></strong><span><?php esc_html_e( 'Checkout WooCommerce protetto', 'atelier-interni' ); ?></span></div>
		<div class="atelier-benefit"><strong><?php esc_html_e( 'Soluzioni su misura', 'atelier-interni' ); ?></strong><span><?php esc_html_e( 'Per privati, aziende ed enti', 'atelier-interni' ); ?></span></div>
	</div></div>
</section>
<section class="atelier-section atelier-section-light">
	<div class="atelier-wrap"><div class="atelier-cta"><div><h2><?php esc_html_e( 'Hai un progetto da realizzare?', 'atelier-interni' ); ?></h2><p><?php esc_html_e( 'Raccontaci le tue esigenze: troveremo insieme la soluzione più adatta.', 'atelier-interni' ); ?></p></div><a class="atelier-btn atelier-btn-light" href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>"><?php esc_html_e( 'Parliamone', 'atelier-interni' ); ?></a></div></div>
</section>
<?php get_footer(); ?>
