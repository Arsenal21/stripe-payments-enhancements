<?php
/*
Plugin Name: Stripe Payments Clear Stuck Scheduled Emails
Version: 0.0.1
Plugin URI: https://s-plugins.com/
Author: alexanderfoxc
Author URI: https://github.com/erommel/stripe-payments-enhancements
Description: Clear stuck scheduled emails.
 */

class ASP_Clear_Stuck_Scheduled_Emails {
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}
	public function init() {
		$crons = _get_cron_array();
		foreach ( $crons as $vk => $cron ) {
			foreach ( $crons[ $vk ] as $k => $v ) {
				if ( $k === 'asp_send_scheduled_email' ) {
					unset( $crons[ $vk ] );
					_set_cron_array( $crons );
				}
			}
		}
	}
}
new ASP_Clear_Stuck_Scheduled_Emails();
