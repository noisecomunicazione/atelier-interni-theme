<?php
/**
 * Site footer.
 *
 * @package AtelierInterni
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
</main>
<footer class="atelier-footer">
	<div class="atelier-wrap">
		<div class="atelier-footer-grid">
			<section>
				<h2><?php bloginfo( 'name' ); ?></h2>
				<p><?php esc_html_e( 'Soluzioni d’arredo, forniture e servizi pensati per privati, professionisti e Pubblica Amministrazione.', 'atelier-interni' ); ?></p>
			</section>
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
				<div><?php if ( is_active_sidebar( 'footer-' . $i ) ) { dynamic_sidebar( 'footer-' . $i ); } elseif ( 1 === $i ) { ?><h3><?php esc_html_e( 'Atelier d’Interni', 'atelier-interni' ); ?></h3><?php wp_nav_menu( array( 'theme_location' => 'footer_company', 'container' => false, 'fallback_cb' => 'atelier_interni_menu_fallback' ) ); } elseif ( 2 === $i && class_exists( 'WooCommerce' ) ) { ?><h3><?php esc_html_e( 'Acquista', 'atelier-interni' ); ?></h3><ul><li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Catalogo', 'atelier-interni' ); ?></a></li><li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Il mio account', 'atelier-interni' ); ?></a></li><li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Carrello', 'atelier-interni' ); ?></a></li></ul><?php } else { ?><h3><?php esc_html_e( 'Contatti', 'atelier-interni' ); ?></h3><p><?php esc_html_e( 'Contattaci per informazioni, preventivi e assistenza.', 'atelier-interni' ); ?></p><?php } ?></div>
			<?php endfor; ?>
		</div>
		<div class="atelier-footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
			<span><?php esc_html_e( 'Privacy · Cookie · Condizioni di vendita', 'atelier-interni' ); ?></span>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
