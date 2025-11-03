<?php
/**
 * Araç içerik türleri, taksonomiler ve meta alanları.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const TAMGACI_ELECTRIC_POST_TYPE   = 'electric_vehicle';
const TAMGACI_COMBUSTION_POST_TYPE = 'combustion_vehicle';
const TAMGACI_MOTORCYCLE_POST_TYPE = 'motorcycle';

function tamgaci_get_vehicle_post_types() {
    return [
        TAMGACI_ELECTRIC_POST_TYPE,
        TAMGACI_COMBUSTION_POST_TYPE,
        TAMGACI_MOTORCYCLE_POST_TYPE,
    ];
}

function tamgaci_register_vehicle_components() {
    $electric_labels = [
        'name'                  => __( 'Elektrikli Araçlar', 'tamgaci' ),
        'singular_name'         => __( 'Elektrikli Araç', 'tamgaci' ),
        'add_new'               => __( 'Yeni Araç', 'tamgaci' ),
        'add_new_item'          => __( 'Yeni Elektrikli Araç Ekle', 'tamgaci' ),
        'edit_item'             => __( 'Elektrikli Aracı Düzenle', 'tamgaci' ),
        'new_item'              => __( 'Yeni Elektrikli Araç', 'tamgaci' ),
        'view_item'             => __( 'Elektrikli Aracı Görüntüle', 'tamgaci' ),
        'view_items'            => __( 'Elektrikli Araçları Görüntüle', 'tamgaci' ),
        'search_items'          => __( 'Elektrikli Araç Ara', 'tamgaci' ),
        'not_found'             => __( 'Elektrikli araç bulunamadı', 'tamgaci' ),
        'not_found_in_trash'    => __( 'Çöpte elektrikli araç bulunamadı', 'tamgaci' ),
        'all_items'             => __( 'Tüm Elektrikli Araçlar', 'tamgaci' ),
        'archives'              => __( 'Elektrikli Araç Arşivi', 'tamgaci' ),
        'menu_name'             => __( 'Elektrikli Araçlar', 'tamgaci' ),
    ];

    register_post_type(
        TAMGACI_ELECTRIC_POST_TYPE,
        [
            'labels'             => $electric_labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => [ 'slug' => 'elektrikli-araclar' ],
            'supports'           => [ 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ],
            'menu_icon'          => 'dashicons-admin-site-alt3',
            'menu_position'      => 5,
            'show_in_rest'       => true,
            'rest_base'          => 'electric-vehicles',
            'taxonomies'         => [ 'vehicle_brand', 'vehicle_powertrain' ],
        ]
    );

    $combustion_labels = [
        'name'                  => __( 'Yakıtlı & Hibrit Araçlar', 'tamgaci' ),
        'singular_name'         => __( 'Yakıtlı / Hibrit Araç', 'tamgaci' ),
        'add_new'               => __( 'Yeni Araç', 'tamgaci' ),
        'add_new_item'          => __( 'Yeni Yakıtlı / Hibrit Araç Ekle', 'tamgaci' ),
        'edit_item'             => __( 'Yakıtlı / Hibrit Aracı Düzenle', 'tamgaci' ),
        'new_item'              => __( 'Yeni Yakıtlı / Hibrit Araç', 'tamgaci' ),
        'view_item'             => __( 'Yakıtlı / Hibrit Aracı Görüntüle', 'tamgaci' ),
        'view_items'            => __( 'Yakıtlı / Hibrit Araçları Görüntüle', 'tamgaci' ),
        'search_items'          => __( 'Yakıtlı / Hibrit Araç Ara', 'tamgaci' ),
        'not_found'             => __( 'Yakıtlı veya hibrit araç bulunamadı', 'tamgaci' ),
        'not_found_in_trash'    => __( 'Çöpte yakıtlı veya hibrit araç bulunamadı', 'tamgaci' ),
        'all_items'             => __( 'Tüm Yakıtlı & Hibrit Araçlar', 'tamgaci' ),
        'archives'              => __( 'Yakıtlı & Hibrit Araç Arşivi', 'tamgaci' ),
        'menu_name'             => __( 'Yakıtlı & Hibrit Araçlar', 'tamgaci' ),
    ];

    register_post_type(
        TAMGACI_COMBUSTION_POST_TYPE,
        [
            'labels'             => $combustion_labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => [ 'slug' => 'yakitli-araclar' ],
            'supports'           => [ 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ],
            'menu_icon'          => 'dashicons-car',
            'menu_position'      => 6,
            'show_in_rest'       => true,
            'rest_base'          => 'combustion-vehicles',
            'taxonomies'         => [ 'vehicle_brand', 'vehicle_powertrain' ],
        ]
    );

    $motorcycle_labels = [
        'name'                  => __( 'Motorlar', 'tamgaci' ),
        'singular_name'         => __( 'Motor', 'tamgaci' ),
        'add_new'               => __( 'Yeni Motor', 'tamgaci' ),
        'add_new_item'          => __( 'Yeni Motor Ekle', 'tamgaci' ),
        'edit_item'             => __( 'Motoru Düzenle', 'tamgaci' ),
        'new_item'              => __( 'Yeni Motor', 'tamgaci' ),
        'view_item'             => __( 'Motoru Görüntüle', 'tamgaci' ),
        'view_items'            => __( 'Motorları Görüntüle', 'tamgaci' ),
        'search_items'          => __( 'Motor Ara', 'tamgaci' ),
        'not_found'             => __( 'Motor bulunamadı', 'tamgaci' ),
        'not_found_in_trash'    => __( 'Çöpte motor bulunamadı', 'tamgaci' ),
        'all_items'             => __( 'Tüm Motorlar', 'tamgaci' ),
        'archives'              => __( 'Motor Arşivi', 'tamgaci' ),
        'menu_name'             => __( 'Motorlar', 'tamgaci' ),
    ];

    register_post_type(
        TAMGACI_MOTORCYCLE_POST_TYPE,
        [
            'labels'             => $motorcycle_labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => [ 'slug' => 'motorlar' ],
            'supports'           => [ 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ],
            'menu_icon'          => 'dashicons-admin-site',
            'menu_position'      => 7,
            'show_in_rest'       => true,
            'rest_base'          => 'motorcycles',
            'taxonomies'         => [ 'vehicle_brand', 'vehicle_powertrain' ],
        ]
    );

    $brand_labels = [
        'name'              => __( 'Markalar', 'tamgaci' ),
        'singular_name'     => __( 'Marka', 'tamgaci' ),
        'search_items'      => __( 'Marka Ara', 'tamgaci' ),
        'all_items'         => __( 'Tüm Markalar', 'tamgaci' ),
        'parent_item'       => __( 'Üst Marka', 'tamgaci' ),
        'parent_item_colon' => __( 'Üst Marka:', 'tamgaci' ),
        'edit_item'         => __( 'Markayı Düzenle', 'tamgaci' ),
        'update_item'       => __( 'Markayı Güncelle', 'tamgaci' ),
        'add_new_item'      => __( 'Yeni Marka Ekle', 'tamgaci' ),
        'new_item_name'     => __( 'Yeni Marka Adı', 'tamgaci' ),
        'menu_name'         => __( 'Markalar', 'tamgaci' ),
    ];

    register_taxonomy(
        'vehicle_brand',
        tamgaci_get_vehicle_post_types(),
        [
            'labels'            => $brand_labels,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'rewrite'           => [ 'slug' => 'marka' ],
            'show_in_rest'      => true,
        ]
    );

    // Note: Models and equipment packages are now child terms of vehicle_brand taxonomy
    // Hierarchy: Brand > Model > Equipment Package
    // No separate vehicle_model or vehicle_equipment taxonomies needed

    $powertrain_labels = [
        'name'          => __( 'Motor Tipleri', 'tamgaci' ),
        'singular_name' => __( 'Motor Tipi', 'tamgaci' ),
        'search_items'  => __( 'Motor Tipi Ara', 'tamgaci' ),
        'all_items'     => __( 'Tüm Motor Tipleri', 'tamgaci' ),
        'edit_item'     => __( 'Motor Tipini Düzenle', 'tamgaci' ),
        'update_item'   => __( 'Motor Tipini Güncelle', 'tamgaci' ),
        'add_new_item'  => __( 'Yeni Motor Tipi Ekle', 'tamgaci' ),
        'new_item_name' => __( 'Yeni Motor Tipi', 'tamgaci' ),
        'menu_name'     => __( 'Motor Tipleri', 'tamgaci' ),
    ];

    register_taxonomy(
        'vehicle_powertrain',
        [ TAMGACI_COMBUSTION_POST_TYPE, TAMGACI_MOTORCYCLE_POST_TYPE ],
        [
            'labels'            => $powertrain_labels,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'rewrite'           => [
                'slug'         => 'motor-tipi',
                'hierarchical' => true,
            ],
            'show_in_rest'      => true,
            'meta_box_cb'       => 'post_categories_meta_box',
        ]
    );

    $body_type_labels = [
        'name'              => __( 'Araç Gövde Tipleri', 'tamgaci' ),
        'singular_name'     => __( 'Gövde Tipi', 'tamgaci' ),
        'search_items'      => __( 'Gövde Tipi Ara', 'tamgaci' ),
        'all_items'         => __( 'Tüm Gövde Tipleri', 'tamgaci' ),
        'edit_item'         => __( 'Gövde Tipini Düzenle', 'tamgaci' ),
        'update_item'       => __( 'Gövde Tipini Güncelle', 'tamgaci' ),
        'add_new_item'      => __( 'Yeni Gövde Tipi Ekle', 'tamgaci' ),
        'new_item_name'     => __( 'Yeni Gövde Tipi Adı', 'tamgaci' ),
        'menu_name'         => __( 'Gövde Tipleri', 'tamgaci' ),
    ];

    register_taxonomy(
        'vehicle_body_type',
        [ TAMGACI_ELECTRIC_POST_TYPE ],
        [
            'labels'            => $body_type_labels,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'rewrite'           => false,
            'show_in_rest'      => true,
            'meta_box_cb'       => 'post_categories_meta_box',
        ]
    );

    // Model Year Taxonomy
    $model_year_labels = [
        'name'              => __( 'Model Yılları', 'tamgaci' ),
        'singular_name'     => __( 'Model Yılı', 'tamgaci' ),
        'search_items'      => __( 'Model Yılı Ara', 'tamgaci' ),
        'all_items'         => __( 'Tüm Model Yılları', 'tamgaci' ),
        'edit_item'         => __( 'Model Yılını Düzenle', 'tamgaci' ),
        'update_item'       => __( 'Model Yılını Güncelle', 'tamgaci' ),
        'add_new_item'      => __( 'Yeni Model Yılı Ekle', 'tamgaci' ),
        'new_item_name'     => __( 'Yeni Model Yılı', 'tamgaci' ),
        'menu_name'         => __( 'Model Yılları', 'tamgaci' ),
    ];

    register_taxonomy(
        'vehicle_model_year',
        tamgaci_get_vehicle_post_types(),
        [
            'labels'            => $model_year_labels,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'rewrite'           => [
                'slug'         => 'yil',
                'with_front'   => false,
                'hierarchical' => false,
            ],
            'show_in_rest'      => true,
            'meta_box_cb'       => 'post_categories_meta_box',
        ]
    );
}
add_action( 'init', 'tamgaci_register_vehicle_components', 5 );

/**
 * Add custom rewrite rules for vehicle_body_type taxonomy.
 * Uses generate_rewrite_rules hook to insert rules at the very beginning.
 */
function tamgaci_add_body_type_rewrite_rules( $wp_rewrite ) {
    $new_rules = [];

    // Get all body type terms
    $terms = get_terms( [
        'taxonomy'   => 'vehicle_body_type',
        'hide_empty' => false,
    ] );

    if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
        foreach ( $terms as $term ) {
            // Body type term archive pages (only match if it's a known term slug)
            $new_rules[ '^elektrikli-araclar/' . $term->slug . '/?$' ] = 'index.php?vehicle_body_type=' . $term->slug;
            $new_rules[ '^elektrikli-araclar/' . $term->slug . '/page/?([0-9]{1,})/?$' ] = 'index.php?vehicle_body_type=' . $term->slug . '&paged=$matches[1]';
        }
    }

    // Main archive page for electric vehicles (without body type)
    // This needs to come AFTER body type rules to not override them
    $new_rules[ '^elektrikli-araclar/?$' ] = 'index.php?post_type=electric_vehicle';
    $new_rules[ '^elektrikli-araclar/page/?([0-9]{1,})/?$' ] = 'index.php?post_type=electric_vehicle&paged=$matches[1]';

    // Prepend our rules to the beginning
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'tamgaci_add_body_type_rewrite_rules' );

function tamgaci_register_vehicle_comparison_cpt() {
    $labels = [
        'name'               => __( 'Araç Karşılaştırmaları', 'tamgaci' ),
        'singular_name'      => __( 'Araç Karşılaştırması', 'tamgaci' ),
        'add_new'            => __( 'Yeni Karşılaştırma', 'tamgaci' ),
        'add_new_item'       => __( 'Yeni Araç Karşılaştırması', 'tamgaci' ),
        'edit_item'          => __( 'Karşılaştırmayı Düzenle', 'tamgaci' ),
        'new_item'           => __( 'Yeni Karşılaştırma', 'tamgaci' ),
        'view_item'          => __( 'Karşılaştırmayı Görüntüle', 'tamgaci' ),
        'view_items'         => __( 'Karşılaştırmaları Görüntüle', 'tamgaci' ),
        'search_items'       => __( 'Karşılaştırma Ara', 'tamgaci' ),
        'not_found'          => __( 'Karşılaştırma bulunamadı', 'tamgaci' ),
        'not_found_in_trash' => __( 'Çöpte karşılaştırma bulunamadı', 'tamgaci' ),
        'menu_name'          => __( 'Karşılaştırmalar', 'tamgaci' ),
    ];

    register_post_type(
        'vehicle_comparison',
        [
            'labels'             => $labels,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_position'      => 7,
            'menu_icon'          => 'dashicons-analytics',
            'supports'           => [ 'title', 'editor', 'excerpt' ],
            'has_archive'        => true,
            'rewrite'            => [ 'slug' => 'karsilastirma' ],
            'show_in_rest'       => true,
        ]
    );
}
add_action( 'init', 'tamgaci_register_vehicle_comparison_cpt', 9 );

