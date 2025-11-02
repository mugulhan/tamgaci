<?php
/**
 * Tekil motor şablonu.
 */

get_header();

echo '<div class="hidden" data-single-template="motorcycle"></div>';

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/vehicle/single' );
    }
}

get_footer();