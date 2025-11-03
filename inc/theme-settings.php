<?php
/**
 * Theme Settings Page
 * Manages Gemini API configuration and other theme options
 */

/**
 * Add settings menu to WordPress admin
 */
function tamgaci_add_settings_menu() {
    add_options_page(
        __( 'Tamgaci Ayarları', 'tamgaci' ),
        __( 'Tamgaci Ayarları', 'tamgaci' ),
        'manage_options',
        'tamgaci-settings',
        'tamgaci_render_settings_page'
    );
}
add_action( 'admin_menu', 'tamgaci_add_settings_menu' );

/**
 * Register settings
 */
function tamgaci_register_settings() {
    register_setting(
        'tamgaci_settings_group',
        'tamgaci_gemini_api_key',
        [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        ]
    );

    add_settings_section(
        'tamgaci_gemini_section',
        __( 'Gemini AI Ayarları', 'tamgaci' ),
        'tamgaci_gemini_section_callback',
        'tamgaci-settings'
    );

    add_settings_field(
        'tamgaci_gemini_api_key',
        __( 'Gemini API Key', 'tamgaci' ),
        'tamgaci_gemini_api_key_callback',
        'tamgaci-settings',
        'tamgaci_gemini_section'
    );
}
add_action( 'admin_init', 'tamgaci_register_settings' );

/**
 * Section description
 */
function tamgaci_gemini_section_callback() {
    echo '<p>' . __( 'Araç teknik özelliklerini otomatik doldurmak için Gemini AI kullanılır.', 'tamgaci' ) . '</p>';
    echo '<p>' . sprintf(
        __( 'API key almak için <a href="%s" target="_blank">Google AI Studio</a> sayfasını ziyaret edin.', 'tamgaci' ),
        'https://aistudio.google.com/app/apikey'
    ) . '</p>';
}

/**
 * API Key field
 */
function tamgaci_gemini_api_key_callback() {
    $api_key = get_option( 'tamgaci_gemini_api_key', '' );
    ?>
    <input
        type="text"
        name="tamgaci_gemini_api_key"
        value="<?php echo esc_attr( $api_key ); ?>"
        class="regular-text"
        placeholder="AIza..."
    />
    <p class="description">
        <?php _e( 'Gemini API anahtarınızı buraya girin.', 'tamgaci' ); ?>
    </p>

    <?php if ( ! empty( $api_key ) ) : ?>
        <p>
            <button type="button" id="test-gemini-api" class="button button-secondary">
                <?php _e( 'API Key\'i Test Et', 'tamgaci' ); ?>
            </button>
            <span id="gemini-test-result" style="margin-left: 10px;"></span>
        </p>
    <?php endif; ?>
    <?php
}

/**
 * Render settings page
 */
function tamgaci_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Show success message after save
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error(
            'tamgaci_messages',
            'tamgaci_message',
            __( 'Ayarlar kaydedildi.', 'tamgaci' ),
            'success'
        );
    }

    settings_errors( 'tamgaci_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'tamgaci_settings_group' );
            do_settings_sections( 'tamgaci-settings' );
            submit_button( __( 'Kaydet', 'tamgaci' ) );
            ?>
        </form>
    </div>
    <?php
}

/**
 * AJAX handler for testing Gemini API key
 */
function tamgaci_test_gemini_api() {
    check_ajax_referer( 'tamgaci-admin', 'nonce' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => __( 'Yetkiniz yok.', 'tamgaci' ) ] );
    }

    $api_key = get_option( 'tamgaci_gemini_api_key', '' );

    if ( empty( $api_key ) ) {
        wp_send_json_error( [ 'message' => __( 'API key bulunamadı.', 'tamgaci' ) ] );
    }

    // Test API key with a simple request
    $response = tamgaci_call_gemini_api(
        'Merhaba, bu bir test mesajıdır. Sadece "Test başarılı" yanıtını ver.',
        $api_key
    );

    if ( is_wp_error( $response ) ) {
        wp_send_json_error( [
            'message' => sprintf(
                __( 'API hatası: %s', 'tamgaci' ),
                $response->get_error_message()
            )
        ] );
    }

    wp_send_json_success( [
        'message' => __( 'API key geçerli! Bağlantı başarılı.', 'tamgaci' ),
        'response' => $response
    ] );
}
add_action( 'wp_ajax_test_gemini_api', 'tamgaci_test_gemini_api' );

/**
 * Call Gemini API
 *
 * @param string $prompt The prompt to send
 * @param string $api_key Optional API key (uses stored key if not provided)
 * @return string|WP_Error Response text or error
 */
