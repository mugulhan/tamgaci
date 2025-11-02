<?php
/**
 * Default fallback template.
 */

get_header();

$site_title   = get_bloginfo( 'name' );
$site_tagline = get_bloginfo( 'description', 'display' );

$compare_url        = function_exists( 'tamgaci_get_vehicle_compare_url' ) ? tamgaci_get_vehicle_compare_url() : home_url( '/' );
$compare_select_url = function_exists( 'tamgaci_get_vehicle_compare_select_url' ) ? tamgaci_get_vehicle_compare_select_url() : $compare_url;

$vehicle_post_types = function_exists( 'tamgaci_get_vehicle_post_types' )
    ? tamgaci_get_vehicle_post_types()
    : [ 'electric_vehicle', 'combustion_vehicle' ];

$vehicle_sections = [];

foreach ( $vehicle_post_types as $post_type ) {
    $object = get_post_type_object( $post_type );

    if ( ! $object ) {
        continue;
    }

    $counts        = wp_count_posts( $post_type );
    $publish_count = $counts && isset( $counts->publish ) ? (int) $counts->publish : 0;

    $vehicle_sections[] = [
        'post_type'    => $post_type,
        'label'        => $object->labels->name,
        'description'  => $object->description,
        'is_electric'  => defined( 'TAMGACI_ELECTRIC_POST_TYPE' ) && TAMGACI_ELECTRIC_POST_TYPE === $post_type,
        'archive_link' => get_post_type_archive_link( $post_type ),
        'count'        => $publish_count,
        'query_args'   => [
            'post_type'           => $post_type,
            'post_status'         => 'publish',
            'posts_per_page'      => 6,
            'ignore_sticky_posts' => true,
            'orderby'             => [
                'menu_order' => 'ASC',
                'title'      => 'ASC',
            ],
        ],
    ];
}

$inventory_total = array_sum( wp_list_pluck( $vehicle_sections, 'count' ) );
$brand_total     = wp_count_terms( 'vehicle_brand', [ 'hide_empty' => true ] );
$body_total      = wp_count_terms( 'vehicle_body_type', [ 'hide_empty' => true ] );

if ( is_wp_error( $brand_total ) ) {
    $brand_total = 0;
}

if ( is_wp_error( $body_total ) ) {
    $body_total = 0;
}

