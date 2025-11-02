<?php
/**
 * Araç karşılaştırma bileşeni.
 */

$vehicle_query = $args['query'] ?? null;

if ( ! ( $vehicle_query instanceof WP_Query ) ) {
    return;
}

$compare_url = $args['compare_url'] ?? '';
$compare_max = isset( $args['compare_max'] ) ? (int) $args['compare_max'] : 4;
$compare_max = max( 2, $compare_max );
?>
<section class="relative bg-white py-12" data-compare-container data-compare-url="<?php echo esc_attr( $compare_url ); ?>" data-compare-max="<?php echo esc_attr( $compare_max ); ?>">
    <div class="container mx-auto px-4">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-semibold text-slate-900 sm:text-4xl">Tamgacı Araç Sıralaması</h1>
            <p class="mt-3 text-slate-600">Teknik özellikleri karşılaştırın ve size uygun modeli bulun.</p>
        </div>

        <div class="vehicle-comparison__carousel swiper">
            <div class="swiper-wrapper">
                <?php
                while ( $vehicle_query->have_posts() ) :
                    $vehicle_query->the_post();

                    $vehicle_id = get_the_ID();
                    $vehicle    = function_exists( 'tamgaci_prepare_vehicle_display_data' )
                        ? tamgaci_prepare_vehicle_display_data( $vehicle_id )
                        : null;

                    if ( ! $vehicle ) {
                        continue;
                    }

                    $specs      = array_slice( $vehicle['specs'], 0, 6 );
                    $brands     = $vehicle['brands'];
                    $models     = $vehicle['models'];
                    $powertrain = $vehicle['powertrain'];
                    $icon       = $vehicle['icon'];
                    $equipment  = $vehicle['equipment'];
                    $year       = $vehicle['year'];
                    $notes      = $vehicle['notes'];
                    $charging   = $vehicle['charging'];
                    $price      = $vehicle['price'];
                    $is_electric = $vehicle['is_electric'];
                ?>
                    <div class="swiper-slide">
                        <article class="flex h-full flex-col gap-6 rounded-2xl border border-slate-200 bg-slate-50 p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-lg" data-vehicle-id="<?php echo esc_attr( $vehicle_id ); ?>">
                            <header class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                <div class="flex items-start gap-3">
                                    <span class="text-3xl text-slate-500" data-icon="<?php echo esc_attr( $icon ); ?>"></span>
                                    <div>
                                        <h2 class="text-xl font-semibold text-slate-900"><?php the_title(); ?></h2>
                                        <?php if ( $brands ) : ?>
                                            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                                                <?php echo esc_html( implode( ' · ', $brands ) ); ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ( $models ) : ?>
                                            <p class="text-sm text-slate-500">
                                                <?php echo esc_html( implode( ' / ', $models ) ); ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ( $equipment || $year ) : ?>
                                            <p class="text-sm font-semibold text-slate-700">
                                                <?php if ( $equipment ) : ?>
                                                    <span><?php echo esc_html( $equipment ); ?></span>
                                                <?php endif; ?>
                                                <?php if ( $year ) : ?>
                                                    <span class="ml-2 inline-flex items-center rounded-full bg-slate-900 px-3 py-0.5 text-xs font-bold uppercase tracking-wide text-white">
                                                        <?php echo esc_html( tamgaci_format_numeric_display( $year ) ); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-3 text-sm">
                                    <?php if ( $price ) : ?>
                                        <span class="text-base font-bold text-slate-900"><?php echo esc_html( $price ); ?></span>
                                    <?php endif; ?>
                                    <button type="button" class="compare-toggle inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-400" data-compare-toggle data-vehicle-id="<?php echo esc_attr( $vehicle_id ); ?>">
                                        <span class="compare-toggle__label--add flex items-center gap-1">
                                            <span data-icon="mdi:checkbox-blank-outline"></span>
                                            <?php esc_html_e( 'Karşılaştırmaya ekle', 'tamgaci' ); ?>
                                        </span>
                                        <span class="compare-toggle__label--remove hidden items-center gap-1">
                                            <span data-icon="mdi:checkbox-marked"></span>
                                            <?php esc_html_e( 'Seçildi', 'tamgaci' ); ?>
                                        </span>
                                    </button>
                                    <?php if ( $powertrain ) : ?>
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white">
                                            <span data-icon="mdi:flash"></span>
                                            <?php echo esc_html( implode( ' / ', $powertrain ) ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </header>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="-mx-4">
                                    <?php the_post_thumbnail( 'large', [ 'class' => 'h-48 w-full rounded-xl object-cover' ] ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( $specs ) : ?>
                                <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                                    <?php foreach ( $specs as $spec ) : ?>
                                        <div class="rounded-lg bg-white p-4 shadow-inner">
                                            <dt class="text-xs uppercase tracking-wide text-slate-500"><?php echo esc_html( $spec['label'] ); ?></dt>
                                            <dd class="text-base font-medium text-slate-900"><?php echo esc_html( $spec['value'] ); ?></dd>
                                        </div>
                                    <?php endforeach; ?>
                                </dl>
                            <?php endif; ?>

                            <?php if ( ( $is_electric && $charging ) || $notes ) : ?>
                                <div class="rounded-2xl bg-white p-5 text-sm text-slate-600 shadow-inner">
                                    <?php if ( $is_electric && $charging ) : ?>
                                        <p class="mb-2 flex items-start gap-2">
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
                            <?php endif; ?>

                            <footer class="flex items-center justify-between">
                                <a class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white transition hover:bg-slate-700" href="<?php the_permalink(); ?>">
                                    <span data-icon="mdi:open-in-new"></span>
                                    <?php esc_html_e( 'Teknik Detaylar', 'tamgaci' ); ?>
                                </a>
                                <span class="text-xs uppercase tracking-wide text-slate-400">Ref: <?php echo esc_html( $vehicle_id ); ?></span>
                            </footer>
                        </article>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="vehicle-comparison__navigation mt-6 flex items-center justify-center gap-4">
                <button class="swiper-button-prev !static !m-0 !h-10 !w-10 rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm">&#8592;</button>
                <div class="swiper-pagination !static"></div>
                <button class="swiper-button-next !static !m-0 !h-10 !w-10 rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm">&#8594;</button>
            </div>
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
</section>
