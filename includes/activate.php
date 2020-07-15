<?php
/**
 * PHP version 7
 *
 * @class     Activate
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
 * Activate class.
 *
 * @category  Custom
 * @package   Inpsydehadi
 * @author    Hadi Budiman <hadibudiman@gmail.com>
 * @copyright 2020 Hadi Budiman
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0-or-later
 * @link      http://hadibudiman.site/
 */
class Activate
{
    /**
     * Activate hook add default option
     *
     * @return nothing
     */
    public static function activate()
    {
        // default setting
        $option_settings = [
        'endpoint_address'=>'https://jsonplaceholder.typicode.com/users',
        'endpoint_field'=> [
               'id' => [
                           'status' =>'1',
                           'display_name' =>'id',
                           'child' => []
                           ],
               'name' => [
                           'status' =>'1',
                           'display_name' =>'name',
                           'child' => []
                           ],
               'username' => [
                           'status' =>'1',
                           'display_name' =>'username',
                           'child' => []
                           ],
               'email' => [
                           'status' =>'0',
                           'display_name' =>'email',
                           'child' => []
                           ],
               'address' => [
                           'status' =>'0',
                           'display_name' =>'address  ',
                           'child' => [
                               'street' => [
                                           'status' =>'0',
                                           'display_name' =>'street',
                                           'child' => []
                                           ],
                               'suite' => [
                                           'status' =>'0',
                                           'display_name' =>'suite',
                                           'child' => []
                                           ],
                               'city' => [
                                           'status' =>'0',
                                           'display_name' =>'city',
                                           'child' => []
                                           ],
                               'zipcode' => [
                                           'status' =>'0',
                                           'display_name' =>'zipcode',
                                           'child' => []
                                           ],
                               'geo' =>     [
                                           'status' =>'0',
                                           'display_name' =>'geo',
                                           'child' => [
                                                       'lat' =>  [
                                                          'status' =>'0',
                                                          'display_name' =>'lat',
                                                          'child' => []
                                                                   ],
                                                       'lng' => [
                                                          'status' =>'0',
                                                          'display_name' =>'lng',
                                                          'child' => []
                                                                   ]
                                                       ]
                                           ]
                                       ]

                           ],
               'phone' => [
                               'status' =>'0',
                               'display_name' =>'phone',
                               'child' => []
                             ],
               'website' => [
                               'status' =>'0',
                               'display_name' =>'website',
                               'child' => []
                             ],
               'company' => [
                               'status' =>'0',
                               'display_name' =>'company',
                               'child' => [
                                           'name' => [
                                                  'status' =>'0',
                                                  'display_name' =>'name',
                                                  'child' => []
                                                       ],
                                           'catchPhrase' => [
                                                  'status' =>'0',
                                                  'display_name' =>'catchPhrase',
                                                  'child' => []
                                                               ],
                                           'bs' => [
                                                  'status' =>'0',
                                                  'display_name' =>'bs',
                                                  'child' => []
                                                     ]
                                           ]
                               ]
           ]

        ];

        // add default option if record not found
        if (!get_option('inpsydehadi_option') ) {
            add_option('inpsydehadi_option', $option_settings);
        }
        self::addSamplePages();
        flush_rewrite_rules();
    }


    /**
     * Add sample page with shortcode if not found
     *
     * @return nothing
     */
    public static function addSamplePages()
    {
        global $wpdb;

        $valid_page_found = $wpdb->get_var(
            $wpdb->prepare(
                "
          SELECT ID FROM $wpdb->posts WHERE 
            post_type='page' AND 
            post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND 
            post_content LIKE %s LIMIT 1;", "%inpsyde-hadi%"
            )
        );
        if (!$valid_page_found) {
            $page_data = array(
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_author'    => 1,
            'post_name'      => 'custom-end-point',
            'post_title'     => 'custom end point',
            'post_content'   => '
            <!-- wp:shortcode -->[inpsyde-hadi]<!-- /wp:shortcode -->
            ',
            'post_parent'    => 0,
            'comment_status' => 'closed',
            );
            $page_id   = wp_insert_post($page_data);
        }
    }
}
