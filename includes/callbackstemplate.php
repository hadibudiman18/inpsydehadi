<?php 
/**
 * PHP version 7
 *
 * @class Callbackstemplate
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

/**
 * Callbackstemplate class. custom end point callback handler
 *
 * @category  Custom
 * @package   Inpsydehadi
 * @author    Hadi Budiman <hadibudiman@gmail.com>
 * @copyright 2020 Hadi Budiman
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0-or-later
 * @link      http://hadibudiman.site/
 */
class Callbackstemplate extends BasePath
{

    public $selected_field; // an array to store selected fields

    /**
     * Get admin dashboard template
     *
     * @return admin template file
     */
    public function adminDashboard()
    {
        return include_once "$this->plugin_path/templates/admin.php";
    }

    /**
     * Set admin enqueue script and style
     *
     * @return nothing
     */
    public function adminEnqueue()
    {
        wp_enqueue_script(
            'admin_inpsydehadiscript', $this->plugin_url . 
            'assets/adminscript.js'
        );
        wp_enqueue_style(
            'inpsydehadistyle', $this->plugin_url . 
            'assets/style.css'
        );
    }

    /**
     * Set frontend enqueue script and style
     *
     * @return nothing
     */
    public function userEnqueue()
    {
        wp_enqueue_style(
            'inpsydehadistyle', $this->plugin_url . 
            'assets/style.css?v=12'
        );
    }

    /**
     * Shorcode handler , get saved options fields display
     *
     * @return front end template file
     */
    public function endPoint()
    {
        //reset 
        $this->selected_field = [];
        $options = get_option('inpsydehadi_option');
        $endpoint_data = $options["endpoint_field"];

        echo "<script>var endpoint_address = '".$options["endpoint_address"]."';";
        echo "var endpoint_field = {";
        foreach ( $endpoint_data as $key => $val ) {
            $this->writejs($key, $val);
        }
        echo "}
		</script>";
        return include_once "$this->plugin_path/templates/endpoint.php";
    }

    /**
     * Write javasript object from option at the frontend  
     * 
     * @param int   $key array key
     * @param array $val array value
     *
     * @return nothing
     */
    public function writejs($key,$val)
    {
        
        echo  $key ." : { ";
        echo "display_name : '".
            ( $val['display_name']!=''?$val['display_name']:$key)."', ";
        echo "status : '".$val['status']."', ";
        if (isset($val['child'])&&count($val['child'])>0) {
            echo "child : {";
            foreach ( $val['child'] as $k => $v ) {
                   $this->writejs($k, $v);
            }
            echo "}";
        } else {
            echo "child : null";
        }
        echo "},";
        
    }
}
