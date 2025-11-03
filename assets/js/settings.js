/**
 * Theme Settings JavaScript
 * Handles API key testing and settings page interactions
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Test Gemini API key
        $('#test-gemini-api').on('click', function(e) {
            e.preventDefault();

            var $button = $(this);
            var $result = $('#gemini-test-result');

            // Disable button and show loading
            $button.prop('disabled', true).text('Test ediliyor...');
            $result.html('<span style="color: #999;">⏳ Bağlantı kuruluyor...</span>');

            $.ajax({
                url: tamgaciSettings.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'test_gemini_api',
                    nonce: tamgaciSettings.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $result.html('<span style="color: #46b450;">✓ ' + response.data.message + '</span>');
                    } else {
                        $result.html('<span style="color: #dc3232;">✗ ' + response.data.message + '</span>');
                    }
                },
                error: function() {
                    $result.html('<span style="color: #dc3232;">✗ Bağlantı hatası oluştu.</span>');
                },
                complete: function() {
                    $button.prop('disabled', false).text('API Key\'i Test Et');
                }
            });
        });
    });
})(jQuery);
