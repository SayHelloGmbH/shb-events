<?php
/*
 * Plugin Name:       Events
 * Plugin URI:        https://github.com/SayHelloGmbH/shb-events
 * Description:       Plugin for the management of events. The output of the events should be managed by the theme: the plugin contains no views.
 * Author:            Mark Howells-Mead (mark@sayhello.ch)
 * Version:           0.0.1
 * Author URI:        https://sayhello.ch/
 * Text Domain:       shb-events
 * Domain Path:       /languages
 * Requires at least: 5.9
 * Requires PHP:      8.0
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Update URI:        https://sayhello.ch/
 */

namespace SayHello\ShbEvents;

/*
 * This lot auto-loads a class or trait just when you need it. You don't need to
 * use require, include or anything to get the class/trait files, as long
 * as they are stored in the correct folder and use the correct namespaces.
 *
 * See http://www.php-fig.org/psr/psr-4/ for an explanation of the file structure
 * and https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md for usage examples.
 */

spl_autoload_register(function ($class) {

	// project-specific namespace prefix
	$prefix = 'SayHello\\ShbEvents\\';

	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/src/';

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr($class, $len);

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
});

function shb_events_get_instance()
{
	return Plugin::getInstance(__FILE__);
}

shb_events_get_instance();
