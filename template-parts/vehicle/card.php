<?php
/**
 * Vehicle card component.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$vehicle    = $args['vehicle'] ?? null;
$card_class = $args['card_class'] ?? 'group flex h-full min-h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md';

if ( ! $vehicle || empty( $vehicle['id'] ) ) {
    return;
}

$post_id    = (int) $vehicle['id'];
$icon       = $vehicle['icon'] ?? 'mdi:car-side';
$year       = $vehicle['year'] ?? '';
$powertrain = $vehicle['powertrain'] ?? [];
$body_types = $vehicle['body_types'] ?? [];
$brands     = $vehicle['brands'] ?? [];
$models     = $vehicle['models'] ?? [];
$equipment        = $vehicle['equipment'] ?? '';
$equipment_detail = $vehicle['equipment_detail'] ?? '';
$price            = $vehicle['price'] ?? '';

$summary = get_the_excerpt( $post_id );
if ( $summary ) {
    $summary = wp_trim_words( wp_strip_all_tags( $summary ), 24, '…' );
}

$term_chip_class = 'inline-flex items-center gap-1 rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-300 hover:text-slate-900';
?>
<article <?php post_class( $card_class, $post_id ); ?> data-vehicle-id="<?php echo esc_attr( $post_id ); ?>">
    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
        <a class="block" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
            <div class="h-48 w-full overflow-hidden bg-slate-50">
                <?php echo get_the_post_thumbnail( $post_id, 'large', [ 'class' => 'h-full w-full object-cover transition group-hover:scale-[1.02]' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </a>
    <?php endif; ?>
    <div class="flex flex-1 flex-col gap-4 p-6">
        <div class="flex items-center justify-between gap-3 text-slate-500">
            <span class="inline-flex items-center gap-2 text-sm font-semibold">
                <span data-icon="<?php echo esc_attr( $icon ); ?>"></span>
                <?php
                if ( ! empty( $body_types ) ) {
                    echo esc_html( implode( ' · ', $body_types ) );
                } elseif ( ! empty( $powertrain ) ) {
                    echo esc_html( implode( ' · ', $powertrain ) );
                }
                ?>
            </span>
            <div class="flex items-center gap-2">
                <?php if ( $price ) : ?>
                    <span class="text-sm font-bold text-slate-900"><?php echo esc_html( $price ); ?></span>
                <?php endif; ?>
                <?php if ( $year ) : ?>
                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-400"><?php echo esc_html( $year ); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <h3 class="text-xl font-semibold text-slate-900">
            <a class="transition hover:text-slate-700" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                <?php echo esc_html( get_the_title( $post_id ) ); ?>
            </a>
        </h3>

        <div class="data-chip-stack">
            <?php
            // Display in hierarchical order: Brand → Model → Body Type
            foreach ( $brands as $brand_name ) :
                $brand_term = get_term_by( 'name', $brand_name, 'vehicle_brand' );
                $link = $brand_term ? get_term_link( $brand_term ) : '';
                ?>
                <?php if ( $link && ! is_wp_error( $link ) ) : ?>
                    <a class="<?php echo esc_attr( $term_chip_class ); ?>" href="<?php echo esc_url( $link ); ?>">
                        <?php echo esc_html( $brand_name ); ?>
                    </a>
                <?php else : ?>
                    <span class="<?php echo esc_attr( $term_chip_class ); ?> cursor-default">
                        <?php echo esc_html( $brand_name ); ?>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php foreach ( $models as $model_name ) :
                $model_term = get_term_by( 'name', $model_name, 'vehicle_brand' );
                $link = $model_term ? get_term_link( $model_term ) : '';
                ?>
                <?php if ( $link && ! is_wp_error( $link ) ) : ?>
                    <a class="<?php echo esc_attr( $term_chip_class ); ?>" href="<?php echo esc_url( $link ); ?>">
                        <?php echo esc_html( $model_name ); ?>
                    </a>
                <?php else : ?>
                    <span class="<?php echo esc_attr( $term_chip_class ); ?> cursor-default">
                        <?php echo esc_html( $model_name ); ?>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php foreach ( $body_types as $body_type ) :
                $body_term = get_term_by( 'name', $body_type, 'vehicle_body_type' );
                $link = $body_term ? get_term_link( $body_term ) : '';
                ?>
                <?php if ( $link && ! is_wp_error( $link ) ) : ?>
                    <a class="<?php echo esc_attr( $term_chip_class ); ?>" href="<?php echo esc_url( $link ); ?>">
                        <?php echo esc_html( $body_type ); ?>
                    </a>
                <?php else : ?>
                    <span class="<?php echo esc_attr( $term_chip_class ); ?> cursor-default">
                        <?php echo esc_html( $body_type ); ?>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <?php if ( $summary ) : ?>
            <p class="text-sm text-slate-600"><?php echo esc_html( $summary ); ?></p>
        <?php endif; ?>

        <div class="mt-auto flex flex-wrap items-center gap-3 pt-4">
            <a class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white transition hover:bg-slate-700" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                <span data-icon="mdi:open-in-new"></span>
                <?php esc_html_e( 'Detayları Gör', 'tamgaci' ); ?>
            </a>
            <button type="button" class="compare-toggle inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-400" data-compare-toggle data-vehicle-id="<?php echo esc_attr( $post_id ); ?>">
                <span class="compare-toggle__label--add flex items-center gap-1">
                    <span data-icon="mdi:checkbox-blank-outline"></span>
                    <?php esc_html_e( 'Karşılaştır', 'tamgaci' ); ?>
                </span>
                <span class="compare-toggle__label--remove hidden items-center gap-1">
                    <span data-icon="mdi:checkbox-marked"></span>
                    <?php esc_html_e( 'Seçildi', 'tamgaci' ); ?>
                </span>
            </button>
        </div>
    </div>
</article>
