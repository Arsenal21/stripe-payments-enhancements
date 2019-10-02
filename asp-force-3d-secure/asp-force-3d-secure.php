<?php
/*
Plugin Name: Stripe Payments Force 3D Secure
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Forces 3D Secure check for supported cards
 */

// Stripe strongly recommends against using this option https://stripe.com/docs/api/payment_intents/create#create_payment_intent-payment_method_options-card-request_three_d_secure
// You should configure Radar rules instead https://stripe.com/docs/payments/3d-secure#three-ds-radar
class ASP_force_3D_secure {
	public function __construct() {
		add_filter( 'asp_ng_before_pi_create_update', array( $this, 'ng_before_pi_create_update_handler' ) );
	}
	public function ng_before_pi_create_update_handler( $pi_params ) {
		$pi_params['payment_method_options'] = array(
			'card' => array( 'request_three_d_secure' => 'any' ),
		);
		return $pi_params;
	}
}
new ASP_force_3D_secure();
