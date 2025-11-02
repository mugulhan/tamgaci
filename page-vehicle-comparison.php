<?php
/**
 * Template Name: Araç Karşılaştırma
 */

get_header();

$post_types = function_exists( 'tamgaci_get_vehicle_post_types' )
    ? tamgaci_get_vehicle_post_types()
    : [ 'electric_vehicle', 'combustion_vehicle' ];

$vehicle_query = new WP_Query(
    [
        'post_type'      => $post_types,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => [
            'menu_order' => 'ASC',
            'title'      => 'ASC',
        ],
    ]
);

if ( $vehicle_query->have_posts() ) {
    get_template_part(
        'template-parts/vehicle/comparison',
        null,
        [
            'query'        => $vehicle_query,
            'compare_url'  => function_exists( 'tamgaci_get_vehicle_compare_url' ) ? tamgaci_get_vehicle_compare_url() : '',
            'compare_max'  => 4,
        ]
    );
    wp_reset_postdata();
} else {
    echo '<section class="container mx-auto px-4 py-12 text-center text-slate-600">'
        . esc_html__( 'Henüz kaydedilmiş araç bulunmuyor. Yönetim panelinden yeni araç ekleyin.', 'tamgaci' )
        . '</section>';
}

get_footer();
