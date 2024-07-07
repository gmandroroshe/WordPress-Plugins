<?php
/*
Plugin Name: Custom Checkout Plugin
Description: Adds custom fields to WooCommerce checkout page and adjusts total based on selected option.
Version: 1.0
Author: Your Name
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', 'custom_checkout_fields_scripts');

function custom_checkout_fields_scripts() {
    // Enqueue jQuery and jQuery UI Datepicker
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-datepicker-style', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css');

    // Enqueue jQuery Timepicker (if needed)
    wp_enqueue_script('jquery-timepicker', plugin_dir_url(__FILE__) . 'assets/js/jquery.timepicker.min.js', array('jquery'), '1.0', true);
    wp_enqueue_style('jquery-timepicker-style', plugin_dir_url(__FILE__) . 'assets/css/jquery.timepicker.min.css', array(), '1.0');

    // Enqueue custom script
    wp_enqueue_script('custom-checkout-fields-script', plugin_dir_url(__FILE__) . 'assets/js/custom-checkout.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true);

    // Localize the script with new data (option costs)
    $translation_array = array(
        'option1_cost' => 350,
        'option2_cost' => 450,
    );
    wp_localize_script('custom-checkout-fields-script', 'custom_checkout_fields_vars', $translation_array);

    // Enqueue custom CSS
    wp_enqueue_style('custom-checkout-fields-style', plugin_dir_url(__FILE__) . 'assets/css/custom-checkout.css');
}


// Hook in your custom fields
add_action('woocommerce_after_checkout_billing_form', 'custom_checkout_fields');

function custom_checkout_fields() {
    echo '<style>
        .radio-option {
            display: inline-block;
            margin-right: 20px; /* Adjust spacing as needed */
        }
    </style>';

    echo '<div id="custom_checkout_field">';
    echo '<h3>' . __('Delivery Options') . '</h3>';

    // Radio buttons for option selection
    echo '<div class="radio-buttons">';
    echo '<div class="radio-option">';
    echo '<input type="radio" name="radio_option" id="radio_option1" value="option1" required>';
    echo '<label for="radio_option1">' . __('Standard Delivery (+Rs350)') . '</label>';
    echo '</div>';

    echo '<div class="radio-option">';
    echo '<input type="radio" name="radio_option" id="radio_option2" value="option2" required>';
    echo '<label for="radio_option2">' . __('Priority Delivery (+Rs450)') . '</label>';
    echo '</div>';
    echo '</div>';

    // Fields for Standard Delivery (hidden by default)
    echo '<div class="option1_fields" style="display:none;">';
    woocommerce_form_field('option1_date', array(
        'type' => 'date',
        'class' => array('form-row-wide'),
        'label' => __('Date for Standard Delivery')
    ));
    echo '<div class="time-slot-container">';
    echo '<label for="option1_time_slot1">' . __('Select Time 8am to 12pm') . '</label>';
    woocommerce_form_field('option1_time_slot1', array(
        'type' => 'select',
        'class' => array('form-row-wide', 'time-slot-select'),
        'options' => array(
            '' => __('Select Time'), // Default option
            '8:00 AM - 9:00 AM' => __('8:00 AM - 9:00 AM'),
            '9:00 AM - 10:00 AM' => __('9:00 AM - 10:00 AM'),
            '10:00 AM - 11:00 AM' => __('10:00 AM - 11:00 AM'),
            '11:00 AM - 12:00 PM' => __('11:00 AM - 12:00 PM')
        )
    ));
    echo '</div>';
    echo '<div class="time-slot-container">';
    echo '<label for="option1_time_slot2">' . __('Select Time 3pm to 7pm') . '</label>';
    woocommerce_form_field('option1_time_slot2', array(
        'type' => 'select',
        'class' => array('form-row-wide', 'time-slot-select'),
        'options' => array(
            '' => __('Select Time'), // Default option
            '3:00 PM - 4:00 PM' => __('3:00 PM - 4:00 PM'),
            '4:00 PM - 5:00 PM' => __('4:00 PM - 5:00 PM'),
            '5:00 PM - 6:00 PM' => __('5:00 PM - 6:00 PM'),
            '6:00 PM - 7:00 PM' => __('6:00 PM - 7:00 PM')
        )
    ));
    echo '</div>';
    echo '</div>';

    // Fields for Priority Delivery (hidden by default)
    echo '<div class="option2_fields" style="display:none;">';
    woocommerce_form_field('option2_date', array(
        'type' => 'date',
        'class' => array('form-row-wide'),
        'label' => __('Date for Priority Delivery')
    ));
    echo '<div class="time-slot-container">';
    echo '<label for="option2_time">' . __('Select Time 3pm to 7pm') . '</label>';
    woocommerce_form_field('option2_time', array(
        'type' => 'select',
        'class' => array('form-row-wide', 'time-slot-select'),
        'options' => array(
            '' => __('Select Time'), // Default option
            '00:00 AM - 01:00 AM' => __('00:00 AM - 01:00 AM'),
            '01:00 AM - 02:00 AM' => __('01:00 AM - 02:00 AM'),
            '02:00 AM - 03:00 AM' => __('02:00 AM - 03:00 AM'),
            '03:00 AM - 04:00 AM' => __('03:00 AM - 04:00 AM'),
            '04:00 AM - 05:00 AM' => __('04:00 AM - 05:00 AM'),
            '05:00 AM - 06:00 AM' => __('05:00 AM - 06:00 AM'),
            '06:00 AM - 07:00 AM' => __('06:00 AM - 07:00 AM'),
            '07:00 AM - 08:00 AM' => __('07:00 AM - 08:00 AM'),
            '08:00 AM - 09:00 AM' => __('08:00 AM - 09:00 AM'),
            '09:00 AM - 10:00 AM' => __('09:00 AM - 10:00 AM'),
            '10:00 AM - 11:00 AM' => __('10:00 AM - 11:00 AM'),
            '11:00 AM - 12:00 PM' => __('11:00 AM - 12:00 PM'),
            '12:00 PM - 01:00 PM' => __('12:00 PM - 01:00 PM'),
            '01:00 PM - 02:00 PM' => __('01:00 PM - 02:00 PM'),
            '02:00 PM - 03:00 PM' => __('02:00 PM - 03:00 PM'),
            '03:00 PM - 04:00 PM' => __('03:00 PM - 04:00 PM'),
            '04:00 PM - 05:00 PM' => __('04:00 PM - 05:00 PM'),
            '05:00 PM - 06:00 PM' => __('05:00 PM - 06:00 PM'),
            '06:00 PM - 07:00 PM' => __('06:00 PM - 07:00 PM'),
            '07:00 PM - 08:00 PM' => __('07:00 PM - 08:00 PM'),
            '08:00 PM - 09:00 PM' => __('08:00 PM - 09:00 PM'),
            '09:00 PM - 10:00 PM' => __('09:00 PM - 10:00 PM'),
            '10:00 PM - 11:00 PM' => __('10:00 PM - 11:00 PM'),
            '11:00 PM - 12:00 AM' => __('11:00 PM - 12:00 AM'),
        )
    ));
    echo '</div>';
    echo '</div>';

    // JavaScript to set minimum date to today and handle time slot selection
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date().toISOString().split("T")[0];
        document.querySelector("input[name=\'option1_date\']").setAttribute("min", today);
        document.querySelector("input[name=\'option2_date\']").setAttribute("min", today);
    });

    var option1Date = document.querySelector("input[name=\'option1_date\']");
    var option2Date = document.querySelector("input[name=\'option2_date\']");

    var option1TimeSlot1 = document.querySelector("select[name=\'option1_time_slot1\']");
    var option1TimeSlot2 = document.querySelector("select[name=\'option1_time_slot2\']");
    var option2TimeSlot = document.querySelector("select[name=\'option2_time\']");

    // Event listener for radio buttons
    var radioOption1 = document.getElementById("radio_option1");
    var radioOption2 = document.getElementById("radio_option2");

    radioOption1.addEventListener("change", function() {
        if (radioOption1.checked) {
            document.querySelector(".option1_fields").style.display = "block";
            document.querySelector(".option2_fields").style.display = "none";
            option1Date.required = true;
            option2Date.required = false;
            updateDeliveryDetails("Standard Delivery (+Rs350)", option1Date.value, option1TimeSlot1.value || option1TimeSlot2.value);
        }
    });

    radioOption2.addEventListener("change", function() {
        if (radioOption2.checked) {
            document.querySelector(".option2_fields").style.display = "block";
            document.querySelector(".option1_fields").style.display = "none";
            option2Date.required = true;
            option1Date.required = false;
            updateDeliveryDetails("Priority Delivery (+Rs450)", option2Date.value, option2TimeSlot.value);
        }
    });

    // Event listener for time slot selection in Standard Delivery
    option1TimeSlot1.addEventListener("change", function() {
        if (option1TimeSlot1.value !== "") {
            option1TimeSlot2.value = ""; // Reset the other time slot
            updateDeliveryDetails("Standard Delivery (+Rs350)", option1Date.value, option1TimeSlot1.value);
        }
    });

    option1TimeSlot2.addEventListener("change", function() {
        if (option1TimeSlot2.value !== "") {
            option1TimeSlot1.value = ""; // Reset the other time slot
            updateDeliveryDetails("Standard Delivery (+Rs350)", option1Date.value, option1TimeSlot2.value);
        }
    });

    // Event listener for time slot selection in Priority Delivery
    option2TimeSlot.addEventListener("change", function() {
        if (option2TimeSlot.value !== "") {
            updateDeliveryDetails("Priority Delivery (+Rs450)", option2Date.value, option2TimeSlot.value);
        }
    });

    function updateDeliveryDetails(deliveryType, selectedDate, timeSlot) {
        var deliveryDetails = document.getElementById("delivery_details");
        deliveryDetails.innerHTML = "Delivery Day and time: " + selectedDate + " " + timeSlot;
    }
    </script>';

    // Container to display selected delivery details
    echo '<div id="delivery_details"></div>';

    echo '</div>';
}








