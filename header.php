<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="theme-color" content="#1e293b" />

    <!-- Preconnect to external domains for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <!-- DNS prefetch for better performance -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />

    <!-- Security headers -->
    <meta name="referrer" content="strict-origin-when-cross-origin" />

    <!-- Iconify Icons -->
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-slate-100 text-slate-900' ); ?>>
<?php wp_body_open(); ?>
<?php
$site_name         = get_bloginfo( 'name' );
$site_description  = get_bloginfo( 'description', 'display' );
$custom_logo_id    = (int) get_theme_mod( 'custom_logo' );
$logo_markup       = '';
$has_primary_menu  = has_nav_menu( 'primary' );
$vehicle_brands    = get_terms( [
    'taxonomy'   => 'vehicle_brand',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
    'number'     => 15
] );

if ( $custom_logo_id ) {
    $logo_markup = wp_get_attachment_image(
        $custom_logo_id,
        'full',
        false,
        [
            'class'    => 'h-10 w-auto max-h-10 object-contain',
            'loading'  => 'eager',
            'fetchpriority' => 'high',
            'alt'      => $site_name ?: $site_description,
            'decoding' => 'async',
        ]
    );
}

// Fallback: If no logo, try to use site icon
$site_icon_id = get_option( 'site_icon' );
if ( ! $logo_markup && $site_icon_id ) {
    $logo_markup = wp_get_attachment_image(
        $site_icon_id,
        'full',
        false,
        [
            'class'    => 'h-10 w-auto max-h-10 object-contain',
            'loading'  => 'eager',
            'fetchpriority' => 'high',
            'alt'      => $site_name ?: $site_description,
            'decoding' => 'async',
        ]
    );
}