function tamgaci_sanitize_decimal( $value ) {
    if ( is_array( $value ) ) {
        return '';
    }

    $normalized = str_replace( ',', '.', trim( (string) $value ) );

    if ( '' === $normalized ) {
        return '';
    }

    if ( ! is_numeric( $normalized ) ) {
        return '';
    }

    // Convert to float and back to string to normalize the number
    $number = (float) $normalized;

    // If it's a whole number, return it as is
    if ( $number == floor( $number ) ) {
        return (string) (int) $number;
    }

    // Otherwise, remove trailing zeros from decimals
    return rtrim( rtrim( number_format( $number, 10, '.', '' ), '0' ), '.' );
}

function tamgaci_format_numeric_display( $value ) {
    if ( '' === $value ) {
        return '';
    }

    $numeric = str_replace( ',', '.', (string) $value );

    if ( is_numeric( $numeric ) ) {
        $float = (float) $numeric;
        if ( abs( $float - round( $float ) ) < 0.001 ) {
            return (string) round( $float );
        }

        return rtrim( rtrim( number_format( $float, 2, '.', '' ), '0' ), '.' );
    }

    return $value;
}

function tamgaci_sanitize_currency( $value ) {
    if ( is_array( $value ) ) {
        return '';
    }

    $value = trim( (string) $value );

    if ( '' === $value ) {
        return '';
    }

    $normalized = preg_replace( '/[^0-9,\.]/', '', $value );
    $normalized = preg_replace( '/\.(?=.*\.)/', '', $normalized );
    $normalized = str_replace( ',', '.', $normalized );

    if ( is_numeric( $normalized ) ) {
        $float      = (float) $normalized;
        $formatted  = sprintf( '%.2f', $float );
        $formatted  = rtrim( rtrim( $formatted, '0' ), '.' );
        return $formatted;
    }

    return preg_replace( '/\D/', '', $value );
}

function tamgaci_format_currency_display( $value, $symbol = '₺' ) {
    if ( '' === $value ) {
        return '';
    }

    $normalized = preg_replace( '/[^0-9,\.]/', '', (string) $value );
    $normalized = preg_replace( '/\.(?=.*\.)/', '', $normalized );
    $normalized = str_replace( ',', '.', $normalized );

    if ( '' === $normalized ) {
        return '';
    }

    if ( ! is_numeric( $normalized ) ) {
        return trim( $value . ' ' . $symbol );
    }

    $amount   = (float) $normalized;
    $decimals = 0;

    if ( false !== strpos( $normalized, '.' ) ) {
        $fraction = rtrim( substr( $normalized, strpos( $normalized, '.' ) + 1 ), '0' );
        $decimals = min( 2, strlen( $fraction ) );
    }

    $formatted = number_format( $amount, $decimals, ',', '.' );
    $symbol    = apply_filters( 'tamgaci_currency_symbol', $symbol );

    return trim( $formatted . ' ' . $symbol );
}

