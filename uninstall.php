<?php
/**
 * PHP version 7
 *
 * Uninstall file
 *
 * @category  Custom
 * @package   Inpsydehadi
 * @author    Hadi Budiman <hadibudiman@gmail.com>
 * @copyright 2020 Hadi Budiman
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0-or-later
 * @link      http://hadibudiman.site/
 *
 * @wordpress-plugin
 * Plugin Name: Inpsydehadi
 * Plugin URI:  http://hadibudiman.site/
 * Description: test plugin
 * Version:     1.0.0
 * Author:      Hadi Budiman
 * Author URI:  http://hadibudiman.site/
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: Inpsydehadi
 */

defined('WP_UNINSTALL_PLUGIN') || exit;

// delete plugin options
delete_option('inpsydehadi_option');

global $wpdb;
$shortcode = '[inpsyde-hadi]';
$tablePosts = $wpdb->prefix . 'posts';

// delete page
$wpdb->query("DELETE FROM $tablePosts WHERE post_content like '%$shortcode%'");