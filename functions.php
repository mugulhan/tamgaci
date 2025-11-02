<?php
/**
 * Tamgaci theme bootstrap.
 */

define( 'TAMGACI_VERSION', '0.10.3' );
define( 'TAMGACI_THEME_PATH', __DIR__ );

require_once TAMGACI_THEME_PATH . '/inc/vehicle-post-type.php';
require_once TAMGACI_THEME_PATH . '/inc/theme-updater.php';
require_once TAMGACI_THEME_PATH . '/inc/sitemap.php';

// Disable WordPress default sitemap
add_filter( 'wp_sitemaps_enabled', '__return_false' );

add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 80,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    register_nav_menus( [
        'primary' => __( 'Ana Menü', 'tamgaci' ),
    ] );
} );

add_action( 'wp_enqueue_scripts', function () {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    $css_path = '/assets/css/main.css';
    $js_path  = '/assets/js/main.js';

    $css_file = $theme_dir . $css_path;
    $css_version = TAMGACI_VERSION;
    if ( file_exists( $css_file ) ) {
        $css_version = filemtime( $css_file );
    }
    wp_enqueue_style( 'tamgaci-main', $theme_uri . $css_path, [], $css_version );

    $js_file = $theme_dir . $js_path;
    $js_version = TAMGACI_VERSION;
    if ( file_exists( $js_file ) ) {
        $js_version = filemtime( $js_file );
        wp_enqueue_script( 'tamgaci-main', $theme_uri . $js_path, [ 'jquery' ], $js_version, true );
        wp_add_inline_script(
            'tamgaci-main',
            'window.tamgaciComparePreview = ' . wp_json_encode( [
                'details' => __( 'Detaylar', 'tamgaci' ),
            ] ) . ';',
            'before'
        );
        wp_add_inline_script(
            'tamgaci-main',
            "(function(){\n  var init = function(){\n    var toggles = document.querySelectorAll('[data-header-toggle]');\n    if(!toggles.length){return;}\n    toggles.forEach(function(toggle){\n      var targetId = toggle.getAttribute('aria-controls');\n      if(!targetId){return;}\n      var target = document.getElementById(targetId);\n      if(!target){return;}\n      var openIcon = toggle.querySelector('[data-header-toggle-icon=\"open\"]');\n      var closeIcon = toggle.querySelector('[data-header-toggle-icon=\"close\"]');\n      toggle.addEventListener('click', function(){\n        var expanded = toggle.getAttribute('aria-expanded') === 'true';\n        var nextState = !expanded;\n        toggle.setAttribute('aria-expanded', nextState ? 'true' : 'false');\n        if(target){\n          if(nextState){\n            target.classList.remove('hidden');\n          } else {\n            target.classList.add('hidden');\n          }\n        }\n        if(openIcon && closeIcon){\n          openIcon.classList.toggle('hidden', nextState);\n          closeIcon.classList.toggle('hidden', !nextState);\n        }\n      });\n    });\n  };\n  if(document.readyState === 'loading'){\n    document.addEventListener('DOMContentLoaded', init);\n  } else {\n    init();\n  }\n})();",
            'after'
        );
    }
}, 10 );

add_action( 'wp_enqueue_scripts', function () {
    // Admin panelinde script'leri yükleme
    if ( is_admin() ) {
        return;
    }

    if ( is_page_template( 'page-vehicle-compare-select.php' ) ) {
        wp_enqueue_style( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', [], '4.1.0-rc0' );
        wp_enqueue_script( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', [ 'jquery' ], '4.1.0-rc0', true );
    }
} );

// Enqueue admin styles
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    // Only load on post edit screens for vehicle post types
    if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ] ) ) {
        return;
    }

    $screen = get_current_screen();
    $vehicle_types = [ 'combustion_vehicle', 'electric_vehicle', 'motorcycle' ];

    if ( $screen && in_array( $screen->post_type, $vehicle_types, true ) ) {
        wp_enqueue_style(
            'tamgaci-admin',
            get_template_directory_uri() . '/assets/css/admin.css',
            [],
            TAMGACI_VERSION
        );
    }
} );