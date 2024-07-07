jQuery(document).ready(function($) {
    // Function to update order total based on selected delivery option
    function updateOrderTotal() {
        var deliveryOption = $('input[name="custom_radio_buttons"]:checked').val();
        if (deliveryOption === 'standard_delivery') {
            // Add $350 for standard delivery
            $('.order-total .woocommerce-Price-amount').append('<span class="delivery-fee"> + $350</span>');
        } else if (deliveryOption === 'priority_delivery') {
            // Add $450 for priority delivery
            $('.order-total .woocommerce-Price-amount').append('<span class="delivery-fee"> + $450</span>');
        }
    }

    // Trigger update on initial page load
    updateOrderTotal();

    // Update order total on radio button change
    $('input[name="custom_radio_buttons"]').change(function() {
        // Remove previously added delivery fee span
        $('.order-total .woocommerce-Price-amount .delivery-fee').remove();
        // Update order total based on selected option
        updateOrderTotal();
    });
});
