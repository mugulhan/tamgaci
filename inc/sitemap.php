<?php
/**
 * Custom Sitemap Generator
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generate sitemap index
 */
function tamgaci_generate_sitemap_index() {
	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$sitemap .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	// Ana sayfa ve sayfalar sitemap
	$sitemap .= "\t<sitemap>\n";
	$sitemap .= "\t\t<loc>" . esc_url( home_url( '/sitemap-pages.xml' ) ) . "</loc>\n";
	$sitemap .= "\t\t<lastmod>" . date( 'c' ) . "</lastmod>\n";
	$sitemap .= "\t</sitemap>\n";

	// Yakıtlı araçlar sitemap
	$sitemap .= "\t<sitemap>\n";
	$sitemap .= "\t\t<loc>" . esc_url( home_url( '/sitemap-combustion-vehicles.xml' ) ) . "</loc>\n";
	$sitemap .= "\t\t<lastmod>" . date( 'c' ) . "</lastmod>\n";
	$sitemap .= "\t</sitemap>\n";

	// Elektrikli araçlar sitemap
	$sitemap .= "\t<sitemap>\n";
	$sitemap .= "\t\t<loc>" . esc_url( home_url( '/sitemap-electric-vehicles.xml' ) ) . "</loc>\n";
	$sitemap .= "\t\t<lastmod>" . date( 'c' ) . "</lastmod>\n";
	$sitemap .= "\t</sitemap>\n";

	// Motosikletler sitemap
	$sitemap .= "\t<sitemap>\n";
	$sitemap .= "\t\t<loc>" . esc_url( home_url( '/sitemap-motorcycles.xml' ) ) . "</loc>\n";
	$sitemap .= "\t\t<lastmod>" . date( 'c' ) . "</lastmod>\n";
	$sitemap .= "\t</sitemap>\n";

	// Karşılaştırmalar sitemap
	$sitemap .= "\t<sitemap>\n";
	$sitemap .= "\t\t<loc>" . esc_url( home_url( '/sitemap-comparisons.xml' ) ) . "</loc>\n";
	$sitemap .= "\t\t<lastmod>" . date( 'c' ) . "</lastmod>\n";
	$sitemap .= "\t</sitemap>\n";

	// Markalar sitemap
	$sitemap .= "\t<sitemap>\n";
	$sitemap .= "\t\t<loc>" . esc_url( home_url( '/sitemap-brands.xml' ) ) . "</loc>\n";
	$sitemap .= "\t\t<lastmod>" . date( 'c' ) . "</lastmod>\n";
	$sitemap .= "\t</sitemap>\n";

	// Modeller sitemap
	$sitemap .= "\t<sitemap>\n";
	$sitemap .= "\t\t<loc>" . esc_url( home_url( '/sitemap-models.xml' ) ) . "</loc>\n";
	$sitemap .= "\t\t<lastmod>" . date( 'c' ) . "</lastmod>\n";
	$sitemap .= "\t</sitemap>\n";

	// Gövde tipleri sitemap
	$sitemap .= "\t<sitemap>\n";
	$sitemap .= "\t\t<loc>" . esc_url( home_url( '/sitemap-body-types.xml' ) ) . "</loc>\n";
	$sitemap .= "\t\t<lastmod>" . date( 'c' ) . "</lastmod>\n";
	$sitemap .= "\t</sitemap>\n";

	$sitemap .= '</sitemapindex>';

	return $sitemap;
}

/**
 * Generate pages sitemap
 */
function tamgaci_generate_sitemap_pages() {
	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	// Ana sayfa
	$sitemap .= "\t<url>\n";
	$sitemap .= "\t\t<loc>" . esc_url( home_url( '/' ) ) . "</loc>\n";
	$sitemap .= "\t\t<lastmod>" . date( 'c', strtotime( get_lastpostmodified( 'gmt' ) ) ) . "</lastmod>\n";
	$sitemap .= "\t\t<changefreq>daily</changefreq>\n";
	$sitemap .= "\t\t<priority>1.0</priority>\n";
	$sitemap .= "\t</url>\n";

	// Sayfalar
	$pages = get_pages( [
		'post_status' => 'publish',
		'sort_column' => 'post_modified',
	] );

	foreach ( $pages as $page ) {
		$sitemap .= "\t<url>\n";
		$sitemap .= "\t\t<loc>" . esc_url( get_permalink( $page->ID ) ) . "</loc>\n";
		$sitemap .= "\t\t<lastmod>" . date( 'c', strtotime( $page->post_modified_gmt ) ) . "</lastmod>\n";
		$sitemap .= "\t\t<changefreq>weekly</changefreq>\n";
		$sitemap .= "\t\t<priority>0.8</priority>\n";
		$sitemap .= "\t</url>\n";
	}

	$sitemap .= '</urlset>';

	return $sitemap;
}

/**
 * Generate vehicle sitemap by post type
 */
