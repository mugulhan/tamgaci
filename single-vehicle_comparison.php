<?php
/**
 * Araç karşılaştırma tekil şablonu.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

while ( have_posts() ) {
    the_post();

    $vehicle_ids = get_post_meta( get_the_ID(), 'tamgaci_comparison_vehicle_ids', true );
    $snapshot    = get_post_meta( get_the_ID(), 'tamgaci_comparison_snapshot', true );

    if ( ! is_array( $vehicle_ids ) || count( $vehicle_ids ) < 2 ) {
        echo '<section class="container mx-auto px-4 py-16 text-center text-slate-600">'
            . esc_html__( 'Karşılaştırma verileri bulunamadı.', 'tamgaci' )
            . '</section>';
        continue;
    }
    ?>
    <section class="container mx-auto px-4 py-16 space-y-12">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-slate-600" aria-label="<?php esc_attr_e( 'Breadcrumb', 'tamgaci' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-slate-900 transition">
                <?php esc_html_e( 'Ana Sayfa', 'tamgaci' ); ?>
            </a>
            <span aria-hidden="true">/</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'vehicle_comparison' ) ); ?>" class="hover:text-slate-900 transition">
                <?php esc_html_e( 'Karşılaştırmalar', 'tamgaci' ); ?>
            </a>
            <span aria-hidden="true">/</span>
            <span class="text-slate-900 font-medium" aria-current="page"><?php the_title(); ?></span>
        </nav>

        <header class="text-center">
            <h1 class="text-3xl font-semibold text-slate-900 sm:text-4xl"><?php the_title(); ?></h1>
            <?php if ( has_excerpt() ) : ?>
                <p class="mt-3 text-slate-600"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>
        </header>

        <div class="grid gap-6 md:grid-cols-<?php echo esc_attr( count( $vehicle_ids ) ); ?>">
            <?php foreach ( $vehicle_ids as $vehicle_id ) :
                $data = $snapshot[ $vehicle_id ] ?? tamgaci_get_vehicle_meta_snapshot( $vehicle_id );
                if ( ! $data ) {
                    continue;
                }
                ?>
                <article class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900"><?php echo esc_html( $data['title'] ); ?></h2>
                            <?php if ( $data['equipment'] ) : ?>
                                <p class="text-sm text-slate-600"><?php echo esc_html( $data['equipment'] ); ?></p>
                            <?php endif; ?>
                            <?php if ( $data['price'] ) : ?>
                                <p class="text-base font-semibold text-slate-900"><?php echo esc_html( $data['price'] ); ?></p>
                            <?php endif; ?>
                        </div>
                        <a class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-slate-400" href="<?php echo esc_url( $data['permalink'] ); ?>">
                            <span data-icon="mdi:open-in-new"></span>
                            <?php esc_html_e( 'Detaylar', 'tamgaci' ); ?>
                        </a>
                    </div>
                    <?php if ( $data['image'] ) : ?>
                        <img class="h-40 w-full rounded-xl object-cover" src="<?php echo esc_url( $data['image'] ); ?>" alt="<?php echo esc_attr( $data['title'] ); ?>" />
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-900 text-left text-xs font-semibold uppercase tracking-wide text-white">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-slate-200"><?php esc_html_e( 'Özellik', 'tamgaci' ); ?></th>
                        <?php foreach ( $vehicle_ids as $vehicle_id ) :
                            $data = $snapshot[ $vehicle_id ] ?? tamgaci_get_vehicle_meta_snapshot( $vehicle_id );
                            if ( ! $data ) {
                                continue;
                            }
                            ?>
                            <th scope="col" class="px-4 py-3 text-white"><?php echo esc_html( $data['title'] ); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <?php
                    // Collect all unique spec labels from all vehicles
                    $all_spec_labels = [];
                    foreach ( $vehicle_ids as $vehicle_id ) {
                        $data = $snapshot[ $vehicle_id ] ?? tamgaci_get_vehicle_meta_snapshot( $vehicle_id );
                        if ( ! empty( $data['specs'] ) && is_array( $data['specs'] ) ) {
                            foreach ( $data['specs'] as $spec ) {
                                if ( ! empty( $spec['label'] ) && ! in_array( $spec['label'], $all_spec_labels, true ) ) {
                                    $all_spec_labels[] = $spec['label'];
                                }
                            }
                        }
                    }

                    // Display each spec row
                    foreach ( $all_spec_labels as $spec_label ) :
                        ?>
                        <tr>
                            <th scope="row" class="whitespace-nowrap px-4 py-3 text-left font-semibold text-slate-600">
                                <?php echo esc_html( $spec_label ); ?>
                            </th>
                            <?php foreach ( $vehicle_ids as $vehicle_id ) :
                                $data  = $snapshot[ $vehicle_id ] ?? tamgaci_get_vehicle_meta_snapshot( $vehicle_id );

                                // Find the spec value by matching label
                                $value = '—';
                                if ( ! empty( $data['specs'] ) && is_array( $data['specs'] ) ) {
                                    foreach ( $data['specs'] as $spec ) {
                                        if ( isset( $spec['label'] ) && $spec['label'] === $spec_label ) {
                                            $value = $spec['value'] ?? '—';
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-900"><?php echo esc_html( $value ); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php
}

get_footer();
