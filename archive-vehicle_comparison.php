<?php
/**
 * Araç karşılaştırma arşiv şablonu.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Get all compareable post types
$compareable_types = [
	'electric_vehicle'    => [
		'label' => __( 'Elektrikli Araçlar', 'tamgaci' ),
		'icon'  => 'mdi:ev-station',
	],
	'combustion_vehicle'  => [
		'label' => __( 'Yakıtlı Araçlar', 'tamgaci' ),
		'icon'  => 'mdi:gas-station',
	],
	'motorcycle'          => [
		'label' => __( 'Motosikletler', 'tamgaci' ),
		'icon'  => 'mdi:motorbike',
	],
];

// Function to get comparisons for a specific post type
function get_comparisons_by_type( $post_type ) {
	$comparisons = [];

	$args = [
		'post_type'      => 'vehicle_comparison',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$item_ids = get_post_meta( get_the_ID(), 'tamgaci_comparison_vehicle_ids', true );

			if ( is_array( $item_ids ) && ! empty( $item_ids ) ) {
				// Check if any of the items belong to this post type
				$belongs_to_type = false;
				foreach ( $item_ids as $item_id ) {
					if ( get_post_type( $item_id ) === $post_type ) {
						$belongs_to_type = true;
						break;
					}
				}

				if ( $belongs_to_type ) {
					$comparisons[] = get_the_ID();
				}
			}
		}
	}

	wp_reset_postdata();

	return $comparisons;
}
?>

<main class="container mx-auto px-4 py-16 space-y-12">
	<!-- Breadcrumb -->
	<nav class="flex items-center gap-2 text-sm text-slate-600" aria-label="<?php esc_attr_e( 'Breadcrumb', 'tamgaci' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-slate-900 transition">
			<?php esc_html_e( 'Ana Sayfa', 'tamgaci' ); ?>
		</a>
		<span aria-hidden="true">/</span>
		<span class="text-slate-900 font-medium" aria-current="page"><?php esc_html_e( 'Karşılaştırmalar', 'tamgaci' ); ?></span>
	</nav>

	<!-- Hero Section -->
	<section class="relative overflow-hidden rounded-[32px] border border-slate-200 bg-gradient-to-br from-white via-blue-50/30 to-purple-50/30 px-8 py-16 shadow-xl lg:px-12">
		<!-- Background Decorations -->
		<div class="absolute -top-20 left-1/4 h-48 w-48 rounded-full bg-blue-100/50 blur-3xl"></div>
		<div class="absolute -bottom-24 right-1/4 h-56 w-56 rounded-full bg-purple-100/50 blur-3xl"></div>

		<div class="relative space-y-6 text-center">
			<!-- Badge -->
			<span class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-blue-700">
				<span data-icon="mdi:table-compare"></span>
				<?php esc_html_e( 'Karşılaştırma Merkezi', 'tamgaci' ); ?>
			</span>

			<!-- Title -->
			<h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
				<?php esc_html_e( 'Karşılaştırmalar', 'tamgaci' ); ?>
			</h1>

			<!-- Description -->
			<p class="max-w-3xl mx-auto text-lg text-slate-600 leading-relaxed">
				<?php
				$post_type_obj = get_post_type_object( 'vehicle_comparison' );
				if ( $post_type_obj && ! empty( $post_type_obj->description ) ) {
					echo esc_html( $post_type_obj->description );
				} else {
					esc_html_e( 'Teknik özellikleri, performans değerlerini ve donanım paketlerini yan yana inceleyin. Detaylı karşılaştırmalarla doğru tercihi yapın.', 'tamgaci' );
				}
				?>
			</p>

			<!-- Stats -->
			<?php
			$total_comparisons = wp_count_posts( 'vehicle_comparison' );
			$published_count = $total_comparisons && isset( $total_comparisons->publish ) ? (int) $total_comparisons->publish : 0;
			?>
			<div class="flex flex-wrap items-center justify-center gap-8 pt-4">
				<div class="flex items-center gap-3">
					<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100">
						<span data-icon="mdi:file-document-multiple" class="text-2xl text-blue-600"></span>
					</div>
					<div class="text-left">
						<p class="text-2xl font-bold text-slate-900"><?php echo esc_html( $published_count ); ?></p>
						<p class="text-sm text-slate-600"><?php esc_html_e( 'Karşılaştırma', 'tamgaci' ); ?></p>
					</div>
				</div>
				<div class="flex items-center gap-3">
					<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100">
						<span data-icon="mdi:format-list-bulleted" class="text-2xl text-purple-600"></span>
					</div>
					<div class="text-left">
						<p class="text-2xl font-bold text-slate-900"><?php echo esc_html( count( $compareable_types ) ); ?></p>
						<p class="text-sm text-slate-600"><?php esc_html_e( 'Kategori', 'tamgaci' ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	// Loop through each post type and show comparisons
	foreach ( $compareable_types as $type_slug => $type_data ) :
		$comparison_ids = get_comparisons_by_type( $type_slug );
		$post_type_obj = get_post_type_object( $type_slug );

		// Check if post type exists
		if ( ! $post_type_obj ) {
			continue;
		}

		// Get post count for this type
		$count = wp_count_posts( $type_slug );
		$publish_count = $count && isset( $count->publish ) ? (int) $count->publish : 0;
		?>

		<!-- Category Section -->
		<section class="space-y-6">
			<!-- Category Header -->
			<div class="flex items-center justify-between border-b border-slate-200 pb-4">
				<div class="flex items-center gap-3">
					<span data-icon="<?php echo esc_attr( $type_data['icon'] ); ?>" class="text-2xl text-blue-600"></span>
					<h2 class="text-2xl font-bold text-slate-900">
						<?php echo esc_html( $type_data['label'] ); ?> <?php esc_html_e( 'Karşılaştırmaları', 'tamgaci' ); ?>
					</h2>
				</div>
				<?php if ( ! empty( $comparison_ids ) ) : ?>
					<span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">
						<?php
						printf(
							esc_html( _n( '%d karşılaştırma', '%d karşılaştırma', count( $comparison_ids ), 'tamgaci' ) ),
							count( $comparison_ids )
						);
						?>
					</span>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $comparison_ids ) ) : ?>
				<!-- Comparisons Grid -->
				<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
					<?php
					// Show only first 6 comparisons on main page
					$display_ids = array_slice( $comparison_ids, 0, 6 );
					foreach ( $display_ids as $comparison_id ) :
						$item_ids = get_post_meta( $comparison_id, 'tamgaci_comparison_vehicle_ids', true );

						// Prepare items for display
						$items = [];
						if ( is_array( $item_ids ) && ! empty( $item_ids ) ) {
							// Check if we have the vehicle snapshot function (for backward compatibility)
							if ( function_exists( 'tamgaci_get_vehicle_meta_snapshot_cards' ) ) {
								$items = tamgaci_get_vehicle_meta_snapshot_cards( $item_ids );
							} else {
								// Generic fallback: just get post titles
								foreach ( $item_ids as $item_id ) {
									$post = get_post( $item_id );
									if ( $post ) {
										$items[] = [
											'title' => get_the_title( $item_id ),
											'price' => '', // No price for generic items
										];
									}
								}
							}
						}
						?>
						<article class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
							<header class="space-y-2">
								<h3 class="text-lg font-semibold text-slate-900">
									<a class="transition hover:text-slate-700" href="<?php echo esc_url( get_permalink( $comparison_id ) ); ?>">
										<?php echo esc_html( get_the_title( $comparison_id ) ); ?>
									</a>
								</h3>
								<p class="text-xs uppercase tracking-wide text-slate-500">
									<?php echo esc_html( get_the_date( '', $comparison_id ) ); ?>
								</p>
							</header>

							<?php if ( ! empty( $items ) ) : ?>
								<ul class="space-y-2 text-sm text-slate-600">
									<?php foreach ( $items as $item ) : ?>
										<li class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
											<span class="font-semibold text-slate-800"><?php echo esc_html( $item['title'] ); ?></span>
											<?php if ( ! empty( $item['price'] ) ) : ?>
												<span class="text-xs font-semibold uppercase tracking-wide text-slate-500">
													<?php echo esc_html( $item['price'] ); ?>
												</span>
											<?php endif; ?>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php else : ?>
								<?php
								$excerpt = get_the_excerpt( $comparison_id );
								if ( $excerpt ) :
									?>
									<p class="text-sm text-slate-600"><?php echo esc_html( $excerpt ); ?></p>
								<?php endif; ?>
							<?php endif; ?>

							<a class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white transition hover:bg-slate-800" href="<?php echo esc_url( get_permalink( $comparison_id ) ); ?>">
								<span data-icon="mdi:table"></span>
								<?php esc_html_e( 'Detaylı karşılaştırma', 'tamgaci' ); ?>
							</a>
						</article>
					<?php endforeach; ?>
				</div>

				<!-- Show "View All" button if there are more than 6 comparisons -->
				<?php if ( count( $comparison_ids ) > 6 ) : ?>
					<div class="text-center pt-4">
						<a class="inline-flex items-center gap-2 rounded-full border-2 border-slate-900 bg-white px-6 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-900 hover:text-white" href="<?php echo esc_url( home_url( '/karsilastirma/' . $type_slug . '/' ) ); ?>">
							<?php esc_html_e( 'Tümünü Gör', 'tamgaci' ); ?>
							<span data-icon="mdi:arrow-right"></span>
						</a>
						<p class="mt-2 text-sm text-slate-500">
							<?php
							printf(
								esc_html__( '%d karşılaştırmanın tümünü görüntüle', 'tamgaci' ),
								count( $comparison_ids )
							);
							?>
						</p>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<!-- No comparisons yet for this type -->
				<div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center">
					<p class="text-slate-600">
						<?php
						printf(
							esc_html__( 'Henüz %s karşılaştırması yayınlanmadı.', 'tamgaci' ),
							'<strong>' . esc_html( strtolower( $type_data['label'] ) ) . '</strong>'
						);
						?>
					</p>
					<p class="mt-2 text-sm text-slate-500">
						<?php
						printf(
							esc_html__( 'Toplam %d adet %s bulunmaktadır.', 'tamgaci' ),
							$publish_count,
							esc_html( strtolower( $type_data['label'] ) )
						);
						?>
					</p>
					<div class="flex flex-wrap items-center justify-center gap-3 mt-4">
						<a class="inline-flex items-center gap-2 rounded-full border-2 border-slate-900 bg-white px-6 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-900 hover:text-white" href="<?php echo esc_url( home_url( '/karsilastirma/' . $type_slug . '/' ) ); ?>">
							<?php esc_html_e( 'Karşılaştırmalara Git', 'tamgaci' ); ?>
							<span data-icon="mdi:compare"></span>
						</a>
						<a class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-100" href="<?php echo esc_url( get_post_type_archive_link( $type_slug ) ); ?>">
							<?php
							printf(
								esc_html__( 'Tüm %s', 'tamgaci' ),
								esc_html( $type_data['label'] )
							);
							?>
							<span data-icon="mdi:arrow-right"></span>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</section>
	<?php endforeach; ?>
</main>

<?php get_footer(); ?>
