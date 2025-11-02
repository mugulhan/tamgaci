<?php
/**
 * Generic archive template for vehicle taxonomies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$term      = get_queried_object();
$taxonomy  = $term->taxonomy ?? '';
$term_name = $term->name ?? '';
$term_desc = term_description();

$taxonomy_object = $taxonomy ? get_taxonomy( $taxonomy ) : null;
$taxonomy_label  = $taxonomy_object ? $taxonomy_object->labels->singular_name : '';

$compare_url        = function_exists( 'tamgaci_get_vehicle_compare_url' ) ? tamgaci_get_vehicle_compare_url() : home_url( '/' );
$compare_select_url = function_exists( 'tamgaci_get_vehicle_compare_select_url' ) ? tamgaci_get_vehicle_compare_select_url() : $compare_url;
?>
<main class="container mx-auto px-4 py-16 space-y-12" data-compare-container data-compare-url="<?php echo esc_attr( $compare_url ); ?>" data-compare-max="4">
    <header class="max-w-4xl space-y-4">
        <nav class="flex items-center gap-2 text-sm text-slate-600" aria-label="<?php esc_attr_e( 'Breadcrumb', 'tamgaci' ); ?>">
            <a class="transition hover:text-slate-900" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e( 'Anasayfa', 'tamgaci' ); ?>
            </a>
            <span data-icon="mdi:chevron-right" class="text-slate-400"></span>
            <?php
            // Determine the archive link based on taxonomy
            $archive_link = null;
            $archive_label = '';

            if ( $taxonomy === 'vehicle_brand' ) {
                // For brand taxonomy, link to electric vehicle archive (most common case)
                $archive_link = get_post_type_archive_link( 'electric_vehicle' );
                $archive_label = __( 'Elektrikli Araçlar', 'tamgaci' );
            } elseif ( $taxonomy === 'vehicle_body_type' ) {
                // For body type, link to electric vehicle archive
                $archive_link = get_post_type_archive_link( 'electric_vehicle' );
                $archive_label = __( 'Elektrikli Araçlar', 'tamgaci' );
            }

            if ( $archive_link ) :
            ?>
                <a class="transition hover:text-slate-900" href="<?php echo esc_url( $archive_link ); ?>">
                    <?php echo esc_html( $archive_label ); ?>
                </a>
                <span data-icon="mdi:chevron-right" class="text-slate-400"></span>
            <?php endif; ?>

            <?php
            // If this is a child term (like a model or equipment), show parent breadcrumb
            if ( ! empty( $term->parent ) && $term->parent > 0 ) {
                $parent_term = get_term( $term->parent, $taxonomy );
                if ( $parent_term && ! is_wp_error( $parent_term ) ) :
                    ?>
                    <a class="transition hover:text-slate-900" href="<?php echo esc_url( get_term_link( $parent_term ) ); ?>">
                        <?php echo esc_html( $parent_term->name ); ?>
                    </a>
                    <span data-icon="mdi:chevron-right" class="text-slate-400"></span>
                    <?php
                endif;
            }
            ?>
            <span class="font-semibold text-slate-900"><?php echo esc_html( $term_name ); ?></span>
        </nav>
        <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl"><?php echo esc_html( $term_name ); ?></h1>
        <?php if ( $term_desc ) : ?>
            <div class="prose max-w-none text-slate-600">
                <?php echo wp_kses_post( $term_desc ); ?>
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

    <?php if ( have_posts() ) : ?>
        <section class="space-y-8">
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
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
                <?php esc_html_e( 'Bu kategoriye araç ekleyin ve ziyaretçilere seçenek sunun.', 'tamgaci' ); ?>
            </p>
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
<?php
get_footer();
