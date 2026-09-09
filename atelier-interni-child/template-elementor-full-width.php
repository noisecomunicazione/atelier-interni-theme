<?php
/**
 * Template Name: Elementor Full Width
 * Template Post Type: page
 *
 * @package AtelierInterni
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) {
	the_post();
	the_content();
}
get_footer();
