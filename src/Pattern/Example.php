<?php

namespace SayHello\shbEvents\Pattern;

// Use function from plugin top-level namespace
use function \SayHello\shbEvents\shb_events_get_instance;

/**
 * Example child class
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Example
{

	public function run()
	{
		add_action('wp_head', [$this, 'example']);
	}

	/**
	 * An example of getting data from the plugin's
	 * top-level namespace using the get_instance method.
	 *
	 * @return void
	 */
	public function example()
	{
		$version = shb_events_get_instance()->version;
		$name = dirname(plugin_basename(shb_events_get_instance()->file));
		echo "<!-- Plugin “{$name}” running in version {$version} -->";
	}
}
