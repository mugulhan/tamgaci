<?php
/**
 * Vehicle dynamic route single template.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/vehicle/single' );
    }
}

get_footer();
