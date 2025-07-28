<?php
/*
* Plugin Name: ASP to GetResponse Integration
* Description: Add customer info to GetResponse contacts when a Stripe payment is completed via Accept Stripe Payments plugin.
* Version: 1.0
* Author: Tips and Tricks HQ
* Author URI: https://s-plugins.com/
* License: GPL2
*/



/**
 * This function retrieves the customer data and create a new contact in the GetResponse using its api.
 * You will need to specify the GetResponse API Key and a Campaign Name in which you want the contact to be added.
 * 
 * Find you api key here: https://app.getresponse.com/api
 * Find you campaigns list here: https://app.getresponse.com/lists
 * 
 * @param array $txn_data
 * @param array $charge_data
 * @return void
 */
function asp_add_customer_data_to_getResponse($txn_data, $charge_data)
{
    $getResponse_api_url = 'https://api.getresponse.com/v3';
    $getResponse_api_contacts_url = $getResponse_api_url . '/contacts';

    $api_key = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"; //TODO - Replace this with your actual API Key. 

    $campaign_name = 'your_campaign_name'; //TODO - Replace this with your actual campaign name.

    $campaign_id = asp_get_getresponse_campaign_id_by_name($campaign_name, $api_key);
    if (is_wp_error($campaign_id)) {
        ASP_Debug_Logger::log("Invalid campaign name ('$campaign_name') provided", false);
        return;
    }

    /**
     * Prepare the data to send to GetResponse
     * You can customize the payment as your requirement. See: https://apireference.getresponse.com/#operation/createContact
     */
    $payload = array(
        'name' => $txn_data['customer_name'],
        'email' => $txn_data['stripeEmail'],
        'campaign' => array(
            'campaignId' => $campaign_id,
        )
    );

    ASP_Debug_Logger::log_array_data($payload, true);

    $response = wp_remote_post($getResponse_api_contacts_url, array(
        'method'    => 'POST',
        'timeout'   => 20,
        'headers'   => array(
            'Content-Type' => 'application/json',
            'X-Auth-Token' => 'api-key ' . $api_key,
        ),
        'body' => json_encode($payload),
    ));

    if (is_wp_error($response)) {
        $response_body = wp_remote_retrieve_body($response);
        ASP_Debug_Logger::log('Error during api call to GetResponse! ', false);
        ASP_Debug_Logger::log_array_data(json_decode($response_body), true);
        return;
    }

    ASP_Debug_Logger::log('The custom info added to GetResponse contacts list.', true);
}

add_action('asp_stripe_payment_completed', 'asp_add_customer_data_to_getResponse', 10, 2);

function asp_get_getresponse_campaign_id_by_name($campaign_name, $api_key)
{
    $api_url = 'https://api.getresponse.com/v3/campaigns';
    $api_url = add_query_arg(array(
        'query[name]' => $campaign_name,
        'fields' => 'id,name',
    ), $api_url);

    $response = wp_remote_get($api_url, [
        'headers' => [
            'X-Auth-Token' => 'api-key ' . $api_key,
            'Content-Type' => 'application/json',
        ],
        'timeout' => 30,
    ]);

    if (is_wp_error($response)) {
        return new WP_Error('request_failed', 'Request failed: ' . $response->get_error_message());
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
        return new WP_Error('invalid_response', 'Invalid response code: ' . $code);
    }

    $body = wp_remote_retrieve_body($response);
    $campaigns = json_decode($body, true);

    if (!is_array($campaigns)) {
        return new WP_Error('invalid_json', 'Could not parse JSON response.');
    }

    foreach ($campaigns as $campaign) {
        if (isset($campaign['name']) && $campaign['name'] === $campaign_name) {
            return $campaign['campaignId'];
        }
    }

    return new WP_Error('not_found', 'Campaign not found.');
}