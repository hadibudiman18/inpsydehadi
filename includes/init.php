<?php
/**
 * PHP version 7
 *
 * @class Init
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

defined('ABSPATH') || exit;

/**
 * Init class.
 *
 * @category  Custom
 * @package   Inpsydehadi
 * @author    Hadi Budiman <hadibudiman@gmail.com>
 * @copyright 2020 Hadi Budiman
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0-or-later
 * @link      http://hadibudiman.site/
 */
final class Init
{
    /**
     * Store all  the classes inside an array
     *
     * @return array full lists of classes
     */
    public static function getServices()
    {
        return [
        settings::class
        ];
    }

    /**
     * Loop through the classes, initialize them,
     * and call register() method if it exists
     *
     * @return nothing
     */
    public static function registerServices()
    {
        foreach ( self::getServices() as $class) {
            $service = self::_instantiate($class);
            if (method_exists($service, 'register') ) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     *
     * @param class $class from the services array
     *
     * @return class instance new instance of the class
     */
    private static function _instantiate( $class )
    {
        return new $class;
    }

}
