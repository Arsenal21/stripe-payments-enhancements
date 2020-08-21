<?php
/*
Plugin Name: Stripe Payments Focus On Card Input
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/Arsenal21/stripe-payments-enhancements
Description: Example of add-on that sets focus to card input when customer name and email are prefilled.
 */

/*
This is an example of payment popup add-on. Feel free to modify it per your requirements.
Note: this add-on is not officially supported and comes with absolutely no warranty.
The sole purpose of it is to provide some real-life code examples.
Please DO NOT create support requrests regarding it on support forums.
*/
class ASP_Focus_On_Card_Input {
	public function __construct() {
		add_action( 'asp_ng_pp_data_ready', array( $this, 'ng_data_ready' ), 10, 2 );
	}

	public function ng_data_ready( $data, $atts ) {
		// check if customer name and email are prefilled
		if ( ! empty( $data['customer_name'] ) && ! empty( $data['customer_email'] ) ) {
			// they are, so let's activate our payment popup add-on
			$addon            = array(
				'name'    => 'FocusOnCardInput',
				'handler' => 'FocusOnCardInputHandlerNG',
			);
			$data['addons'][] = $addon;

			add_action( 'asp_ng_pp_output_add_scripts', array( $this, 'ng_add_scripts' ) );
		}
		return $data;
	}

	public function ng_add_scripts( $scripts ) {
			$scripts[] = array(
				'footer' => true,
				'src'    => plugins_url( '', __FILE__ ) . '/focus_on_card_input.js?ver=0.0.1',
			);
			return $scripts;
	}
}
new ASP_Focus_On_Card_Input();
