<?php
/*
Plugin Name: Stripe Payments Override IP Limit
Version: 1.0
Plugin URI: https://s-plugins.com/
Author: Tips and Tricks HQ
Author URI: https://www.tipsandtricks-hq.com/
Description: Overrides the per ip address limit for the incoming transaction requests
*/

function asp_override_ip_limit_for_my_site( $limit ){
    $limit = 50;
    return $limit;
}
add_action( 'asp_request_usage_count_by_ip_limit', 'asp_override_ip_limit_for_my_site' );

