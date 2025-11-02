<?php
/**
 * Template for displaying comparisons by category (post type)
 * This template is accessed via custom rewrite rules
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the post type from the URL
$post_type_slug = get_query_var( 'comparison_category' );

// Validate post type
$valid_types = [ 'electric_vehicle', 'combustion_vehicle', 'motorcycle' ];
if ( ! in_array( $post_type_slug, $valid_types, true ) ) {
	wp_redirect( home_url( '/karsilastirma/' ) );
	exit;
}

// Get post type labels
$type_labels = [
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

$type_data = $type_labels[ $post_type_slug ];

// Get all comparisons for this type
function get_all_comparisons_by_type( $post_type ) {
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
				foreach ( $item_ids as $item_id ) {
					if ( get_post_type( $item_id ) === $post_type ) {
						$comparisons[] = get_the_ID();
						break;
					}
				}
			}
		}
	}

	wp_reset_postdata();

	return $comparisons;
}

$comparison_ids = get_all_comparisons_by_type( $post_type_slug );
$comparison_count = count( $comparison_ids );

get_header();
?>

<main class="container mx-auto px-4 py-16 space-y-12">
	<!-- Breadcrumb -->
	<nav class="flex items-center gap-2 text-sm text-slate-600" aria-label="<?php esc_attr_e( 'Breadcrumb', 'tamgaci' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-slate-900 transition">
			<?php esc_html_e( 'Ana Sayfa', 'tamgaci' ); ?>
		</a>
		<span aria-hidden="true">/</span>
		<a href="<?php echo esc_url( home_url( '/karsilastirma/' ) ); ?>" class="hover:text-slate-900 transition">
			<?php esc_html_e( 'Karşılaştırmalar', 'tamgaci' ); ?>
		</a>
		<span aria-hidden="true">/</span>
		<span class="text-slate-900 font-medium" aria-current="page"><?php echo esc_html( $type_data['label'] ); ?></span>
	</nav>

	<!-- Header -->
	<header class="space-y-4 text-center">
		<div class="flex items-center justify-center gap-3">
			<span data-icon="<?php echo esc_attr( $type_data['icon'] ); ?>" class="text-4xl text-blue-600"></span>
			<h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
				<?php echo esc_html( $type_data['label'] ); ?> <?php esc_html_e( 'Karşılaştırmaları', 'tamgaci' ); ?>
			</h1>
		</div>
		<p class="max-w-2xl mx-auto text-lg text-slate-600">
			<?php
			printf(
				esc_html__( 'Toplam %d adet karşılaştırma bulunmaktadır.', 'tamgaci' ),
				$comparison_count
			);
			?>
		</p>
	</header>

	<?php if ( ! empty( $comparison_ids ) ) : ?>
		<!-- Comparisons Grid -->
		<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
			<?php
			foreach ( $comparison_ids as $comparison_id ) :
				$item_ids = get_post_meta( $comparison_id, 'tamgaci_comparison_vehicle_ids', true );

				// Prepare items for display
				$items = [];
				if ( is_array( $item_ids ) && ! empty( $item_ids ) ) {
					if ( function_exists( 'tamgaci_get_vehicle_meta_snapshot_cards' ) ) {
						$items = tamgaci_get_vehicle_meta_snapshot_cards( $item_ids );
					} else {
						foreach ( $item_ids as $item_id ) {
							$post = get_post( $item_id );
							if ( $post ) {
								$items[] = [
									'title' => get_the_title( $item_id ),
									'price' => '',
								];
							}
						}
					}
				}
				?>
				<article class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
					<header class="space-y-2">
						<h2 class="text-lg font-semibold text-slate-900">
							<a class="transition hover:text-slate-700" href="<?php echo esc_url( get_permalink( $comparison_id ) ); ?>">
								<?php echo esc_html( get_the_title( $comparison_id ) ); ?>
							</a>
						</h2>
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
	<?php else : ?>
		<!-- No comparisons -->
		<div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-12 text-center">
			<p class="text-lg font-semibold text-slate-900">
				<?php
				printf(
					esc_html__( 'Henüz %s karşılaştırması yayınlanmadı.', 'tamgaci' ),
					strtolower( $type_data['label'] )
				);
				?>
			</p>
		</div>
	<?php endif; ?>

	<!-- Back Button -->
	<div class="text-center">
		<a class="inline-flex items-center gap-2 rounded-full border-2 border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-900 hover:text-slate-900" href="<?php echo esc_url( home_url( '/karsilastirma/' ) ); ?>">
			<span data-icon="mdi:arrow-left"></span>
			<?php esc_html_e( 'Tüm Karşılaştırmalara Dön', 'tamgaci' ); ?>
		</a>
	</div>
</main>

<?php get_footer(); ?>
