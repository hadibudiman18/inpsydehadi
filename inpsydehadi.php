<?php
/**
 * PHP version 7
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

defined('ABSPATH') || exit;

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    include_once dirname(__FILE__) . '/vendor/autoload.php';
}


//activation
register_activation_hook(__FILE__, [ 'Includes\Activate','activate']);

 // deactivation 
register_deactivation_hook(__FILE__, [ 'Includes\Deactivate','deactivate']);

if (class_exists('Includes\\Init') ) {
    Includes\Init::registerServices();
}