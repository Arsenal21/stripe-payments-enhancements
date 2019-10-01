<?php
/*
Plugin Name: Stripe Payments Change Products Slug
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Code example to change products slug. Requires Stripe Payments 2.0.10+.
 */
class ASP_change_products_slug {
	public function __construct() {
		add_action( 'asp_products_post_type_before_register', array( $this, 'handle_change_products_slug' ) );
	}
	public function handle_change_products_slug( $args ) {
		$args['rewrite'] = array( 'slug' => 'test-slug' );
		return $args;
	}
}
new ASP_change_products_slug();
