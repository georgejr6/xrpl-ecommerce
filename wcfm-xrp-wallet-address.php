<?php

require plugin_dir_path(__FILE__) . 'user-interface.php';
require plugin_dir_path(__FILE__) . 'send_payment.php';
require plugin_dir_path(__FILE__) . 'xrp_validation.php'

/// will require the user-interface.php .. make sure this is in the right directory, folder)

/// This will include the contents of the send_payment.php file into your main PHP file. 
/// Then, you can call the functions defined in the send_payment.php file from your main PHP file.

/// Remember to replace the path in the require or include statement with the correct path to your send_payment.php file, 
/// if it's not in the same directory as your main PHP file.

/**
 * Plugin Name: WCFM XRP Wallet Addresses
 * Plugin URI: 
 * Description: This plugin allows WCFM vendors to add their XRP wallet addresses to their profiles
 * Version: 1.0
 * Author: Mwosa From DIGITVL
 * Author URI: https://digitvl.com
 * License: GPL2
 */

class WCFM_XRP_Wallet_Addresses {

private $vendor_wallet_address = array();

public function __construct() {
    add_action('wcfm_vendor_settings_update', array($this, 'save_vendor_wallet_address'), 10, 2);
    add_filter('wcfm_vendor_settings_fields_general', array($this, 'add_vendor_wallet_address_field'), 10, 2);
}

// Function to add XRP wallet address field to vendor settings
public function add_vendor_wallet_address_field($settings_fields, $vendor_id) {
    $settings_fields['general']['vendor_xrp_wallet_address'] = array(
        'label' => __('XRP Wallet Address', 'wc-frontend-manager'),
        'type' => 'text',
        'name' => 'vendor_xrp_wallet_address',
        'class' => 'wcfm-text wcfm_ele',
        'label_class' => 'wcfm_title wcfm_ele',
        'value' => $this->get_vendor_wallet_address($vendor_id),
        'hints' => __('Enter the XRP wallet address for this vendor', 'wc-frontend-manager'),
    );
    return $settings_fields;
}

// Function to save the vendors XRP wallet address
public function save_vendor_wallet_address($vendor_id, $wcfm_settings_form) {
    if (isset($wcfm_settings_form['vendor_xrp_wallet_address'])) {
        update_user_meta($vendor_id, 'vendor_xrp_wallet_address', $wcfm_settings_form['vendor_xrp_wallet_address']);
    }
}

// Function to retrieve a vendor's XRP wallet address
public function get_vendor_wallet_address($vendor_id) {
    return get_user_meta($vendor_id, 'vendor_xrp_wallet_address', true);
}

// Function to process a payment
public function process_payment($product_id, $payment_amount) {
    // Retrieve the vendor_id for the product
    $vendor_id = get_post_field('post_author', $product_id);
    // Retrieve the vendor's XRP wallet address
    $wallet_address = $this->get_vendor_wallet_address($vendor_id);
    // Validate the wallet address to ensure it is a legitimate XRP address
    if ($this->validate_wallet_address($wallet_address)) {
        // Send the payment to the vendor's XRP wallet address
        // Add code to send the payment here
        // need to add code that makes a call to the XUMM API and sends the payment to the vendor's XRP wallet address. 
        //It would also be a good idea to handle any errors that may occur during the process of sending the payment.
        return true;
    }
    return false;
}

// Function to validate an XRP wallet address
private function validate_xrp_wallet_address($wallet_address) {
    // Add code to validate the XRP wallet address
    // You can use a library like XRPValidator (https://github.com/XRPValidator/XRPValidator) to validate XRP addresses
    return true;
}

// Function to process a payment to vendor
public function process_payment_to_vendor($product_id, $payment_amount) {
    // Retrieve the vendor_id for the product
    $vendor_id = get_post_field('post_author', $product_id);
    // Check if the vendor is approved as a store vendor
    $vendor_is_approved = get_user_meta($vendor_id, 'wcfm_is_store_vendor', true);
    if ($vendor_is_approved) {
        // Retrieve the vendor's XRP wallet address
        $wallet_address = $this->get_vendor_wallet_address($vendor_id);
        // Validate the XRP wallet address
        if ($this->validate_xrp_wallet_address($wallet_address)) {
            // Send the payment to the vendor's XRP wallet address
            // Add code to send the payment here
            // need to add code that makes a call to the XUMM API and sends the payment to the vendor's XRP wallet address. 
            //It would also be a good idea to handle any errors that may occur during the process of sending the payment.
            return true;
        }
    }
    return false;
}

