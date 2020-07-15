<?php
/**
 * PHP version 7
 *
 * Inpsydehadi admin page setting
 *
 * admin page dashboard Settings .
 *
 * @file admin
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
?>
<div class="wrap">
<h1>Inpsyde Hadi Plugin Dashboard</h1>
<?php settings_errors();?>
 <form action="options.php" method="post" id="inpsydehadi_form">
        <?php 
        settings_fields('inpsydehadi_option');
        do_settings_sections('inpsydehadi_plugin'); ?>
        <p><span class="small"> 
        *only checked checkboxes will display at the frontend
        </span><p>
        <input id="submit-button" name="submit" class="button button-primary" 
        type="submit" value="<?php esc_attr_e('Save'); ?>" />
    </form>
<p>Short Code : [inpsyde-hadi]</p>
</div>
