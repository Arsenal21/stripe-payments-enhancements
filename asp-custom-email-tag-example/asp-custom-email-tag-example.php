<?php
/*
Plugin Name: Stripe Payments Custom Email Tag Example
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Adds {purchase_page_url} email merge tag which shows URL payment was made on
 */
class ASP_custom_email_tag_example {
	public function __construct() {
		add_filter( 'asp_email_body_tags_vals_before_replace', array( $this, 'handle_body_before_replace' ), 10, 2 );
		add_filter( 'asp_email_body_after_replace', array( $this, 'handle_body_after_replace' ) );
		add_filter( 'asp_get_email_tags_descr', array( $this, 'handle_email_tags_descr' ) );
	}
	public function handle_body_before_replace( $tags_vals, $post ) {
		$referrer = filter_var( $_SERVER['HTTP_REFERER'], FILTER_SANITIZE_URL );
		if ( ! empty( $referrer ) ) {
			$tags_vals['tags'][] = '{purchase_page_url}';
			$tags_vals['vals'][] = $referrer;
		}
		return $tags_vals;
	}

	public function handle_body_after_replace( $body ) {
		//let's remove potential tags leftovers
		$body = preg_replace( array( '/\{purchase_page_url\}/' ), array( '' ), $body );
		return $body;
	}

	public function handle_email_tags_descr( $email_tags ) {
		//this adds description for email tag
		$email_tags['Custom tags']         = '';
		$email_tags['{purchase_page_url}'] = 'Shows URL payment was made on.';
		return $email_tags;
	}
}
new ASP_custom_email_tag_example();
