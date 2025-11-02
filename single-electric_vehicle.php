<?php
/**
 * Tekil elektrikli araç şablonu.
 */

get_header();

echo '<div class="hidden" data-single-template="electric"></div>';

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/vehicle/single' );
    }
}

get_footer();