function tamgaci_generate_sitemap_vehicles( $post_type ) {
	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	$vehicles = get_posts( [
		'post_type'      => $post_type,
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'modified',
		'order'          => 'DESC',
	] );

	foreach ( $vehicles as $vehicle ) {
		$sitemap .= "\t<url>\n";
		$sitemap .= "\t\t<loc>" . esc_url( get_permalink( $vehicle->ID ) ) . "</loc>\n";
		$sitemap .= "\t\t<lastmod>" . date( 'c', strtotime( $vehicle->post_modified_gmt ) ) . "</lastmod>\n";
		$sitemap .= "\t\t<changefreq>weekly</changefreq>\n";
		$sitemap .= "\t\t<priority>0.9</priority>\n";
		$sitemap .= "\t</url>\n";
	}

	$sitemap .= '</urlset>';

	return $sitemap;
}

/**
 * Generate comparison sitemap
 */
function tamgaci_generate_sitemap_comparisons() {
	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	$comparisons = get_posts( [
		'post_type'      => 'vehicle_comparison',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'modified',
		'order'          => 'DESC',
	] );

	foreach ( $comparisons as $comparison ) {
		$sitemap .= "\t<url>\n";
		$sitemap .= "\t\t<loc>" . esc_url( get_permalink( $comparison->ID ) ) . "</loc>\n";
		$sitemap .= "\t\t<lastmod>" . date( 'c', strtotime( $comparison->post_modified_gmt ) ) . "</lastmod>\n";
		$sitemap .= "\t\t<changefreq>monthly</changefreq>\n";
		$sitemap .= "\t\t<priority>0.7</priority>\n";
		$sitemap .= "\t</url>\n";
	}

	$sitemap .= '</urlset>';

	return $sitemap;
}

/**
 * Generate taxonomy sitemap
 */
function tamgaci_generate_sitemap_taxonomy( $taxonomy ) {
	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	$terms = get_terms( [
		'taxonomy'   => $taxonomy,
		'hide_empty' => true,
	] );

	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$sitemap .= "\t<url>\n";
			$sitemap .= "\t\t<loc>" . esc_url( get_term_link( $term ) ) . "</loc>\n";
			$sitemap .= "\t\t<changefreq>weekly</changefreq>\n";
			$sitemap .= "\t\t<priority>0.7</priority>\n";
			$sitemap .= "\t</url>\n";
		}
	}

	$sitemap .= '</urlset>';

	return $sitemap;
}

/**
 * Handle sitemap.xml request
 */
function tamgaci_sitemap_template() {
	// Check if the request is for sitemap.xml
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

	// Main sitemap index
	if ( $request_uri === '/sitemap.xml' || strpos( $request_uri, '/sitemap.xml' ) !== false ) {
		header( 'Content-Type: application/xml; charset=utf-8' );
		status_header( 200 );
		echo tamgaci_generate_sitemap_index(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	// Pages sitemap
	if ( strpos( $request_uri, 'sitemap-pages.xml' ) !== false ) {
		header( 'Content-Type: application/xml; charset=utf-8' );
		status_header( 200 );
		echo tamgaci_generate_sitemap_pages(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	// Combustion vehicles sitemap
	if ( strpos( $request_uri, 'sitemap-combustion-vehicles.xml' ) !== false ) {
		header( 'Content-Type: application/xml; charset=utf-8' );
		status_header( 200 );
		echo tamgaci_generate_sitemap_vehicles( 'combustion_vehicle' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	// Electric vehicles sitemap
	if ( strpos( $request_uri, 'sitemap-electric-vehicles.xml' ) !== false ) {
		header( 'Content-Type: application/xml; charset=utf-8' );
		status_header( 200 );
		echo tamgaci_generate_sitemap_vehicles( 'electric_vehicle' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	// Motorcycles sitemap
	if ( strpos( $request_uri, 'sitemap-motorcycles.xml' ) !== false ) {
		header( 'Content-Type: application/xml; charset=utf-8' );
		status_header( 200 );
		echo tamgaci_generate_sitemap_vehicles( 'motorcycle' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	// Comparisons sitemap
	if ( strpos( $request_uri, 'sitemap-comparisons.xml' ) !== false ) {
		header( 'Content-Type: application/xml; charset=utf-8' );
		status_header( 200 );
		echo tamgaci_generate_sitemap_comparisons(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	// Brands sitemap
	if ( strpos( $request_uri, 'sitemap-brands.xml' ) !== false ) {
		header( 'Content-Type: application/xml; charset=utf-8' );
		status_header( 200 );
		echo tamgaci_generate_sitemap_taxonomy( 'vehicle_brand' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	// Models sitemap
	if ( strpos( $request_uri, 'sitemap-models.xml' ) !== false ) {
		header( 'Content-Type: application/xml; charset=utf-8' );
		status_header( 200 );
		echo tamgaci_generate_sitemap_taxonomy( 'vehicle_model' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	// Body types sitemap
	if ( strpos( $request_uri, 'sitemap-body-types.xml' ) !== false ) {
		header( 'Content-Type: application/xml; charset=utf-8' );
		status_header( 200 );
		echo tamgaci_generate_sitemap_taxonomy( 'vehicle_body_type' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}
}
add_action( 'template_redirect', 'tamgaci_sitemap_template', 1 );
