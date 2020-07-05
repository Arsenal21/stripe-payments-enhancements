<?php
/*
Plugin Name: Stripe Payments Minimum Amount
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/Arsenal21/stripe-payments-enhancements
Description: Example of payment popup addon that enforces minimum payment amount.
 */

/*
This is an example of payment popup addon. Feel free to modify it per your requirements.
Note: this plugin is not officially supported and comes with absolutely no warranty.
The sole purpose of it is to provide some real-life code examples.
Please DO NOT create support requrests regarding it on support forums.
*/
class ASP_Minimum_Amount {
	// edit this to specify product IDs where you want to force minimum amount
	// leave array blank (e.g. array();) to use for ALL products
	public $apply_to_products = array( '123', '456' );
	// minimum amount
	public $min_amount = 500;

	public function __construct() {
		add_action( 'asp_ng_pp_data_ready', array( $this, 'ng_data_ready' ), 10, 2 );
	}

	public function ng_data_ready( $data, $atts ) {
		if ( empty( $this->apply_to_products ) || in_array( $data['product_id'], $this->apply_to_products, true ) ) {
			$addon            = array(
				'name'    => 'MinAmount',
				'handler' => 'MinAmountHandlerNG',
			);
			$data['addons'][] = $addon;

			$data['prod_min_amount'] = $this->min_amount;
			add_action( 'asp_ng_pp_output_add_scripts', array( $this, 'ng_add_scripts' ) );
		}
		return $data;
	}

	public function ng_add_scripts( $scripts ) {
			$scripts[] = array(
				'footer' => true,
				'src'    => plugins_url( '', __FILE__ ) . '/min_amount.js?ver=0.0.1',
			);
			return $scripts;
	}
}
new ASP_Minimum_Amount();
