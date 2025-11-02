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
    });
})(jQuery);