function tamgaci_vehicle_meta_schema( $post_type ) {
    // Common fields for all vehicle types
    $common = [
        'tamgaci_vehicle_equipment' => [
            'label'       => __( 'Versiyon / Donanım', 'tamgaci' ),
            'type'        => 'text',
            'placeholder' => 'Standart Menzil (V1/V2)',
            'sanitize'    => 'sanitize_text_field',
            'description' => __( 'Donanım paketinin teknik adını buraya girin.', 'tamgaci' ),
        ],
        'tamgaci_vehicle_price' => [
            'label'       => __( 'Fiyat (₺)', 'tamgaci' ),
            'type'        => 'number',
            'placeholder' => '1450000',
            'sanitize'    => 'tamgaci_sanitize_currency',
            'step'        => '0.01',
            'description' => __( 'Araç için güncel satış fiyatını TL cinsinden girin.', 'tamgaci' ),
        ],
        'tamgaci_vehicle_year' => [
            'label'       => __( 'Üretim Yılı', 'tamgaci' ),
            'type'        => 'number',
            'placeholder' => '2025',
            'sanitize'    => 'tamgaci_sanitize_decimal',
            'step'        => '1',
        ],
    ];

    // Optional/Advanced fields (shown at the bottom)
    $optional = [
        'tamgaci_vehicle_icon' => [
            'label'       => __( 'Iconify Simge Anahtarı', 'tamgaci' ),
            'type'        => 'text',
            'placeholder' => 'mdi:car-side',
            'description' => __( 'Iconify kütüphanesi simge adı. Örn: mdi:car-electric', 'tamgaci' ),
            'sanitize'    => 'sanitize_text_field',
        ],
        'tamgaci_vehicle_notes' => [
            'label'       => __( 'Ek Notlar', 'tamgaci' ),
            'type'        => 'textarea',
            'placeholder' => __( 'Opsiyon paketleri, öne çıkan özellikler...', 'tamgaci' ),
            'sanitize'    => 'sanitize_textarea_field',
        ],
    ];

    $base = $common;

    if ( TAMGACI_MOTORCYCLE_POST_TYPE === $post_type ) {
        $extra = [
            'tamgaci_vehicle_engine_displacement' => [
                'label'       => __( 'Motor Hacmi (cc)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '1000',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'cc',
            ],
            'tamgaci_vehicle_power' => [
                'label'       => __( 'Motor Gücü (kW)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '75',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'kW',
            ],
            'tamgaci_vehicle_horsepower' => [
                'label'       => __( 'Beygir Gücü (PS)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '102',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'PS',
            ],
            'tamgaci_vehicle_torque' => [
                'label'       => __( 'Azami Tork (Nm)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '110',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'Nm',
            ],
            'tamgaci_vehicle_fuel_consumption_city' => [
                'label'       => __( 'Şehir İçi Tüketim (L/100 km)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '4.8',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'L/100 km',
            ],
            'tamgaci_vehicle_fuel_consumption_highway' => [
                'label'       => __( 'Şehir Dışı Tüketim (L/100 km)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '3.8',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'L/100 km',
            ],
            'tamgaci_vehicle_fuel_consumption' => [
                'label'       => __( 'WLTP Birleşik Tüketim (L/100 km)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '4.2',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'L/100 km',
                'description' => __( 'Şehir içi + şehir dışı girerseniz otomatik hesaplanır. Ya da bu değeri girerseniz şehir içi/dışı tahmini hesaplanır.', 'tamgaci' ),
            ],
            'tamgaci_vehicle_fuel_tank_capacity' => [
                'label'       => __( 'Yakıt Deposu Kapasitesi (L)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '17',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'L',
            ],
            'tamgaci_vehicle_transmission_type' => [
                'label'       => __( 'Şanzıman Tipi', 'tamgaci' ),
                'type'        => 'select',
                'options'     => [
                    ''         => __( 'Seçiniz...', 'tamgaci' ),
                    'manuel'   => __( 'Manuel', 'tamgaci' ),
                    'otomatik' => __( 'Otomatik', 'tamgaci' ),
                    'cvt'      => __( 'CVT', 'tamgaci' ),
                ],
                'sanitize'    => 'sanitize_text_field',
            ],
            'tamgaci_vehicle_top_speed' => [
                'label'       => __( 'Maks. Hız (km/h)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '200',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'km/h',
            ],
            'tamgaci_vehicle_weight' => [
                'label'       => __( 'Ağırlık (kg)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '195',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'kg',
            ],
            'tamgaci_vehicle_trunk_capacity' => [
                'label'       => __( 'Bagaj/Depo Hacmi (L)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '25',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'L',
                'description' => __( 'Bagaj veya depo hacmi litre cinsinden', 'tamgaci' ),
            ],
        ];
    } elseif ( TAMGACI_ELECTRIC_POST_TYPE === $post_type ) {
        $extra = [
            'tamgaci_vehicle_battery' => [
                'label'       => __( 'Batarya Kapasitesi (kWh)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '52.4',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'kWh',
            ],
            'tamgaci_vehicle_range' => [
                'label'       => __( 'WLTP Menzili (km)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '314',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'km',
            ],
            'tamgaci_vehicle_charging_power' => [
                'label'       => __( 'DC Hızlı Şarj Gücü (kW)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '180',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'kW',
                'description' => __( 'DC şarj sırasında ulaşabileceği maksimum şarj gücü', 'tamgaci' ),
            ],
            'tamgaci_vehicle_ac_charging_power' => [
                'label'       => __( 'AC Şarj Gücü (kW)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '11',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'kW',
                'description' => __( 'AC şarj sırasında ulaşabileceği maksimum şarj gücü (genellikle 7.4 kW veya 11 kW)', 'tamgaci' ),
            ],
            'tamgaci_vehicle_power' => [
                'label'       => __( 'Motor Gücü (kW)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '150',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'kW',
            ],
            'tamgaci_vehicle_horsepower' => [
                'label'       => __( 'Beygir Gücü (PS)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '204',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'PS',
            ],
            'tamgaci_vehicle_torque' => [
                'label'       => __( 'Azami Tork (Nm)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '350',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'Nm',
            ],
            'tamgaci_vehicle_acceleration' => [
                'label'       => __( '0-100 km/h', 'tamgaci' ),
                'type'        => 'text',
                'placeholder' => '7.9 sn',
                'sanitize'    => 'sanitize_text_field',
            ],
            'tamgaci_vehicle_top_speed' => [
                'label'       => __( 'Maks. Hız (km/h)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '160',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'km/h',
            ],
            'tamgaci_vehicle_consumption' => [
                'label'       => __( 'Tüketim (kWh/100 km)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '16.7',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'kWh/100 km',
            ],
            'tamgaci_vehicle_drive' => [
                'label'       => __( 'Çekiş Sistemi', 'tamgaci' ),
                'type'        => 'select',
                'options'     => [
                    ''    => __( 'Seçiniz...', 'tamgaci' ),
                    'fwd' => __( 'Önden Çekiş (FWD)', 'tamgaci' ),
                    'rwd' => __( 'Arkadan İtiş (RWD)', 'tamgaci' ),
                    'awd' => __( 'Dört Tekerlekten Çekiş (AWD)', 'tamgaci' ),
                ],
                'sanitize'    => 'sanitize_text_field',
            ],
            'tamgaci_vehicle_trunk_capacity' => [
                'label'       => __( 'Bagaj Hacmi (L)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '425',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'L',
                'description' => __( 'Bagaj hacmi litre cinsinden', 'tamgaci' ),
            ],
        ];
    } else {
        // Combustion/Hybrid vehicles - simplified
        $extra = [
            'tamgaci_vehicle_engine_description' => [
                'label'       => __( 'Motor Açıklaması', 'tamgaci' ),
                'type'        => 'text',
                'placeholder' => '1.5 TSI 150 PS DSG',
                'sanitize'    => 'sanitize_text_field',
                'description' => __( 'Motor tipini ve özelliklerini girin.', 'tamgaci' ),
            ],
            'tamgaci_vehicle_fuel_type' => [
                'label'       => __( 'Yakıt Tipi', 'tamgaci' ),
                'type'        => 'select',
                'options'     => [
                    ''        => __( 'Seçiniz...', 'tamgaci' ),
                    'benzin'  => __( 'Benzin', 'tamgaci' ),
                    'dizel'   => __( 'Dizel', 'tamgaci' ),
                    'lpg'     => __( 'LPG', 'tamgaci' ),
                    'mhev'    => __( 'Mild Hybrid (mHEV)', 'tamgaci' ),
                    'hybrid'  => __( 'Hybrid', 'tamgaci' ),
                    'phev'    => __( 'Plug-in Hybrid (PHEV)', 'tamgaci' ),
                ],
                'sanitize'    => 'sanitize_text_field',
            ],
            'tamgaci_vehicle_engine_displacement' => [
                'label'       => __( 'Silindir Hacmi (cc)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '1498',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'cc',
            ],
            'tamgaci_vehicle_cylinder_count' => [
                'label'       => __( 'Silindir Sayısı', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '4',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
            ],
            'tamgaci_vehicle_power' => [
                'label'       => __( 'Motor Gücü (kW)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '110',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'kW',
                'description' => __( 'Beygir gücü girerseniz otomatik hesaplanır. Ya da bu değeri girerseniz beygir gücü tahmini hesaplanır. (1 kW = 1.35962 PS)', 'tamgaci' ),
            ],
            'tamgaci_vehicle_horsepower' => [
                'label'       => __( 'Beygir Gücü (PS)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '150',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'PS',
                'description' => __( 'Motor gücü girerseniz otomatik hesaplanır. Ya da bu değeri girerseniz motor gücü tahmini hesaplanır. (1 kW = 1.35962 PS)', 'tamgaci' ),
            ],
            'tamgaci_vehicle_torque' => [
                'label'       => __( 'Azami Tork (Nm)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '250',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'Nm',
            ],
            'tamgaci_vehicle_fuel_consumption_city' => [
                'label'       => __( 'Şehir İçi Tüketim (L/100 km)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '6.5',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'L/100 km',
            ],
            'tamgaci_vehicle_fuel_consumption_highway' => [
                'label'       => __( 'Şehir Dışı Tüketim (L/100 km)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '4.8',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'L/100 km',
            ],
            'tamgaci_vehicle_fuel_consumption' => [
                'label'       => __( 'WLTP Birleşik Tüketim (L/100 km)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '5.8',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '0.1',
                'unit'        => 'L/100 km',
                'description' => __( 'Şehir içi + şehir dışı girerseniz otomatik hesaplanır. Ya da bu değeri girerseniz şehir içi/dışı tahmini hesaplanır.', 'tamgaci' ),
            ],
            'tamgaci_vehicle_fuel_tank_capacity' => [
                'label'       => __( 'Yakıt Deposu Kapasitesi (L)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '50',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'L',
            ],
            'tamgaci_vehicle_transmission_type' => [
                'label'       => __( 'Şanzıman Tipi', 'tamgaci' ),
                'type'        => 'select',
                'options'     => [
                    ''         => __( 'Seçiniz...', 'tamgaci' ),
                    'manuel'   => __( 'Manuel', 'tamgaci' ),
                    'otomatik' => __( 'Otomatik', 'tamgaci' ),
                    'cvt'      => __( 'CVT', 'tamgaci' ),
                    'dsg'      => __( 'DSG', 'tamgaci' ),
                ],
                'sanitize'    => 'sanitize_text_field',
            ],
            'tamgaci_vehicle_gear_count' => [
                'label'       => __( 'Vites Sayısı', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '6',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
            ],
            'tamgaci_vehicle_acceleration' => [
                'label'       => __( '0-100 km/h', 'tamgaci' ),
                'type'        => 'text',
                'placeholder' => '8.9 sn',
                'sanitize'    => 'sanitize_text_field',
            ],
            'tamgaci_vehicle_top_speed' => [
                'label'       => __( 'Maks. Hız (km/h)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '210',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'km/h',
            ],
            'tamgaci_vehicle_drive' => [
                'label'       => __( 'Çekiş Sistemi', 'tamgaci' ),
                'type'        => 'select',
                'options'     => [
                    ''    => __( 'Seçiniz...', 'tamgaci' ),
                    'fwd' => __( 'Önden Çekiş (FWD)', 'tamgaci' ),
                    'rwd' => __( 'Arkadan İtiş (RWD)', 'tamgaci' ),
                    'awd' => __( 'Dört Tekerlekten Çekiş (AWD)', 'tamgaci' ),
                ],
                'sanitize'    => 'sanitize_text_field',
            ],
            'tamgaci_vehicle_trunk_capacity' => [
                'label'       => __( 'Bagaj Hacmi (L)', 'tamgaci' ),
                'type'        => 'number',
                'placeholder' => '425',
                'sanitize'    => 'tamgaci_sanitize_decimal',
                'step'        => '1',
                'unit'        => 'L',
                'description' => __( 'Bagaj hacmi litre cinsinden', 'tamgaci' ),
            ],
        ];
    }

    return array_merge( $base, $extra, $optional );
}

function tamgaci_register_vehicle_meta() {
    foreach ( tamgaci_get_vehicle_post_types() as $post_type ) {
        foreach ( tamgaci_vehicle_meta_schema( $post_type ) as $key => $config ) {
            register_post_meta(
                $post_type,
                $key,
                [
                    'single'            => true,
                    'type'              => 'string',
                    'show_in_rest'      => true,
                    'sanitize_callback' => $config['sanitize'],
                    'auth_callback'     => function () {
                        return current_user_can( 'edit_posts' );
                    },
                    'default'           => '',
                ]
            );
        }
    }
}
add_action( 'init', 'tamgaci_register_vehicle_meta', 10 );

function tamgaci_add_vehicle_meta_box() {
    foreach ( tamgaci_get_vehicle_post_types() as $post_type ) {
        add_meta_box(
            'tamgaci-vehicle-specs',
            __( 'Araç Teknik Özellikleri', 'tamgaci' ),
            'tamgaci_render_vehicle_meta_box',
            $post_type,
            'normal',
            'default'
        );
    }
}
add_action( 'add_meta_boxes', 'tamgaci_add_vehicle_meta_box' );

function tamgaci_render_vehicle_meta_box( $post ) {
    wp_nonce_field( 'tamgaci_vehicle_meta', 'tamgaci_vehicle_meta_nonce' );

    $post_type = get_post_type( $post );
    $schema    = tamgaci_vehicle_meta_schema( $post_type );

    // Gemini AI Auto-fill section
    $api_key = get_option( 'tamgaci_gemini_api_key', '' );
    ?>
    <div class="tamgaci-gemini-autofill" style="background: #f0f6fc; border: 1px solid #0969da; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
        <h4 style="margin-top: 0; color: #0969da;">
            <span class="dashicons dashicons-superhero" style="vertical-align: middle;"></span>
            <?php _e( 'AI ile Otomatik Doldur', 'tamgaci' ); ?>
        </h4>

        <?php if ( empty( $api_key ) ) : ?>
            <p style="color: #d1242f;">
                <?php
                printf(
                    __( 'Gemini API key tanımlanmamış. Lütfen <a href="%s">Ayarlar</a> sayfasından API key ekleyin.', 'tamgaci' ),
                    admin_url( 'options-general.php?page=tamgaci-settings' )
                );
                ?>
            </p>
        <?php else : ?>
            <p style="margin: 0 0 10px 0;">
                <?php _e( 'Aracın teknik özelliklerini metin olarak veya görsel yükleyerek AI ile analiz edin.', 'tamgaci' ); ?>
            </p>

            <!-- Tabs for Text vs Image -->
            <div style="margin-bottom: 10px;">
                <button type="button" class="button" id="tamgaci-tab-text" style="margin-right: 5px; background: #0969da; color: white; border-color: #0969da;">
                    <span class="dashicons dashicons-text" style="vertical-align: middle;"></span>
                    <?php _e( 'Metin', 'tamgaci' ); ?>
                </button>
                <button type="button" class="button" id="tamgaci-tab-image" style="background: white; color: #0969da;">
                    <span class="dashicons dashicons-camera" style="vertical-align: middle;"></span>
                    <?php _e( 'Görsel', 'tamgaci' ); ?>
                </button>
            </div>

            <!-- Text input panel -->
            <div id="tamgaci-panel-text">
                <textarea
                    id="tamgaci-gemini-input"
                    rows="6"
                    style="width: 100%; font-family: monospace; font-size: 13px; padding: 8px;"
                    placeholder="<?php esc_attr_e( 'Örnek:\nVolkswagen Golf 1.5 TSI 2024\nMotor Gücü: 110 kW / 150 PS\nSilindir Hacmi: 1498 cc\nYakıt Tipi: Benzin\nŞehir İçi Tüketim: 6.5 L/100km\n...', 'tamgaci' ); ?>"
                ></textarea>
            </div>

            <!-- Image paste panel -->
            <div id="tamgaci-panel-image" style="display: none;">
                <div id="tamgaci-paste-area"
                     contenteditable="true"
                     style="border: 2px dashed #0969da; border-radius: 6px; padding: 40px 20px; text-align: center; background: white; min-height: 200px; cursor: text; outline: none; position: relative;"
                     tabindex="0">
                    <div id="tamgaci-paste-placeholder" style="pointer-events: none; color: #666;">
                        <span class="dashicons dashicons-images-alt2" style="font-size: 48px; width: 48px; height: 48px; color: #0969da;"></span>
                        <br><br>
                        <?php _e( 'Görseli buraya yapıştırın (Ctrl+V / Cmd+V)', 'tamgaci' ); ?>
                        <br>
                        <span style="font-size: 12px;"><?php _e( 'Ekran görüntüsü, kopyalanmış görsel veya dosyadan yapıştırma', 'tamgaci' ); ?></span>
                    </div>
                    <div id="tamgaci-image-preview"></div>
                </div>
                <p style="margin-top: 10px; font-size: 12px; color: #666;">
                    <?php _e( 'Tüm görsel formatları desteklenir. Maksimum boyut: 4MB', 'tamgaci' ); ?>
                </p>
            </div>

            <p style="margin: 10px 0 0 0;">
                <button type="button" id="tamgaci-gemini-autofill-btn" class="button button-primary button-large">
                    <span class="dashicons dashicons-superhero" style="vertical-align: middle;"></span>
                    <?php _e( 'AI ile Doldur', 'tamgaci' ); ?>
                </button>
                <span id="tamgaci-gemini-status" style="margin-left: 10px;"></span>
            </p>
        <?php endif; ?>
    </div>
    <?php

    echo '<div class="tamgaci-meta-grid">';

    foreach ( $schema as $key => $config ) {
        $value = get_post_meta( $post->ID, $key, true );

        echo '<label>';
        echo '<span>' . esc_html( $config['label'] ) . '</span>';

        $placeholder = isset( $config['placeholder'] ) ? $config['placeholder'] : '';

        if ( 'textarea' === $config['type'] ) {
            printf(
                '<textarea name="%1$s" rows="3" placeholder="%2$s">%3$s</textarea>',
                esc_attr( $key ),
                esc_attr( $placeholder ),
                esc_textarea( $value )
            );
        } elseif ( 'select' === $config['type'] && isset( $config['options'] ) ) {
            echo '<select name="' . esc_attr( $key ) . '">';
            foreach ( $config['options'] as $option_value => $option_label ) {
                printf(
                    '<option value="%1$s"%3$s>%2$s</option>',
                    esc_attr( $option_value ),
                    esc_html( $option_label ),
                    selected( $value, $option_value, false )
                );
            }
            echo '</select>';
        } else {
            $input_type = ( 'number' === $config['type'] ) ? 'number' : 'text';
            $step_attr  = ( 'number' === $config['type'] && isset( $config['step'] ) ) ? sprintf( ' step="%s"', esc_attr( $config['step'] ) ) : '';
            printf(
                '<input type="%4$s" name="%1$s" value="%2$s" placeholder="%3$s"%5$s />',
                esc_attr( $key ),
                esc_attr( $value ),
                esc_attr( $placeholder ),
                esc_attr( $input_type ),
                $step_attr
            );
        }

        if ( ! empty( $config['description'] ) ) {
            echo '<span class="description">' . esc_html( $config['description'] ) . '</span>';
        }

        echo '</label>';
    }

    echo '</div>';
}

function tamgaci_save_vehicle_meta( $post_id, $post, $update ) {
    if ( ! in_array( $post->post_type, tamgaci_get_vehicle_post_types(), true ) ) {
        return;
    }

    if ( ! isset( $_POST['tamgaci_vehicle_meta_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['tamgaci_vehicle_meta_nonce'] ), 'tamgaci_vehicle_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $schema = tamgaci_vehicle_meta_schema( $post->post_type );

    // Store values for potential calculations
    $saved_values = [];

    foreach ( $schema as $key => $config ) {
        $raw_value = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
        $sanitize  = $config['sanitize'];

        if ( is_callable( $sanitize ) ) {
            $value = call_user_func( $sanitize, $raw_value );
        } else {
            $value = sanitize_text_field( $raw_value );
        }

        update_post_meta( $post_id, $key, $value );
        $saved_values[ $key ] = $value;
    }

    // Fuel consumption bi-directional calculation
    $city = isset( $saved_values['tamgaci_vehicle_fuel_consumption_city'] ) ? (float) $saved_values['tamgaci_vehicle_fuel_consumption_city'] : 0;
    $highway = isset( $saved_values['tamgaci_vehicle_fuel_consumption_highway'] ) ? (float) $saved_values['tamgaci_vehicle_fuel_consumption_highway'] : 0;
    $average = isset( $saved_values['tamgaci_vehicle_fuel_consumption'] ) ? (float) $saved_values['tamgaci_vehicle_fuel_consumption'] : 0;

    // If city and highway are provided, calculate average
    if ( $city > 0 && $highway > 0 ) {
        // Calculate weighted average (55% city, 45% highway as per WLTP)
        $calculated_average = round( ( $city * 0.55 + $highway * 0.45 ), 1 );
        update_post_meta( $post_id, 'tamgaci_vehicle_fuel_consumption', $calculated_average );
    }
    // If average is provided but city/highway are empty, estimate them
    elseif ( $average > 0 && $city == 0 && $highway == 0 ) {
        // Reverse calculation: estimate city and highway from average
        // City is typically 15% higher than average, highway 10% lower
        $estimated_city = round( $average * 1.15, 1 );
        $estimated_highway = round( $average * 0.90, 1 );
        update_post_meta( $post_id, 'tamgaci_vehicle_fuel_consumption_city', $estimated_city );
        update_post_meta( $post_id, 'tamgaci_vehicle_fuel_consumption_highway', $estimated_highway );
    }

    // Power bi-directional calculation (kW ↔ PS)
    // Conversion factor: 1 kW = 1.35962 PS (DIN standard)
    $power_kw = isset( $saved_values['tamgaci_vehicle_power'] ) ? (float) $saved_values['tamgaci_vehicle_power'] : 0;
    $power_ps = isset( $saved_values['tamgaci_vehicle_horsepower'] ) ? (float) $saved_values['tamgaci_vehicle_horsepower'] : 0;

    // If kW is provided, calculate PS
    if ( $power_kw > 0 && $power_ps == 0 ) {
        $calculated_ps = round( $power_kw * 1.35962 );
        update_post_meta( $post_id, 'tamgaci_vehicle_horsepower', $calculated_ps );
    }
    // If PS is provided, calculate kW
    elseif ( $power_ps > 0 && $power_kw == 0 ) {
        $calculated_kw = round( $power_ps / 1.35962, 1 );
        update_post_meta( $post_id, 'tamgaci_vehicle_power', $calculated_kw );
    }
}
add_action( 'save_post', 'tamgaci_save_vehicle_meta', 10, 3 );

/**
 * Get brand names (top-level only) from vehicle_brand taxonomy
 */
function tamgaci_get_vehicle_brand_names( $post_id ) {
    $terms = get_the_terms( $post_id, 'vehicle_brand' );

    if ( ! $terms || is_wp_error( $terms ) ) {
        return [];
    }

    $brands = [];
    foreach ( $terms as $term ) {
        // Only include top-level brands (parent = 0)
        if ( $term->parent === 0 ) {
            $brands[] = $term->name;
        }
    }

    return $brands;
}

/**
 * Get model names (child terms only) from vehicle_brand taxonomy
 */
function tamgaci_get_vehicle_model_names( $post_id ) {
    $terms = get_the_terms( $post_id, 'vehicle_brand' );

    if ( ! $terms || is_wp_error( $terms ) ) {
        return [];
    }

    $models = [];
    foreach ( $terms as $term ) {
        // Only include models (has parent, but parent is top-level brand)
        if ( $term->parent > 0 ) {
            $parent_term = get_term( $term->parent, 'vehicle_brand' );
            if ( $parent_term && ! is_wp_error( $parent_term ) && $parent_term->parent === 0 ) {
                // Parent is a brand, so this is a model
                $models[] = $term->name;
            }
        }
    }

    return $models;
}

/**
 * Get equipment package names (grandchild terms) from vehicle_brand taxonomy
 */
function tamgaci_get_vehicle_equipment_names( $post_id ) {
    $terms = get_the_terms( $post_id, 'vehicle_brand' );

    if ( ! $terms || is_wp_error( $terms ) ) {
        return [];
    }

    $equipment = [];
    foreach ( $terms as $term ) {
        // Only include equipment packages (has parent, and parent has parent)
        if ( $term->parent > 0 ) {
            $parent_term = get_term( $term->parent, 'vehicle_brand' );
            if ( $parent_term && ! is_wp_error( $parent_term ) && $parent_term->parent > 0 ) {
                // Parent is a model (has a brand parent), so this is equipment
                $equipment[] = $term->name;
            }
        }
    }

    return $equipment;
}

function tamgaci_get_vehicle_term_names( $post_id, $taxonomy ) {
    $terms = get_the_terms( $post_id, $taxonomy );

    if ( ! $terms || is_wp_error( $terms ) ) {
        return [];
    }

    return array_map(
        static function ( $term ) use ( $taxonomy ) {
            if ( is_taxonomy_hierarchical( $taxonomy ) ) {
                $ancestors = get_term_parents_list(
                    $term->term_id,
                    $taxonomy,
                    [
                        'format'     => 'name',
                        'separator'  => ' › ',
                        'inclusive'  => false,
                        'link'       => false,
                    ]
                );

                $ancestors = $ancestors ? trim( $ancestors, ' › ' ) : '';

                return $ancestors
                    ? $ancestors . ' › ' . $term->name
                    : $term->name;
            }

            return $term->name;
        },
        $terms
    );
}

function tamgaci_get_primary_term( $post_id, $taxonomy ) {
    $terms = wp_get_post_terms( $post_id, $taxonomy );

    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        return null;
    }

    usort(
        $terms,
        static function ( $a, $b ) use ( $taxonomy ) {
            $depth_a = count( get_ancestors( $a->term_id, $taxonomy ) );
            $depth_b = count( get_ancestors( $b->term_id, $taxonomy ) );

            if ( $depth_a === $depth_b ) {
                return $a->term_id <=> $b->term_id;
            }

            return $depth_b <=> $depth_a;
        }
    );

    return $terms[0];
}

function tamgaci_get_vehicle_permalink_segments( $post_id ) {
    $segments = [];

    $primary_term = tamgaci_get_primary_term( $post_id, 'vehicle_brand' );
    if ( ! $primary_term ) {
        return $segments;
    }

    // Build hierarchy from current term to root
    $hierarchy = [];
    $current   = $primary_term;

    while ( $current && ! is_wp_error( $current ) ) {
        array_unshift( $hierarchy, $current->slug );
        if ( $current->parent > 0 ) {
            $current = get_term( $current->parent, 'vehicle_brand' );
        } else {
            break;
        }
    }

    // Add all hierarchy slugs (Brand > Model > Equipment)
    $segments = $hierarchy;

    // Optionally add custom equipment detail
    $equipment_detail = get_post_meta( $post_id, 'tamgaci_vehicle_equipment', true );
    if ( $equipment_detail ) {
        $detail_slug = sanitize_title( $equipment_detail );
        if ( $detail_slug && ! in_array( $detail_slug, $segments, true ) ) {
            $segments[] = $detail_slug;
        }
    }

    // Add model year at the end if available
    $year_terms = get_the_terms( $post_id, 'vehicle_model_year' );
    if ( ! empty( $year_terms ) && ! is_wp_error( $year_terms ) ) {
        $year_term = array_shift( $year_terms );
        $segments[] = $year_term->slug;
    }

    return array_filter( $segments );
}

function tamgaci_filter_vehicle_permalink( $permalink, $post ) {
    if ( ! in_array( $post->post_type, tamgaci_get_vehicle_post_types(), true ) ) {
        return $permalink;
    }

    $segments = tamgaci_get_vehicle_permalink_segments( $post->ID );

    if ( empty( $segments ) ) {
        return $permalink;
    }

    // Get the base slug for the post type
    $post_type_obj = get_post_type_object( $post->post_type );
    $base_slug = $post_type_obj->rewrite['slug'] ?? $post->post_type;

    // Build the hierarchical URL: /base-slug/brand/model/equipment/post-name/
    $hierarchy_path = implode( '/', $segments );
    $new_permalink = home_url( '/' . $base_slug . '/' . $hierarchy_path . '/' );

    return $new_permalink;
}
add_filter( 'post_type_link', 'tamgaci_filter_vehicle_permalink', 10, 2 );

function tamgaci_register_vehicle_permalink_rules() {
    $post_types = tamgaci_get_vehicle_post_types();

    foreach ( $post_types as $post_type ) {
        $post_type_obj = get_post_type_object( $post_type );
        if ( ! $post_type_obj ) {
            continue;
        }

        $slug = $post_type_obj->rewrite['slug'] ?? $post_type;

        // Add rewrite rules for hierarchical structure
        // The post_name in database is the full concatenated slug (e.g., tesla-model-s-plaid)
        // We need to match the entire path and use it to find the post

        // 5 levels: brand/model/equipment/detail/year
        add_rewrite_rule(
            '^' . $slug . '/([^/]+)/([^/]+)/([^/]+)/([^/]+)/([^/]+)/?$',
            'index.php?post_type=' . $post_type . '&name=$matches[1]-$matches[2]-$matches[3]-$matches[4]-$matches[5]',
            'top'
        );

        // 4 levels: brand/model/equipment/year
        add_rewrite_rule(
            '^' . $slug . '/([^/]+)/([^/]+)/([^/]+)/([^/]+)/?$',
            'index.php?post_type=' . $post_type . '&name=$matches[1]-$matches[2]-$matches[3]-$matches[4]',
            'top'
        );

        // 3 levels: brand/model/year
        add_rewrite_rule(
            '^' . $slug . '/([^/]+)/([^/]+)/([^/]+)/?$',
            'index.php?post_type=' . $post_type . '&name=$matches[1]-$matches[2]-$matches[3]',
            'top'
        );

        // 2 levels: brand/model
        add_rewrite_rule(
            '^' . $slug . '/([^/]+)/([^/]+)/?$',
            'index.php?post_type=' . $post_type . '&name=$matches[1]-$matches[2]',
            'top'
        );

        // 1 level: brand only (fallback)
        add_rewrite_rule(
            '^' . $slug . '/([^/]+)/?$',
            'index.php?post_type=' . $post_type . '&name=$matches[1]',
            'top'
        );
    }
}
add_action( 'init', 'tamgaci_register_vehicle_permalink_rules', 20 );


// Removed automatic taxonomy hierarchy sync to avoid unintended parent reassignment.

function tamgaci_generate_comparison_key( $vehicle_ids ) {
    sort( $vehicle_ids, SORT_NUMERIC );
    return md5( implode( '-', $vehicle_ids ) );
}

function tamgaci_get_vehicle_meta_snapshot( $vehicle_id ) {
    $data = tamgaci_prepare_vehicle_display_data( $vehicle_id );

    if ( ! $data ) {
        return null;
    }

    return [
        'id'         => $vehicle_id,
        'title'      => tamgaci_get_vehicle_display_title( $vehicle_id ),
        'permalink'  => get_permalink( $vehicle_id ),
        'price'      => $data['price'] ?? '',
        'powertrain' => implode( ' / ', $data['powertrain'] ?? [] ),
        'equipment'  => $data['equipment'] ?? '',
        'specs'      => $data['specs'] ?? [],
        'image'      => $data['image'] ?? '',
    ];
}

function tamgaci_get_vehicle_price_value( $vehicle_id ) {
    $price_raw = get_post_meta( $vehicle_id, 'tamgaci_vehicle_price', true );

    if ( '' === $price_raw ) {
        return null;
    }

    $normalized = preg_replace( '/[\s\xa0]/u', '', (string) $price_raw );
    $normalized = str_replace( '.', '', $normalized );
    $normalized = str_replace( ',', '.', $normalized );

    if ( ! is_numeric( $normalized ) ) {
        return null;
    }

    return (float) $normalized;
}

function tamgaci_get_vehicle_display_title( $vehicle_id ) {
    $brand_term = tamgaci_get_primary_term( $vehicle_id, 'vehicle_brand' );
    $detail     = get_post_meta( $vehicle_id, 'tamgaci_vehicle_equipment', true );

    $parts = [];

    // Get brand, model, and equipment from hierarchical brand taxonomy
    if ( $brand_term ) {
        $hierarchy = [];
        $current   = $brand_term;

        // Build hierarchy from current term to root
        while ( $current && ! is_wp_error( $current ) ) {
            array_unshift( $hierarchy, $current->name );
            if ( $current->parent > 0 ) {
                $current = get_term( $current->parent, 'vehicle_brand' );
            } else {
                break;
            }
        }

        // Add all hierarchy parts (Brand > Model > Equipment)
        $parts = array_merge( $parts, $hierarchy );
    }

    // Don't add custom equipment detail to title to avoid duplication
    // Equipment info should only come from taxonomy hierarchy

    $title = trim( preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $parts ) ) ) );

    return $title ?: get_the_title( $vehicle_id );
}

function tamgaci_get_vehicle_profile_signature( $vehicle_id ) {
    $brand_term = tamgaci_get_primary_term( $vehicle_id, 'vehicle_brand' );
    $detail     = get_post_meta( $vehicle_id, 'tamgaci_vehicle_equipment', true );

    $brand_slug     = '';
    $model_slug     = '';
    $equipment_slug = '';

    // Get brand, model, and equipment from hierarchical brand taxonomy
    if ( $brand_term ) {
        $hierarchy = [];
        $current   = $brand_term;

        // Build hierarchy from current term to root
        while ( $current && ! is_wp_error( $current ) ) {
            array_unshift( $hierarchy, $current );
            if ( $current->parent > 0 ) {
                $current = get_term( $current->parent, 'vehicle_brand' );
            } else {
                break;
            }
        }

        // Extract slugs based on position in hierarchy
        if ( count( $hierarchy ) >= 1 ) {
            $brand_slug = $hierarchy[0]->slug;
        }
        if ( count( $hierarchy ) >= 2 ) {
            $model_slug = $hierarchy[1]->slug;
        }
        if ( count( $hierarchy ) >= 3 ) {
            $equipment_slug = $hierarchy[2]->slug;
        }
    }

    return implode(
        '|',
        [
            $brand_slug,
            $model_slug,
            $equipment_slug,
            $detail ? sanitize_title( $detail ) : '',
        ]
    );
}

function tamgaci_get_vehicle_meta_snapshot_cards( $vehicle_ids ) {
    $snapshots = [];

    foreach ( $vehicle_ids as $vehicle_id ) {
        $snapshot = tamgaci_get_vehicle_meta_snapshot( $vehicle_id );
        if ( $snapshot ) {
            $snapshots[] = $snapshot;
        }
    }

    return $snapshots;
}

function tamgaci_create_vehicle_comparison_post( $vehicle_ids ) {
    $vehicle_ids = array_unique( array_map( 'absint', $vehicle_ids ) );

    if ( count( $vehicle_ids ) < 2 ) {
        return 0;
    }

    $meta_snapshot = [];

    foreach ( $vehicle_ids as $vehicle_id ) {
        $snapshot = tamgaci_get_vehicle_meta_snapshot( $vehicle_id );
        if ( ! $snapshot ) {
            return 0;
        }
        $meta_snapshot[ $vehicle_id ] = $snapshot;
    }

    $key = tamgaci_generate_comparison_key( $vehicle_ids );

    $vehicle_titles = array_map( 'tamgaci_get_vehicle_display_title', $vehicle_ids );

    $slug_seed = [];

    foreach ( $vehicle_ids as $seed_vehicle_id ) {
        $seed_title = sanitize_title( tamgaci_get_vehicle_display_title( $seed_vehicle_id ) );
        $segments   = array_slice( explode( '-', $seed_title ), 0, 2 );
        $slug_seed[] = implode( '-', array_filter( $segments ) );
    }

    $slug_hash   = substr( $key, 0, 6 );
    $slug_core   = implode( '-vs-', array_filter( $slug_seed ) );
    $post_slug   = sanitize_title( $slug_core ? $slug_core . '-' . $slug_hash : $slug_hash );
    $post_title  = trim( implode( ' vs ', array_filter( $vehicle_titles ) ) );

    $existing = get_posts( [
        'post_type'      => 'vehicle_comparison',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'meta_key'       => 'tamgaci_comparison_key',
        'meta_value'     => $key,
        'fields'         => 'ids',
    ] );

    if ( $existing ) {
        $existing_id = (int) $existing[0];

        $comparison_post = get_post( $existing_id );

        if ( $comparison_post instanceof WP_Post ) {
            $update_args  = [ 'ID' => $existing_id ];
            $needs_update = false;

            if ( $post_title && $comparison_post->post_title !== $post_title ) {
                $update_args['post_title'] = $post_title;
                $needs_update              = true;
            }

            if ( $post_slug && $comparison_post->post_name !== $post_slug ) {
                $update_args['post_name'] = $post_slug;
                $needs_update             = true;
            }

            if ( 'publish' !== $comparison_post->post_status ) {
                $update_args['post_status'] = 'publish';
                $needs_update               = true;
            }

            if ( $needs_update ) {
                wp_update_post( $update_args );
            }
        }

        update_post_meta( $existing_id, 'tamgaci_comparison_key', $key );
        update_post_meta( $existing_id, 'tamgaci_comparison_vehicle_ids', $vehicle_ids );
        update_post_meta( $existing_id, 'tamgaci_comparison_snapshot', $meta_snapshot );

        return $existing_id;
    }

    $post_id = wp_insert_post( [
        'post_type'   => 'vehicle_comparison',
        'post_status' => 'publish',
        'post_title'  => $post_title,
        'post_name'   => $post_slug,
        'post_author' => get_current_user_id(),
    ] );

    if ( is_wp_error( $post_id ) || ! $post_id ) {
        return 0;
    }

    update_post_meta( $post_id, 'tamgaci_comparison_key', $key );
    update_post_meta( $post_id, 'tamgaci_comparison_vehicle_ids', $vehicle_ids );
    update_post_meta( $post_id, 'tamgaci_comparison_snapshot', $meta_snapshot );

    return $post_id;
}

function tamgaci_build_vehicle_comparisons( $vehicle_id, $post = null, $update = false ) {
    $vehicle_id = absint( $vehicle_id );

    if ( ! $vehicle_id || ! in_array( get_post_type( $vehicle_id ), tamgaci_get_vehicle_post_types(), true ) ) {
        return;
    }

    $vehicle_post = get_post( $vehicle_id );

    if ( ! $vehicle_post instanceof WP_Post || 'publish' !== $vehicle_post->post_status ) {
        return;
    }

    // Prevent running during autosave or when post is being created
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( wp_is_post_autosave( $vehicle_id ) || wp_is_post_revision( $vehicle_id ) ) {
        return;
    }

    $current_price     = tamgaci_get_vehicle_price_value( $vehicle_id );
    $current_signature = tamgaci_get_vehicle_profile_signature( $vehicle_id );
    $current_post_type = get_post_type( $vehicle_id );

    $candidate_ids = get_posts( [
        'post_type'      => $current_post_type, // Only compare with same post type
        'post_status'    => 'publish',
        'posts_per_page' => 30,
        'post__not_in'   => [ $vehicle_id ],
        'fields'         => 'ids',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    ] );

    if ( empty( $candidate_ids ) ) {
        return;
    }

    $current_brand = tamgaci_get_primary_term( $vehicle_id, 'vehicle_brand' );

    $scored = [];

    foreach ( $candidate_ids as $candidate_id ) {
        $candidate_signature = tamgaci_get_vehicle_profile_signature( $candidate_id );
        if ( $candidate_signature === $current_signature ) {
            continue;
        }

        $candidate_price = tamgaci_get_vehicle_price_value( $candidate_id );
        $brand_match     = 0;

        if ( $current_brand ) {
            $candidate_brand = tamgaci_get_primary_term( $candidate_id, 'vehicle_brand' );
            $brand_match     = ( $candidate_brand && $candidate_brand->term_id === $current_brand->term_id ) ? 1 : 0;
        }

        $price_diff = null;

        if ( null !== $current_price && null !== $candidate_price ) {
            $price_diff = abs( $current_price - $candidate_price );
        }

        $scored[] = [
            'id'         => $candidate_id,
            'brand'      => $brand_match,
            'price_diff' => $price_diff,
        ];
    }

    usort(
        $scored,
        static function ( $a, $b ) {
            if ( $a['brand'] !== $b['brand'] ) {
                return $b['brand'] <=> $a['brand'];
            }

            if ( $a['price_diff'] === $b['price_diff'] ) {
                return $a['id'] <=> $b['id'];
            }

            if ( null === $a['price_diff'] ) {
                return 1;
            }

            if ( null === $b['price_diff'] ) {
                return -1;
            }

            return $a['price_diff'] <=> $b['price_diff'];
        }
    );

    $created = 0;

    foreach ( $scored as $candidate ) {
        $result = tamgaci_create_vehicle_comparison_post( [ $vehicle_id, $candidate['id'] ] );
        if ( $result ) {
            $created++;
        }

        if ( $created >= 3 ) {
            break;
        }
    }
}
// Enable automatic comparison building when a vehicle is published
add_action( 'save_post', 'tamgaci_build_vehicle_comparisons', 90, 3 );

function tamgaci_seed_all_vehicle_comparisons() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Bu işlem için yetkiniz yok.', 'tamgaci' ) );
    }

    check_admin_referer( 'tamgaci_seed_comparisons' );

    remove_action( 'save_post', 'tamgaci_build_vehicle_comparisons', 90 );

    // Check if a specific post type is requested
    $requested_post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( $_GET['post_type'] ) : '';
    $post_types = $requested_post_type && in_array( $requested_post_type, tamgaci_get_vehicle_post_types(), true )
        ? [ $requested_post_type ]
        : tamgaci_get_vehicle_post_types();

    $vehicle_posts = get_posts( [
        'post_type'      => $post_types,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ] );

    foreach ( $vehicle_posts as $vehicle_id ) {
        tamgaci_build_vehicle_comparisons( $vehicle_id );
    }

    add_action( 'save_post', 'tamgaci_build_vehicle_comparisons', 90 );

    $redirect_args = [ 'tamgaci_seeded' => '1' ];
    if ( $requested_post_type ) {
        $redirect_args['post_type_seeded'] = $requested_post_type;
    }

    wp_safe_redirect( add_query_arg( $redirect_args, wp_get_referer() ?: admin_url() ) );
    exit;
}
add_action( 'admin_post_tamgaci_seed_comparisons', 'tamgaci_seed_all_vehicle_comparisons' );

function tamgaci_delete_all_vehicle_comparisons() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Bu işlem için yetkiniz yok.', 'tamgaci' ) );
    }

    check_admin_referer( 'tamgaci_delete_comparisons' );

    // Check if a specific post type is requested
    $requested_post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( $_GET['post_type'] ) : '';

    $comparison_posts = get_posts( [
        'post_type'      => 'vehicle_comparison',
        'post_status'    => 'any',
        'fields'         => 'ids',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
    ] );

    foreach ( $comparison_posts as $comparison_id ) {
        // If a specific post type is requested, only delete comparisons for that type
        if ( $requested_post_type ) {
            $vehicle_ids = get_post_meta( $comparison_id, 'tamgaci_comparison_vehicle_ids', true );
            if ( ! empty( $vehicle_ids ) && is_array( $vehicle_ids ) ) {
                $first_vehicle = get_post( $vehicle_ids[0] );
                if ( ! $first_vehicle || $first_vehicle->post_type !== $requested_post_type ) {
                    continue; // Skip this comparison
                }
            } else {
                continue; // Skip if no vehicle IDs
            }
        }

        wp_delete_post( $comparison_id, true );
    }

    $redirect_args = [ 'tamgaci_deleted' => '1' ];
    if ( $requested_post_type ) {
        $redirect_args['post_type_deleted'] = $requested_post_type;
    }

    wp_safe_redirect( add_query_arg( $redirect_args, wp_get_referer() ?: admin_url() ) );
    exit;
}
add_action( 'admin_post_tamgaci_delete_comparisons', 'tamgaci_delete_all_vehicle_comparisons' );

function tamgaci_get_post_type_label( $post_type ) {
    $post_type_obj = get_post_type_object( $post_type );
    return $post_type_obj ? $post_type_obj->labels->name : $post_type;
}

function tamgaci_register_comparison_tools_menu() {
    add_submenu_page(
        'edit.php?post_type=vehicle_comparison',
        __( 'Karşılaştırma Araçları', 'tamgaci' ),
        __( 'Karşılaştırma Araçları', 'tamgaci' ),
        'manage_options',
        'tamgaci-comparison-tools',
        'tamgaci_render_comparison_tools_page'
    );
}
add_action( 'admin_menu', 'tamgaci_register_comparison_tools_menu' );

function tamgaci_render_comparison_tools_page() {
    if ( isset( $_GET['tamgaci_seeded'] ) ) {
        $post_type = sanitize_text_field( $_GET['post_type_seeded'] ?? '' );
        $message = $post_type
            ? sprintf( __( '%s karşılaştırmaları oluşturuldu.', 'tamgaci' ), tamgaci_get_post_type_label( $post_type ) )
            : __( 'Karşılaştırmalar oluşturuldu.', 'tamgaci' );
        echo '<div class="notice notice-success"><p>' . esc_html( $message ) . '</p></div>';
    }

    if ( isset( $_GET['tamgaci_deleted'] ) ) {
        $post_type = sanitize_text_field( $_GET['post_type_deleted'] ?? '' );
        $message = $post_type
            ? sprintf( __( '%s karşılaştırmaları silindi.', 'tamgaci' ), tamgaci_get_post_type_label( $post_type ) )
            : __( 'Tüm karşılaştırmalar silindi.', 'tamgaci' );
        echo '<div class="notice notice-warning"><p>' . esc_html( $message ) . '</p></div>';
    }

    $vehicle_post_types = tamgaci_get_vehicle_post_types();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Karşılaştırma Araçları', 'tamgaci' ); ?></h1>
        <p><?php esc_html_e( 'Araç tipine göre otomatik karşılaştırma kayıtları oluşturabilir veya silebilirsiniz.', 'tamgaci' ); ?></p>

        <style>
            .tamgaci-comparison-section {
                background: #fff;
                border: 1px solid #ccd0d4;
                border-radius: 4px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 1px 1px rgba(0,0,0,.04);
            }
            .tamgaci-comparison-section h2 {
                margin-top: 0;
                padding-bottom: 10px;
                border-bottom: 1px solid #ddd;
            }
            .tamgaci-comparison-buttons {
                display: flex;
                gap: 12px;
                margin-top: 16px;
                align-items: center;
            }
            .tamgaci-comparison-count {
                color: #646970;
                font-size: 13px;
                margin-left: auto;
            }
        </style>

        <?php foreach ( $vehicle_post_types as $post_type ) :
            $post_type_obj = get_post_type_object( $post_type );
            $label = $post_type_obj->labels->name;

            // Count vehicles for this post type
            $vehicle_count = wp_count_posts( $post_type )->publish;

            // Count comparisons for this post type
            $comparison_count = 0;
            $comparisons = get_posts( [
                'post_type'      => 'vehicle_comparison',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'fields'         => 'ids',
                'meta_query'     => [
                    [
                        'key'     => 'tamgaci_comparison_vehicle_ids',
                        'compare' => 'EXISTS',
                    ],
                ],
            ] );

            foreach ( $comparisons as $comp_id ) {
                $vehicle_ids = get_post_meta( $comp_id, 'tamgaci_comparison_vehicle_ids', true );
                if ( ! empty( $vehicle_ids ) && is_array( $vehicle_ids ) ) {
                    $first_vehicle = get_post( $vehicle_ids[0] );
                    if ( $first_vehicle && $first_vehicle->post_type === $post_type ) {
                        $comparison_count++;
                    }
                }
            }

            $seed_url = wp_nonce_url(
                admin_url( 'admin-post.php?action=tamgaci_seed_comparisons&post_type=' . $post_type ),
                'tamgaci_seed_comparisons'
            );
            $delete_url = wp_nonce_url(
                admin_url( 'admin-post.php?action=tamgaci_delete_comparisons&post_type=' . $post_type ),
                'tamgaci_delete_comparisons'
            );
        ?>
            <div class="tamgaci-comparison-section">
                <h2><?php echo esc_html( $label ); ?></h2>
                <div class="tamgaci-comparison-buttons">
                    <a class="button button-primary" href="<?php echo esc_url( $seed_url ); ?>">
                        <?php esc_html_e( 'Karşılaştırmaları Oluştur', 'tamgaci' ); ?>
                    </a>
                    <a class="button button-secondary" href="<?php echo esc_url( $delete_url ); ?>" onclick="return confirm('<?php echo esc_js( sprintf( __( '%s karşılaştırmalarını silmek istediğinize emin misiniz?', 'tamgaci' ), $label ) ); ?>');">
                        <?php esc_html_e( 'Karşılaştırmaları Sil', 'tamgaci' ); ?>
                    </a>
                    <span class="tamgaci-comparison-count">
                        <?php
                        printf(
                            __( '%d araç, %d karşılaştırma', 'tamgaci' ),
                            $vehicle_count,
                            $comparison_count
                        );
                        ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>

        <hr style="margin: 30px 0;">

        <div class="tamgaci-comparison-section" style="background: #fcf9e8; border-color: #f0e68c;">
            <h2><?php esc_html_e( 'Tüm Araçlar', 'tamgaci' ); ?></h2>
            <p><?php esc_html_e( 'Tüm araç tiplerindeki karşılaştırmaları toplu olarak yönetin.', 'tamgaci' ); ?></p>
            <div class="tamgaci-comparison-buttons">
                <a class="button button-primary" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=tamgaci_seed_comparisons' ), 'tamgaci_seed_comparisons' ) ); ?>">
                    <?php esc_html_e( 'Tüm Karşılaştırmaları Oluştur', 'tamgaci' ); ?>
                </a>
                <a class="button button-secondary" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=tamgaci_delete_comparisons' ), 'tamgaci_delete_comparisons' ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'TÜM karşılaştırmaları silmek istediğinize emin misiniz? Bu işlem geri alınamaz.', 'tamgaci' ) ); ?>');">
                    <?php esc_html_e( 'Tüm Karşılaştırmaları Sil', 'tamgaci' ); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
}

function tamgaci_format_vehicle_title( $brands, $models, $equipment_terms, $equipment_detail, $year ) {
    $parts = [];

    if ( ! empty( $brands ) ) {
        $parts[] = implode( ' ', (array) $brands );
    }

    if ( ! empty( $models ) ) {
        $parts[] = implode( ' ', (array) $models );
    }

    if ( ! empty( $equipment_terms ) ) {
        $parts[] = implode( ' ', array_filter( (array) $equipment_terms ) );
    }

    // Only use equipment_detail if no equipment terms are set
    if ( $equipment_detail && empty( $equipment_terms ) ) {
        $parts[] = $equipment_detail;
    }

    if ( $year ) {
        $parts[] = $year;
    }

    $title = trim( preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $parts ) ) ) );

    return $title;
}

function tamgaci_build_vehicle_title( $post_id ) {
    $brands           = tamgaci_get_vehicle_brand_names( $post_id );
    $models           = tamgaci_get_vehicle_model_names( $post_id );
    $equipment_terms  = tamgaci_get_vehicle_equipment_names( $post_id );
    $equipment_detail = get_post_meta( $post_id, 'tamgaci_vehicle_equipment', true );
    $year             = get_post_meta( $post_id, 'tamgaci_vehicle_year', true );

    return tamgaci_format_vehicle_title( $brands, $models, $equipment_terms, $equipment_detail, $year );
}

function tamgaci_collect_vehicle_context_from_request() {
    $collect_terms = static function ( $taxonomy ) {
        if ( empty( $_POST['tax_input'][ $taxonomy ] ) ) {
            return [];
        }

        $raw  = wp_unslash( $_POST['tax_input'][ $taxonomy ] );
        $raw  = is_array( $raw ) ? $raw : explode( ',', $raw );
        $names = [];

        foreach ( $raw as $value ) {
            if ( '' === $value || null === $value ) {
                continue;
            }

            if ( is_numeric( $value ) ) {
                $term = get_term( (int) $value, $taxonomy );
                if ( $term && ! is_wp_error( $term ) ) {
                    $names[] = $term->name;
                }
            } else {
                $names[] = sanitize_text_field( $value );
            }
        }

        return array_values( array_unique( array_filter( $names ) ) );
    };

    // Collect brands, models, and equipment from vehicle_brand taxonomy (hierarchical)
    $all_brand_terms = $collect_terms( 'vehicle_brand' );
    $brands          = [];
    $models          = [];
    $equipment_terms = [];

    foreach ( $all_brand_terms as $term_name ) {
        // Find the term to check its level in hierarchy
        $terms = get_terms([
            'taxonomy'   => 'vehicle_brand',
            'name'       => $term_name,
            'hide_empty' => false,
        ]);

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $term = $terms[0];

            if ( $term->parent > 0 ) {
                // Has a parent, check if parent also has a parent
                $parent_term = get_term( $term->parent, 'vehicle_brand' );

                if ( $parent_term && ! is_wp_error( $parent_term ) ) {
                    if ( $parent_term->parent > 0 ) {
                        // Parent has a parent, so this is equipment (3rd level)
                        $equipment_terms[] = $term_name;
                    } else {
                        // Parent is top-level, so this is model (2nd level)
                        $models[] = $term_name;
                    }
                }
            } else {
                // Top-level brand
                $brands[] = $term_name;
            }
        }
    }

    $equipment_detail = isset( $_POST['tamgaci_vehicle_equipment'] )
        ? sanitize_text_field( wp_unslash( $_POST['tamgaci_vehicle_equipment'] ) )
        : '';

    $year = isset( $_POST['tamgaci_vehicle_year'] )
        ? tamgaci_sanitize_decimal( wp_unslash( $_POST['tamgaci_vehicle_year'] ) )
        : '';

    return [
        'brands'           => $brands,
        'models'           => $models,
        'equipment_terms'  => $equipment_terms,
        'equipment_detail' => $equipment_detail,
        'year'             => $year,
    ];
}

function tamgaci_filter_vehicle_insert_data( $data, $postarr ) {
    if ( ! in_array( $data['post_type'], tamgaci_get_vehicle_post_types(), true ) ) {
        return $data;
    }

    $post_id = isset( $postarr['ID'] ) ? (int) $postarr['ID'] : 0;

    $title = $post_id > 0 ? tamgaci_build_vehicle_title( $post_id ) : '';

    if ( ! $title ) {
        $context = tamgaci_collect_vehicle_context_from_request();
        $title   = tamgaci_format_vehicle_title(
            $context['brands'],
            $context['models'],
            $context['equipment_terms'],
            $context['equipment_detail'],
            $context['year']
        );
    }

    if ( $title ) {
        $data['post_title'] = $title;
        $data['post_name']  = sanitize_title( $title );
    }

    return $data;
}
// Temporarily disabled to debug - this might cause infinite loop
// add_filter( 'wp_insert_post_data', 'tamgaci_filter_vehicle_insert_data', 10, 2 );

/**
 * Calculate DC fast charging time (20% to 80%) with realistic charging curve
 *
 * This calculation takes into account the aggressive charging curve where power
 * significantly decreases as the battery fills up. Based on real-world data
 * from Togg T10X, the average power during 20-80% charging is approximately 37.4%
 * of peak power, resulting in ~28 minutes for 52.4 kWh at 180 kW peak.
 *
 * Charging curve model (calibrated to real data):
 * - 20% to 40%: ~90% of max power (initial high speed)
 * - 40% to 60%: ~50% of max power (significant tapering)
 * - 60% to 80%: ~20% of max power (heavy tapering for battery protection)
 *
 * @param float $battery_capacity Battery capacity in kWh
 * @param float $charging_power DC charging power in kW (peak power)
 * @return int Charging time in minutes, or 0 if calculation not possible
 */
function tamgaci_calculate_charging_time( $battery_capacity, $charging_power ) {
    if ( ! $battery_capacity || ! $charging_power || $charging_power <= 0 ) {
        return 0;
    }

    // Phase 1: 20% to 40% (20% of capacity) at ~90% of peak power
    $phase1_energy = $battery_capacity * 0.20;
    $phase1_power  = $charging_power * 0.90;
    $phase1_time   = $phase1_energy / $phase1_power;

    // Phase 2: 40% to 60% (20% of capacity) at ~50% of peak power
    $phase2_energy = $battery_capacity * 0.20;
    $phase2_power  = $charging_power * 0.50;
    $phase2_time   = $phase2_energy / $phase2_power;

    // Phase 3: 60% to 80% (20% of capacity) at ~20% of peak power
    $phase3_energy = $battery_capacity * 0.20;
    $phase3_power  = $charging_power * 0.20;
    $phase3_time   = $phase3_energy / $phase3_power;

    // Total time in hours, then convert to minutes
    $total_time_hours      = $phase1_time + $phase2_time + $phase3_time;
    $charging_time_minutes = round( $total_time_hours * 60 );

    return (int) $charging_time_minutes;
}

/**
 * Calculate AC charging time (20% to 80%)
 *
 * AC charging maintains relatively constant power throughout the charging process
 * as the onboard charger handles the AC to DC conversion at a steady rate.
 * Based on real-world data from Togg T10X: 195 minutes for 52.4 kWh at 11 kW.
 *
 * @param float $battery_capacity Battery capacity in kWh
 * @param float $charging_power AC charging power in kW (typically 7.4 or 11 kW)
 * @return int Charging time in minutes, or 0 if calculation not possible
 */
function tamgaci_calculate_ac_charging_time( $battery_capacity, $charging_power ) {
    if ( ! $battery_capacity || ! $charging_power || $charging_power <= 0 ) {
        return 0;
    }

    // Calculate 60% of battery capacity (20% to 80%)
    $energy_to_charge = $battery_capacity * 0.6;

    // AC charging is relatively constant, applying 88% efficiency for onboard charger
    // (calibrated to match real data: Togg T10X takes 195 min for 52.4 kWh at 11 kW)
    $charging_efficiency = 0.88;
    $effective_power     = $charging_power * $charging_efficiency;

    // Calculate time in hours, then convert to minutes
    $charging_time_hours   = $energy_to_charge / $effective_power;
    $charging_time_minutes = round( $charging_time_hours * 60 );

    return (int) $charging_time_minutes;
}

/**
 * Get vehicle icon based on body type
 *
 * @param int $post_id Vehicle post ID
 * @return string Icon name for iconify
 */
function tamgaci_get_vehicle_icon_by_body_type( $post_id ) {
    // Custom icon from meta field has priority
    $custom_icon = get_post_meta( $post_id, 'tamgaci_vehicle_icon', true );
    if ( $custom_icon ) {
        return $custom_icon;
    }

    // Get body type terms
    $body_types = wp_get_post_terms( $post_id, 'vehicle_body_type', [ 'fields' => 'names' ] );

    if ( is_wp_error( $body_types ) || empty( $body_types ) ) {
        return 'mdi:car-side';
    }

    // Icon mapping based on body type
    $icon_map = [
        'SUV'           => 'mdi:car-estate',
        'Sedan'         => 'mdi:car-sedan',
        'Coupe'         => 'mdi:car-sports',
        'Hatchback'     => 'mdi:car-hatchback',
        'Wagon'         => 'mdi:car-estate',
        'Pickup'        => 'mdi:truck',
        'Van'           => 'mdi:van-utility',
        'Minivan'       => 'mdi:van-passenger',
        'Convertible'   => 'mdi:car-convertible',
        'Crossover'     => 'mdi:car-lifted-pickup',
        'Sports Car'    => 'mdi:car-sports',
        'Limousine'     => 'mdi:car-limousine',
        'Motorcycle'    => 'mdi:motorbike',
    ];

    // Get first body type and return corresponding icon
    $first_body_type = $body_types[0];

    return $icon_map[ $first_body_type ] ?? 'mdi:car-side';
}

function tamgaci_prepare_vehicle_display_data( $post_id ) {
    if ( ! $post_id || ! in_array( get_post_type( $post_id ), tamgaci_get_vehicle_post_types(), true ) ) {
        return null;
    }

    $post_type   = get_post_type( $post_id );
    $is_electric = TAMGACI_ELECTRIC_POST_TYPE === $post_type;

    $schema = tamgaci_vehicle_meta_schema( $post_type );

    $exclude_from_specs = [
        'tamgaci_vehicle_icon',
        'tamgaci_vehicle_equipment',
        'tamgaci_vehicle_year',
        'tamgaci_vehicle_notes',
        'tamgaci_vehicle_charging',
        'tamgaci_vehicle_price',
        'tamgaci_vehicle_charging_power',
        'tamgaci_vehicle_ac_charging_power',
    ];

    $specs = [];

    foreach ( $schema as $key => $config ) {
        if ( in_array( $key, $exclude_from_specs, true ) ) {
            continue;
        }

        $value      = get_post_meta( $post_id, $key, true );
        $raw_value  = $value;

        if ( '' === trim( (string) $value ) ) {
            continue;
        }

        $display_value = $value;

        if ( isset( $config['unit'] ) && $config['unit'] ) {
            $display_value = tamgaci_format_numeric_display( $value ) . ' ' . $config['unit'];
        }

        $specs[] = [
            'key'   => $key,
            'label' => $config['label'],
            'value' => $display_value,
        ];

        if ( 'tamgaci_vehicle_cylinder_volume' === $key ) {
            $numeric_value = str_replace( ',', '.', (string) $raw_value );
            if ( is_numeric( $numeric_value ) ) {
                $cc_value = (float) $numeric_value * 1000;
                $specs[] = [
                    'key'   => $key . '_cc',
                    'label' => __( 'Silindir Hacmi (cc)', 'tamgaci' ),
                    'value' => tamgaci_format_numeric_display( $cc_value ) . ' cc',
                ];
            }
        }
    }

    $equipment_terms   = tamgaci_get_vehicle_equipment_names( $post_id );
    $equipment_detail  = get_post_meta( $post_id, 'tamgaci_vehicle_equipment', true );
    $equipment_display = [];

    if ( ! empty( $equipment_terms ) ) {
        $equipment_display[] = implode( ' · ', $equipment_terms );
    }

    if ( $equipment_detail ) {
        $equipment_display[] = $equipment_detail;
    }

    $equipment_output = implode( ' · ', array_filter( $equipment_display ) );

    $price_raw = get_post_meta( $post_id, 'tamgaci_vehicle_price', true );
    $price     = tamgaci_format_currency_display( $price_raw );

    // Calculate charging times for electric vehicles
    $dc_charging_time         = 0;
    $dc_charging_time_display = '';
    $ac_charging_time         = 0;
    $ac_charging_time_display = '';

    if ( $is_electric ) {
        $battery_capacity = get_post_meta( $post_id, 'tamgaci_vehicle_battery', true );
        $dc_charging_power = get_post_meta( $post_id, 'tamgaci_vehicle_charging_power', true );
        $ac_charging_power = get_post_meta( $post_id, 'tamgaci_vehicle_ac_charging_power', true );

        // DC Fast Charging
        if ( $battery_capacity && $dc_charging_power ) {
            $dc_charging_time = tamgaci_calculate_charging_time(
                (float) str_replace( ',', '.', $battery_capacity ),
                (float) str_replace( ',', '.', $dc_charging_power )
            );

            if ( $dc_charging_time > 0 ) {
                $dc_charging_time_display = sprintf(
                    __( '%d dakika (%s kW, %%20-%%80)', 'tamgaci' ),
                    $dc_charging_time,
                    tamgaci_format_numeric_display( $dc_charging_power )
                );
            }
        }

        // AC Charging
        if ( $battery_capacity && $ac_charging_power ) {
            $ac_charging_time = tamgaci_calculate_ac_charging_time(
                (float) str_replace( ',', '.', $battery_capacity ),
                (float) str_replace( ',', '.', $ac_charging_power )
            );

            if ( $ac_charging_time > 0 ) {
                // Convert to hours and minutes for better display
                $ac_hours   = floor( $ac_charging_time / 60 );
                $ac_minutes = $ac_charging_time % 60;

                if ( $ac_hours > 0 && $ac_minutes > 0 ) {
                    $ac_charging_time_display = sprintf(
                        __( '%d saat %d dakika (%s kW, %%20-%%80)', 'tamgaci' ),
                        $ac_hours,
                        $ac_minutes,
                        tamgaci_format_numeric_display( $ac_charging_power )
                    );
                } elseif ( $ac_hours > 0 ) {
                    $ac_charging_time_display = sprintf(
                        __( '%d saat (%s kW, %%20-%%80)', 'tamgaci' ),
                        $ac_hours,
                        tamgaci_format_numeric_display( $ac_charging_power )
                    );
                } else {
                    $ac_charging_time_display = sprintf(
                        __( '%d dakika (%s kW, %%20-%%80)', 'tamgaci' ),
                        $ac_minutes,
                        tamgaci_format_numeric_display( $ac_charging_power )
                    );
                }
            }
        }
    }

    return [
        'post_type'             => $post_type,
        'is_electric'           => $is_electric,
        'icon'                  => tamgaci_get_vehicle_icon_by_body_type( $post_id ),
        'year'                  => tamgaci_format_numeric_display( get_post_meta( $post_id, 'tamgaci_vehicle_year', true ) ),
        'model_years'           => tamgaci_get_vehicle_term_names( $post_id, 'vehicle_model_year' ),
        'equipment'             => $equipment_output,
        'equipment_terms'       => $equipment_terms,
        'equipment_detail'      => $equipment_detail,
        'price'                 => $price,
        'price_raw'             => $price_raw,
        'notes'                      => get_post_meta( $post_id, 'tamgaci_vehicle_notes', true ),
        'charging'                   => get_post_meta( $post_id, 'tamgaci_vehicle_charging', true ),
        'dc_charging_time'           => $dc_charging_time,
        'dc_charging_time_display'   => $dc_charging_time_display,
        'ac_charging_time'           => $ac_charging_time,
        'ac_charging_time_display'   => $ac_charging_time_display,
        'brands'                     => tamgaci_get_vehicle_brand_names( $post_id ),
        'models'                     => tamgaci_get_vehicle_model_names( $post_id ),
        'powertrain'            => tamgaci_get_vehicle_term_names( $post_id, 'vehicle_powertrain' ),
        'body_types'            => tamgaci_get_vehicle_term_names( $post_id, 'vehicle_body_type' ),
        'specs'                 => $specs,
        'id'                    => $post_id,
        'title'                 => get_the_title( $post_id ),
        'permalink'             => get_permalink( $post_id ),
        'image'                 => get_the_post_thumbnail_url( $post_id, 'large' ),
    ];
}

function tamgaci_ensure_compare_page() {
    static $running = false;

    if ( $running ) {
        return (int) get_option( 'tamgaci_compare_page_id', 0 );
    }

    $running = true;

    $page_id = (int) get_option( 'tamgaci_compare_page_id', 0 );

    if ( $page_id ) {
        $page = get_post( $page_id );
        if ( $page && 'trash' !== $page->post_status ) {
            if ( 'page-vehicle-compare.php' !== get_page_template_slug( $page_id ) ) {
                update_post_meta( $page_id, '_wp_page_template', 'page-vehicle-compare.php' );
            }
            $running = false;
            return $page_id;
        }
    }

    $existing = get_posts( [
        'post_type'   => 'page',
        'post_status' => 'publish',
        'meta_key'    => '_wp_page_template',
        'meta_value'  => 'page-vehicle-compare.php',
        'numberposts' => 1,
    ] );

    if ( $existing ) {
        $page_id = (int) $existing[0]->ID;
        update_option( 'tamgaci_compare_page_id', $page_id );
        $running = false;
        return $page_id;
    }

    $page_id = wp_insert_post( [
        'post_title'   => __( 'Araç Karşılaştırma', 'tamgaci' ),
        'post_name'    => 'arac-karsilastirma',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
    ] );

    if ( ! is_wp_error( $page_id ) && $page_id ) {
        update_post_meta( $page_id, '_wp_page_template', 'page-vehicle-compare.php' );
        update_option( 'tamgaci_compare_page_id', (int) $page_id );
        $running = false;
        return (int) $page_id;
    }

    $running = false;
    return 0;
}

function tamgaci_get_vehicle_compare_url() {
    $page_id = tamgaci_ensure_compare_page();

    if ( $page_id ) {
        $link = get_permalink( $page_id );
        if ( $link ) {
            return $link;
        }
    }

    return home_url( '/' );
}

function tamgaci_ensure_compare_select_page() {
    static $running = false;

    if ( $running ) {
        return (int) get_option( 'tamgaci_compare_select_page_id', 0 );
    }

    $running = true;

    $page_id = (int) get_option( 'tamgaci_compare_select_page_id', 0 );

    if ( $page_id ) {
        $page = get_post( $page_id );
        if ( $page && 'trash' !== $page->post_status ) {
            if ( 'page-vehicle-compare-select.php' !== get_page_template_slug( $page_id ) ) {
                update_post_meta( $page_id, '_wp_page_template', 'page-vehicle-compare-select.php' );
            }
            $running = false;
            return $page_id;
        }
    }

    $existing = get_posts( [
        'post_type'   => 'page',
        'post_status' => 'publish',
        'meta_key'    => '_wp_page_template',
        'meta_value'  => 'page-vehicle-compare-select.php',
        'numberposts' => 1,
    ] );

    if ( $existing ) {
        $page_id = (int) $existing[0]->ID;
        update_option( 'tamgaci_compare_select_page_id', $page_id );
        $running = false;
        return $page_id;
    }

    $page_id = wp_insert_post( [
        'post_title'   => __( 'Araç Karşılaştırma Seçimi', 'tamgaci' ),
        'post_name'    => 'arac-karsilastirma-secimi',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
    ] );

    if ( ! is_wp_error( $page_id ) && $page_id ) {
        update_post_meta( $page_id, '_wp_page_template', 'page-vehicle-compare-select.php' );
        update_option( 'tamgaci_compare_select_page_id', (int) $page_id );
        $running = false;
        return (int) $page_id;
    }

    $running = false;
    return 0;
}

function tamgaci_get_vehicle_compare_select_url() {
    $page_id = tamgaci_ensure_compare_select_page();

    if ( $page_id ) {
        $link = get_permalink( $page_id );
        if ( $link ) {
            return $link;
        }
    }

    return tamgaci_get_vehicle_compare_url();
}

function tamgaci_should_skip_vehicle_slug_sync( $post ) {
    if ( ! $post instanceof WP_Post ) {
        return true;
    }

    if ( ! in_array( $post->post_type, tamgaci_get_vehicle_post_types(), true ) ) {
        return true;
    }

    if ( in_array( $post->post_status, [ 'auto-draft', 'trash' ], true ) ) {
        return true;
    }

    return false;
}

function tamgaci_update_vehicle_title_and_slug( WP_Post $post ) {
    static $running = false;

    if ( $running ) {
        return;
    }

    if ( tamgaci_should_skip_vehicle_slug_sync( $post ) ) {
        return;
    }

    $title = tamgaci_build_vehicle_title( $post->ID );

    if ( ! $title ) {
        return;
    }

    $update_args  = [ 'ID' => $post->ID ];
    $needs_update = false;

    if ( $post->post_title !== $title ) {
        $update_args['post_title'] = $title;
        $needs_update              = true;
    }

    // Build slug from taxonomy hierarchy instead of title
    $segments = tamgaci_get_vehicle_permalink_segments( $post->ID );
    $slug = ! empty( $segments ) ? implode( '-', $segments ) : sanitize_title( $title );

    if ( $slug && $post->post_name !== $slug ) {
        $update_args['post_name'] = $slug;
        $needs_update             = true;
    }

    if ( ! $needs_update ) {
        return;
    }

    $running = true;
    wp_update_post( $update_args );
    $running = false;
}

function tamgaci_sync_vehicle_title_slug( $post_id, $post, $update ) {
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return;
    }

    if ( tamgaci_should_skip_vehicle_slug_sync( $post ) ) {
        return;
    }

    tamgaci_update_vehicle_title_and_slug( $post );
}
add_action( 'save_post', 'tamgaci_sync_vehicle_title_slug', 50, 3 );

function tamgaci_rest_sync_vehicle_title_slug( WP_Post $post, $request, $creating ) {
    tamgaci_update_vehicle_title_and_slug( $post );
}

add_action( 'rest_after_insert_' . TAMGACI_ELECTRIC_POST_TYPE, 'tamgaci_rest_sync_vehicle_title_slug', 20, 3 );
add_action( 'rest_after_insert_' . TAMGACI_COMBUSTION_POST_TYPE, 'tamgaci_rest_sync_vehicle_title_slug', 20, 3 );
add_action( 'rest_after_insert_' . TAMGACI_MOTORCYCLE_POST_TYPE, 'tamgaci_rest_sync_vehicle_title_slug', 20, 3 );

function tamgaci_seed_powertrain_terms() {
    $defaults = [
        'elektrikli' => __( 'Elektrikli', 'tamgaci' ),
        'benzinli'   => __( 'Benzinli', 'tamgaci' ),
        'dizel'      => __( 'Dizel', 'tamgaci' ),
        'hibrit'     => __( 'Hibrit', 'tamgaci' ),
        'motor'      => __( 'Motor', 'tamgaci' ),
    ];

    foreach ( $defaults as $slug => $label ) {
        if ( ! term_exists( $slug, 'vehicle_powertrain' ) ) {
            wp_insert_term( $label, 'vehicle_powertrain', [ 'slug' => $slug ] );
        }
    }
}
add_action( 'after_switch_theme', 'tamgaci_seed_powertrain_terms' );
add_action( 'init', 'tamgaci_seed_powertrain_terms' );

function tamgaci_assign_default_powertrain_term( $post_id, $post, $update ) {
    if ( TAMGACI_ELECTRIC_POST_TYPE !== $post->post_type ) {
        return;
    }

    if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
        return;
    }

    if ( ! has_term( '', 'vehicle_powertrain', $post_id ) ) {
        wp_set_post_terms( $post_id, [ 'elektrikli' ], 'vehicle_powertrain', false );
    }
}
// Temporarily disabled to debug
// add_action( 'save_post', 'tamgaci_assign_default_powertrain_term', 20, 3 );

add_action( 'after_switch_theme', 'tamgaci_ensure_compare_page' );
add_action( 'init', 'tamgaci_ensure_compare_page' );
add_action( 'after_switch_theme', 'tamgaci_ensure_compare_select_page' );
add_action( 'init', 'tamgaci_ensure_compare_select_page' );

/**
 * Filter term links for vehicle_body_type to use custom URL structure.
 */
function tamgaci_filter_body_type_term_link( $termlink, $term, $taxonomy ) {
    if ( 'vehicle_body_type' === $taxonomy ) {
        $termlink = home_url( 'elektrikli-araclar/' . $term->slug . '/' );
    }
    return $termlink;
}
add_filter( 'term_link', 'tamgaci_filter_body_type_term_link', 10, 3 );

/**
 * Filter electric vehicle archive query based on URL parameters.
 */
function tamgaci_filter_electric_vehicle_archive( $query ) {
    // Only modify main query on electric vehicle archive
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'electric_vehicle' ) ) {
        $tax_query = [];
        $meta_query = [];

        // Filter by brand
        if ( ! empty( $_GET['marka'] ) ) {
            $brands = array_map( 'sanitize_text_field', (array) $_GET['marka'] );
            $tax_query[] = [
                'taxonomy' => 'vehicle_brand',
                'field'    => 'slug',
                'terms'    => $brands,
            ];
        }

        // Filter by body type
        if ( ! empty( $_GET['govde'] ) ) {
            $body_types = array_map( 'sanitize_text_field', (array) $_GET['govde'] );
            $tax_query[] = [
                'taxonomy' => 'vehicle_body_type',
                'field'    => 'slug',
                'terms'    => $body_types,
            ];
        }

        // Filter by battery capacity (kWh)
        if ( ! empty( $_GET['batarya'] ) ) {
            $battery_range = sanitize_text_field( $_GET['batarya'] );
            list( $min, $max ) = explode( '-', $battery_range );
            if ( is_numeric( $min ) && is_numeric( $max ) ) {
                $meta_query[] = [
                    'key'     => 'tamgaci_vehicle_battery',
                    'value'   => [ (float) $min, (float) $max ],
                    'type'    => 'DECIMAL(10,2)',
                    'compare' => 'BETWEEN',
                ];
            }
        }

        // Filter by range (km)
        if ( ! empty( $_GET['menzil'] ) ) {
            $range_range = sanitize_text_field( $_GET['menzil'] );
            list( $min, $max ) = explode( '-', $range_range );
            if ( is_numeric( $min ) && is_numeric( $max ) ) {
                $meta_query[] = [
                    'key'     => 'tamgaci_vehicle_range',
                    'value'   => [ (float) $min, (float) $max ],
                    'type'    => 'DECIMAL(10,2)',
                    'compare' => 'BETWEEN',
                ];
            }
        }

        // Filter by DC charging power (kW)
        if ( ! empty( $_GET['sarj'] ) ) {
            $charging_range = sanitize_text_field( $_GET['sarj'] );
            list( $min, $max ) = explode( '-', $charging_range );
            if ( is_numeric( $min ) && is_numeric( $max ) ) {
                $meta_query[] = [
                    'key'     => 'tamgaci_vehicle_charging_power',
                    'value'   => [ (float) $min, (float) $max ],
                    'type'    => 'DECIMAL(10,2)',
                    'compare' => 'BETWEEN',
                ];
            }
        }

        // Filter by horsepower (PS)
        if ( ! empty( $_GET['guc'] ) ) {
            $power_range = sanitize_text_field( $_GET['guc'] );
            list( $min, $max ) = explode( '-', $power_range );
            if ( is_numeric( $min ) && is_numeric( $max ) ) {
                $meta_query[] = [
                    'key'     => 'tamgaci_vehicle_horsepower',
                    'value'   => [ (float) $min, (float) $max ],
                    'type'    => 'DECIMAL(10,2)',
                    'compare' => 'BETWEEN',
                ];
            }
        }

        // Apply tax query if filters exist
        if ( ! empty( $tax_query ) ) {
            $tax_query['relation'] = 'AND';
            $query->set( 'tax_query', $tax_query );
        }

        // Apply meta query if filters exist
        if ( ! empty( $meta_query ) ) {
            $meta_query['relation'] = 'AND';
            $query->set( 'meta_query', $meta_query );
        }
    }
}
add_action( 'pre_get_posts', 'tamgaci_filter_electric_vehicle_archive' );

/**
 * Add custom columns to vehicle_comparison admin list
 */
function tamgaci_comparison_admin_columns( $columns ) {
    $new_columns = [];

    // Keep checkbox and title
    if ( isset( $columns['cb'] ) ) {
        $new_columns['cb'] = $columns['cb'];
    }
    if ( isset( $columns['title'] ) ) {
        $new_columns['title'] = $columns['title'];
    }

    // Add custom columns
    $new_columns['comparison_types'] = __( 'Karşılaştırma Türü', 'tamgaci' );
    $new_columns['comparison_items'] = __( 'Karşılaştırılan Öğeler', 'tamgaci' );

    // Keep date
    if ( isset( $columns['date'] ) ) {
        $new_columns['date'] = $columns['date'];
    }

    return $new_columns;
}
add_filter( 'manage_vehicle_comparison_posts_columns', 'tamgaci_comparison_admin_columns' );

/**
 * Populate custom columns in vehicle_comparison admin list
 */
function tamgaci_comparison_admin_column_content( $column, $post_id ) {
    if ( $column === 'comparison_types' ) {
        $vehicle_ids = get_post_meta( $post_id, 'tamgaci_comparison_vehicle_ids', true );

        if ( ! is_array( $vehicle_ids ) || empty( $vehicle_ids ) ) {
            echo '<span style="color: #999;">—</span>';
            return;
        }

        // Collect unique post types
        $post_types = [];
        foreach ( $vehicle_ids as $vehicle_id ) {
            $post_type = get_post_type( $vehicle_id );
            if ( $post_type && ! in_array( $post_type, $post_types, true ) ) {
                $post_types[] = $post_type;
            }
        }

        // Display post type labels with icons
        $labels = [];
        $type_icons = [
            'electric_vehicle'   => '⚡',
            'combustion_vehicle' => '⛽',
            'motorcycle'         => '🏍️',
        ];

        foreach ( $post_types as $post_type ) {
            $post_type_obj = get_post_type_object( $post_type );
            if ( $post_type_obj ) {
                $icon = isset( $type_icons[ $post_type ] ) ? $type_icons[ $post_type ] . ' ' : '';
                $labels[] = '<span style="display: inline-block; padding: 4px 8px; background: #f0f0f1; border-radius: 4px; font-size: 12px; white-space: nowrap;">'
                    . esc_html( $icon . $post_type_obj->labels->singular_name )
                    . '</span>';
            }
        }

        echo implode( ' ', $labels );
    }

    if ( $column === 'comparison_items' ) {
        $vehicle_ids = get_post_meta( $post_id, 'tamgaci_comparison_vehicle_ids', true );

        if ( ! is_array( $vehicle_ids ) || empty( $vehicle_ids ) ) {
            echo '<span style="color: #999;">—</span>';
            return;
        }

        echo '<strong>' . count( $vehicle_ids ) . '</strong> ' . esc_html__( 'öğe', 'tamgaci' );
    }
}
add_action( 'manage_vehicle_comparison_posts_custom_column', 'tamgaci_comparison_admin_column_content', 10, 2 );

/**
 * Add "Build Comparisons" action link to vehicle post rows
 */
function tamgaci_vehicle_row_actions( $actions, $post ) {
    $vehicle_types = tamgaci_get_vehicle_post_types();

    if ( ! in_array( $post->post_type, $vehicle_types, true ) ) {
        return $actions;
    }

    if ( $post->post_status !== 'publish' ) {
        return $actions;
    }

    $url = wp_nonce_url(
        admin_url( 'admin-post.php?action=tamgaci_build_single_comparison&post_id=' . $post->ID ),
        'tamgaci_build_comparison_' . $post->ID
    );

    $actions['build_comparisons'] = sprintf(
        '<a href="%s" title="%s">%s</a>',
        esc_url( $url ),
        esc_attr__( 'Bu araç için karşılaştırmalar oluştur', 'tamgaci' ),
        esc_html__( 'Karşılaştırma Oluştur', 'tamgaci' )
    );

    return $actions;
}
add_filter( 'post_row_actions', 'tamgaci_vehicle_row_actions', 10, 2 );

/**
 * Handle single vehicle comparison building
 */
function tamgaci_build_single_comparison_handler() {
    if ( ! isset( $_GET['post_id'] ) ) {
        wp_die( esc_html__( 'Geçersiz istek.', 'tamgaci' ) );
    }

    $post_id = absint( $_GET['post_id'] );

    check_admin_referer( 'tamgaci_build_comparison_' . $post_id );

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        wp_die( esc_html__( 'Bu işlem için yetkiniz yok.', 'tamgaci' ) );
    }

    $post = get_post( $post_id );
    $vehicle_types = tamgaci_get_vehicle_post_types();

    if ( ! $post || ! in_array( $post->post_type, $vehicle_types, true ) ) {
        wp_die( esc_html__( 'Geçersiz araç.', 'tamgaci' ) );
    }

    // Build comparisons for this vehicle
    tamgaci_build_vehicle_comparisons( $post_id );

    // Redirect back with success message
    $redirect_url = add_query_arg(
        [
            'post_type' => $post->post_type,
            'tamgaci_comparison_built' => '1',
            'vehicle_id' => $post_id,
        ],
        admin_url( 'edit.php' )
    );

    wp_safe_redirect( $redirect_url );
    exit;
}
add_action( 'admin_post_tamgaci_build_single_comparison', 'tamgaci_build_single_comparison_handler' );

/**
 * Show admin notice after building comparisons
 */
function tamgaci_comparison_built_notice() {
    if ( ! isset( $_GET['tamgaci_comparison_built'] ) || ! isset( $_GET['vehicle_id'] ) ) {
        return;
    }

    $vehicle_id = absint( $_GET['vehicle_id'] );
    $vehicle_title = get_the_title( $vehicle_id );

    printf(
        '<div class="notice notice-success is-dismissible"><p>%s</p></div>',
        sprintf(
            esc_html__( '"%s" için karşılaştırmalar oluşturuldu.', 'tamgaci' ),
            esc_html( $vehicle_title )
        )
    );
}
add_action( 'admin_notices', 'tamgaci_comparison_built_notice' );

/**
 * Add admin submenu page for updating comparison titles
 */
function tamgaci_add_comparison_tools_menu() {
	add_submenu_page(
		'edit.php?post_type=vehicle_comparison',
		__( 'Başlıkları Güncelle', 'tamgaci' ),
		__( 'Başlıkları Güncelle', 'tamgaci' ),
		'manage_options',
		'tamgaci-update-comparison-titles',
		'tamgaci_render_update_comparison_titles_page'
	);
}
add_action( 'admin_menu', 'tamgaci_add_comparison_tools_menu' );

/**
 * Render the update comparison titles admin page
 */
function tamgaci_render_update_comparison_titles_page() {
	// Security check
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'Unauthorized access.', 'tamgaci' ) );
	}

	// Handle update action
	$do_update = isset( $_POST['tamgaci_update_titles_nonce'] ) && wp_verify_nonce( $_POST['tamgaci_update_titles_nonce'], 'tamgaci_update_comparison_titles' );

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Karşılaştırma Başlıklarını Güncelle', 'tamgaci' ); ?></h1>

		<div class="notice notice-info">
			<p>
				<strong><?php esc_html_e( 'Amaç:', 'tamgaci' ); ?></strong>
				<?php esc_html_e( 'Bu araç, tekrar eden donanım isimlerini düzeltmek için tüm karşılaştırma başlıklarını yeniden oluşturur (v0.11.2 düzeltmesi).', 'tamgaci' ); ?>
			</p>
		</div>

		<?php
		// Get all comparison posts
		$args = array(
			'post_type'      => 'vehicle_comparison',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		);

		$comparisons = get_posts( $args );

		if ( empty( $comparisons ) ) {
			echo '<div class="notice notice-warning"><p>' . esc_html__( 'Karşılaştırma bulunamadı.', 'tamgaci' ) . '</p></div>';
		} else {
			$total_count     = count( $comparisons );
			$updated_count   = 0;
			$unchanged_count = 0;
			$error_count     = 0;
			$updates         = array();

			foreach ( $comparisons as $post ) {
				$vehicle_ids = get_post_meta( $post->ID, 'tamgaci_comparison_vehicles', true );

				if ( empty( $vehicle_ids ) || ! is_array( $vehicle_ids ) ) {
					$error_count++;
					continue;
				}

				// Generate new title using the fixed function
				$vehicle_titles = array_map( 'tamgaci_get_vehicle_display_title', $vehicle_ids );
				$new_title      = trim( implode( ' vs ', array_filter( $vehicle_titles ) ) );

				$old_title = $post->post_title;

				if ( $old_title !== $new_title ) {
					$updates[] = array(
						'id'  => $post->ID,
						'old' => $old_title,
						'new' => $new_title,
						'url' => get_permalink( $post->ID ),
					);

					// Update if confirmed
					if ( $do_update ) {
						$result = wp_update_post(
							array(
								'ID'         => $post->ID,
								'post_title' => $new_title,
							)
						);

						if ( is_wp_error( $result ) ) {
							$error_count++;
						} else {
							$updated_count++;
						}
					}
				} else {
					$unchanged_count++;
				}
			}

			// Display stats
			?>
			<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0;">
				<div style="background: #f6f7f7; padding: 15px; border-radius: 4px; text-align: center;">
					<div style="font-size: 32px; font-weight: bold; color: #2271b1;"><?php echo esc_html( $total_count ); ?></div>
					<div style="color: #50575e; font-size: 14px;"><?php esc_html_e( 'Toplam Karşılaştırma', 'tamgaci' ); ?></div>
				</div>

				<div style="background: #f6f7f7; padding: 15px; border-radius: 4px; text-align: center;">
					<div style="font-size: 32px; font-weight: bold; color: #2271b1;"><?php echo esc_html( count( $updates ) ); ?></div>
					<div style="color: #50575e; font-size: 14px;"><?php esc_html_e( 'Güncellenmeli', 'tamgaci' ); ?></div>
				</div>

				<?php if ( $do_update ) : ?>
					<div style="background: #f6f7f7; padding: 15px; border-radius: 4px; text-align: center;">
						<div style="font-size: 32px; font-weight: bold; color: #00a32a;"><?php echo esc_html( $updated_count ); ?></div>
						<div style="color: #50575e; font-size: 14px;"><?php esc_html_e( 'Güncellendi', 'tamgaci' ); ?></div>
					</div>

					<div style="background: #f6f7f7; padding: 15px; border-radius: 4px; text-align: center;">
						<div style="font-size: 32px; font-weight: bold; color: #2271b1;"><?php echo esc_html( $unchanged_count ); ?></div>
						<div style="color: #50575e; font-size: 14px;"><?php esc_html_e( 'Zaten Doğru', 'tamgaci' ); ?></div>
					</div>

					<?php if ( $error_count > 0 ) : ?>
						<div style="background: #f6f7f7; padding: 15px; border-radius: 4px; text-align: center;">
							<div style="font-size: 32px; font-weight: bold; color: #d63638;"><?php echo esc_html( $error_count ); ?></div>
							<div style="color: #50575e; font-size: 14px;"><?php esc_html_e( 'Hata', 'tamgaci' ); ?></div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<?php
			// Display results
			if ( $do_update ) {
				if ( $updated_count > 0 ) {
					echo '<div class="notice notice-success"><p>✅ ' . sprintf( esc_html__( '%d karşılaştırma başlığı başarıyla güncellendi!', 'tamgaci' ), $updated_count ) . '</p></div>';
				}
				if ( $unchanged_count > 0 ) {
					echo '<div class="notice notice-info"><p>ℹ️ ' . sprintf( esc_html__( '%d karşılaştırma zaten doğru başlığa sahipti.', 'tamgaci' ), $unchanged_count ) . '</p></div>';
				}
				if ( $error_count > 0 ) {
					echo '<div class="notice notice-error"><p>❌ ' . sprintf( esc_html__( '%d karşılaştırmada hata oluştu.', 'tamgaci' ), $error_count ) . '</p></div>';
				}

				echo '<p><a href="' . esc_url( admin_url( 'edit.php?post_type=vehicle_comparison' ) ) . '" class="button button-primary">' . esc_html__( 'Tüm Karşılaştırmaları Görüntüle', 'tamgaci' ) . '</a></p>';
			} else {
				// Show preview of changes
				if ( ! empty( $updates ) ) {
					?>
					<h2><?php echo sprintf( esc_html__( 'Değişikliklerin Önizlemesi (%d gönderi güncellenecek)', 'tamgaci' ), count( $updates ) ); ?></h2>

					<table class="wp-list-table widefat fixed striped">
						<thead>
							<tr>
								<th style="width: 80px;"><?php esc_html_e( 'ID', 'tamgaci' ); ?></th>
								<th><?php esc_html_e( 'Eski Başlık', 'tamgaci' ); ?></th>
								<th><?php esc_html_e( 'Yeni Başlık', 'tamgaci' ); ?></th>
								<th style="width: 100px;"><?php esc_html_e( 'Link', 'tamgaci' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( array_slice( $updates, 0, 20 ) as $update ) : ?>
								<tr>
									<td><?php echo esc_html( $update['id'] ); ?></td>
									<td><span style="color: #d63638; text-decoration: line-through;"><?php echo esc_html( $update['old'] ); ?></span></td>
									<td><strong style="color: #00a32a;"><?php echo esc_html( $update['new'] ); ?></strong></td>
									<td><a href="<?php echo esc_url( $update['url'] ); ?>" target="_blank"><?php esc_html_e( 'Görüntüle', 'tamgaci' ); ?></a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<?php if ( count( $updates ) > 20 ) : ?>
						<p><em><?php echo sprintf( esc_html__( 'İlk 20 tanesi gösteriliyor (toplam %d değişiklik)...', 'tamgaci' ), count( $updates ) ); ?></em></p>
					<?php endif; ?>

					<div class="notice notice-warning">
						<p><strong>⚠️ <?php esc_html_e( 'Uyarı:', 'tamgaci' ); ?></strong> <?php echo sprintf( esc_html__( 'Bu işlem %d karşılaştırma gönderisinin başlığını veritabanında güncelleyecek.', 'tamgaci' ), count( $updates ) ); ?></p>
					</div>

					<form method="post" onsubmit="return confirm('<?php echo esc_js( sprintf( __( '%d karşılaştırma başlığını güncellemek istediğinizden emin misiniz?', 'tamgaci' ), count( $updates ) ) ); ?>');">
						<?php wp_nonce_field( 'tamgaci_update_comparison_titles', 'tamgaci_update_titles_nonce' ); ?>
						<p>
							<button type="submit" class="button button-primary">✅ <?php esc_html_e( 'Onayla ve Tüm Başlıkları Güncelle', 'tamgaci' ); ?></button>
							<a href="<?php echo esc_url( admin_url() ); ?>" class="button"><?php esc_html_e( 'İptal', 'tamgaci' ); ?></a>
						</p>
					</form>
					<?php
				} else {
					echo '<div class="notice notice-success"><p>✅ ' . esc_html__( 'Tüm karşılaştırma başlıkları zaten doğru! Güncelleme gerekmez.', 'tamgaci' ) . '</p></div>';
				}
			}
		}
		?>
	</div>
	<?php
}