// Adjust cart total based on selected delivery option
add_action('woocommerce_cart_calculate_fees', 'custom_checkout_fields_fee');

function custom_checkout_fields_fee($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    // Ensure the fee is added based on the selected delivery option
    $chosen_option = WC()->session->get('radio_option');

    if ($chosen_option == 'option1') {
        $cart->add_fee(__('Standard Delivery'), 350);
    } elseif ($chosen_option == 'option2') {
        $cart->add_fee(__('Priority Delivery'), 450);
    }
}

// Save the custom fields
add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_fields_save');

function custom_checkout_fields_save($order_id) {
    if (isset($_POST['radio_option'])) {
        update_post_meta($order_id, '_radio_option', sanitize_text_field($_POST['radio_option']));
    }
    if (isset($_POST['option1_date'])) {
        update_post_meta($order_id, '_option1_date', sanitize_text_field($_POST['option1_date']));
    }
    if (isset($_POST['option1_time_slot1'])) {
        update_post_meta($order_id, '_option1_time_slot1', sanitize_text_field($_POST['option1_time_slot1']));
    }
    if (isset($_POST['option1_time_slot2'])) {
        update_post_meta($order_id, '_option1_time_slot2', sanitize_text_field($_POST['option1_time_slot2']));
    }
    if (isset($_POST['option2_date'])) {
        update_post_meta($order_id, '_option2_date', sanitize_text_field($_POST['option2_date']));
    }
    if (isset($_POST['option2_time'])) {
        update_post_meta($order_id, '_option2_time', sanitize_text_field($_POST['option2_time']));
    }
}

