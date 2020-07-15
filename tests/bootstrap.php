<?php
/*
// First we need to load the composer autoloader so we can use WP Mock
require_once __DIR__ . '/../vendor/autoload.php';

// Now call the bootstrap method of WP Mock
WP_Mock::bootstrap();

/**
 * Now we include any plugin files that we need to be able to run the tests. This
 * should be files that define the functions and classes you're going to test.
 */
//require_once __DIR__ . '/../includes/settings.php';


// define test environment
define( 'PLUGIN_PHPUNIT', true );

// define fake ABSPATH
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', sys_get_temp_dir() );
}
// define fake PLUGIN_ABSPATH
if ( ! defined( 'PLUGIN_ABSPATH' ) ) {
	define( 'PLUGIN_ABSPATH', sys_get_temp_dir() . '/wp-content/plugins/inpsydehadi/' );
}

require_once __DIR__ . '/../vendor/autoload.php';

// Include the class for PluginTestCase
require_once __DIR__ . '/plugintestcase.php';

/*
require_once __DIR__ . '/../../../../wp-includes/plugin.php';
require_once __DIR__ . '/../../../../wp-includes/functions.php';
require_once __DIR__ . '/../../../../wp-includes/link-template.php';
*/