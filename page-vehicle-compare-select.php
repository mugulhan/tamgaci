<?php
/**
 * Template Name: Araç Karşılaştırma Seçimi
 */

get_header();

tamgaci_ensure_compare_page();
$compare_url = tamgaci_get_vehicle_compare_url();

$vehicles = new WP_Query( [
    'post_type'      => tamgaci_get_vehicle_post_types(),
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => [
        'menu_order' => 'ASC',
        'title'      => 'ASC',
    ],
] );

// Get all brands for filtering
$all_brands = get_terms( [
    'taxonomy'   => 'vehicle_brand',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
] );

// Get all body types for filtering
$all_body_types = get_terms( [
    'taxonomy'   => 'vehicle_body_type',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
] );

?>
<section class="relative bg-gradient-to-br from-slate-50 via-white to-slate-50 py-16">
    <div class="container mx-auto px-4">
        <!-- Hero Section -->
        <header class="mb-12 text-center">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/25">
                <iconify-icon icon="mdi:car-compare" class="h-8 w-8 text-white"></iconify-icon>
            </div>
            <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl"><?php the_title(); ?></h1>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-slate-600">
                <?php esc_html_e( 'Karşılaştırmak istediğiniz araçları kolayca arayın, filtreleyin ve seçin. Detaylı karşılaştırma tablosunu anında görüntüleyin.', 'tamgaci' ); ?>
            </p>
            <div class="mt-6 flex justify-center">
                <div class="flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                    <iconify-icon icon="mdi:information" class="h-4 w-4"></iconify-icon>
                    <span><?php esc_html_e( 'En az 2 araç seçmeniz gerekiyor', 'tamgaci' ); ?></span>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-6xl">
            <!-- Search and Filters -->
            <div class="mb-8 rounded-2xl border border-slate-200/50 bg-white/80 p-6 shadow-lg backdrop-blur-sm">
                <div class="mb-4 flex items-center gap-3">
                    <iconify-icon icon="mdi:filter-variant" class="h-5 w-5 text-slate-600"></iconify-icon>
                    <h2 class="text-lg font-semibold text-slate-900"><?php esc_html_e( 'Arama ve Filtreler', 'tamgaci' ); ?></h2>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <!-- Search Input -->
                    <div class="md:col-span-3">
                        <label class="mb-2 block text-sm font-medium text-slate-700"><?php esc_html_e( 'Araç Ara', 'tamgaci' ); ?></label>
                        <div class="relative">
                            <iconify-icon icon="mdi:magnify" class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"></iconify-icon>
                            <input
                                type="text"
                                id="vehicle-search"
                                class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-4 text-sm transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                                placeholder="<?php esc_attr_e( 'Araç model, marka veya donanım ara...', 'tamgaci' ); ?>"
                            >
                        </div>
                    </div>

                    <!-- Brand Filter -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700"><?php esc_html_e( 'Marka', 'tamgaci' ); ?></label>
                        <select id="brand-filter" class="w-full rounded-xl border border-slate-300 bg-white py-3 px-4 text-sm transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                            <option value=""><?php esc_html_e( 'Tüm Markalar', 'tamgaci' ); ?></option>
                            <?php if ( ! is_wp_error( $all_brands ) && ! empty( $all_brands ) ) : ?>
                                <?php foreach ( $all_brands as $brand ) : ?>
                                    <option value="<?php echo esc_attr( $brand->slug ); ?>"><?php echo esc_html( $brand->name ); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Body Type Filter -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700"><?php esc_html_e( 'Gövde Tipi', 'tamgaci' ); ?></label>
                        <select id="body-type-filter" class="w-full rounded-xl border border-slate-300 bg-white py-3 px-4 text-sm transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                            <option value=""><?php esc_html_e( 'Tüm Tipler', 'tamgaci' ); ?></option>
                            <?php if ( ! is_wp_error( $all_body_types ) && ! empty( $all_body_types ) ) : ?>
                                <?php foreach ( $all_body_types as $body_type ) : ?>
                                    <option value="<?php echo esc_attr( $body_type->slug ); ?>"><?php echo esc_html( $body_type->name ); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Vehicle Type Filter -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700"><?php esc_html_e( 'Araç Tipi', 'tamgaci' ); ?></label>
                        <select id="vehicle-type-filter" class="w-full rounded-xl border border-slate-300 bg-white py-3 px-4 text-sm transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                            <option value=""><?php esc_html_e( 'Tümü', 'tamgaci' ); ?></option>
                            <option value="electric_vehicle"><?php esc_html_e( 'Elektrikli', 'tamgaci' ); ?></option>
                            <option value="combustion_vehicle"><?php esc_html_e( 'Yakıtlı & Hibrit', 'tamgaci' ); ?></option>
                            <option value="motorcycle"><?php esc_html_e( 'Motorlar', 'tamgaci' ); ?></option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button type="button" id="clear-filters" class="text-sm font-medium text-slate-600 hover:text-slate-900">
                            <iconify-icon icon="mdi:filter-off" class="mr-1 h-4 w-4"></iconify-icon>
                            <?php esc_html_e( 'Filtreleri Temizle', 'tamgaci' ); ?>
                        </button>
                    </div>
                    <div class="text-sm text-slate-500">
                        <span id="results-count"><?php echo esc_html( $vehicles->found_posts ); ?></span> <?php esc_html_e( 'araç bulundu', 'tamgaci' ); ?>
                    </div>
                </div>
            </div>

            <!-- Selected Vehicles Preview -->
            <div id="selected-vehicles" class="mb-8 hidden rounded-2xl border border-blue-200/50 bg-blue-50/50 p-6 shadow-lg">
                <div class="mb-4 flex items-center gap-3">
                    <iconify-icon icon="mdi:check-circle" class="h-5 w-5 text-blue-600"></iconify-icon>
                    <h3 class="text-lg font-semibold text-blue-900"><?php esc_html_e( 'Seçilen Araçlar', 'tamgaci' ); ?></h3>
                    <span id="selected-count" class="rounded-full bg-blue-600 px-2 py-1 text-xs font-bold text-white">0</span>
                </div>
                <div id="selected-preview" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3"></div>
                <div class="mt-6 flex flex-wrap gap-3">
                    <button type="button" id="compare-button" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:bg-blue-700 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-50" disabled>
                        <iconify-icon icon="mdi:table-compare" class="h-5 w-5"></iconify-icon>
                        <?php esc_html_e( 'Karşılaştırmayı Başlat', 'tamgaci' ); ?>
                    </button>
                    <button type="button" id="clear-selection" class="inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition-all hover:bg-slate-50">
                        <iconify-icon icon="mdi:close" class="h-4 w-4"></iconify-icon>
                        <?php esc_html_e( 'Seçimi Temizle', 'tamgaci' ); ?>
                    </button>
                </div>
            </div>

            <!-- Vehicle Grid -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-900"><?php esc_html_e( 'Araç Listesi', 'tamgaci' ); ?></h3>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-500"><?php esc_html_e( 'Görünüm:', 'tamgaci' ); ?></span>
                        <button type="button" id="grid-view" class="rounded-lg bg-blue-600 p-2 text-white">
                            <iconify-icon icon="mdi:view-grid" class="h-4 w-4"></iconify-icon>
                        </button>
                        <button type="button" id="list-view" class="rounded-lg bg-slate-200 p-2 text-slate-600 hover:bg-slate-300">
                            <iconify-icon icon="mdi:view-list" class="h-4 w-4"></iconify-icon>
                        </button>
                    </div>
                </div>

                <div id="vehicles-container" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php if ( $vehicles->have_posts() ) : ?>
                        <?php while ( $vehicles->have_posts() ) : $vehicles->the_post(); ?>
                            <?php
                            $vehicle_data = tamgaci_prepare_vehicle_display_data( get_the_ID() );
                            if ( ! $vehicle_data ) continue;
                            ?>
                            <div
                                class="vehicle-card group relative cursor-pointer rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:border-blue-300 hover:shadow-lg hover:-translate-y-1"
                                data-vehicle-id="<?php echo esc_attr( get_the_ID() ); ?>"
                                data-vehicle-data="<?php echo esc_attr( wp_json_encode( [
                                    'id' => get_the_ID(),
                                    'title' => get_the_title(),
                                    'brands' => $vehicle_data['brands'] ?? [],
                                    'models' => $vehicle_data['models'] ?? [],
                                    'equipment' => $vehicle_data['equipment'] ?? '',
                                    'price' => $vehicle_data['price'] ?? '',
                                    'image' => $vehicle_data['image'] ?? '',
                                    'permalink' => get_permalink(),
                                    'post_type' => get_post_type(),
                                    'body_types' => $vehicle_data['body_types'] ?? [],
                                ] ) ); ?>"
                            >
                                <!-- Selection Checkbox -->
                                <div class="absolute right-4 top-4 z-10">
                                    <div class="vehicle-checkbox flex h-6 w-6 items-center justify-center rounded-full border-2 border-slate-300 bg-white transition-all group-hover:border-blue-500">
                                        <iconify-icon icon="mdi:check" class="hidden h-4 w-4 text-white"></iconify-icon>
                                    </div>
                                </div>

                                <!-- Vehicle Image -->
                                <?php if ( $vehicle_data['image'] ) : ?>
                                    <div class="mb-4 overflow-hidden rounded-xl">
                                        <img
                                            src="<?php echo esc_url( $vehicle_data['image'] ); ?>"
                                            alt="<?php echo esc_attr( get_the_title() ); ?>"
                                            class="h-32 w-full object-cover transition-transform group-hover:scale-105"
                                            loading="lazy"
                                        >
                                    </div>
                                <?php endif; ?>

                                <!-- Vehicle Info -->
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-slate-900 group-hover:text-blue-600">
                                        <?php echo esc_html( get_the_title() ); ?>
                                    </h4>

                                    <?php if ( ! empty( $vehicle_data['brands'] ) ) : ?>
                                        <p class="text-sm text-slate-600">
                                            <iconify-icon icon="mdi:car" class="mr-1 h-4 w-4"></iconify-icon>
                                            <?php echo esc_html( implode( ' · ', $vehicle_data['brands'] ) ); ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ( $vehicle_data['equipment'] ) : ?>
                                        <p class="text-sm text-slate-500">
                                            <?php echo esc_html( $vehicle_data['equipment'] ); ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ( $vehicle_data['price'] ) : ?>
                                        <p class="text-lg font-bold text-green-600">
                                            <?php echo esc_html( $vehicle_data['price'] ); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <!-- Vehicle Type Badge -->
                                <div class="absolute left-4 top-4">
                                    <span class="rounded-full px-2 py-1 text-xs font-semibold <?php echo $vehicle_data['is_electric'] ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700'; ?>">
                                        <?php echo $vehicle_data['is_electric'] ? esc_html__( 'ELEKTRİKLİ', 'tamgaci' ) : esc_html__( 'YAKITLI', 'tamgaci' ); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>

                <!-- No Results Message -->
                <div id="no-results" class="hidden py-12 text-center">
                    <iconify-icon icon="mdi:car-off" class="mx-auto h-16 w-16 text-slate-300"></iconify-icon>
                    <h3 class="mt-4 text-lg font-medium text-slate-900"><?php esc_html_e( 'Araç bulunamadı', 'tamgaci' ); ?></h3>
                    <p class="mt-2 text-sm text-slate-500"><?php esc_html_e( 'Arama kriterlerinizi değiştirerek tekrar deneyin.', 'tamgaci' ); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectedVehicles = new Set();
    const vehicleCards = document.querySelectorAll('.vehicle-card');
    const selectedContainer = document.getElementById('selected-vehicles');
    const selectedPreview = document.getElementById('selected-preview');
    const selectedCount = document.getElementById('selected-count');
    const compareButton = document.getElementById('compare-button');
    const clearSelection = document.getElementById('clear-selection');
    const searchInput = document.getElementById('vehicle-search');
    const brandFilter = document.getElementById('brand-filter');
    const bodyTypeFilter = document.getElementById('body-type-filter');
    const vehicleTypeFilter = document.getElementById('vehicle-type-filter');
    const clearFilters = document.getElementById('clear-filters');
    const resultsCount = document.getElementById('results-count');
    const vehiclesContainer = document.getElementById('vehicles-container');
    const noResults = document.getElementById('no-results');

    // Vehicle selection
    vehicleCards.forEach(card => {
        card.addEventListener('click', function() {
            const vehicleId = this.dataset.vehicleId;
            const checkbox = this.querySelector('.vehicle-checkbox');
            const checkIcon = checkbox.querySelector('iconify-icon');

            if (selectedVehicles.has(vehicleId)) {
                // Deselect
                selectedVehicles.delete(vehicleId);
                this.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
                checkbox.classList.remove('bg-blue-600', 'border-blue-600');
                checkbox.classList.add('border-slate-300');
                checkIcon.classList.add('hidden');
            } else {
                // Select
                selectedVehicles.add(vehicleId);
                this.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
                checkbox.classList.add('bg-blue-600', 'border-blue-600');
                checkbox.classList.remove('border-slate-300');
                checkIcon.classList.remove('hidden');
            }

            updateSelectedPreview();
        });
    });

    function updateSelectedPreview() {
        selectedCount.textContent = selectedVehicles.size;

        if (selectedVehicles.size === 0) {
            selectedContainer.classList.add('hidden');
            compareButton.disabled = true;
        } else {
            selectedContainer.classList.remove('hidden');
            compareButton.disabled = selectedVehicles.size < 2;

            // Update preview
            selectedPreview.innerHTML = '';
            selectedVehicles.forEach(vehicleId => {
                const card = document.querySelector(`[data-vehicle-id="${vehicleId}"]`);
                const data = JSON.parse(card.dataset.vehicleData);

                const previewCard = document.createElement('div');
                previewCard.className = 'flex items-center gap-3 rounded-xl bg-white p-3 shadow-sm';
                previewCard.innerHTML = `
                    <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <iconify-icon icon="mdi:car" class="h-6 w-6 text-blue-600"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <h5 class="font-medium text-slate-900">${data.title}</h5>
                        <p class="text-sm text-slate-600">${data.brands.join(' · ')}</p>
                    </div>
                `;
                selectedPreview.appendChild(previewCard);
            });
        }
    }

    // Compare button
    compareButton.addEventListener('click', function() {
        if (selectedVehicles.size >= 2) {
            const vehicleIds = Array.from(selectedVehicles);
            const compareUrl = `<?php echo esc_url( $compare_url ); ?>?vehicles=${vehicleIds.join(',')}`;
            window.location.href = compareUrl;
        }
    });

    // Clear selection
    clearSelection.addEventListener('click', function() {
        selectedVehicles.clear();
        vehicleCards.forEach(card => {
            card.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
            const checkbox = card.querySelector('.vehicle-checkbox');
            const checkIcon = checkbox.querySelector('iconify-icon');
            checkbox.classList.remove('bg-blue-600', 'border-blue-600');
            checkbox.classList.add('border-slate-300');
            checkIcon.classList.add('hidden');
        });
        updateSelectedPreview();
    });

    // Filtering and search
    function filterVehicles() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedBrand = brandFilter.value;
        const selectedBodyType = bodyTypeFilter.value;
        const selectedVehicleType = vehicleTypeFilter.value;

        let visibleCount = 0;

        vehicleCards.forEach(card => {
            const data = JSON.parse(card.dataset.vehicleData);
            let show = true;

            // Search filter
            if (searchTerm && !data.title.toLowerCase().includes(searchTerm) &&
                !data.brands.some(brand => brand.toLowerCase().includes(searchTerm)) &&
                !data.equipment.toLowerCase().includes(searchTerm)) {
                show = false;
            }

            // Brand filter
            if (selectedBrand && !data.brands.some(brand =>
                brand.toLowerCase().includes(selectedBrand.replace('-', ' ')))) {
                show = false;
            }

            // Body type filter
            if (selectedBodyType && !data.body_types.some(type =>
                type.toLowerCase().includes(selectedBodyType.replace('-', ' ')))) {
                show = false;
            }

            // Vehicle type filter
            if (selectedVehicleType && data.post_type !== selectedVehicleType) {
                show = false;
            }

            if (show) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        resultsCount.textContent = visibleCount;

        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            vehiclesContainer.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            vehiclesContainer.classList.remove('hidden');
        }
    }

    // Event listeners for filters
    searchInput.addEventListener('input', filterVehicles);
    brandFilter.addEventListener('change', filterVehicles);
    bodyTypeFilter.addEventListener('change', filterVehicles);
    vehicleTypeFilter.addEventListener('change', filterVehicles);

    clearFilters.addEventListener('click', function() {
        searchInput.value = '';
        brandFilter.value = '';
        bodyTypeFilter.value = '';
        vehicleTypeFilter.value = '';
        filterVehicles();
    });

    // View toggle
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');

    listView.addEventListener('click', function() {
        vehiclesContainer.className = 'space-y-4';
        vehicleCards.forEach(card => {
            card.className = card.className.replace('rounded-2xl border border-slate-200 bg-white p-6', 'rounded-xl border border-slate-200 bg-white p-4 flex items-center gap-4');
        });
        gridView.className = 'rounded-lg bg-slate-200 p-2 text-slate-600 hover:bg-slate-300';
        listView.className = 'rounded-lg bg-blue-600 p-2 text-white';
    });

    gridView.addEventListener('click', function() {
        vehiclesContainer.className = 'grid gap-6 sm:grid-cols-2 lg:grid-cols-3';
        vehicleCards.forEach(card => {
            card.className = card.className.replace('rounded-xl border border-slate-200 bg-white p-4 flex items-center gap-4', 'rounded-2xl border border-slate-200 bg-white p-6');
        });
        gridView.className = 'rounded-lg bg-blue-600 p-2 text-white';
        listView.className = 'rounded-lg bg-slate-200 p-2 text-slate-600 hover:bg-slate-300';
    });
});
</script>

<?php
get_footer();
