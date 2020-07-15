<?php

defined('WP_UNINSTALL_PLUGIN') || exit;

// delete plugin options
delete_option('inpsydehadi_option');

global $wpdb;
$shortcode = '[inpsyde-hadi]';
$tablePosts = $wpdb->prefix . 'posts';

// delete page
$wpdb->query("DELETE FROM $tablePosts WHERE post_content like '%$shortcode%'");
