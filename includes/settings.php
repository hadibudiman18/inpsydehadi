<?php
/**
 * PHP version 7
 *
 * @class Settings
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


namespace Includes;

use Includes\BasePath;
use Includes\Callbackstemplate;

defined('ABSPATH') || exit;

/**
 * Settings class.
 *
 * @category  Custom
 * @package   Inpsydehadi
 * @author    Hadi Budiman <hadibudiman@gmail.com>
 * @copyright 2020 Hadi Budiman
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0-or-later
 * @link      http://hadibudiman.site/
 */
class Settings extends BasePath
{
    public $callbacks;

    /**
     * List action/filter etc that need to loads
     * called by init class registerServices()
     *
     * @return nothing
     */
    public function register()
    {
        $this->callbacks = new Callbackstemplate();
        add_action('admin_menu', [ $this, 'addAdminMenu']);
        add_action('admin_init', [ $this,'registerFormSettings']);
        add_filter(
            'plugin_action_links_'.$this->plugin_name, [$this,'settingLink']
        );
        add_shortcode('inpsyde-hadi', [ $this->callbacks, 'endPoint']);
        add_action('admin_enqueue_scripts', [$this->callbacks,'adminEnqueue']);
        add_action('wp_enqueue_scripts', [$this->callbacks,'userEnqueue']);

        
    }
    /**
     *  Admin menu page
     *
     * @return nothing
     */
    public function addAdminMenu()
    {
        add_menu_page(
            'Inpsyde Hadi',
            'Inpsyde Hadi',
            'manage_options',
            'inpsydehadi',
            [ $this->callbacks, 'adminDashboard'],
            'dashicons-smiley',
            '110'
        );
    }

    /**
     * Setting link
     *
     * @param array $links array from wp
     *
     * @return array links
     */
    public function settingLink( $links)
    {
        $setting_link = '<a href="admin.php?page=inpsydehadi">Settings</a>';
        array_push($links, $setting_link);
        return $links;
    }

    /**
     *  Form admin admin page
     *
     * @return nothing
     */
    public function registerFormSettings()
    {
        register_setting(
            'inpsydehadi_option',
            'inpsydehadi_option',
            [ $this, 'inpsyde_hadi_options_endpoint_field' ]
        );
        add_settings_section(
            'endpoint_settings',
            'End Point Settings',
            [ $this,'endpointSettingsSectionText'],
            'inpsydehadi_plugin'
        );

        add_settings_field(
            'endpoint_address',
            'End Point Address',
            [ $this,'endpointAddress'],
            'inpsydehadi_plugin',
            'endpoint_settings'
        );
        add_settings_field(
            'endpoint_field',
            'Display Field',
            [ $this,'endpointField'],
            'inpsydehadi_plugin',
            'endpoint_settings'
        );
    }

    /**
     *  Form admin admin page text section
     *
     * @return nothing
     */
    public function endpointSettingsSectionText()
    {
        echo '<p>Setting End Point and field to display on the front end</p>';
    }

    /**
     *  Form admin admin page address section
     *
     * @return nothing
     */
    public function endpointAddress()
    {
        $options = get_option('inpsydehadi_option');
        echo '<input type="hidden" id="checkstatus" value="1">
        <input style="width:450px" id="endpoint_address" 
        name="inpsydehadi_option[endpoint_address]" type="text" 
        value="'.esc_attr($options['endpoint_address']).'" required/> 
        <button id="inpsyde_hadi_check_button" type="button" class="button">
        	Check Address
        </button> 
        <span id="checkstatus_message"></span><br>* only accept json response!';
    }

    /**
     *  Form admin admin page field selection section
     *
     * @return nothing
     */
    public function endpointField()
    {
        $options = get_option('inpsydehadi_option');
        echo '<div id="endpoint_field_container">';
        foreach ($options["endpoint_field"] as $key => $val) {
            $this->endpointFieldEle(
                [ 'parent' => [], 'key' => $key, 'val' => $val ]
            );
        }
        echo '</div>';
    }

    /**
     *  Form admin admin page element section
     *
     * @param array $ele array setting from options
     *
     * @return nothing
     */
    public function endpointFieldEle($ele)
    {
        $value = $ele['val']["display_name"];
        $checked = ($ele['val']["status"]=='1') ? ' checked="checked"': '';
        
        // generate parent
        $parent_lists = $this->endpointFieldEleParent($ele['parent']);
        //add class to parent element to make sure at least 3 selected elemet
        $classParent = ( $parent_lists[0] == '' ) ? 'parentfield' : '';
        
        echo $parent_lists[1] . '
        	<input type="checkbox" data-class="'.$ele['key'].'" 
        	class="'.$classParent.' '.$parent_lists[2].'" 
        	name="inpsydehadi_option[endpoint_field]'.$parent_lists[0].
            '['.$ele['key'].'][status]" value="1" '.$checked.'>
        	<input class="inpsydehadi_option" 
        	name="inpsydehadi_option[endpoint_field]'.$parent_lists[0].
            '['.$ele['key'].'][display_name]" 
        	type="text" value="'.esc_attr($value).'" /><br>';    

        if (isset($ele['val']["child"]) && count($ele['val']["child"]) > 0 ) {
            $ele['parent'][] = $ele['key'];
            foreach ( $ele['val']["child"] as $key => $val ) {
                $ele['val'] = $val;
                $ele['key'] = $key;
                $this->endpointFieldEle($ele);
            }
        } 

    }

    /**
     *  Form admin admin page element section
     *
     * @param array $ele array setting from options
     *
     * @return array [as input name, blank space, class name]
     */
    public function endpointFieldEleParent($ele)
    {
        $parent = '';
        $space = '';
        $classname = '';
        for ( $i=0; $i<count($ele); $i++ ) {
            $parent .=  "[$ele[$i]]" ."[child]";
            $space .= ' &nbsp; &nbsp;  &nbsp; ';
            $classname .= $ele[$i].' ';
        }
        return [ $parent, $space, $classname ];
    }
    
}