<?php

/**
 * Plugin Name: Stripe Custom Reference Data Collector
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
 * Add the custom plugin data as a hidden input element in payment popup form.
 */

function handle_asp_ng_pp_output_before_closing_form($a) {
	$value = "Some reference value"; // <<<< Place your reference data here.

	echo '<input type="hidden" name="custom_plugin_input" id="custom_plugin_input" value="'.esc_attr($value).'">';
}

add_action( 'asp_ng_pp_output_before_closing_form', 'handle_asp_ng_pp_output_before_closing_form' );

/*
 * Register the custom plugin data handler
 */

function handle_asp_ng_pp_data_ready( $data ) {
	$data['addons'][] = array(
		'name'    => 'Custom Plugin',
		'handler' => 'MyCustomPluginHandler',
	);

	return $data;
}

add_filter( 'asp_ng_pp_data_ready', 'handle_asp_ng_pp_data_ready', 10, 1 );

/*
 * Register the custom plugin data handling script
 */

function handle_asp_ng_pp_output_add_scripts( $scripts ) {
	$scripts[] = array(
		'footer' => true,
		'src'    => plugins_url( '', __FILE__ )  . '/custom-plugin-script.js' . '?ver=' . wp_rand(),
	);

	return $scripts;
}

add_filter( 'asp_ng_pp_output_add_scripts', 'handle_asp_ng_pp_output_add_scripts' );

/*
 * Add the custom plugin data in customer info in payment intent creat api of stripe.
 */

function handle_asp_ng_before_customer_create_update( $customer_opts, $customer_id ) {
	if ( ! isset( $customer_opts['metadata'] ) ) {
		$customer_opts['metadata'] = array();
	}

	if ( isset( $_POST['custom_plugin_data'] ) ) {
		$customer_opts['metadata']['custom_plugin_data'] = sanitize_text_field( $_POST['custom_plugin_data'] );
	}

	return $customer_opts;
}

add_filter( 'asp_ng_before_customer_create_update', 'handle_asp_ng_before_customer_create_update', 10, 2 );

