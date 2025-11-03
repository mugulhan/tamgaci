/**
 * Admin panel JavaScript for Tamgaci theme
 * Handles bi-directional automatic calculations:
 * - Fuel consumption (city/highway ↔ WLTP combined)
 * - Power (kW ↔ PS)
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Fuel consumption calculation for combustion vehicles and motorcycles
        var cityField = $('input[name="tamgaci_vehicle_fuel_consumption_city"]');
        var highwayField = $('input[name="tamgaci_vehicle_fuel_consumption_highway"]');
        var averageField = $('input[name="tamgaci_vehicle_fuel_consumption"]');

        if (cityField.length && highwayField.length && averageField.length) {
            var isCalculatingFuel = false; // Prevent infinite loops

            // Calculate average from city + highway
            function calculateAverage() {
                if (isCalculatingFuel) return;

                var city = parseFloat(cityField.val());
                var highway = parseFloat(highwayField.val());

                if (!isNaN(city) && !isNaN(highway) && city > 0 && highway > 0) {
                    isCalculatingFuel = true;
                    // Calculate weighted average (55% city, 45% highway as per WLTP)
                    var average = (city * 0.55 + highway * 0.45).toFixed(1);
                    averageField.val(average);
                    isCalculatingFuel = false;
                }
            }

            // Calculate city + highway from average
            function calculateCityHighway() {
                if (isCalculatingFuel) return;

                var average = parseFloat(averageField.val());
                var city = parseFloat(cityField.val());
                var highway = parseFloat(highwayField.val());

                // Only calculate if average is provided but city/highway are empty
                if (!isNaN(average) && average > 0 && (isNaN(city) || city == 0) && (isNaN(highway) || highway == 0)) {
                    isCalculatingFuel = true;
                    // Estimate city (typically 15% higher) and highway (10% lower)
                    var estimatedCity = (average * 1.15).toFixed(1);
                    var estimatedHighway = (average * 0.90).toFixed(1);
                    cityField.val(estimatedCity);
                    highwayField.val(estimatedHighway);
                    isCalculatingFuel = false;
                }
            }

            // Bind to input events
            cityField.on('input change', function() {
                calculateAverage();
            });

            highwayField.on('input change', function() {
                calculateAverage();
            });

            averageField.on('input change', function() {
                calculateCityHighway();
            });

            // Calculate on page load if values exist
            var initialCity = parseFloat(cityField.val());
            var initialHighway = parseFloat(highwayField.val());
            var initialAverage = parseFloat(averageField.val());

            if (!isNaN(initialCity) && !isNaN(initialHighway) && initialCity > 0 && initialHighway > 0) {
                calculateAverage();
            } else if (!isNaN(initialAverage) && initialAverage > 0) {
                calculateCityHighway();
            }
        }

        // Power calculation (kW ↔ PS)
        // Conversion factor: 1 kW = 1.35962 PS (DIN standard)
        var powerKwField = $('input[name="tamgaci_vehicle_power"]');
        var powerPsField = $('input[name="tamgaci_vehicle_horsepower"]');

        if (powerKwField.length && powerPsField.length) {
            var isCalculatingPower = false; // Prevent infinite loops

            // Calculate PS from kW
            function calculatePS() {
                if (isCalculatingPower) return;

                var kw = parseFloat(powerKwField.val());
                var ps = parseFloat(powerPsField.val());

                // Only calculate if kW is provided but PS is empty or zero
                if (!isNaN(kw) && kw > 0 && (isNaN(ps) || ps == 0)) {
                    isCalculatingPower = true;
                    var calculatedPs = Math.round(kw * 1.35962);
                    powerPsField.val(calculatedPs);
                    isCalculatingPower = false;
                }
            }

            // Calculate kW from PS
            function calculateKW() {
                if (isCalculatingPower) return;

                var ps = parseFloat(powerPsField.val());
                var kw = parseFloat(powerKwField.val());

                // Only calculate if PS is provided but kW is empty or zero
                if (!isNaN(ps) && ps > 0 && (isNaN(kw) || kw == 0)) {
                    isCalculatingPower = true;
                    var calculatedKw = (ps / 1.35962).toFixed(1);
                    powerKwField.val(calculatedKw);
                    isCalculatingPower = false;
                }
            }

            // Bind to input events
            powerKwField.on('input change', function() {
                calculatePS();
            });

            powerPsField.on('input change', function() {
                calculateKW();
            });

            // Calculate on page load if values exist
            var initialKw = parseFloat(powerKwField.val());
            var initialPs = parseFloat(powerPsField.val());

            if (!isNaN(initialKw) && initialKw > 0 && (isNaN(initialPs) || initialPs == 0)) {
                calculatePS();
            } else if (!isNaN(initialPs) && initialPs > 0 && (isNaN(initialKw) || initialKw == 0)) {
                calculateKW();
            }
        }

        // Tab switching for Text/Image input
        var currentImageData = null;

        $('#tamgaci-tab-text').on('click', function() {
            $('#tamgaci-panel-text').show();
            $('#tamgaci-panel-image').hide();
            $(this).css({'background': '#0969da', 'color': 'white', 'border-color': '#0969da'});
            $('#tamgaci-tab-image').css({'background': 'white', 'color': '#0969da'});
        });

        $('#tamgaci-tab-image').on('click', function() {
            $('#tamgaci-panel-text').hide();
            $('#tamgaci-panel-image').show();
            $(this).css({'background': '#0969da', 'color': 'white', 'border-color': '#0969da'});
            $('#tamgaci-tab-text').css({'background': 'white', 'color': '#0969da'});

            // Focus on paste area
            setTimeout(function() {
                $('#tamgaci-paste-area').focus();
            }, 100);
        });

        // Clipboard paste handler
        var $pasteArea = $('#tamgaci-paste-area');

        $pasteArea.on('paste', function(e) {
            e.preventDefault();

            var clipboardData = e.originalEvent.clipboardData || window.clipboardData;
            var items = clipboardData.items;

            console.log('Paste event detected');

            // Look for image in clipboard
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf('image') !== -1) {
                    var blob = items[i].getAsFile();
                    console.log('Image found in clipboard:', blob.type, blob.size);

                    // Validate file size (4MB max)
                    if (blob.size > 4 * 1024 * 1024) {
                        alert('Görsel boyutu 4MB\'dan küçük olmalıdır.');
                        return;
                    }

                    // Read as base64
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        currentImageData = event.target.result;

                        // Hide placeholder
                        $('#tamgaci-paste-placeholder').hide();

                        // Show preview
                        $('#tamgaci-image-preview').html(
                            '<img src="' + currentImageData + '" style="max-width: 100%; max-height: 300px; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" />' +
                            '<p style="margin-top: 10px; color: #46b450;"><strong>✓ Görsel yapıştırıldı</strong></p>' +
                            '<button type="button" id="tamgaci-clear-image" class="button button-small" style="margin-top: 5px;">' +
                            '<span class="dashicons dashicons-no" style="vertical-align: middle;"></span> Temizle</button>'
                        );

                        console.log('Image loaded successfully');
                    };
                    reader.readAsDataURL(blob);

                    return;
                }
            }

            // If no image found
            console.log('No image found in clipboard');
        });

        // Clear image button
        $(document).on('click', '#tamgaci-clear-image', function() {
            currentImageData = null;
            $('#tamgaci-image-preview').empty();
            $('#tamgaci-paste-placeholder').show();
            $('#tamgaci-paste-area').html($('#tamgaci-paste-placeholder'));
            console.log('Image cleared');
        });

        // Focus styling
        $pasteArea.on('focus', function() {
            $(this).css('border-color', '#2271b1');
        });

        $pasteArea.on('blur', function() {
            $(this).css('border-color', '#0969da');
        });

        // Gemini AI Auto-fill
        $('#tamgaci-gemini-autofill-btn').on('click', function(e) {
            e.preventDefault();

            var $button = $(this);
            var $status = $('#tamgaci-gemini-status');
            var $input = $('#tamgaci-gemini-input');
            var inputText = $input.val().trim();
            var imageData = currentImageData;

            console.log('Gemini autofill button clicked');
            console.log('Input text:', inputText);
            console.log('Image data:', imageData ? 'Yes' : 'No');

            // Check if we have either text or image
            if (!inputText && !imageData) {
                $status.html('<span style="color: #dc3232;">✗ Lütfen teknik özellikleri veya görsel girin.</span>');
                return;
            }

            // Get post type from body class
            var postType = '';
            if ($('body').hasClass('post-type-combustion_vehicle')) {
                postType = 'combustion_vehicle';
            } else if ($('body').hasClass('post-type-electric_vehicle')) {
                postType = 'electric_vehicle';
            } else if ($('body').hasClass('post-type-motorcycle')) {
                postType = 'motorcycle';
            }

            console.log('Post type:', postType);

            if (!postType) {
                $status.html('<span style="color: #dc3232;">✗ Araç tipi tespit edilemedi.</span>');
                return;
            }

            // Check if tamgaciAdmin is defined
            if (typeof tamgaciAdmin === 'undefined') {
                console.error('tamgaciAdmin is not defined');
                $status.html('<span style="color: #dc3232;">✗ JavaScript yapılandırma hatası. Sayfayı yenileyin.</span>');
                return;
            }

            console.log('Sending AJAX request...');

            // Disable button and show loading
            $button.prop('disabled', true).html('<span class="dashicons dashicons-update dashicons-spin" style="vertical-align: middle;"></span> AI Analiz Ediyor...');
            $status.html('<span style="color: #999;">⏳ Gemini API ile iletişim kuruluyor...</span>');

            $.ajax({
                url: tamgaciAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'gemini_autofill_vehicle',
                    nonce: tamgaciAdmin.nonce,
                    input_text: inputText,
                    image_data: imageData || '',
                    post_type: postType
                },
                success: function(response) {
                    console.log('AJAX response:', response);

                    if (response.success) {
                        $status.html('<span style="color: #46b450;">✓ ' + response.data.message + '</span>');

                        // Fill form fields
                        var data = response.data.data;
                        console.log('Filling fields with data:', data);

                        for (var key in data) {
                            if (data.hasOwnProperty(key) && data[key] !== null) {
                                var $field = $('input[name="' + key + '"], select[name="' + key + '"], textarea[name="' + key + '"]');
                                if ($field.length) {
                                    console.log('Setting field', key, 'to', data[key]);
                                    $field.val(data[key]).trigger('change');
                                }
                            }
                        }

                        // Scroll to meta fields
                        $('html, body').animate({
                            scrollTop: $('.tamgaci-meta-grid').offset().top - 100
                        }, 500);
                    } else {
                        console.error('API error:', response.data);
                        $status.html('<span style="color: #dc3232;">✗ ' + response.data.message + '</span>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', xhr, status, error);
                    console.error('Response text:', xhr.responseText);
                    $status.html('<span style="color: #dc3232;">✗ Bağlantı hatası: ' + error + '</span>');
                },
                complete: function() {
                    $button.prop('disabled', false).html('<span class="dashicons dashicons-superhero" style="vertical-align: middle;"></span> AI ile Doldur');
                }
            });
        });
    });
})(jQuery);
