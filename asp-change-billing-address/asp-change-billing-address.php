<?php
/*
Plugin Name: Stripe Payments Change Billing Address
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Example how to change billing and shipping address after payment.
 */
class ASP_Change_Billing_Address {
	public function __construct() {
		add_filter( 'asp_ng_payment_completed', array( $this, 'handle_ng_payment_completed' ) );
	}
	public function handle_ng_payment_completed( $data ) {
		// this function changes "UK" to "GB" in billing and shipping address after payment
		if ( empty( $data['billing_address'] ) ) {
			return $data;
		}
		$data['billing_address'] = preg_replace( '/^UK/m', 'GB', $data['billing_address'] );

		if ( empty( $data['shipping_address'] ) ) {
			return $data;
		}
		$data['shipping_address'] = preg_replace( '/^UK/m', 'GB', $data['shipping_address'] );

		return $data;
	}
}
new ASP_Change_Billing_Address();
