<?php
/**
 * Tekil araç görünümü.
 */

$vehicle_id = get_the_ID();

if ( ! $vehicle_id ) {
    return;
}

$vehicle = function_exists( 'tamgaci_prepare_vehicle_display_data' )
    ? tamgaci_prepare_vehicle_display_data( $vehicle_id )
    : null;

if ( ! $vehicle ) {
    return;
}

$post_type    = $vehicle['post_type'];
$is_electric  = $vehicle['is_electric'];
$icon         = $vehicle['icon'];
$year         = $vehicle['year'];
$model_years  = $vehicle['model_years'] ?? [];
$equipment    = $vehicle['equipment'];
$brands       = $vehicle['brands'];
$models       = $vehicle['models'];
$powertrain   = $vehicle['powertrain'];
$specs        = $vehicle['specs'];
$notes        = $vehicle['notes'];
$charging     = $vehicle['charging'];
$dc_charging_time_display = $vehicle['dc_charging_time_display'] ?? '';
$ac_charging_time_display = $vehicle['ac_charging_time_display'] ?? '';
$equipment_terms = tamgaci_get_vehicle_equipment_names( $vehicle_id );
$body_terms      = tamgaci_get_vehicle_term_names( $vehicle_id, 'vehicle_body_type' );
$price        = $vehicle['price'];

$archive_link  = get_post_type_archive_link( $post_type );
$archive_label = $is_electric
    ? __( 'Tüm Elektrikli Araçlar', 'tamgaci' )
    : __( 'Tüm Yakıtlı & Hibrit Araçlar', 'tamgaci' );

$compare_url = function_exists( 'tamgaci_get_vehicle_compare_url' )
    ? tamgaci_get_vehicle_compare_url()
    : get_permalink();

$post_types = tamgaci_get_vehicle_post_types();

// Get vehicles from the same brand
$same_brand_vehicles = [];
if ( ! empty( $brands ) ) {
    $same_brand_args = [
        'post_type'           => $post_type,
        'post__not_in'        => [ $vehicle_id ],
        'posts_per_page'      => 8,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
        'orderby'             => 'rand',
        'tax_query'           => [
            [
                'taxonomy' => 'vehicle_brand',
                'field'    => 'name',
                'terms'    => $brands,
            ],
        ],
    ];

    $same_brand_query = new WP_Query( $same_brand_args );

    if ( $same_brand_query->have_posts() ) {
        while ( $same_brand_query->have_posts() ) {
            $same_brand_query->the_post();
            $related_data = tamgaci_prepare_vehicle_display_data( get_the_ID() );
            if ( $related_data ) {
                $same_brand_vehicles[] = $related_data;
            }
        }
        wp_reset_postdata();
    }
}

// Get vehicles from other brands
$other_brands_vehicles = [];
$other_brands_args = [
    'post_type'           => $post_type,
    'post__not_in'        => [ $vehicle_id ],
    'posts_per_page'      => 8,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'orderby'             => 'rand',
];

// If we have brands, exclude them
if ( ! empty( $brands ) ) {
    $other_brands_args['tax_query'] = [
        [
            'taxonomy' => 'vehicle_brand',
            'field'    => 'name',
            'terms'    => $brands,
            'operator' => 'NOT IN',
        ],
    ];
}

$other_brands_query = new WP_Query( $other_brands_args );

if ( $other_brands_query->have_posts() ) {
    while ( $other_brands_query->have_posts() ) {
        $other_brands_query->the_post();
        $related_data = tamgaci_prepare_vehicle_display_data( get_the_ID() );
        if ( $related_data ) {
            $other_brands_vehicles[] = $related_data;
        }
    }
    wp_reset_postdata();
}

$compare_max = 4;

