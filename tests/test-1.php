<?php

namespace tests;
use \Brain\Monkey\Functions;
use \Brain\Monkey\Actions;
use \Includes\Settings;


class MyClassTest extends \PluginTestCase {

 public function test_construct() {
        Functions\when('add_shortcode')
            ->justReturn(true);
        Functions\when('plugin_dir_path')
            ->justReturn(true);
        Functions\when('plugin_dir_url')
            ->justReturn(true);
        Functions\when('plugin_basename')
            ->justReturn(true);

            
		$class = new \Includes\Settings();
        $class->register();

       
        self::assertTrue( has_action('admin_menu',  '\Includes\Settings->addAdminMenu()' ) );
        self::assertTrue( has_action('admin_init',  '\Includes\Settings->registerFormSettings()' ) );
 		 
		
	}
}
