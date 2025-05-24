<?php
/*
* Plugin Name: ASP to Zapier Webhook Integration
* Description: Sends customer name and email to Zapier when a Stripe payment is completed via Accept Stripe Payments plugin.
* Version: 1.0
* Author: Tips and Tricks HQ
* Author URI: https://s-plugins.com/
* License: GPL2
*/

add_action('asp_stripe_payment_completed', 'asp_send_data_to_zapier_webhook', 10, 2);

function asp_send_data_to_zapier_webhook($txn_data, $charge_data) {
    //TODO - Replace this with your actual Zapier webhook URL
    $zapier_webhook_url = 'https://hooks.zapier.com/hooks/catch/XXXXXXX/XXXXXXXX';

    // Prepare the data to send to Zapier
    $payload = array(
        'customer_name'  => $txn_data['customer_first_name'] . ' ' . $txn_data['customer_last_name'],
        'customer_email' => $txn_data['stripeEmail'],
        'product_id'     => $txn_data['product_id'],
        'item_name'      => $txn_data['item_name'],
        'txn_id'         => $txn_data['txn_id'],
        'amount'         => $txn_data['item_price'],
    );

    // Send the webhook using wp_remote_post
    wp_remote_post($zapier_webhook_url, array(
        'method'    => 'POST',
        'timeout'   => 20,
        'headers'   => array('Content-Type' => 'application/json'),
        'body'      => json_encode($payload),
    ));
    ASP_Debug_Logger::log('Data sent to Zapier webhook URL: ' . $zapier_webhook_url, true);
    ASP_Debug_Logger::log_array_data($payload);
}