?>
<section class="relative bg-white" data-compare-container data-compare-url="<?php echo esc_attr( $compare_url ); ?>" data-compare-max="<?php echo esc_attr( $compare_max ); ?>">
<article class="overflow-hidden" data-vehicle-id="<?php echo esc_attr( $vehicle['id'] ); ?>">
    <div class="container mx-auto px-4 py-10">
        <nav class="mb-6 flex items-center gap-2 text-sm text-slate-600" aria-label="<?php esc_attr_e( 'Breadcrumb', 'tamgaci' ); ?>">
            <a class="transition hover:text-slate-900" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e( 'Anasayfa', 'tamgaci' ); ?>
            </a>
            <span data-icon="mdi:chevron-right" class="text-slate-400"></span>
            <?php if ( $archive_link ) : ?>
                <a class="transition hover:text-slate-900" href="<?php echo esc_url( $archive_link ); ?>">
                    <?php echo esc_html( $is_electric ? __( 'Elektrikli Araçlar', 'tamgaci' ) : __( 'Yakıtlı & Hibrit Araçlar', 'tamgaci' ) ); ?>
                </a>
                <span data-icon="mdi:chevron-right" class="text-slate-400"></span>
            <?php endif; ?>
            <?php
            // Get the first brand (top-level) for breadcrumb
            if ( ! empty( $brands ) ) {
                $all_terms = wp_get_post_terms( $vehicle_id, 'vehicle_brand' );
                foreach ( $all_terms as $term ) {
                    if ( $term->parent === 0 ) { // Only show first brand
                        ?>
                        <a class="transition hover:text-slate-900" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
                            <?php echo esc_html( $term->name ); ?>
                        </a>
                        <span data-icon="mdi:chevron-right" class="text-slate-400"></span>
                        <?php
                        break; // Only show first brand
                    }
                }
            }
            ?>
            <span class="font-semibold text-slate-900"><?php the_title(); ?></span>
        </nav>
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px]">
            <div class="flex flex-col gap-8">
                <header class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-3 text-slate-500">
                            <span class="text-3xl" data-icon="<?php echo esc_attr( $icon ); ?>"></span>
                            <?php if ( $powertrain ) : ?>
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-1 text-xs font-semibold uppercase tracking-wide text-white">
                                    <span data-icon="mdi:flash"></span>
                                    <?php echo esc_html( implode( ' / ', $powertrain ) ); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ( $year ) : ?>
                                <span class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1 text-xs font-semibold text-slate-700">
                                    <span data-icon="mdi:calendar"></span>
                                    <?php echo esc_html( $year ); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="mt-4 flex flex-col gap-2">
                            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl"><?php the_title(); ?></h1>
                            <?php if ( $brands ) : ?>
                                <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                                    <?php
                                    // Get only top-level brands from vehicle_brand taxonomy
                                    $all_terms = wp_get_post_terms( $vehicle_id, 'vehicle_brand' );
                                    foreach ( $all_terms as $term ) :
                                        if ( $term->parent === 0 ) : // Only show brands (top-level)
                                            ?>
                                            <a class="mr-2 inline-flex items-center gap-1 text-slate-500 transition hover:text-slate-900" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
                                                <span data-icon="mdi:factory"></span>
                                                <?php echo esc_html( $term->name ); ?>
                                            </a>
                                            <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </p>
                            <?php endif; ?>
                            <?php if ( $models ) : ?>
                                <p class="flex flex-wrap items-center gap-2 text-base text-slate-600">
                                    <?php
                                    // Get only models (2nd level) from vehicle_brand taxonomy
                                    $all_terms = wp_get_post_terms( $vehicle_id, 'vehicle_brand' );
                                    foreach ( $all_terms as $term ) :
                                        // Only show models (has parent, but parent is top-level)
                                        if ( $term->parent > 0 ) {
                                            $parent_term = get_term( $term->parent, 'vehicle_brand' );
                                            if ( $parent_term && ! is_wp_error( $parent_term ) && $parent_term->parent === 0 ) :
                                                ?>
                                                <a class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-300 hover:text-slate-900" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
                                                    <?php echo esc_html( $term->name ); ?>
                                                </a>
                                                <?php
                                            endif;
                                        }
                                    endforeach;
                                    ?>
                                </p>
                            <?php endif; ?>
                            <?php if ( $equipment_terms ) : ?>
                                <p class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
                                    <?php
                                    // Get equipment package terms from vehicle_brand taxonomy
                                    $all_terms = wp_get_post_terms( $vehicle_id, 'vehicle_brand' );
                                    foreach ( $all_terms as $term ) :
                                        // Only show equipment packages (3rd level - has parent with parent)
                                        if ( $term->parent > 0 ) {
                                            $parent_term = get_term( $term->parent, 'vehicle_brand' );
                                            if ( $parent_term && ! is_wp_error( $parent_term ) && $parent_term->parent > 0 ) :
                                                ?>
                                                <a class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-700 transition hover:border-slate-400 hover:text-slate-900" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
                                                    <?php echo esc_html( $term->name ); ?>
                                                </a>
                                                <?php
                                            endif;
                                        }
                                    endforeach;
                                    ?>
                                </p>
                            <?php elseif ( $equipment ) : ?>
                                <p class="text-base font-semibold text-slate-800">
                                    <?php echo esc_html( $equipment ); ?>
                                </p>
                            <?php endif; ?>
                            <?php if ( $body_terms ) : ?>
                                <p class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
                                    <?php foreach ( wp_get_post_terms( $vehicle_id, 'vehicle_body_type' ) as $term ) : ?>
                                        <a class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-300 hover:text-slate-900" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
                                            <?php echo esc_html( $term->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ( ! empty( $model_years ) ) : ?>
                                <p class="flex flex-wrap items-center gap-2 text-sm">
                                    <span class="inline-flex items-center gap-2 rounded-full border-2 border-blue-500 bg-blue-50 px-3 py-1.5 text-sm font-bold text-blue-700">
                                        <span data-icon="mdi:calendar-star"></span>
                                        <?php echo esc_html( implode( ', ', $model_years ) ); ?> <?php esc_html_e( 'Model', 'tamgaci' ); ?>
                                    </span>
                                </p>
                            <?php endif; ?>
                            <?php if ( $price ) : ?>
                                <p class="text-2xl font-bold text-slate-900">
                                    <?php echo esc_html( $price ); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <figure class="mt-4 w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg md:mt-0 md:h-44 md:w-64 lg:w-80">
                            <?php the_post_thumbnail( 'large', [ 'class' => 'h-full w-full object-contain' ] ); ?>
                        </figure>
                    <?php endif; ?>
                </header>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="compare-toggle inline-flex items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-400" data-compare-toggle data-vehicle-id="<?php echo esc_attr( $vehicle['id'] ); ?>">
                        <span class="compare-toggle__label--add flex items-center gap-1">
                            <span data-icon="mdi:checkbox-blank-outline"></span>
                            <?php esc_html_e( 'Karşılaştırmaya ekle', 'tamgaci' ); ?>
                        </span>
                        <span class="compare-toggle__label--remove hidden items-center gap-1">
                            <span data-icon="mdi:checkbox-marked"></span>
                            <?php esc_html_e( 'Seçildi', 'tamgaci' ); ?>
                        </span>
                    </button>
                    <a class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-400" href="<?php echo esc_url( tamgaci_get_vehicle_compare_url() ); ?>" data-compare-clear>
                        <span data-icon="mdi:playlist-edit"></span>
                        <?php esc_html_e( 'Seçimleri Düzenle', 'tamgaci' ); ?>
                    </a>
                </div>

                <?php if ( $specs ) : ?>
                    <section>
                        <h2 class="text-lg font-semibold text-slate-900">
                            <?php
                            if ( $is_electric ) {
                                esc_html_e( 'Elektrikli Araç Teknik Özellikleri', 'tamgaci' );
                            } elseif ( $post_type === 'motorcycle' ) {
                                esc_html_e( 'Motor Teknik Özellikleri', 'tamgaci' );
                            } else {
                                esc_html_e( 'Yakıtlı Araç Teknik Özellikleri', 'tamgaci' );
                            }
                            ?>
                        </h2>
                        <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                            <?php foreach ( $specs as $spec ) : ?>
                                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                    <dt class="text-xs uppercase tracking-wide text-slate-500"><?php echo esc_html( $spec['label'] ); ?></dt>
                                    <dd class="mt-1 text-base font-medium text-slate-900"><?php echo esc_html( $spec['value'] ); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    </section>
                <?php endif; ?>

                <?php if ( ( $is_electric && ( $charging || $dc_charging_time_display || $ac_charging_time_display ) ) || $notes ) : ?>
                    <section class="rounded-2xl bg-slate-50 p-6 text-sm text-slate-700 shadow-inner">
                        <h2 class="text-base font-semibold text-slate-900"><?php esc_html_e( 'Şarj Bilgileri & Notlar', 'tamgaci' ); ?></h2>
                        <div class="mt-3 space-y-3">
                            <?php if ( $is_electric && $dc_charging_time_display ) : ?>
                                <p class="flex items-start gap-2">
                                    <span data-icon="mdi:lightning-bolt" class="mt-0.5 text-lg text-amber-500"></span>
                                    <span><strong>DC Hızlı Şarj:</strong> <?php echo esc_html( $dc_charging_time_display ); ?></span>
                                </p>
                            <?php endif; ?>
                            <?php if ( $is_electric && $ac_charging_time_display ) : ?>
                                <p class="flex items-start gap-2">
                                    <span data-icon="mdi:power-plug" class="mt-0.5 text-lg text-blue-500"></span>
                                    <span><strong>AC Şarj:</strong> <?php echo esc_html( $ac_charging_time_display ); ?></span>
                                </p>
                            <?php endif; ?>
                            <?php if ( $is_electric && $charging ) : ?>
                                <p class="flex items-start gap-2">
                                    <span data-icon="mdi:ev-station" class="mt-0.5 text-lg text-slate-500"></span>
                                    <span><?php echo esc_html( $charging ); ?></span>
                                </p>
                            <?php endif; ?>
                            <?php if ( $notes ) : ?>
                                <p class="flex items-start gap-2">
                                    <span data-icon="mdi:note-text-outline" class="mt-0.5 text-lg text-slate-500"></span>
                                    <span><?php echo esc_html( $notes ); ?></span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <section class="prose max-w-none prose-headings:text-slate-900 prose-a:text-brand">
                    <?php the_content(); ?>
                </section>
            </div>

            <aside class="flex flex-col gap-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 shadow-inner">
                <h2 class="text-lg font-semibold text-slate-900"><?php esc_html_e( 'Öne Çıkanlar', 'tamgaci' ); ?></h2>
                <ul class="space-y-3 text-sm text-slate-700">
                    <?php if ( $is_electric ) : ?>
                        <li class="flex items-start gap-2">
                            <span data-icon="mdi:lightning-bolt" class="mt-0.5 text-lg text-slate-500"></span>
                            <span><?php esc_html_e( 'Elektrikli güç aktarma ve yüksek verimlilik', 'tamgaci' ); ?></span>
                        </li>
                    <?php else : ?>
                        <li class="flex items-start gap-2">
                            <span data-icon="mdi:engine" class="mt-0.5 text-lg text-slate-500"></span>
                            <span><?php esc_html_e( 'Geleneksel güç aktarma çözümleri ve geniş seçenekler', 'tamgaci' ); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ( $equipment ) : ?>
                        <li class="flex items-start gap-2">
                            <span data-icon="mdi:star-circle" class="mt-0.5 text-lg text-slate-500"></span>
                            <span><?php echo esc_html( $equipment ); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ( $brands ) : ?>
                        <li class="flex items-start gap-2">
                            <span data-icon="mdi:factory" class="mt-0.5 text-lg text-slate-500"></span>
                            <span><?php echo esc_html( implode( ', ', $brands ) ); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ( $models ) : ?>
                        <li class="flex items-start gap-2">
                            <span data-icon="mdi:label" class="mt-0.5 text-lg text-slate-500"></span>
                            <span><?php echo esc_html( implode( ', ', $models ) ); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>

                <?php if ( $archive_link ) : ?>
                    <a class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow transition hover:bg-slate-700" href="<?php echo esc_url( $archive_link ); ?>">
                        <span data-icon="mdi:arrow-left"></span>
                        <?php echo esc_html( $archive_label ); ?>
                    </a>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</article>

<?php if ( ! empty( $same_brand_vehicles ) ) : ?>
    <div class="container mx-auto px-4 pb-12">
        <section class="rounded-2xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
            <header class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">
                        <?php
                        if ( ! empty( $brands ) ) {
                            /* translators: %s: brand name */
                            printf( esc_html__( '%s Markasından Diğer Araçlar', 'tamgaci' ), esc_html( implode( ', ', $brands ) ) );
                        } else {
                            esc_html_e( 'Aynı Markadan Diğer Araçlar', 'tamgaci' );
                        }
                        ?>
                    </h2>
                    <p class="text-sm text-slate-600"><?php esc_html_e( 'Aynı markadan diğer modelleri karşılaştırabilirsiniz.', 'tamgaci' ); ?></p>
                </div>
            </header>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <?php foreach ( $same_brand_vehicles as $related ) : ?>
                    <article class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm" data-vehicle-id="<?php echo esc_attr( $related['id'] ); ?>">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl text-slate-400" data-icon="<?php echo esc_attr( $related['icon'] ); ?>"></span>
                                <div>
                                    <h3 class="text-base font-semibold text-slate-900"><?php echo esc_html( $related['title'] ); ?></h3>
                                    <?php if ( $related['models'] ) : ?>
                                        <p class="text-xs text-slate-500"><?php echo esc_html( implode( ' / ', $related['models'] ) ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <button type="button" class="compare-toggle inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-400" data-compare-toggle data-vehicle-id="<?php echo esc_attr( $related['id'] ); ?>">
                                <span class="compare-toggle__label--add flex items-center gap-1">
                                    <span data-icon="mdi:checkbox-blank-outline"></span>
                                    <?php esc_html_e( 'Ekle', 'tamgaci' ); ?>
                                </span>
                                <span class="compare-toggle__label--remove hidden items-center gap-1">
                                    <span data-icon="mdi:checkbox-marked"></span>
                                    <?php esc_html_e( 'Seçildi', 'tamgaci' ); ?>
                                </span>
                            </button>
                        </div>
                        <?php if ( $related['image'] ) : ?>
                            <img class="h-32 w-full rounded-lg object-cover" src="<?php echo esc_url( $related['image'] ); ?>" alt="<?php echo esc_attr( $related['title'] ); ?>" />
                        <?php endif; ?>
                        <dl class="grid grid-cols-1 gap-2 text-xs text-slate-600">
                            <?php foreach ( array_slice( $related['specs'], 0, 3 ) as $spec ) : ?>
                                <div>
                                    <dt class="font-semibold text-slate-500"><?php echo esc_html( $spec['label'] ); ?></dt>
                                    <dd class="text-slate-800"><?php echo esc_html( $spec['value'] ); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                        <a class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-brand-accent" href="<?php echo esc_url( $related['permalink'] ); ?>">
                            <span data-icon="mdi:arrow-right"></span>
                            <?php esc_html_e( 'Detaylar', 'tamgaci' ); ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
<?php endif; ?>

<?php if ( ! empty( $other_brands_vehicles ) ) : ?>
    <div class="container mx-auto px-4 pb-12">
        <section class="rounded-2xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
            <header class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900"><?php esc_html_e( 'Diğer Markalardan Araçlar', 'tamgaci' ); ?></h2>
                    <p class="text-sm text-slate-600"><?php esc_html_e( 'Farklı markaların modellerini de karşılaştırabilirsiniz.', 'tamgaci' ); ?></p>
                </div>
            </header>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <?php foreach ( $other_brands_vehicles as $related ) : ?>
                    <article class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm" data-vehicle-id="<?php echo esc_attr( $related['id'] ); ?>">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl text-slate-400" data-icon="<?php echo esc_attr( $related['icon'] ); ?>"></span>
                                <div>
                                    <h3 class="text-base font-semibold text-slate-900"><?php echo esc_html( $related['title'] ); ?></h3>
                                    <?php if ( $related['models'] ) : ?>
                                        <p class="text-xs text-slate-500"><?php echo esc_html( implode( ' / ', $related['models'] ) ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <button type="button" class="compare-toggle inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-400" data-compare-toggle data-vehicle-id="<?php echo esc_attr( $related['id'] ); ?>">
                                <span class="compare-toggle__label--add flex items-center gap-1">
                                    <span data-icon="mdi:checkbox-blank-outline"></span>
                                    <?php esc_html_e( 'Ekle', 'tamgaci' ); ?>
                                </span>
                                <span class="compare-toggle__label--remove hidden items-center gap-1">
                                    <span data-icon="mdi:checkbox-marked"></span>
                                    <?php esc_html_e( 'Seçildi', 'tamgaci' ); ?>
                                </span>
                            </button>
                        </div>
                        <?php if ( $related['image'] ) : ?>
                            <img class="h-32 w-full rounded-lg object-cover" src="<?php echo esc_url( $related['image'] ); ?>" alt="<?php echo esc_attr( $related['title'] ); ?>" />
                        <?php endif; ?>
                        <dl class="grid grid-cols-1 gap-2 text-xs text-slate-600">
                            <?php if ( ! empty( $related['key_specs'] ) ) : ?>
                                <?php foreach ( array_slice( $related['key_specs'], 0, 3 ) as $spec ) : ?>
                                    <div class="flex justify-between">
                                        <dt><?php echo esc_html( $spec['label'] ); ?>:</dt>
                                        <dd class="font-medium text-slate-900"><?php echo esc_html( $spec['value'] ); ?></dd>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </dl>
                        <a class="mt-auto inline-flex items-center justify-center gap-2 rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-900 transition hover:bg-slate-200" href="<?php echo esc_url( $related['url'] ); ?>">
                            <?php esc_html_e( 'Detaylar', 'tamgaci' ); ?>
                            <span data-icon="mdi:arrow-right"></span>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
<?php endif; ?>

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
