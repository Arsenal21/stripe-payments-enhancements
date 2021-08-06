<?php
/*
Plugin Name: Stripe Payments Email Match
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/Arsenal21/stripe-payments-enhancements
Description: Example of add-on that checks if email and custom field match.
 */

/*
This is an example of payment popup add-on. Feel free to modify it per your requirements.
Note: this add-on is not officially supported and comes with absolutely no warranty.
The sole purpose of it is to provide some real-life code examples.
Please DO NOT create support requrests regarding it on support forums.
*/
class ASP_Email_Match {
	public function __construct() {
		add_action( 'asp_ng_pp_data_ready', array( $this, 'ng_data_ready' ), 100, 2 );
	}

	public function ng_data_ready( $data, $atts ) {
		// uncomment below to enable the add-on only for the product with id 123
		// if ( 123 !== $data['product_id'] ) {
		// 	return $data;
		// }

		$addon            = array(
			'name'    => 'EmailMatch',
			'handler' => 'EmailMatchNG',
		);
		$data['addons'][] = $addon;

		add_action( 'asp_ng_pp_output_add_scripts', array( $this, 'ng_add_scripts' ) );

		return $data;
	}

	public function ng_add_scripts( $scripts ) {
			$scripts[] = array(
				'footer' => true,
				'src'    => plugins_url( '', __FILE__ ) . '/email_match.js?ver=0.0.1',
			);
			return $scripts;
	}
}
new ASP_Email_Match();
