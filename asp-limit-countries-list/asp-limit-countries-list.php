<?php
/*
Plugin Name: Stripe Payments Limit Countries List
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Example of `asp_ng_pp_countries_list` filter usage.
 */

class ASP_Limit_Countries_List {
	public function __construct() {
		add_filter( 'asp_ng_pp_countries_list', array( $this, 'countries_list' ) );
	}
	public function countries_list( $countries ) {
		//reset countries array so we could create our own
		$countries = array();
		//let's add countries we need
		$countries = array(
			''   => '—', //this is mandatory
			'AL' => __( 'Albania', 'stripe-payments' ),
			'AT' => __( 'Austria', 'stripe-payments' ),
			'BE' => __( 'Belgium', 'stripe-payments' ),
			'BA' => __( 'Bosnia and Herzegovina', 'stripe-payments' ),
		);
		return $countries;
	}
}
new ASP_Limit_Countries_List();