$brand_initial = '';
if ( $site_name ) {
    $brand_initial = function_exists( 'mb_substr' )
        ? mb_substr( $site_name, 0, 1 )
        : substr( $site_name, 0, 1 );
}
?>
<header class="sticky top-0 z-50 border-b border-slate-200/50 bg-white/80 text-slate-900 shadow-lg shadow-slate-900/5 backdrop-blur-xl supports-backdrop-blur:bg-white/75" role="banner">
    <div class="container mx-auto flex items-center justify-between gap-4 px-6 py-3 lg:flex-wrap lg:px-8">
        <a class="group flex items-center gap-4 text-slate-900 no-underline transition-all duration-300 hover:scale-105 focus:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 rounded-lg p-2 -m-2" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( sprintf( __( '%s ana sayfasına git', 'tamgaci' ), $site_name ?: get_bloginfo( 'name' ) ) ); ?>">
            <?php if ( $logo_markup ) : ?>
                <div class="relative inline-flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 p-0.5 shadow-lg shadow-blue-500/25 transition-all duration-300 group-hover:shadow-xl group-hover:shadow-blue-500/40" aria-hidden="true">
                    <span class="inline-flex h-full w-full items-center justify-center overflow-hidden rounded-[14px] bg-white p-1.5">
                        <?php echo $logo_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </span>
                </div>
            <?php elseif ( $brand_initial ) : ?>
                <div class="relative inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 text-base font-bold uppercase tracking-wide text-white shadow-lg shadow-slate-900/25 transition-all duration-300 group-hover:shadow-xl group-hover:shadow-slate-900/40" aria-hidden="true">
                    <?php echo esc_html( strtoupper( $brand_initial ) ); ?>
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/20 to-transparent"></div>
                </div>
            <?php endif; ?>
            <?php if ( $site_name ) : ?>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-slate-900 transition-colors duration-300 group-hover:text-blue-600 sm:text-xl">
                        <?php echo esc_html( $site_name ); ?>
                    </span>
                    <?php if ( $site_description ) : ?>
                        <span class="text-xs font-medium text-slate-500 transition-colors duration-300 group-hover:text-slate-600">
                            <?php echo esc_html( $site_description ); ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </a>

        <!-- Desktop Navigation Links -->
        <div class="hidden lg:flex lg:items-center lg:gap-2">
            <!-- Electric Vehicles Link -->
            <a
                href="<?php echo esc_url( get_post_type_archive_link( 'electric_vehicle' ) ); ?>"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-slate-50 to-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-md shadow-slate-900/5 transition-all duration-300 hover:scale-105 hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 hover:shadow-lg hover:shadow-blue-500/20 focus:scale-105 focus:from-blue-50 focus:to-purple-50 focus:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2"
            >
                <iconify-icon icon="mdi:ev-station" class="h-4 w-4" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                <span><?php esc_html_e( 'Elektrikli Araçlar', 'tamgaci' ); ?></span>
            </a>

            <!-- Desktop Brands Menu -->
            <?php if ( ! is_wp_error( $vehicle_brands ) && ! empty( $vehicle_brands ) ) : ?>
            <div class="relative">
                <button
                    type="button"
                    class="group flex items-center gap-2 rounded-xl bg-gradient-to-r from-slate-50 to-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-md shadow-slate-900/5 transition-all duration-300 hover:scale-105 hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 hover:shadow-lg hover:shadow-blue-500/20 focus:scale-105 focus:from-blue-50 focus:to-purple-50 focus:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2"
                    data-brands-toggle
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <iconify-icon icon="mdi:car" class="h-4 w-4 transition-transform duration-300 group-hover:scale-110" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                    <span><?php esc_html_e( 'Markalar', 'tamgaci' ); ?></span>
                    <iconify-icon icon="mdi:chevron-down" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                </button>

                <div
                    class="absolute left-0 top-full z-50 mt-2 hidden w-72 rounded-2xl border border-slate-200/50 bg-white/95 p-2 shadow-xl shadow-slate-900/10 backdrop-blur-xl transition-all duration-300"
                    data-brands-menu
                >
                    <div class="grid grid-cols-2 gap-1">
                        <?php foreach ( $vehicle_brands as $brand ) : ?>
                            <a
                                href="<?php echo esc_url( get_term_link( $brand ) ); ?>"
                                class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition-colors duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600"
                            >
                                <iconify-icon icon="mdi:car-side" class="h-4 w-4 opacity-60" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                                <span><?php echo esc_html( $brand->name ); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <?php if ( count( $vehicle_brands ) >= 15 ) : ?>
                        <div class="mt-2 border-t border-slate-200 pt-2">
                            <a
                                href="/marka"
                                class="flex w-full items-center justify-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-blue-600 transition-colors duration-200 hover:bg-blue-50"
                            >
                                <span><?php esc_html_e( 'Tüm Markaları Gör', 'tamgaci' ); ?></span>
                                <iconify-icon icon="mdi:arrow-right" class="h-4 w-4" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Desktop Primary Menu - Right -->
        <?php if ( $has_primary_menu ) : ?>
            <div class="hidden lg:block">
                <nav
                    id="primary-navigation"
                    aria-label="<?php esc_attr_e( 'Birincil menü', 'tamgaci' ); ?>"
                    role="navigation"
                >
                    <?php
                    wp_nav_menu( [
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'flex items-center gap-2',
                        'fallback_cb'    => false,
                        'link_before'    => '<span class="relative inline-flex items-center rounded-xl px-4 py-2.5 text-slate-700 transition-all duration-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 hover:shadow-lg hover:shadow-blue-500/10 focus:bg-gradient-to-r focus:from-blue-50 focus:to-purple-50 focus:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 hover:scale-105 focus:scale-105">',
                        'link_after'     => '<div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/20 to-transparent opacity-0 transition-opacity duration-300 hover:opacity-100"></div></span>',
                    ] );
                    ?>
                </nav>
            </div>
        <?php endif; ?>

        <!-- Mobile Hamburger Menu Button - Right Side -->
        <button
            type="button"
            class="group relative inline-flex h-12 w-12 items-center justify-center rounded-2xl border-0 bg-gradient-to-br from-slate-100 to-slate-200 text-slate-600 shadow-lg shadow-slate-900/5 transition-all duration-300 hover:scale-105 hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 hover:shadow-xl hover:shadow-blue-500/20 focus:scale-105 focus:from-blue-50 focus:to-purple-50 focus:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-2 lg:hidden"
            aria-controls="mobile-navigation"
            aria-expanded="false"
            aria-haspopup="true"
            data-mobile-toggle
        >
            <span class="sr-only"><?php esc_html_e( 'Menüyü aç/kapat', 'tamgaci' ); ?></span>
            <iconify-icon icon="mdi:menu" data-mobile-toggle-icon="open" class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
            <iconify-icon icon="mdi:close" data-mobile-toggle-icon="close" class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" aria-hidden="true" style="display: none;"></iconify-icon>
            <div class="pointer-events-none absolute inset-0 rounded-2xl bg-gradient-to-br from-white/40 to-transparent transition-opacity duration-300 group-hover:opacity-60"></div>
        </button>

        <!-- Mobile Navigation Full-Screen Overlay -->
        <div
            id="mobile-navigation"
            class="fixed left-0 right-0 top-0 bottom-0 z-[100] hidden bg-gradient-to-br from-slate-900/95 to-slate-800/95 backdrop-blur-xl lg:hidden"
            data-mobile-nav-overlay
            style="position: fixed !important;"
        >
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiIGQ9Ik0yMCAyMGM1LjUyMyAwIDEwLTQuNDc3IDEwLTEwUzI1LjUyMyAwIDIwIDBzLTEwIDQuNDc3LTEwIDEwIDQuNDc3IDEwIDEwIDEweiIvPjwvZz48L3N2Zz4=')] opacity-20"></div>

            <!-- Content Container -->
            <div class="relative flex h-full flex-col">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-6 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <iconify-icon icon="mdi:car" class="h-5 w-5 text-white" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                        </div>
                        <span class="text-xl font-bold text-white"><?php echo esc_html( get_bloginfo( 'name' ) ?: __( 'Menü', 'tamgaci' ) ); ?></span>
                    </div>
                    <button
                        type="button"
                        class="relative inline-flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white transition-all duration-300 hover:bg-white/20 hover:scale-105 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50"
                        data-mobile-close
                    >
                        <iconify-icon icon="mdi:close" class="h-6 w-6" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                        <span class="sr-only"><?php esc_html_e( 'Menüyü kapat', 'tamgaci' ); ?></span>
                    </button>
                </div>

                <!-- Main Content -->
                <div class="flex-1 overflow-y-auto px-6 py-8">
                    <!-- Mobile Electric Vehicles Link -->
                    <div class="mb-12">
                        <a
                            href="<?php echo esc_url( get_post_type_archive_link( 'electric_vehicle' ) ); ?>"
                            class="group flex items-center gap-4 rounded-xl bg-gradient-to-r from-blue-500/10 to-purple-600/10 p-5 backdrop-blur-sm transition-all duration-300 hover:from-blue-500/20 hover:to-purple-600/20 hover:scale-105 hover:shadow-lg"
                        >
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg">
                                <iconify-icon icon="mdi:ev-station" class="h-6 w-6 text-white" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                            </div>
                            <div class="flex-1">
                                <span class="block text-lg font-bold text-white"><?php esc_html_e( 'Elektrikli Araçlar', 'tamgaci' ); ?></span>
                                <span class="text-sm text-white/70"><?php esc_html_e( 'Tüm elektrikli araçları keşfedin', 'tamgaci' ); ?></span>
                            </div>
                            <iconify-icon icon="mdi:chevron-right" class="h-6 w-6 text-white/50 transition-transform group-hover:translate-x-1" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                        </a>
                    </div>

                    <!-- Mobile Brands Menu -->
                    <?php if ( ! is_wp_error( $vehicle_brands ) && ! empty( $vehicle_brands ) ) : ?>
                        <div class="mb-12">
                            <div class="mb-6 flex items-center gap-3">
                                <iconify-icon icon="mdi:car-multiple" class="h-5 w-5 text-blue-400" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                                <h3 class="text-lg font-bold text-white"><?php esc_html_e( 'Markalar', 'tamgaci' ); ?></h3>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <?php foreach ( array_slice( $vehicle_brands, 0, 12 ) as $brand ) : ?>
                                    <a
                                        href="<?php echo esc_url( get_term_link( $brand ) ); ?>"
                                        class="group flex items-center gap-3 rounded-xl bg-white/5 p-4 backdrop-blur-sm transition-all duration-300 hover:bg-white/10 hover:scale-105 hover:shadow-lg"
                                    >
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500/20 to-purple-600/20 group-hover:from-blue-500/30 group-hover:to-purple-600/30">
                                            <iconify-icon icon="mdi:car-side" class="h-5 w-5 text-blue-400 group-hover:text-blue-300" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                                        </div>
                                        <span class="font-medium text-white group-hover:text-blue-200"><?php echo esc_html( $brand->name ); ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <?php if ( count( $vehicle_brands ) > 12 ) : ?>
                                <a
                                    href="/marka"
                                    class="mt-6 flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-white/5 p-4 font-semibold text-white backdrop-blur-sm transition-all duration-300 hover:bg-white/10 hover:scale-105"
                                >
                                    <span><?php esc_html_e( 'Tüm Markaları Gör', 'tamgaci' ); ?></span>
                                    <iconify-icon icon="mdi:arrow-right" class="h-5 w-5" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Mobile Primary Menu -->
                    <?php if ( $has_primary_menu ) : ?>
                        <div>
                            <div class="mb-6 flex items-center gap-3">
                                <iconify-icon icon="mdi:menu" class="h-5 w-5 text-purple-400" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                                <h3 class="text-lg font-bold text-white"><?php esc_html_e( 'Sayfalar', 'tamgaci' ); ?></h3>
                            </div>
                            <?php
                            wp_nav_menu( [
                                'theme_location' => 'primary',
                                'container'      => false,
                                'menu_id'        => 'mobile-primary-menu',
                                'menu_class'     => 'space-y-3',
                                'fallback_cb'    => false,
                                'link_before'    => '<span class="group flex items-center gap-3 rounded-xl bg-white/5 p-4 font-medium text-white backdrop-blur-sm transition-all duration-300 hover:bg-white/10 hover:scale-105 hover:text-blue-200">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-purple-500/20 to-pink-600/20 group-hover:from-purple-500/30 group-hover:to-pink-600/30">
                                        <iconify-icon icon="mdi:circle-outline" class="h-4 w-4 text-purple-400 group-hover:text-purple-300" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                                    </div>',
                                'link_after'     => '</span>',
                            ] );
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer -->
                <div class="border-t border-white/10 px-6 py-6">
                    <div class="flex items-center justify-center gap-2 text-sm text-white/60">
                        <iconify-icon icon="mdi:heart" class="h-4 w-4 text-red-400" aria-hidden="true" style="display: inline-flex;"></iconify-icon>
                        <span><?php printf( esc_html__( '%s ile güçlendirilmiştir', 'tamgaci' ), esc_html( get_bloginfo( 'name' ) ) ); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main id="content" class="relative min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50" role="main">
