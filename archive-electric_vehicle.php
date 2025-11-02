<?php
/**
 * Archive template for Electric Vehicles.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$post_type_object = get_post_type_object( 'electric_vehicle' );
$archive_title    = $post_type_object ? $post_type_object->labels->name : __( 'Elektrikli Araçlar', 'tamgaci' );
$archive_desc     = get_the_archive_description();

$compare_url        = function_exists( 'tamgaci_get_vehicle_compare_url' ) ? tamgaci_get_vehicle_compare_url() : home_url( '/' );
$compare_select_url = function_exists( 'tamgaci_get_vehicle_compare_select_url' ) ? tamgaci_get_vehicle_compare_select_url() : $compare_url;

// Get filter values from URL
$selected_brands = isset( $_GET['marka'] ) ? (array) $_GET['marka'] : [];
$selected_body_types = isset( $_GET['govde'] ) ? (array) $_GET['govde'] : [];
$selected_battery = isset( $_GET['batarya'] ) ? sanitize_text_field( $_GET['batarya'] ) : '';
$selected_range = isset( $_GET['menzil'] ) ? sanitize_text_field( $_GET['menzil'] ) : '';
$selected_charging = isset( $_GET['sarj'] ) ? sanitize_text_field( $_GET['sarj'] ) : '';
$selected_power = isset( $_GET['guc'] ) ? sanitize_text_field( $_GET['guc'] ) : '';

// Get all brands (top-level only)
$all_brands = get_terms( [
    'taxonomy'   => 'vehicle_brand',
    'hide_empty' => true,
    'parent'     => 0,
] );

// Get all body types
$all_body_types = get_terms( [
    'taxonomy'   => 'vehicle_body_type',
    'hide_empty' => true,
] );

// Define spec filter ranges
$battery_ranges = [
    '0-50'    => __( '0-50 kWh', 'tamgaci' ),
    '50-70'   => __( '50-70 kWh', 'tamgaci' ),
    '70-85'   => __( '70-85 kWh', 'tamgaci' ),
    '85-150'  => __( '85+ kWh', 'tamgaci' ),
];

$range_ranges = [
    '0-300'   => __( '0-300 km', 'tamgaci' ),
    '300-400' => __( '300-400 km', 'tamgaci' ),
    '400-500' => __( '400-500 km', 'tamgaci' ),
    '500-999' => __( '500+ km', 'tamgaci' ),
];

$charging_ranges = [
    '0-100'   => __( '0-100 kW', 'tamgaci' ),
    '100-150' => __( '100-150 kW', 'tamgaci' ),
    '150-200' => __( '150-200 kW', 'tamgaci' ),
    '200-500' => __( '200+ kW', 'tamgaci' ),
];

$power_ranges = [
    '0-150'   => __( '0-150 PS', 'tamgaci' ),
    '150-250' => __( '150-250 PS', 'tamgaci' ),
    '250-400' => __( '250-400 PS', 'tamgaci' ),
    '400-999' => __( '400+ PS', 'tamgaci' ),
];
?>
<main class="container mx-auto px-4 py-16 space-y-12" data-compare-container data-compare-url="<?php echo esc_attr( $compare_url ); ?>" data-compare-max="4">
    <header class="max-w-4xl space-y-4">
        <nav class="flex items-center gap-2 text-sm text-slate-600" aria-label="<?php esc_attr_e( 'Breadcrumb', 'tamgaci' ); ?>">
            <a class="transition hover:text-slate-900" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e( 'Anasayfa', 'tamgaci' ); ?>
            </a>
            <span data-icon="mdi:chevron-right" class="text-slate-400"></span>
            <span class="font-semibold text-slate-900"><?php echo esc_html( $archive_title ); ?></span>
        </nav>
        <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl"><?php echo esc_html( $archive_title ); ?></h1>
        <?php if ( $archive_desc ) : ?>
            <div class="prose max-w-none text-slate-600">
                <?php echo wp_kses_post( $archive_desc ); ?>
            </div>
        <?php endif; ?>
        <div class="flex flex-wrap items-center gap-3">
            <a class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700" href="<?php echo esc_url( $compare_select_url ); ?>">
                <span data-icon="mdi:table"></span>
                <?php esc_html_e( 'Karşılaştırmaya Başla', 'tamgaci' ); ?>
            </a>
            <a class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-900" href="<?php echo esc_url( $compare_url ); ?>">
                <span data-icon="mdi:playlist-edit"></span>
                <?php esc_html_e( 'Seçimlerimi Gör', 'tamgaci' ); ?>
            </a>
        </div>
    </header>

    <div class="flex flex-col gap-8 md:flex-row md:items-start md:gap-8">
        <!-- Filters Sidebar -->
        <aside class="w-full md:sticky md:top-4 md:w-64 md:flex-shrink-0">
            <form method="get" action="" class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">
                            <span data-icon="mdi:filter-variant" class="mr-2"></span>
                            <?php esc_html_e( 'Filtreler', 'tamgaci' ); ?>
                        </h2>
                        <?php if ( ! empty( $selected_brands ) || ! empty( $selected_body_types ) || $selected_battery || $selected_range || $selected_charging || $selected_power ) : ?>
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'electric_vehicle' ) ); ?>" class="text-xs text-slate-500 hover:text-slate-700">
                                <?php esc_html_e( 'Temizle', 'tamgaci' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Brand Filter -->
                    <?php if ( ! empty( $all_brands ) && ! is_wp_error( $all_brands ) ) : ?>
                        <div class="border-t border-slate-100 py-6">
                            <h3 class="mb-4 text-sm font-semibold text-slate-700"><?php esc_html_e( 'Marka', 'tamgaci' ); ?></h3>
                            <div class="space-y-2">
                                <?php foreach ( $all_brands as $brand ) : ?>
                                    <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
                                        <input
                                            type="checkbox"
                                            name="marka[]"
                                            value="<?php echo esc_attr( $brand->slug ); ?>"
                                            <?php checked( in_array( $brand->slug, $selected_brands ) ); ?>
                                            class="rounded border-slate-300 text-slate-900 focus:ring-slate-500"
                                        />
                                        <span><?php echo esc_html( $brand->name ); ?></span>
                                        <span class="ml-auto text-xs text-slate-400">(<?php echo esc_html( $brand->count ); ?>)</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Body Type Filter -->
                    <?php if ( ! empty( $all_body_types ) && ! is_wp_error( $all_body_types ) ) : ?>
                        <div class="border-t border-slate-100 py-6">
                            <h3 class="mb-4 text-sm font-semibold text-slate-700"><?php esc_html_e( 'Gövde Tipi', 'tamgaci' ); ?></h3>
                            <div class="space-y-2">
                                <?php foreach ( $all_body_types as $body_type ) : ?>
                                    <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
                                        <input
                                            type="checkbox"
                                            name="govde[]"
                                            value="<?php echo esc_attr( $body_type->slug ); ?>"
                                            <?php checked( in_array( $body_type->slug, $selected_body_types ) ); ?>
                                            class="rounded border-slate-300 text-slate-900 focus:ring-slate-500"
                                        />
                                        <span><?php echo esc_html( $body_type->name ); ?></span>
                                        <span class="ml-auto text-xs text-slate-400">(<?php echo esc_html( $body_type->count ); ?>)</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Battery Capacity Filter -->
                    <div class="border-t border-slate-100 py-6">
                        <h3 class="mb-4 text-sm font-semibold text-slate-700"><?php esc_html_e( 'Batarya Kapasitesi', 'tamgaci' ); ?></h3>
                        <div class="space-y-2">
                            <?php foreach ( $battery_ranges as $value => $label ) : ?>
                                <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
                                    <input
                                        type="radio"
                                        name="batarya"
                                        value="<?php echo esc_attr( $value ); ?>"
                                        <?php checked( $selected_battery, $value ); ?>
                                        class="rounded-full border-slate-300 text-slate-900 focus:ring-slate-500"
                                    />
                                    <span><?php echo esc_html( $label ); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Range Filter -->
                    <div class="border-t border-slate-100 py-6">
                        <h3 class="mb-4 text-sm font-semibold text-slate-700"><?php esc_html_e( 'WLTP Menzili', 'tamgaci' ); ?></h3>
                        <div class="space-y-2">
                            <?php foreach ( $range_ranges as $value => $label ) : ?>
                                <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
                                    <input
                                        type="radio"
                                        name="menzil"
                                        value="<?php echo esc_attr( $value ); ?>"
                                        <?php checked( $selected_range, $value ); ?>
                                        class="rounded-full border-slate-300 text-slate-900 focus:ring-slate-500"
                                    />
                                    <span><?php echo esc_html( $label ); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- DC Charging Power Filter -->
                    <div class="border-t border-slate-100 py-6">
                        <h3 class="mb-4 text-sm font-semibold text-slate-700"><?php esc_html_e( 'DC Hızlı Şarj', 'tamgaci' ); ?></h3>
                        <div class="space-y-2">
                            <?php foreach ( $charging_ranges as $value => $label ) : ?>
                                <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
                                    <input
                                        type="radio"
                                        name="sarj"
                                        value="<?php echo esc_attr( $value ); ?>"
                                        <?php checked( $selected_charging, $value ); ?>
                                        class="rounded-full border-slate-300 text-slate-900 focus:ring-slate-500"
                                    />
                                    <span><?php echo esc_html( $label ); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Horsepower Filter -->
                    <div class="border-t border-slate-100 py-6">
                        <h3 class="mb-4 text-sm font-semibold text-slate-700"><?php esc_html_e( 'Motor Gücü', 'tamgaci' ); ?></h3>
                        <div class="space-y-2">
                            <?php foreach ( $power_ranges as $value => $label ) : ?>
                                <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
                                    <input
                                        type="radio"
                                        name="guc"
                                        value="<?php echo esc_attr( $value ); ?>"
                                        <?php checked( $selected_power, $value ); ?>
                                        class="rounded-full border-slate-300 text-slate-900 focus:ring-slate-500"
                                    />
                                    <span><?php echo esc_html( $label ); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-6">
                        <button type="submit" class="w-full rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">
                            <?php esc_html_e( 'Filtreleri Uygula', 'tamgaci' ); ?>
                        </button>
                    </div>
                </div>
            </form>
        </aside>

        <!-- Vehicle List -->
        <div class="flex-1">
            <?php if ( have_posts() ) : ?>
                <section class="space-y-8">
                    <div class="mb-4 flex items-center justify-between">
                        <p class="text-sm text-slate-600">
                            <?php
                            global $wp_query;
                            printf(
                                esc_html( _n( '%s araç bulundu', '%s araç bulundu', $wp_query->found_posts, 'tamgaci' ) ),
                                '<strong>' . esc_html( number_format_i18n( $wp_query->found_posts ) ) . '</strong>'
                            );
                            ?>
                        </p>
                    </div>
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php
                while ( have_posts() ) :
                    the_post();

                    $vehicle_data = function_exists( 'tamgaci_prepare_vehicle_display_data' )
                        ? tamgaci_prepare_vehicle_display_data( get_the_ID() )
                        : null;

                    if ( ! $vehicle_data ) {
                        continue;
                    }

                    get_template_part(
                        'template-parts/vehicle/card',
                        null,
                        [
                            'vehicle' => $vehicle_data,
                        ]
                    );
                endwhile;
                ?>
            </div>
            <?php the_posts_pagination( [
                'mid_size'           => 2,
                'prev_text'          => __( 'Önceki', 'tamgaci' ),
                'next_text'          => __( 'Sonraki', 'tamgaci' ),
                'screen_reader_text' => __( 'Araç sayfaları navigasyonu', 'tamgaci' ),
            ] ); ?>
                </section>
            <?php else : ?>
                <section class="rounded-3xl border border-dashed border-slate-200 bg-white p-12 text-center">
                    <h2 class="text-2xl font-semibold text-slate-900"><?php esc_html_e( 'Henüz içerik eklenmemiş.', 'tamgaci' ); ?></h2>
                    <p class="mt-3 text-sm text-slate-600">
                        <?php esc_html_e( 'Filtrelerinize uygun araç bulunamadı. Lütfen farklı filtreler deneyin.', 'tamgaci' ); ?>
                    </p>
                </section>
            <?php endif; ?>
        </div>
    </div>

    <div class="vehicle-comparison__selection pointer-events-none fixed inset-x-0 bottom-6 z-40 flex justify-center" data-compare-panel hidden>
        <div class="pointer-events-auto flex items-center gap-4 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-xl">
            <span class="flex items-center gap-2 text-xs uppercase tracking-wide text-white/80">
                <span data-icon="mdi:check"></span>
                <span data-compare-count>0</span>
                <?php esc_html_e( 'araç seçildi', 'tamgaci' ); ?>
            </span>
            <div class="flex items-center gap-2">
                <button type="button" class="rounded-full border border-white/30 px-3 py-1 text-xs font-semibold uppercase tracking-wide transition hover:border-white/60" data-compare-clear>
                    <?php esc_html_e( 'Temizle', 'tamgaci' ); ?>
                </button>
                <a class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40" href="#" data-compare-submit>
                    <span data-icon="mdi:table"></span>
                    <?php esc_html_e( 'Karşılaştır', 'tamgaci' ); ?>
                </a>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
