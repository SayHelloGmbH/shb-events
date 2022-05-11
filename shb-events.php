<?php
/*
 * Plugin Name:       Events
 * Plugin URI:        #
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

require_once 'src/Plugin.php';

function shb_events_get_instance()
{
	return Plugin::getInstance(__FILE__);
}

shb_events_get_instance();