$has_any_vehicle = false;
?>
<main class="container mx-auto px-4 py-16 space-y-16" data-compare-container data-compare-url="<?php echo esc_attr( $compare_url ); ?>" data-compare-max="4">
    <section class="relative overflow-hidden rounded-[32px] border border-slate-200 bg-white px-8 py-14 shadow-xl lg:px-12">
        <div class="absolute -top-20 left-1/2 h-48 w-48 -translate-x-1/2 rounded-full bg-blue-50 blur-3xl"></div>
        <div class="absolute -bottom-24 right-12 h-56 w-56 rounded-full bg-slate-100 blur-3xl"></div>
        <div class="relative grid gap-12 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-center">
            <div class="space-y-8">
                <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-blue-700">
                    <span data-icon="mdi:car-multiple"></span>
                    <?php esc_html_e( 'Karşılaştırma Motoru', 'tamgaci' ); ?>
                </span>
                <div class="space-y-4">
                    <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                        <?php echo esc_html( $site_title ? $site_title : __( 'Geleceğin araçlarını keşfedin', 'tamgaci' ) ); ?>
                    </h1>
                    <p class="max-w-2xl text-lg text-slate-600">
                        <?php
                        if ( $site_tagline ) {
                            echo esc_html( $site_tagline );
                        } else {
                            esc_html_e( 'Teknik özellikleri, performans değerlerini ve donanım paketlerini detaylı karşılaştırın, bilinçli seçim yapın.', 'tamgaci' );
                        }
                        ?>
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <a class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-slate-800" href="<?php echo esc_url( $compare_select_url ); ?>">
                        <span data-icon="mdi:table"></span>
                        <?php esc_html_e( 'Karşılaştırmaya Başla', 'tamgaci' ); ?>
                    </a>
                    <a class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-900" href="<?php echo esc_url( $compare_url ); ?>">
                        <span data-icon="mdi:playlist-edit"></span>
                        <?php esc_html_e( 'Seçimlerimi Gör', 'tamgaci' ); ?>
                    </a>
                </div>
                <dl class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500"><?php esc_html_e( 'Toplam Araç', 'tamgaci' ); ?></dt>
                        <dd class="mt-1 text-3xl font-semibold text-slate-900">
                            <?php echo esc_html( number_format_i18n( $inventory_total ) ); ?>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500"><?php esc_html_e( 'Marka', 'tamgaci' ); ?></dt>
                        <dd class="mt-1 text-3xl font-semibold text-slate-900">
                            <?php echo esc_html( number_format_i18n( (int) $brand_total ) ); ?>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500"><?php esc_html_e( 'Gövde Tipi', 'tamgaci' ); ?></dt>
                        <dd class="mt-1 text-3xl font-semibold text-slate-900">
                            <?php echo esc_html( number_format_i18n( (int) $body_total ) ); ?>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500"><?php esc_html_e( 'Veri Güncellemesi', 'tamgaci' ); ?></dt>
                        <dd class="mt-1 text-lg font-semibold text-slate-700">
                            <?php echo esc_html( date_i18n( get_option( 'date_format' ), current_time( 'timestamp' ) ) ); ?>
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-600"><?php esc_html_e( 'Kategorilere göz atın', 'tamgaci' ); ?></p>
                <div class="space-y-3">
                    <?php foreach ( array_slice( $vehicle_sections, 0, 3 ) as $section ) : ?>
                        <div class="flex items-center justify-between gap-4 rounded-2xl bg-white px-4 py-3 shadow-sm">
                            <div class="space-y-1">
                                <p class="text-sm font-semibold text-slate-900"><?php echo esc_html( $section['label'] ); ?></p>
                                <p class="text-xs text-slate-500">
                                    <?php
                                    printf(
                                        esc_html__( '%d yayınlanmış içerik', 'tamgaci' ),
                                        (int) $section['count']
                                    );
                                    ?>
                                </p>
                            </div>
                            <?php if ( $section['archive_link'] ) : ?>
                                <a class="inline-flex items-center gap-1 rounded-full border border-slate-200 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-300 hover:text-slate-900" href="<?php echo esc_url( $section['archive_link'] ); ?>">
                                    <span data-icon="mdi:open-in-new"></span>
                                    <?php esc_html_e( 'Tümü', 'tamgaci' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ( count( $vehicle_sections ) > 3 ) : ?>
                    <a class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white transition hover:bg-slate-800" href="<?php echo esc_url( $compare_select_url ); ?>">
                        <span data-icon="mdi:view-grid-outline"></span>
                        <?php esc_html_e( 'Tüm kategorileri gör', 'tamgaci' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php
    $comparison_query = new WP_Query( [
        'post_type'      => 'vehicle_comparison',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'no_found_rows'  => true,
    ] );

    if ( $comparison_query->have_posts() ) : ?>
        <section class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900"><?php esc_html_e( 'Öne çıkan karşılaştırmalar', 'tamgaci' ); ?></h2>
                    <p class="text-sm text-slate-500"><?php esc_html_e( 'Kullanıcıların en çok merak ettiği karşılaştırmalar.', 'tamgaci' ); ?></p>
                </div>
                <a class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-300 hover:text-slate-900" href="<?php echo esc_url( get_post_type_archive_link( 'vehicle_comparison' ) ); ?>">
                    <span data-icon="mdi:compare"></span>
                    <?php esc_html_e( 'Tüm karşılaştırmalar', 'tamgaci' ); ?>
                </a>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                <?php
                while ( $comparison_query->have_posts() ) :
                    $comparison_query->the_post();
                    $vehicle_ids = get_post_meta( get_the_ID(), 'tamgaci_comparison_vehicle_ids', true );
                    $vehicles    = tamgaci_get_vehicle_meta_snapshot_cards( (array) $vehicle_ids );
                    ?>
                    <article class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <header class="space-y-2">
                            <h3 class="text-lg font-semibold text-slate-900">
                                <a class="transition hover:text-slate-700" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="text-xs uppercase tracking-wide text-slate-500"><?php echo esc_html( get_the_date() ); ?></p>
                        </header>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <?php foreach ( $vehicles as $vehicle ) : ?>
                                <li class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                                    <span class="font-semibold text-slate-800"><?php echo esc_html( $vehicle['title'] ); ?></span>
                                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        <?php echo esc_html( $vehicle['price'] ?: __( 'Fiyat yakında', 'tamgaci' ) ); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white transition hover:bg-slate-800" href="<?php the_permalink(); ?>">
                            <span data-icon="mdi:table"></span>
                            <?php esc_html_e( 'Detaylı karşılaştırma', 'tamgaci' ); ?>
                        </a>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </section>
    <?php endif; ?>

    <?php foreach ( $vehicle_sections as $section ) : ?>
        <?php
        $vehicles = new WP_Query( $section['query_args'] );
        $has_section_posts = $vehicles->have_posts();

        if ( $has_section_posts ) {
            $has_any_vehicle = true;
        }
        ?>
        <section class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">
                        <?php echo esc_html( $section['label'] ); ?>
                    </h2>
                    <p class="text-sm text-slate-500">
                        <?php
                        if ( $section['is_electric'] ) {
                            esc_html_e( 'Tamamen elektrikli ve hibrit odaklı modelleri inceleyin.', 'tamgaci' );
                        } else {
                            esc_html_e( 'Yakıtlı ve hibrit seçeneklerle portföyünüzü genişletin.', 'tamgaci' );
                        }
                        ?>
                    </p>
                </div>
                <div class="flex gap-3">
                    <?php if ( $section['archive_link'] ) : ?>
                        <a class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-300 hover:text-slate-900" href="<?php echo esc_url( $section['archive_link'] ); ?>">
                            <span data-icon="mdi:view-grid-outline"></span>
                            <?php esc_html_e( 'Tüm Liste', 'tamgaci' ); ?>
                        </a>
                    <?php endif; ?>
                    <a class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-300 hover:text-slate-900" href="<?php echo esc_url( $compare_select_url ); ?>">
                        <span data-icon="mdi:table-plus"></span>
                        <?php esc_html_e( 'Karşılaştırmaya ekle', 'tamgaci' ); ?>
                    </a>
                </div>
            </div>

            <?php if ( $has_section_posts ) : ?>
                <div class="tamgaci-vehicle-carousel" data-vehicle-carousel>
                    <div class="tamgaci-vehicle-carousel__track swiper overflow-hidden">
                        <div class="swiper-wrapper !items-stretch">
                            <?php
                            while ( $vehicles->have_posts() ) :
                                $vehicles->the_post();

                                $vehicle_data = function_exists( 'tamgaci_prepare_vehicle_display_data' )
                                    ? tamgaci_prepare_vehicle_display_data( get_the_ID() )
                                    : null;

                                if ( ! $vehicle_data ) {
                                    continue;
                                }
                                ?>
                                <div class="swiper-slide !h-auto !w-[280px] sm:!w-[320px] lg:!w-[360px] xl:!w-[400px]">
                                    <?php
                                    get_template_part(
                                        'template-parts/vehicle/card',
                                        null,
                                        [
                                            'vehicle'    => $vehicle_data,
                                            'card_class' => 'group flex h-full min-h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md',
                                        ]
                                    );
                                    ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <div class="tamgaci-vehicle-carousel__controls mt-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="swiper-pagination"></div>
                        <div class="flex items-center justify-end gap-3">
                            <button type="button" class="swiper-button-prev group !static !m-0 !h-10 !w-10 !after:!hidden rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50" aria-label="<?php esc_attr_e( 'Önceki', 'tamgaci' ); ?>">
                                <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button type="button" class="swiper-button-next group !static !m-0 !h-10 !w-10 !after:!hidden rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50" aria-label="<?php esc_attr_e( 'Sonraki', 'tamgaci' ); ?>">
                                <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-12 text-center">
                    <p class="text-lg font-semibold text-slate-900">
                        <?php esc_html_e( 'Henüz bu kategoride yayınlanmış araç yok.', 'tamgaci' ); ?>
                    </p>
                    <p class="mt-3 text-sm text-slate-600">
                        <?php esc_html_e( 'Yönetim panelinden yeni araç ekleyerek listeyi zenginleştirebilirsiniz.', 'tamgaci' ); ?>
                    </p>
                </div>
            <?php endif; ?>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endforeach; ?>

    <?php if ( ! $has_any_vehicle ) : ?>
        <section class="rounded-3xl border border-dashed border-slate-200 bg-white p-12 text-center shadow-inner">
            <h2 class="text-2xl font-semibold text-slate-900">
                <?php esc_html_e( 'Araç katalogunuza henüz içerik eklemediniz.', 'tamgaci' ); ?>
            </h2>
            <p class="mt-3 text-sm text-slate-600">
                <?php esc_html_e( 'Elektrikli veya yakıtlı araç ekleyerek ana sayfayı doldurun ve ziyaretçilerinizi bilgilendirin.', 'tamgaci' ); ?>
            </p>
            <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                <a class="mt-6 inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=' . ( $vehicle_sections[0]['post_type'] ?? 'electric_vehicle' ) ) ); ?>">
                    <span data-icon="mdi:plus"></span>
                    <?php esc_html_e( 'Yeni araç ekle', 'tamgaci' ); ?>
                </a>
            <?php endif; ?>
        </section>
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
</main>
<?php get_footer(); ?>
