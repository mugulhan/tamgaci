/**
 * Admin panel JavaScript for Tamgaci theme
 * Handles automatic fuel consumption calculation
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Fuel consumption calculation for combustion vehicles and motorcycles
        var cityField = $('input[name="tamgaci_vehicle_fuel_consumption_city"]');
        var highwayField = $('input[name="tamgaci_vehicle_fuel_consumption_highway"]');
        var averageField = $('input[name="tamgaci_vehicle_fuel_consumption"]');

        if (cityField.length && highwayField.length && averageField.length) {
            // Calculate average when either field changes
            function calculateAverage() {
                var city = parseFloat(cityField.val());
                var highway = parseFloat(highwayField.val());

                if (!isNaN(city) && !isNaN(highway) && city > 0 && highway > 0) {
                    // Calculate weighted average (55% city, 45% highway as per WLTP)
                    var average = (city * 0.55 + highway * 0.45).toFixed(1);
                    averageField.val(average);
                }
            }

            // Bind to input events
            cityField.on('input change', calculateAverage);
            highwayField.on('input change', calculateAverage);

            // Calculate on page load if values exist
            calculateAverage();
        }
    });
})(jQuery);