function tamgaci_call_gemini_api( $prompt, $api_key = '' ) {
    if ( empty( $api_key ) ) {
        $api_key = get_option( 'tamgaci_gemini_api_key', '' );
    }

    if ( empty( $api_key ) ) {
        return new WP_Error( 'no_api_key', __( 'Gemini API key tanımlanmamış.', 'tamgaci' ) );
    }

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=' . $api_key;

    $body = [
        'contents' => [
            [
                'parts' => [
                    [
                        'text' => $prompt
                    ]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.1,
            'maxOutputTokens' => 2048,
        ]
    ];

    $response = wp_remote_post( $url, [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'body'    => wp_json_encode( $body ),
        'timeout' => 30,
    ] );

    if ( is_wp_error( $response ) ) {
        return $response;
    }

    $status_code = wp_remote_retrieve_response_code( $response );
    $body_data   = wp_remote_retrieve_body( $response );
    $decoded     = json_decode( $body_data, true );

    if ( $status_code !== 200 ) {
        $error_message = isset( $decoded['error']['message'] )
            ? $decoded['error']['message']
            : __( 'Bilinmeyen API hatası', 'tamgaci' );

        return new WP_Error( 'api_error', $error_message );
    }

    if ( ! isset( $decoded['candidates'][0]['content']['parts'][0]['text'] ) ) {
        return new WP_Error( 'invalid_response', __( 'API yanıtı beklenmeyen formatta.', 'tamgaci' ) );
    }

    return $decoded['candidates'][0]['content']['parts'][0]['text'];
}

/**
 * Call Gemini Vision API with image
 *
 * @param string $prompt The prompt to send
 * @param string $image_base64 Base64 encoded image data
 * @param string $mime_type Image MIME type (e.g. 'image/jpeg')
 * @param string $api_key Optional API key
 * @return string|WP_Error Response text or error
 */
function tamgaci_call_gemini_vision_api( $prompt, $image_base64, $mime_type, $api_key = '' ) {
    if ( empty( $api_key ) ) {
        $api_key = get_option( 'tamgaci_gemini_api_key', '' );
    }

    if ( empty( $api_key ) ) {
        return new WP_Error( 'no_api_key', __( 'Gemini API key tanımlanmamış.', 'tamgaci' ) );
    }

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=' . $api_key;

    $body = [
        'contents' => [
            [
                'parts' => [
                    [
                        'text' => $prompt
                    ],
                    [
                        'inline_data' => [
                            'mime_type' => $mime_type,
                            'data'      => $image_base64
                        ]
                    ]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.1,
            'maxOutputTokens' => 2048,
        ]
    ];

    $response = wp_remote_post( $url, [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'body'    => wp_json_encode( $body ),
        'timeout' => 30,
    ] );

    if ( is_wp_error( $response ) ) {
        return $response;
    }

    $status_code = wp_remote_retrieve_response_code( $response );
    $body_data   = wp_remote_retrieve_body( $response );
    $decoded     = json_decode( $body_data, true );

    if ( $status_code !== 200 ) {
        $error_message = isset( $decoded['error']['message'] )
            ? $decoded['error']['message']
            : __( 'Bilinmeyen API hatası', 'tamgaci' );

        return new WP_Error( 'api_error', $error_message );
    }

    if ( ! isset( $decoded['candidates'][0]['content']['parts'][0]['text'] ) ) {
        return new WP_Error( 'invalid_response', __( 'API yanıtı beklenmeyen formatta.', 'tamgaci' ) );
    }

    return $decoded['candidates'][0]['content']['parts'][0]['text'];
}

/**
 * AJAX handler for auto-filling vehicle specs with Gemini AI
 */
function tamgaci_gemini_autofill_vehicle() {
    check_ajax_referer( 'tamgaci-admin', 'nonce' );

    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_send_json_error( [ 'message' => __( 'Yetkiniz yok.', 'tamgaci' ) ] );
    }

    $input_text  = isset( $_POST['input_text'] ) ? sanitize_textarea_field( wp_unslash( $_POST['input_text'] ) ) : '';
    $image_data  = isset( $_POST['image_data'] ) ? $_POST['image_data'] : ''; // Base64, don't sanitize yet
    $post_type   = isset( $_POST['post_type'] ) ? sanitize_text_field( wp_unslash( $_POST['post_type'] ) ) : '';

    // Check if we have either text or image
    if ( empty( $input_text ) && empty( $image_data ) ) {
        wp_send_json_error( [ 'message' => __( 'Lütfen teknik özellikleri veya görsel girin.', 'tamgaci' ) ] );
    }

    if ( ! in_array( $post_type, [ 'combustion_vehicle', 'electric_vehicle', 'motorcycle' ] ) ) {
        wp_send_json_error( [ 'message' => __( 'Geçersiz araç tipi.', 'tamgaci' ) ] );
    }

    // Get field schema for the post type
    require_once TAMGACI_THEME_PATH . '/inc/vehicle-post-type.php';
    $schema = tamgaci_vehicle_meta_schema( $post_type );

    // Build field list for Gemini
    $field_descriptions = [];
    foreach ( $schema as $key => $config ) {
        $field_name = str_replace( 'tamgaci_vehicle_', '', $key );
        $field_descriptions[] = sprintf(
            '"%s": %s (%s)',
            $field_name,
            $config['label'],
            isset( $config['unit'] ) ? $config['unit'] : 'metin'
        );
    }

    // Create prompt for Gemini
    $prompt = "Aşağıdaki araç teknik özelliklerini analiz et ve JSON formatında çıkar.\n\n";
    $prompt .= "GİRDİ METNİ:\n" . $input_text . "\n\n";
    $prompt .= "ÇIKTI FORMATI (JSON):\n";
    $prompt .= "Sadece şu alanları doldur (boş bırakma, değer yoksa null ver):\n\n";
    $prompt .= implode( "\n", $field_descriptions ) . "\n\n";
    $prompt .= "ÖNEMLİ KURALLAR:\n";
    $prompt .= "- Sadece JSON formatında yanıt ver, başka hiçbir açıklama ekleme\n";
    $prompt .= "- Alan adlarında 'tamgaci_vehicle_' öneki OLMASIN, sadece alan adı\n";
    $prompt .= "- Sayısal değerleri rakam olarak ver (string değil)\n";
    $prompt .= "- Yakıt tipi için: benzin, dizel, lpg, mhev, hybrid, phev seçeneklerinden birini seç\n";
    $prompt .= "- Çekiş sistemi için: fwd, rwd, awd seçeneklerinden birini seç\n";
    $prompt .= "- Vites tipi için: manual, automatic, semi_automatic seçeneklerinden birini seç\n";
    $prompt .= "- Güç hesaplaması: Eğer sadece kW verilmişse PS = kW × 1.35962, sadece PS verilmişse kW = PS / 1.35962\n";
    $prompt .= "- WLTP tüketim: Eğer şehir içi ve şehir dışı verilmişse, birleşik = (şehir içi × 0.55) + (şehir dışı × 0.45)\n\n";
    $prompt .= "ÖRNEK JSON ÇIKTI:\n";
    $prompt .= "{\n";
    $prompt .= '  "model": "Golf",'."\n";
    $prompt .= '  "engine_description": "1.5 TSI 150 PS",'."\n";
    $prompt .= '  "fuel_type": "benzin",'."\n";
    $prompt .= '  "power": 110,'."\n";
    $prompt .= '  "horsepower": 150'."\n";
    $prompt .= "}\n\n";

    // Check if we're using image or text input
    if ( ! empty( $image_data ) ) {
        // Parse base64 image data
        if ( preg_match( '/^data:image\/(\w+);base64,(.+)$/', $image_data, $matches ) ) {
            $image_type = $matches[1];
            $image_base64 = $matches[2];
            $mime_type = 'image/' . $image_type;

            $prompt .= "Bu görseldeki araç teknik özelliklerini analiz et ve yukarıdaki formata göre JSON çıkar.";

            // Call Gemini Vision API
            $response = tamgaci_call_gemini_vision_api( $prompt, $image_base64, $mime_type );
        } else {
            wp_send_json_error( [ 'message' => __( 'Geçersiz görsel formatı.', 'tamgaci' ) ] );
        }
    } else {
        // Text input
        $prompt .= "Şimdi yukarıdaki girdiye göre JSON üret:";

        // Call Gemini API
        $response = tamgaci_call_gemini_api( $prompt );
    }

    if ( is_wp_error( $response ) ) {
        wp_send_json_error( [
            'message' => sprintf(
                __( 'Gemini API hatası: %s', 'tamgaci' ),
                $response->get_error_message()
            )
        ] );
    }

    // Parse JSON response
    // Remove markdown code blocks if present
    $response = preg_replace( '/```json\s*|\s*```/', '', $response );
    $response = trim( $response );

    $parsed_data = json_decode( $response, true );

    if ( json_last_error() !== JSON_ERROR_NONE ) {
        wp_send_json_error( [
            'message' => __( 'AI yanıtı JSON formatında değil.', 'tamgaci' ),
            'raw_response' => $response
        ] );
    }

    // Map field names back to full meta keys
    $mapped_data = [];
    foreach ( $parsed_data as $field_name => $value ) {
        $full_key = 'tamgaci_vehicle_' . $field_name;
        if ( isset( $schema[ $full_key ] ) ) {
            $mapped_data[ $full_key ] = $value;
        }
    }

    wp_send_json_success( [
        'message' => __( 'AI analizi tamamlandı! Alanlar dolduruldu.', 'tamgaci' ),
        'data' => $mapped_data
    ] );
}
add_action( 'wp_ajax_gemini_autofill_vehicle', 'tamgaci_gemini_autofill_vehicle' );

/**
 * Enqueue settings page JavaScript
 */
function tamgaci_enqueue_settings_scripts( $hook ) {
    if ( 'settings_page_tamgaci-settings' !== $hook ) {
        return;
    }

    wp_enqueue_script(
        'tamgaci-settings',
        get_template_directory_uri() . '/assets/js/settings.js',
        [ 'jquery' ],
        TAMGACI_VERSION,
        true
    );

    wp_localize_script( 'tamgaci-settings', 'tamgaciSettings', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'tamgaci-admin' ),
    ] );
}
add_action( 'admin_enqueue_scripts', 'tamgaci_enqueue_settings_scripts' );
