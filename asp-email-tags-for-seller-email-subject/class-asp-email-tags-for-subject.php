<?php
/*
Plugin Name: Stripe Payments Email Tags For Seller Email Subject
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Makes email tags work in the seller email subject
 */
class ASP_Email_Tags_For_Seller_Email_Subject {
	public function __construct() {
		add_filter( 'asp_seller_email_subject', array( $this, 'email_subject_handler' ), 10, 2 );
		//uncomment following line to make tags work for buyer email subject:
		//add_filter( 'asp_buyer_email_subject', array( $this, 'email_subject_handler' ), 10, 2 );
	}
	public function email_subject_handler( $subj, $data ) {
		$subj = asp_apply_dynamic_tags_on_email_body( $subj, $data );
		return $subj;
	}
}
new ASP_Email_Tags_For_Seller_Email_Subject();
