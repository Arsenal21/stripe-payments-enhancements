<?php
/*
Plugin Name: Stripe Payments Prefill Customer Name and Email
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Code example to prefill customer name and email
 */
class ASP_prefill_customer_name_and_email {
	public function __construct() {
		add_action( 'asp-button-output-data-ready', array( $this, 'handle_data_ready' ), 10, 2 );
	}
	public function handle_data_ready( $data, $not_used ) {
		$data['customer_email'] = 'john@example.com';
		$data['customer_name']  = 'John Doe';
		return $data;
	}
}
new ASP_prefill_customer_name_and_email();
