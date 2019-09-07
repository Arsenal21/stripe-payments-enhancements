<?php
/*
Plugin Name: Stripe Payments Custom Field to Description
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Puts custom field data to Stripe's description field
 */
class ASP_custom_field_to_description {
	public function __construct() {
		add_action( 'asp_ng_payment_completed_update_pi', array( $this, 'handle_pi_update' ), 10, 2 );
	}
	public function handle_pi_update( $update_opts, $data ) {
		if ( isset( $data['custom_fields'] ) ) {
			$update_opts['description'] = sprintf( '%s: %s', $data['custom_fields'][0]['name'], $data['custom_fields'][0]['value'] );
		}
		return $update_opts;
	}
}
new ASP_custom_field_to_description();
