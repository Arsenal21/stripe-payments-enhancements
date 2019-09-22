<?php
/*
Plugin Name: Stripe Payments Enable Dev Mode
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Just enables DEV mode for Stripe Payments plugin
 */
class ASP_enable_dev_mode {
	public function __construct() {
		define( 'WP_ASP_DEV_MODE', true );
	}

}
new ASP_enable_dev_mode();
