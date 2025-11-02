/**
 * Admin panel JavaScript for Tamgaci theme
 * Handles bi-directional automatic fuel consumption calculation
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Fuel consumption calculation for combustion vehicles and motorcycles
        var cityField = $('input[name="tamgaci_vehicle_fuel_consumption_city"]');
        var highwayField = $('input[name="tamgaci_vehicle_fuel_consumption_highway"]');
        var averageField = $('input[name="tamgaci_vehicle_fuel_consumption"]');

        if (cityField.length && highwayField.length && averageField.length) {
            var isCalculating = false; // Prevent infinite loops

            // Calculate average from city + highway
            function calculateAverage() {
                if (isCalculating) return;

                var city = parseFloat(cityField.val());
                var highway = parseFloat(highwayField.val());

                if (!isNaN(city) && !isNaN(highway) && city > 0 && highway > 0) {
                    isCalculating = true;
                    // Calculate weighted average (55% city, 45% highway as per WLTP)
                    var average = (city * 0.55 + highway * 0.45).toFixed(1);
                    averageField.val(average);
                    isCalculating = false;
                }
            }

            // Calculate city + highway from average
            function calculateCityHighway() {
                if (isCalculating) return;

                var average = parseFloat(averageField.val());
                var city = parseFloat(cityField.val());
                var highway = parseFloat(highwayField.val());

                // Only calculate if average is provided but city/highway are empty
                if (!isNaN(average) && average > 0 && (isNaN(city) || city == 0) && (isNaN(highway) || highway == 0)) {
                    isCalculating = true;
                    // Estimate city (typically 15% higher) and highway (10% lower)
                    var estimatedCity = (average * 1.15).toFixed(1);
                    var estimatedHighway = (average * 0.90).toFixed(1);
                    cityField.val(estimatedCity);
                    highwayField.val(estimatedHighway);
                    isCalculating = false;
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
    });
})(jQuery);
