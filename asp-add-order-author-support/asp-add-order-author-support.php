<?php
/*
Plugin Name: Stripe Payments Add Order Author Support
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Adds 'author' support for 'stripe-order' post type
 */
class ASP_custom_field_to_description {
	public function __construct() {
		add_action( 'asp_stripe_order_register_post_type_args', array( $this, 'stripe_order_args_handler' ) );
	}
	public function stripe_order_args_handler( $args ) {
		array_push( $args['supports'], 'author' );
		return $args;
	}
}
new ASP_custom_field_to_description();
