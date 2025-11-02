<?php
/**
 * Template Name: Araç Karşılaştırma Tablosu
 */

get_header();

$vehicle_param = isset( $_GET['vehicles'] ) ? sanitize_text_field( wp_unslash( $_GET['vehicles'] ) ) : '';
$vehicle_ids   = array_filter( array_map( 'absint', preg_split( '/[\s,]+/', $vehicle_param ) ) );
$vehicle_ids   = array_unique( $vehicle_ids );

if ( empty( $vehicle_ids ) ) {
    echo '<section class="container mx-auto px-4 py-16 text-center text-slate-600">'
        . esc_html__( 'Karşılaştırmak için araç seçmediniz. Araç listesine giderek modelleri seçin.', 'tamgaci' )
        . '</section>';
    get_footer();
    return;
}

$vehicle_query = new WP_Query( [
    'post_type'      => tamgaci_get_vehicle_post_types(),
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'post__in'       => $vehicle_ids,
    'orderby'        => 'post__in',
] );

if ( ! $vehicle_query->have_posts() ) {
    echo '<section class="container mx-auto px-4 py-16 text-center text-slate-600">'
        . esc_html__( 'Seçtiğiniz araçlar bulunamadı. Lütfen seçimlerinizi kontrol edin.', 'tamgaci' )
        . '</section>';
    get_footer();
    return;
}

$vehicles = [];
$spec_map = [];

while ( $vehicle_query->have_posts() ) {
    $vehicle_query->the_post();

    $data = tamgaci_prepare_vehicle_display_data( get_the_ID() );

    if ( ! $data ) {
        continue;
    }

    $vehicles[] = $data;

    foreach ( $data['specs'] as $spec ) {
        $spec_map[ $spec['key'] ] = $spec['label'];
    }
}

wp_reset_postdata();

$spec_keys = array_keys( $spec_map );
$has_price = false;

foreach ( $vehicles as $vehicle ) {
    if ( ! empty( $vehicle['price'] ) ) {
        $has_price = true;
        break;
    }
}

?>
<section class="relative bg-white py-12">
    <div class="container mx-auto px-4">
        <header class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900 sm:text-4xl"><?php the_title(); ?></h1>
                <p class="mt-2 text-slate-600"><?php esc_html_e( 'Seçtiğiniz araçların teknik değerlerini yan yana karşılaştırın.', 'tamgaci' ); ?></p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-400" href="<?php echo esc_url( tamgaci_get_vehicle_compare_url() ); ?>" data-compare-clear>
                    <span data-icon="mdi:playlist-edit"></span>
                    <?php esc_html_e( 'Seçimleri Düzenle', 'tamgaci' ); ?>
                </a>
            </div>
        </header>

        <div class="grid gap-8">
            <div class="grid gap-6 md:grid-cols-<?php echo esc_attr( max( 1, count( $vehicles ) ) ); ?>">
                <?php foreach ( $vehicles as $vehicle ) : ?>
                    <article class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <span class="text-3xl text-slate-500" data-icon="<?php echo esc_attr( $vehicle['icon'] ); ?>"></span>
                                <div>
                                    <h2 class="text-xl font-semibold text-slate-900"><?php echo esc_html( $vehicle['title'] ); ?></h2>
                                    <?php if ( $vehicle['brands'] ) : ?>
                                        <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                                            <?php echo esc_html( implode( ' · ', $vehicle['brands'] ) ); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ( $vehicle['models'] ) : ?>
                                        <p class="text-sm text-slate-500"><?php echo esc_html( implode( ' / ', $vehicle['models'] ) ); ?></p>
                                    <?php endif; ?>
                                    <?php if ( $vehicle['equipment'] || $vehicle['year'] ) : ?>
                                        <p class="text-sm font-semibold text-slate-700">
                                            <?php if ( $vehicle['equipment'] ) : ?>
                                                <span><?php echo esc_html( $vehicle['equipment'] ); ?></span>
                                            <?php endif; ?>
                                            <?php if ( $vehicle['year'] ) : ?>
                                                <span class="ml-2 inline-flex items-center rounded-full bg-slate-900 px-3 py-0.5 text-xs font-bold uppercase tracking-wide text-white">
                                                    <?php echo esc_html( tamgaci_format_numeric_display( $vehicle['year'] ) ); ?>
                                                </span>
                                            <?php endif; ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <?php if ( $vehicle['price'] ) : ?>
                                    <span class="text-base font-bold text-slate-900"><?php echo esc_html( $vehicle['price'] ); ?></span>
                                <?php endif; ?>
                                <a class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-500 transition hover:border-slate-400" href="<?php echo esc_url( $vehicle['permalink'] ); ?>">
                                    <span data-icon="mdi:open-in-new"></span>
                                    <?php esc_html_e( 'Detaylar', 'tamgaci' ); ?>
                                </a>
                            </div>
                        </div>
                        <?php if ( $vehicle['image'] ) : ?>
                            <img class="h-40 w-full rounded-xl bg-white object-contain" src="<?php echo esc_url( $vehicle['image'] ); ?>" alt="<?php echo esc_attr( $vehicle['title'] ); ?>" />
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-900 text-left text-xs font-semibold uppercase tracking-wide text-white">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-slate-200"><?php esc_html_e( 'Özellik', 'tamgaci' ); ?></th>
                            <?php foreach ( $vehicles as $vehicle ) : ?>
                                <th scope="col" class="px-4 py-3 text-white"><?php echo esc_html( $vehicle['title'] ); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <?php if ( $has_price ) : ?>
                            <tr>
                                <th scope="row" class="whitespace-nowrap px-4 py-3 text-left font-semibold text-slate-600">
                                    <?php esc_html_e( 'Fiyat', 'tamgaci' ); ?>
                                </th>
                                <?php foreach ( $vehicles as $vehicle ) : ?>
                                    <td class="whitespace-nowrap px-4 py-3 text-slate-900">
                                        <?php echo esc_html( $vehicle['price'] ?: '—' ); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ( $spec_keys as $key ) : ?>
                            <tr>
                                <th scope="row" class="whitespace-nowrap px-4 py-3 text-left font-semibold text-slate-600">
                                    <?php echo esc_html( $spec_map[ $key ] ); ?>
                                </th>
                                <?php foreach ( $vehicles as $vehicle ) : ?>
                                    <?php
                                    $value = '—';
                                    foreach ( $vehicle['specs'] as $spec ) {
                                        if ( $spec['key'] === $key ) {
                                            $value = $spec['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <td class="whitespace-nowrap px-4 py-3 text-slate-900">
                                        <?php echo esc_html( $value ); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