// Display the custom fields in the order admin
add_action('woocommerce_admin_order_data_after_billing_address', 'custom_checkout_fields_display_admin_order_meta', 10, 1);

function custom_checkout_fields_display_admin_order_meta($order) {
    $radio_option = get_post_meta($order->get_id(), '_radio_option', true);
    $option1_date = get_post_meta($order->get_id(), '_option1_date', true);
    $option1_time_slot1 = get_post_meta($order->get_id(), '_option1_time_slot1', true);
    $option1_time_slot2 = get_post_meta($order->get_id(), '_option1_time_slot2', true);
    $option2_date = get_post_meta($order->get_id(), '_option2_date', true);
    $option2_time = get_post_meta($order->get_id(), '_option2_time', true);

    if ($radio_option) {
        echo '<p><strong>' . __('Delivery Option') . ':</strong> ' . $radio_option . '</p>';
    }
    if ($option1_date) {
        echo '<p><strong>' . __('Date for Standard Delivery') . ':</strong> ' . $option1_date . '</p>';
    }
    if ($option1_time_slot1) {
        echo '<p><strong>' . __('Time Slot 1 for Standard Delivery') . ':</strong> ' . $option1_time_slot1 . '</p>';
    }
    if ($option1_time_slot2) {
        echo '<p><strong>' . __('Time Slot 2 for Standard Delivery') . ':</strong> ' . $option1_time_slot2 . '</p>';
    }
    if ($option2_date) {
        echo '<p><strong>' . __('Date for Priority Delivery') . ':</strong> ' . $option2_date . '</p>';
    }
    if ($option2_time) {
        echo '<p><strong>' . __('Time for Priority Delivery') . ':</strong> ' . $option2_time . '</p>';
    }
}

// JavaScript for datepicker and time picker
add_action('wp_footer', 'custom_checkout_fields_script');

function custom_checkout_fields_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Show/hide fields based on radio button selection
            $('input[name="radio_option"]').change(function() {
                if ($(this).val() === 'option1') {
                    $('.option1_fields').show();
                    $('.option2_fields').hide();
                } else if ($(this).val() === 'option2') {
                    $('.option1_fields').hide();
                    $('.option2_fields').show();
                }

                // Save selected option in session
                var selectedOption = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: wc_checkout_params.ajax_url,
                    data: {
                        action: 'save_selected_delivery_option',
                        selected_option: selectedOption,
                    },
                    success: function() {
                        $('body').trigger('update_checkout');
                    }
                });
            });

            // Initialize time picker for Standard Delivery - Time Slot 1
            $('#option1_time_slot1').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                scrollbar: true,
                dropdown: true,
                zindex: 9999
            });

            // Initialize time picker for Standard Delivery - Time Slot 2
            $('#option1_time_slot2').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                scrollbar: true,
                dropdown: true,
                zindex: 9999
            });
        });
    </script>
    <?php
}

// Ajax handler to save selected delivery option in session
add_action('wp_ajax_save_selected_delivery_option', 'save_selected_delivery_option');
add_action('wp_ajax_nopriv_save_selected_delivery_option', 'save_selected_delivery_option');

function save_selected_delivery_option() {
    if (isset($_POST['selected_option'])) {
        WC()->session->set('radio_option', sanitize_text_field($_POST['selected_option']));
    }
    die();
}
?>
